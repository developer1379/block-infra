<?php

namespace App\Repositories\ProjectMilestone;

use App\Models\ProjectMilestone;
use App\Repositories\ProjectMilestone\Interfaces\ProjectMilestoneRepositoryInterface;

class ProjectMilestoneRepository implements ProjectMilestoneRepositoryInterface
{
    public function getByProjectId(int $projectId)
    {
        return ProjectMilestone::where('project_id', $projectId)
            ->orderBy('due_date', 'asc')
            ->get();
    }

    public function create(array $data)
    {
        return ProjectMilestone::create($data);
    }

    public function update(int $id, array $data)
    {
        $milestone = ProjectMilestone::findOrFail($id);
        $milestone->update($data);
        return $milestone;
    }

    public function delete(int $id)
    {
        $milestone = ProjectMilestone::findOrFail($id);
        return $milestone->delete();
    }

    public function updateStatus(int $id, string $status)
    {
        $milestone = ProjectMilestone::findOrFail($id);
        $milestone->status = $status;
        $milestone->save();
        return $milestone;
    }
}
