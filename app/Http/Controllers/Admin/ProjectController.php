<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Work; // Import Work Model
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\Request;

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

        return view('admin.pages.projects.index', compact('projects', 'createdByUsers', 'hasBid'));
    }

    public function create()
    {
        // Fetch active works for the dropdown (including Unit relation if needed for display)
        $works = Work::with('unit')->where('is_active', 1)->orderBy('name')->get();

        return view('admin.pages.projects.create', compact('works'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'budget_max'       => 'nullable|numeric', // Removed budget_min to match new logic
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
        if ($request->has('works')) {
            $project->works()->sync($request->works);
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function show($id)
    {
        $project = $this->projects->find($id);
        return view('admin.pages.projects.show', compact('project'));
    }

    public function edit($id)
    {
        $project = $this->projects->find($id);

        // Fetch active works for the dropdown
        $works = Work::with('unit')->where('is_active', 1)->orderBy('name')->get();

        return view('admin.pages.projects.edit', compact('project', 'works'));
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
        $project->works()->sync($request->works ?? []);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $this->projects->delete($id);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted.');
    }
}
