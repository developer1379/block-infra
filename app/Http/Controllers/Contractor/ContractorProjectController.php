<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContractorProjectController extends Controller
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

        $isAssigned = $project->award && $project->award->awarded_to === Auth::id();

        abort_unless($isAssigned, 403, 'You are not authorized to view this project.');

        // 2. Load necessary data for the view
        $project->load([
            'milestones',
            'progressUpdates' => function ($query) {
                $query->latest(); // Order history by newest first
            },
            'award.bid' // To show the bid amount
        ]);

        return view('contractor.projects.show', compact('project'));
    }

    public function details($id)
    {
        $project = $this->projects->find($id);
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
            'report_file'         => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // Max 5MB
        ]);

        // 3. Handle File Upload
        $filePath = null;
        if ($request->hasFile('report_file')) {
            // Stores in storage/app/public/progress-reports
            $filePath = $request->file('report_file')->store('progress-reports', 'public');
        }

        // 4. Create the History Record
        $project->progressUpdates()->create([
            'user_id'             => Auth::id(), // Optional: track who posted it
            'progress_percentage' => $request->progress_percentage,
            'report_description'  => $request->report_description,
            'report_file_path'    => $filePath,
        ]);

        // 5. Update the Main Project Progress
        $project->update([
            'current_progress' => $request->progress_percentage
        ]);

        // Optional: If progress is 100%, you might want to change status to 'completed_pending_review'
        if ($request->progress_percentage == 100) {
            // $project->update(['status' => 'completed']);
        }

        // 6. Redirect back with success message
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
