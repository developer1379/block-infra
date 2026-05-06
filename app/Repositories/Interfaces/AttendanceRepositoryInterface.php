<?php

namespace App\Repositories\Interfaces;

interface AttendanceRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function create(array $data);
    public function getByProjectAndDate($projectId, $date);
    public function getByWorker($workerId);
    public function getAllPaginated(array $projectIds, $perPage = 15);
}
