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
            return view('admin.projects.show', compact('project'));
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
            // Load milestones and invoices
            $milestones = \App\Models\ProjectMilestone::where('project_id', $id)->get();
            $invoices = \App\Models\Invoice::where('project_id', $id)->with('payments')->get();
            
            return view('admin.projects.payments', compact('project', 'milestones', 'invoices'));
        } catch (Exception $e) {
            Log::error('Project Payments Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load project finances.');
        }
    }
}

