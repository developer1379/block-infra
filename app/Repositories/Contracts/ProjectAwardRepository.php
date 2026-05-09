<?php

namespace App\Repositories\Contracts;

use App\Models\ProjectAward;
use App\Repositories\Interfaces\ProjectAwardRepositoryInterface;

class ProjectAwardRepository implements ProjectAwardRepositoryInterface
{
    public function award(array $data)
    {
        return ProjectAward::create($data);
    }

    public function createOrUpdate(array $attributes, array $values)
    {
        return ProjectAward::updateOrCreate($attributes, $values);
    }

    public function getByProject($projectId)
    {
        return ProjectAward::where('project_id', $projectId)
            ->with(['project', 'bid.contractor'])
            ->first();
    }
}
