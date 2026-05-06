<?php

namespace App\Repositories\Interfaces;

interface WorkerRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function getByContractor($contractorId);
    public function recordAttendance(array $data);
}
