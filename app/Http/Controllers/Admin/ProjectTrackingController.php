<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project; // Or use ProjectRepositoryInterface
use App\Models\Material;
use App\Models\MaterialInventory;
use App\Repositories\ProjectMilestone\Interfaces\ProjectMilestoneRepositoryInterface;

class ProjectTrackingController extends Controller
{
    protected $milestoneRepo;

    public function __construct(ProjectMilestoneRepositoryInterface $milestoneRepo)
    {
        $this->milestoneRepo = $milestoneRepo;
    }

    /**
     * Display the tracking page (The view you created)
     */
    public function show($id)
    {
        // Fetch project with all necessary relationships
        $project = Project::with([
            'award.bid',
            'award.awardedTo',
            'milestones.projectWork.work',
            'progressUpdates',
            'works',
            'inventoryLogs.material'
        ])->findOrFail($id);

        $materials = Material::orderBy('name')->get();

        // Calculate Overall Progress (Weighted by milestone amount)
        $totalWeight = $project->milestones->sum('amount');
        $weightedProgress = 0;
        
        if ($totalWeight > 0) {
            foreach ($project->milestones as $milestone) {
                $weightedProgress += (($milestone->progress ?? 0) * $milestone->amount);
            }
            $overallProgress = round($weightedProgress / $totalWeight);
        } else {
            // Fallback to simple average if no amounts are set
            $overallProgress = $project->milestones->count() > 0 
                ? round($project->milestones->avg('progress') ?? 0) 
                : 0;
        }

        return view('admin.projects.tracking', compact('project', 'overallProgress', 'materials'));
    }

    /**
     * Store a new Milestone
     */
    public function storeMilestone(Request $request)
    {
        $data = $request->validate([
            'project_id'       => 'required|exists:projects,id',
            'project_work_id'  => 'nullable|exists:project_works,id',
            'title'            => 'required|string|max:255',
            'amount'           => 'required|numeric|min:0',
            'due_date'         => 'nullable|date',
            'description'      => 'nullable|string'
        ]);

        $this->milestoneRepo->create($data);

        return back()->with('success', 'Milestone added successfully.');
    }

    /**
     * Update Milestone Status (e.g. Mark as Paid/Completed)
     */
    public function updateMilestoneStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,paid'
        ]);

        $this->milestoneRepo->updateStatus($id, $request->status);

        return back()->with('success', 'Milestone status updated.');
    }

    /**
     * Delete a Milestone
     */
    public function destroyMilestone($id)
    {
        $this->milestoneRepo->delete($id);
        return back()->with('success', 'Milestone deleted.');
    }

    /**
     * Allocate Material to Project
     */
    public function allocateMaterial(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'material_id' => 'required|exists:materials,id',
            'quantity' => 'required|numeric|min:0.01',
            'unit_price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'entry_date' => 'required|date'
        ]);

        MaterialInventory::create([
            'project_id' => $request->project_id,
            'material_id' => $request->material_id,
            'quantity' => $request->quantity,
            'type' => 'in', // Allocation is an 'in' for the project site
            'unit_price' => $request->unit_price,
            'entry_date' => $request->entry_date,
            'notes' => $request->notes,
            'vendor_name' => 'Admin Allocation'
        ]);

        return back()->with('success', 'Material allocated to project successfully.');
    }
}

