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

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

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

        return $query->orderBy('id', 'DESC')->paginate(50);
    }

    public function getProjectCreators()
    {
        return User::select('id', 'name')->orderBy('name')->get();
    }

    public function countProjectsByContractor($contractorId)
    {
        return Project::whereHas('bids', function ($query) use ($contractorId) {
            $query->where('contractor_id', $contractorId);
        })->count();
    }

    public function getOngoingProjectsByContractor($contractorId)
    {
        return Project::whereHas('bids', function ($query) use ($contractorId) {
            $query->where('contractor_id', $contractorId)
                  ->where('status', 'awarded');
        })->with(['bids' => function ($query) use ($contractorId) {
            $query->where('contractor_id', $contractorId)
                  ->where('status', 'awarded');
        }])->get();
    }

    public function getProjectsByContractor($contractorId)
    {
        return Project::where(function($q) use ($contractorId) {
            $q->where('contractor_id', $contractorId)
              ->orWhereHas('bids', function ($query) use ($contractorId) {
                  $query->where('contractor_id', $contractorId);
              })
              ->orWhereHas('projectWorks', function ($query) use ($contractorId) {
                  $query->where('contractor_id', $contractorId);
              });
        })->with(['bids' => function ($query) use ($contractorId) {
            $query->where('contractor_id', $contractorId);
        }])->get();
    }

    public function countBidsByContractor($contractorId)
    {
        return \App\Models\Bid::where('contractor_id', $contractorId)->count();
    }

    public function directAllocate($projectId, $contractorId)
    {
        $project = $this->find($projectId);
        
        // Update project
        $project->update([
            'contractor_id' => $contractorId,
            'status' => 'awarded'
        ]);

        // Update all project works to this contractor
        \App\Models\ProjectWork::where('project_id', $projectId)
            ->update(['contractor_id' => $contractorId]);

        return $project;
    }

    public function assignWorkToContractor($projectWorkId, $contractorId)
    {
        $work = \App\Models\ProjectWork::findOrFail($projectWorkId);
        $work->update(['contractor_id' => $contractorId]);
        
        // If it's the first work assigned, maybe update project status to 'partially_awarded' or just 'awarded'
        $project = $work->project;
        if ($project->status == 'open') {
            $project->update(['status' => 'awarded']);
        }

        return $work;
    }


}
