<?php

namespace App\Repositories\Contracts;

use App\Models\Project;
use App\Models\User;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAll()
    {
        return Project::with('createdBy')->latest()->get();
    }

    public function find($id)
    {
        return Project::with('bids.contractor')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Project::create($data);
    }

    public function update($id, array $data)
    {
        $project = $this->find($id);
        $project->update($data);
        return $project;
    }

    public function delete($id)
    {
        return Project::destroy($id);
    }

    public function getOpenProjects()
    {
        return Project::where('status', 'open')
            ->with('bids')
            ->latest()
            ->get();
    }

    public function getProjectsWithBids()
    {
        return Project::withCount('bids')
            ->with('bids.contractor')
            ->latest()
            ->get();
    }

    /** ⭐ NEW: FILTER SUPPORT */
    public function filterProjects($filters)
    {
        $query = Project::query()->with('createdBy');

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['created_by'])) {
            $query->where('created_by', $filters['created_by']);
        }

        return $query->orderBy('id', 'DESC')->get();
    }

    /** ⭐ NEW: FETCH USERS FOR DROPDOWN */
    public function getProjectCreators()
    {
        return User::select('id', 'name')->orderBy('name')->get();
    }
}
