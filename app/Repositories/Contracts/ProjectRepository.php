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
            $contractorUserId = auth()->id();

            if (!$contractor) {
                return collect([]);
            }

            $contractorUuid = $contractor->id;
            $contractorCategoryIds = $contractor->categories->pluck('id')->toArray();

            $query->where(function ($q) use ($contractorCategoryIds, $contractorUserId, $contractorUuid) {
                // 1. Projects matching contractor categories (if status is open)
                if (!empty($contractorCategoryIds)) {
                    $q->whereHas('categories', function ($catQ) use ($contractorCategoryIds) {
                        $catQ->whereIn('categories.id', $contractorCategoryIds);
                    })->where('status', 'open');
                }

                // 2. Projects directly assigned to this contractor
                $q->orWhere('contractor_id', $contractorUuid);

                // 3. Projects where they have at least one assigned work item
                $q->orWhereHas('projectWorks', function ($workQ) use ($contractorUserId) {
                    $workQ->where('contractor_id', $contractorUserId);
                });

                // 4. Projects where they have submitted a bid (to keep tracking them)
                $q->orWhereHas('bids', function ($bidQ) use ($contractorUserId) {
                    $bidQ->where('contractor_id', $contractorUserId);
                });
            });
        }

        return $query->orderBy('id', 'DESC')->paginate(50);
    }

    public function getProjectCreators()
    {
        return User::select('id', 'name')->orderBy('name')->get();
    }

    public function countProjectsByContractor($contractorUserId)
    {
        $contractor = \App\Models\Contractor::where('user_id', $contractorUserId)->first();
        $contractorUuid = $contractor ? $contractor->id : null;

        return Project::where(function($q) use ($contractorUserId, $contractorUuid) {
            if ($contractorUuid) {
                $q->where('contractor_id', $contractorUuid);
            }
            $q->orWhereHas('bids', function ($query) use ($contractorUserId) {
                  $query->where('contractor_id', $contractorUserId);
              })
              ->orWhereHas('projectWorks', function ($query) use ($contractorUserId) {
                  $query->where('contractor_id', $contractorUserId);
              });
        })->count();
    }

    public function getOngoingProjectsByContractor($contractorUserId)
    {
        $contractor = \App\Models\Contractor::where('user_id', $contractorUserId)->first();
        $contractorUuid = $contractor ? $contractor->id : null;

        return Project::where('status', 'awarded')
            ->where(function($q) use ($contractorUserId, $contractorUuid) {
                if ($contractorUuid) {
                    $q->where('contractor_id', $contractorUuid);
                }
                $q->orWhereHas('bids', function ($query) use ($contractorUserId) {
                      $query->where('contractor_id', $contractorUserId)
                            ->where('status', 'accepted');
                  })
                  ->orWhereHas('projectWorks', function ($query) use ($contractorUserId) {
                      $query->where('contractor_id', $contractorUserId);
                  });
            })->with(['bids' => function ($query) use ($contractorUserId) {
                $query->where('contractor_id', $contractorUserId);
            }])->get();
    }

    public function getProjectsByContractor($contractorUserId)
    {
        $contractor = \App\Models\Contractor::where('user_id', $contractorUserId)->first();
        $contractorUuid = $contractor ? $contractor->id : null;

        return Project::where(function($q) use ($contractorUserId, $contractorUuid) {
            if ($contractorUuid) {
                $q->where('contractor_id', $contractorUuid);
            }
            $q->orWhereHas('bids', function ($query) use ($contractorUserId) {
                  $query->where('contractor_id', $contractorUserId);
              })
              ->orWhereHas('projectWorks', function ($query) use ($contractorUserId) {
                  $query->where('contractor_id', $contractorUserId);
              });
        })->with(['bids' => function ($query) use ($contractorUserId) {
            $query->where('contractor_id', $contractorUserId);
        }])->get();
    }

    public function countBidsByContractor($contractorId)
    {
        return \App\Models\Bid::where('contractor_id', $contractorId)->count();
    }

    public function directAllocate($projectId, $contractorUserId)
    {
        $project = $this->find($projectId);
        
        $contractor = $contractorUserId ? \App\Models\Contractor::where('user_id', $contractorUserId)->first() : null;
        $contractorUuid = $contractor ? $contractor->id : null;

        // Update project
        $project->update([
            'contractor_id' => $contractorUuid,
            'status' => $contractorUuid ? 'awarded' : 'open'
        ]);

        // Update all project works to this contractor (using User ID as per our schema)
        \App\Models\ProjectWork::where('project_id', $projectId)
            ->update(['contractor_id' => $contractorUserId]);

        return $project;
    }

    public function assignWorkToContractor($projectWorkId, $contractorUserId)
    {
        $work = \App\Models\ProjectWork::findOrFail($projectWorkId);
        $work->update(['contractor_id' => $contractorUserId]);
        
        // Ensure project status is updated
        $project = $work->project;
        if ($contractorUserId) {
            if ($project->status == 'open') {
                $project->update(['status' => 'awarded']);
            }

            // Also update project.contractor_id if not set (optional, but helps with backward compatibility)
            if (!$project->contractor_id) {
                $contractor = \App\Models\Contractor::where('user_id', $contractorUserId)->first();
                if ($contractor) {
                    $project->update(['contractor_id' => $contractor->id]);
                }
            }
        }

        return $work;
    }


}
