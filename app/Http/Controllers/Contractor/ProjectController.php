<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{

    protected $projects;
    protected $bids;

    public function __construct(ProjectRepositoryInterface $projects, BidRepositoryInterface $bids)
    {
        $this->projects = $projects;
        $this->bids = $bids;
    }
    public function index(Request $request)
    {
        $filters = [
            'search'      => $request->search,
            'status'      => $request->status,
            'created_by'  => $request->created_by,
            'category_id' => $request->category_id ?? null,
        ];

        $projects = $this->projects->filterProjects($filters);
        $createdByUsers = $this->projects->getProjectCreators();

        // Check contractor bid status
        $hasBid = [];
        if (auth()->user()->hasRole('contractor')) {
            foreach ($projects as $project) {
                $hasBid[$project->id] = $this->bids->hasUserBid($project->id, auth()->id());
            }
        }

        return view('contractor.projects.index', compact('projects', 'createdByUsers', 'hasBid'));
    }

    public function projectBids($projectId)
    {
        $project = $this->projects->find($projectId);
        $bids = $this->bids->getByProject($projectId);

        return view('contractor.bids.index', compact('project', 'bids'));
    }

    /**
     * Show the specific project workspace (The UI created in the previous step).
     */
    public function show(Project $project)
    {
        $isAssigned = ($project->award && $project->award->awarded_to === Auth::id()) || 
                      $project->projectWorks()->where('contractor_id', Auth::id())->exists();
        abort_unless($isAssigned, 403, 'You are not authorized to view this project.');

        $contractorUserId = Auth::id();
        $isWholeProjectAwarded = $project->award && $project->award->awarded_to === $contractorUserId;

        $project->load([
            'milestones' => function($q) use ($contractorUserId, $isWholeProjectAwarded) {
                if (!$isWholeProjectAwarded) {
                    $q->where(function($sub) use ($contractorUserId) {
                        $sub->whereNull('project_work_id')
                            ->orWhereHas('projectWork', function($workQ) use ($contractorUserId) {
                                $workQ->where('contractor_id', $contractorUserId);
                            });
                    });
                }
            },
            'progressUpdates' => function ($query) {
                $query->latest();
            },
            'award.bid'
        ]);

        if (!$isWholeProjectAwarded) {
            // Filter works if we were to display them (adding this for consistency)
            $project->setRelation('works', $project->works->filter(function($work) use ($contractorUserId) {
                return $work->pivot->contractor_id == $contractorUserId;
            }));
        }

        // Fetch additional management data
        $workerCount = \App\Models\Worker::where('contractor_id', Auth::user()->contractor->id)->count();
        $attendanceToday = \App\Models\ProjectAttendance::where('project_id', $project->id)
            ->where('attendance_date', date('Y-m-d'))
            ->count();
            
        // 1. Linked Workers (Active on this project based on attendance)
        $linkedWorkers = \App\Models\Worker::whereHas('attendances', function($q) use ($project) {
                $q->where('project_id', $project->id);
            })
            ->withCount(['attendances' => function($q) use ($project) {
                $q->where('project_id', $project->id);
            }])
            ->get();

        // 2. Total Payouts for this project
        $totalProjectPayouts = \App\Models\WorkerPayment::where('project_id', $project->id)->sum('amount');

        $materialLogs = \App\Models\MaterialInventory::where('project_id', $project->id)
            ->with('material')
            ->latest()
            ->take(5)
            ->get();

        return view('contractor.projects.show', compact('project', 'workerCount', 'attendanceToday', 'materialLogs', 'linkedWorkers', 'totalProjectPayouts'));
    }

    public function details($id)
    {
        $project = $this->projects->find($id);
        $contractorUserId = Auth::id();

        // If the project is awarded to this contractor as a whole, show all works
        $isWholeProjectAwarded = $project->award && $project->award->awarded_to === $contractorUserId;

        if (!$isWholeProjectAwarded) {
            // Filter works to only show those specifically assigned to this contractor
            $project->setRelation('works', $project->works->filter(function($work) use ($contractorUserId) {
                return $work->pivot->contractor_id == $contractorUserId;
            }));
        }

        return view('contractor.projects.details', compact('project'));
    }

    /**
     * Handle the progress report submission.
     */
    public function storeProgress(Request $request, Project $project)
    {
        // 1. SECURITY: Check authorization again
        $isAssigned = $project->award->awarded_to === Auth::id();
        abort_unless($isAssigned, 403, 'You are not authorized to update this project.');

        // 2. Validate Input
        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'report_description'  => 'required|string|max:2000',
            'report_file'         => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'verification_photo'  => 'nullable|string', // Base64 from camera
            'latitude'            => 'nullable|numeric',
            'longitude'           => 'nullable|numeric',
            'location_address'    => 'nullable|string',
        ]);

        // 3. Handle File Upload or Camera Photo
        $filePath = null;
        if ($request->filled('verification_photo')) {
            $img = $request->verification_photo;
            $img = str_replace('data:image/jpeg;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $fileName = 'report_' . time() . '_' . uniqid() . '.jpg';
            $filePath = 'progress-reports/' . $fileName;
            Storage::disk('public')->put($filePath, $data);
        } elseif ($request->hasFile('report_file')) {
            $filePath = $request->file('report_file')->store('progress-reports', 'public');
        }

        // 4. Create the History Record
        $project->progressUpdates()->create([
            'user_id'             => Auth::id(),
            'progress_percentage' => $request->progress_percentage,
            'report_description'  => $request->report_description,
            'report_file_path'    => $filePath,
            'latitude'            => $request->latitude,
            'longitude'           => $request->longitude,
            'location_address'    => $request->location_address,
        ]);

        // 5. Update the Main Project Progress
        $project->update([
            'current_progress' => $request->progress_percentage
        ]);

        return back()->with('success', 'Progress report submitted successfully!');
    }


    /**
     * Show Add Bid Page
     */
    public function createBid($projectId)
    {
        // Load project via repo
        $project = $this->projects->find($projectId);

        // Load the view inside admin/pages (as requested)
        return view('contractor.bids.create', compact('project'));
    }

    /**
     * Store Bid (Contractor submission)
     */
    public function storeBid(Request $request, $projectId)
    {
        $request->validate([
            'bid_amount'    => 'required|numeric|min:1',
            'delivery_days' => 'required|integer|min:1',
            'proposal_text' => 'nullable|string',
            'proposal_pdf'  => 'nullable|mimes:pdf|max:5120', // max 5MB
        ]);

        $pdfPath = null;

        if ($request->hasFile('proposal_pdf')) {
            $pdfPath = $request->file('proposal_pdf')
                ->store('bids/pdf', 'public');
        }

        $this->bids->create([
            'project_id'    => $projectId,
            'contractor_id' => auth()->id(),
            'bid_amount'    => $request->bid_amount,
            'delivery_days' => $request->delivery_days,
            'proposal_text' => $request->proposal_text,
            'proposal_pdf'  => $pdfPath,   // save path
        ]);

        return redirect()->route('contractor.projects.show', $projectId)
            ->with('success', 'Bid submitted successfully.');
    }
}
