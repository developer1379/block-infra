<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project; // Or use ProjectRepositoryInterface
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
            'works'
        ])->findOrFail($id);

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

        return view('admin.projects.tracking', compact('project', 'overallProgress'));
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
            'amount'           => 'nullable|numeric|min:0',
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
}

