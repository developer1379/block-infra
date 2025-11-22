<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
            'search'     => $request->search,
            'status'     => $request->status,
            'created_by' => $request->created_by,
            'category_id' => $request->category_id ?? null, // NEW - category filter support
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
        // We will load categories inside Blade, same as contractor create/edit
        return view('admin.pages.projects.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'budget_min'   => 'nullable|numeric',
            'budget_max'   => 'nullable|numeric',
            'location'     => 'nullable|string|max:255',

            // ⭐ NEW: multiple categories
            'categories'    => 'nullable|array',
            'categories.*'  => 'exists:categories,id',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        // Repository handles category sync
        $this->projects->create($data);

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
        return view('admin.pages.projects.edit', compact('project'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'budget_min'   => 'nullable|numeric',
            'budget_max'   => 'nullable|numeric',
            'location'     => 'nullable|string|max:255',

            // ⭐ NEW: multiple categories
            'categories'    => 'nullable|array',
            'categories.*'  => 'exists:categories,id',
        ]);

        // Repository handles sync
        $this->projects->update($id, $request->all());

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
