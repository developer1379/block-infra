<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
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
            'search'     => $request->search,
            'status'     => $request->status,
            'created_by' => $user_id,
            'category_id' => $request->category_id ?? null,
        ];

        $projects = $this->projects->filterProjects($filters);


        return view('user::projects.index', compact('projects'));
    }


    public function create()
    {
        return view('user::projects.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'budget_min'   => 'nullable|numeric',
            'budget_max'   => 'nullable|numeric',
            'location'     => 'nullable|string|max:255',
            'categories'    => 'nullable|array',
            'categories.*'  => 'exists:categories,id',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        // Repository handles category sync
        $this->projects->create($data);

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
        return view('user::projects.edit', compact('project'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'budget_min'   => 'nullable|numeric',
            'budget_max'   => 'nullable|numeric',
            'location'     => 'nullable|string|max:255',
            'categories'    => 'nullable|array',
            'categories.*'  => 'exists:categories,id',
        ]);

        // Repository handles sync
        $this->projects->update($id, $request->all());

        return redirect()->route('user.projects.index')
            ->with('success', 'Project updated successfully.');
    }


    public function destroy($id)
    {
        $this->projects->delete($id);

        return redirect()->route('user.projects.index')
            ->with('success', 'Project deleted.');
    }
}
