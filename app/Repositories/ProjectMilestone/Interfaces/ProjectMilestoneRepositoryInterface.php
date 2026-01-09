<?php

namespace App\Repositories\ProjectMilestone\Interfaces;

interface ProjectMilestoneRepositoryInterface
{
    public function getByProjectId(int $projectId);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function updateStatus(int $id, string $status);
}
