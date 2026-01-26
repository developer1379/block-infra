<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MilestoneComment;
use App\Models\Project;
use App\Models\ProjectMilestone;
use App\Models\Work;
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user_id = Auth::user()->id;
        $filters = [
            'search'      => $request->search,
            'status'      => $request->status,
            'created_by'  => $user_id,
            'category_id' => $request->category_id ?? null,
        ];

        $projects = $this->projects->filterProjects($filters);

        return view('user::projects.index', compact('projects'));
    }

    public function create()
    {
        // Fetch active works for the dropdown (including Unit relation if needed for display)
        $works = Work::with('unit')->where('is_active', 1)->orderBy('name')->get();

        return view('user::projects.create', compact('works'));
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
            // Updated validation for works with quantity/amount
            'works'            => 'nullable|array',
            'works.*.quantity' => 'required|numeric|min:1',
            'works.*.amount'   => 'nullable|numeric',
        ]);

        $data = $request->except(['categories', 'works']);
        $data['created_by'] = auth()->id();

        // Create the project
        $project = $this->projects->create($data);

        // Sync Categories
        if ($request->has('categories')) {
            $project->categories()->sync($request->categories);
        }

        // Sync Works with Pivot Data (Quantity & Amount)
        // The request->works array is already keyed by ID: [ 1 => ['quantity' => 5, 'amount' => 100] ]
        if ($request->has('works')) {
            $project->works()->sync($request->works);
        }

        return redirect()->route('user.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function show($id)
    {
        $project = $this->projects->find($id);
        return view('user::projects.show', compact('project'));
    }

    public function edit($id)
    {
        $project = $this->projects->find($id);

        // Fetch works for the edit dropdown
        $works = Work::with('unit')->where('is_active', 1)->orderBy('name')->get();

        return view('user::projects.edit', compact('project', 'works'));
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
            // Updated validation
            'works'            => 'nullable|array',
            'works.*.quantity' => 'required|numeric|min:1',
            'works.*.amount'   => 'nullable|numeric',
        ]);

        // Update basic project data
        $this->projects->update($id, $request->except(['categories', 'works']));

        // Retrieve model to sync relationships
        $project = $this->projects->find($id);

        // Sync Categories
        $project->categories()->sync($request->categories ?? []);

        // Sync Works with Pivot Data
        // Passing [] if works is null handles removing all works if the user cleared the list
        $project->works()->sync($request->works ?? []);

        return redirect()->route('user.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $this->projects->delete($id);

        return redirect()->route('user.projects.index')
            ->with('success', 'Project deleted.');
    }

    public function updateMilestoneStatus(Request $request, $id)
    {
        $request->validate([
            'status'  => 'required|string|in:pending,in_progress,completed,on_hold,paid',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $milestone = ProjectMilestone::where('id', $id)->firstOrFail();

        // Optional: Verify user owns the project
        if ($milestone->project->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Update Status
        $milestone->update([
            'status' => $request->status
        ]);

        // If remarks exist, add them as a comment so they are preserved
        if ($request->filled('remarks')) {
            MilestoneComment::create([
                'milestone_id' => $milestone->id,
                'user_id'      => Auth::id(),
                'content'      => "Status updated to " . ucfirst(str_replace('_', ' ', $request->status)) . ".\nNote: " . $request->remarks,
            ]);
        }

        return back()->with('success', 'Milestone status updated.');
    }
}
