<?php

namespace App\Repositories\Interfaces;

interface BidRepositoryInterface
{
    public function getByProject($projectId);
    public function find($id);
    public function create(array $data);
    public function updateStatus($id, $status);
}
