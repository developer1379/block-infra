<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Contracts\WorkRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ProjectController extends Controller
{
    protected $projects;
    protected $bids;
    protected $works;

    public function __construct(
        ProjectRepositoryInterface $projects,
        BidRepositoryInterface $bids,
        WorkRepositoryInterface $works
    ) {
        $this->projects = $projects;
        $this->bids = $bids;
        $this->works = $works;
    }

    public function index(Request $request)
    {
        try {
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

            return view('admin.projects.index', compact('projects', 'createdByUsers', 'hasBid'));
        } catch (Exception $e) {
            Log::error('Project Index Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load projects list.');
        }
    }

    public function create()
    {
        try {
            // Fetch active works for the dropdown using repository
            $works = $this->works->all();
            return view('admin.projects.create', compact('works'));
        } catch (Exception $e) {
            Log::error('Project Create Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to load project creation form.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'budget_max'       => 'nullable|numeric',
            'location'         => 'nullable|string|max:255',
            'categories'       => 'nullable|array',
            'categories.*'     => 'exists:categories,id',
            'works'            => 'nullable|array',
            'works.*.quantity' => 'required|numeric|min:1',
            'works.*.amount'   => 'nullable|numeric',
        ]);

        try {
            $data = $request->except(['categories', 'works']);
            $data['created_by'] = auth()->id();

            // Create the project
            $project = $this->projects->create($data);

            // Sync Categories
            if ($request->has('categories')) {
                $project->categories()->sync($request->categories);
            }

            // Sync Works with Pivot Data (Quantity & Amount)
            if ($request->has('works')) {
                $project->works()->sync($request->works);
            }

            return redirect()->route('admin.projects.index')
                ->with('success', 'Project created successfully.');
        } catch (Exception $e) {
            Log::error('Project Store Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to save project.');
        }
    }

    public function show($id)
    {
        try {
            $project = $this->projects->find($id);
            
            // Stats & Analytics
            $workerCount = \App\Models\ProjectAttendance::where('project_id', $project->id)
                ->distinct('worker_id')
                ->count();
                
            $attendanceToday = \App\Models\ProjectAttendance::where('project_id', $project->id)
                ->whereDate('attendance_date', now())
                ->count();
                
            $totalProjectPayouts = \App\Models\WorkerPayment::where('project_id', $project->id)
                ->where('status', 'verified')
                ->sum('amount');
                
            $pendingProjectPayouts = \App\Models\WorkerPayment::where('project_id', $project->id)
                ->where('status', 'pending')
                ->sum('amount');

            // 1. Linked Workers (Active on this project based on attendance)
            $linkedWorkers = \App\Models\Worker::whereHas('attendances', function($q) use ($project) {
                    $q->where('project_id', $project->id);
                })
                ->withCount(['attendances' => function($q) use ($project) {
                    $q->where('project_id', $project->id);
                }])
                ->get();

            $groupedMaterials = \App\Models\MaterialInventory::where('project_id', $project->id)
                ->with(['material' => function($q) {
                    $q->select('id', 'name', 'unit');
                }])
                ->orderBy('entry_date', 'desc')
                ->get()
                ->groupBy('material_id');

            $contractors = \App\Models\User::role('contractor')->with('contractor')->orderBy('name')->get();

            return view('admin.projects.show', compact(
                'project', 
                'workerCount', 
                'attendanceToday', 
                'totalProjectPayouts', 
                'pendingProjectPayouts',
                'groupedMaterials',
                'linkedWorkers',
                'contractors'
            ));
        } catch (Exception $e) {
            Log::error('Project Show Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load project details.');
        }
    }

    public function edit($id)
    {
        try {
            $project = $this->projects->find($id);
            $works = $this->works->all();
            return view('admin.projects.edit', compact('project', 'works'));
        } catch (Exception $e) {
            Log::error('Project Edit Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load project for editing.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'budget_max'       => 'nullable|numeric',
            'location'         => 'nullable|string|max:255',
            'categories'       => 'nullable|array',
            'categories.*'     => 'exists:categories,id',
            'works'            => 'nullable|array',
            'works.*.quantity' => 'required|numeric|min:1',
            'works.*.amount'   => 'nullable|numeric',
        ]);

        try {
            // Update basic project data
            $this->projects->update($id, $request->except(['categories', 'works']));

            // Retrieve model to sync relationships
            $project = $this->projects->find($id);

            // Sync Categories
            $project->categories()->sync($request->categories ?? []);

            // Sync Works with Pivot Data
            $project->works()->sync($request->works ?? []);

            return redirect()->route('admin.projects.index')
                ->with('success', 'Project updated successfully.');
        } catch (Exception $e) {
            Log::error('Project Update Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update project.');
        }
    }

    public function destroy($id)
    {
        try {
            $this->projects->delete($id);
            return redirect()->route('admin.projects.index')
                ->with('success', 'Project deleted.');
        } catch (Exception $e) {
            Log::error('Project Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to delete project.');
        }
    }

    public function payments($id)
    {
        try {
            $project = $this->projects->find($id);
            // Load milestones, invoices, and direct project payments
            $milestones = \App\Models\ProjectMilestone::where('project_id', $id)->get();
            $invoices = \App\Models\Invoice::where('project_id', $id)->with('payments')->get();
            $projectPayments = \App\Models\ProjectPayment::where('project_id', $id)->latest()->get();
            
            return view('admin.projects.payments', compact('project', 'milestones', 'invoices', 'projectPayments'));
        } catch (Exception $e) {
            Log::error('Project Payments Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load project finances.');
        }
    }

    public function storePayment(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'transaction_reference' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        try {
            \App\Models\ProjectPayment::create([
                'project_id' => $id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'transaction_reference' => $request->transaction_reference,
                'notes' => $request->notes
            ]);

            return back()->with('success', 'Payment recorded successfully.');
        } catch (Exception $e) {
            Log::error('Admin Project Store Payment Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to record payment.');
        }
    }
}

