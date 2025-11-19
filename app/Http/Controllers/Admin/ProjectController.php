<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projects;

    public function __construct(ProjectRepositoryInterface $projects)
    {
        $this->projects = $projects;
    }

    public function index(Request $request)
    {
        $filters = [
            'search'     => $request->search,
            'status'     => $request->status,
            'created_by' => $request->created_by,
        ];

        $projects = $this->projects->filterProjects($filters);

        // Get users for filters
        $createdByUsers = $this->projects->getProjectCreators();

        // If contractor role → check bid status
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
        return view('admin.pages.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string',
            'description' => 'required|string',
            'budget_min'  => 'nullable|numeric',
            'budget_max'  => 'nullable|numeric',
            'location'    => 'nullable|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

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
            'title'       => 'required|string',
            'description' => 'required|string',
        ]);

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
