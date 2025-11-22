<?php

namespace App\Repositories\Contracts;

use App\Models\Project;
use App\Models\User;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getAll()
    {
        return Project::with(['createdBy', 'categories'])
            ->latest()
            ->get();
    }

    public function find($id)
    {
        return Project::with(['bids.contractor', 'categories'])
            ->findOrFail($id);
    }

    public function create(array $data)
    {
        // Extract category IDs
        $categoryIds = $data['categories'] ?? [];

        unset($data['categories']);

        // Create project
        $project = Project::create($data);

        // Sync categories
        if (!empty($categoryIds)) {
            $project->categories()->sync($categoryIds);
        }

        return $project;
    }

    public function update($id, array $data)
    {
        $project = $this->find($id);

        // Extract category IDs (if present)
        $categoryIds = $data['categories'] ?? null;
        unset($data['categories']);

        // Update project fields
        $project->update($data);

        // Sync category pivot
        if (!is_null($categoryIds)) {
            $project->categories()->sync($categoryIds);
        }

        return $project;
    }

    public function delete($id)
    {
        return Project::destroy($id);
    }

    public function getOpenProjects()
    {
        return Project::with(['bids', 'categories'])
            ->where('status', 'open')
            ->latest()
            ->get();
    }

    public function getProjectsWithBids()
    {
        return Project::withCount('bids')
            ->with(['bids.contractor', 'categories'])
            ->latest()
            ->get();
    }

    /** ⭐ FILTER SUPPORT */
    public function filterProjects($filters)
    {
        $query = Project::query()->with(['createdBy', 'categories']);

        // 🔍 Search
        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        // 📌 Status Filter
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // 👤 Admin Filter by Creator
        if (!empty($filters['created_by'])) {
            $query->where('created_by', $filters['created_by']);
        }

        // 🏷 Category Filter (for admin)
        if (!empty($filters['category_id'])) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('categories.id', $filters['category_id']);
            });
        }

        if (auth()->user()->hasRole('contractor')) {

            $contractor = auth()->user()->contractor;

            if (!$contractor) {
                return collect([]);  // return empty collection
            }

            $contractorCategoryIds = $contractor->categories->pluck('id')->toArray();

            if (empty($contractorCategoryIds)) {
                return collect([]);
            }

            $query->whereHas('categories', function ($q) use ($contractorCategoryIds) {
                $q->whereIn('categories.id', $contractorCategoryIds);
            });
        }

        return $query->orderBy('id', 'DESC')->get();
    }


    /** ⭐ FETCH USERS FOR DROPDOWN */
    public function getProjectCreators()
    {
        return User::select('id', 'name')->orderBy('name')->get();
    }
}
