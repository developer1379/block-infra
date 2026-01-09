<?php

namespace App\Repositories\ProjectProgressUpdate\Interfaces;

interface ProjectProgressUpdateRepositoryInterface
{
    public function getByProjectId(int $projectId);
    public function create(array $data);
    public function getLatestProgress(int $projectId);
}
