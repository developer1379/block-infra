<?php

namespace App\Repositories;

use App\Models\Worker;
use App\Models\ProjectAttendance;
use App\Repositories\Interfaces\WorkerRepositoryInterface;

class WorkerRepository implements WorkerRepositoryInterface
{
    public function getAll()
    {
        return Worker::latest()->get();
    }

    public function find($id)
    {
        return Worker::findOrFail($id);
    }

    public function create(array $data)
    {
        return Worker::create($data);
    }

    public function update($id, array $data)
    {
        $worker = $this->find($id);
        $worker->update($data);
        return $worker;
    }

    public function getByContractor($contractorId)
    {
        return Worker::where('contractor_id', $contractorId)->latest()->get();
    }

    public function recordAttendance(array $data)
    {
        return ProjectAttendance::updateOrCreate(
            [
                'project_id' => $data['project_id'],
                'worker_id' => $data['worker_id'],
                'attendance_date' => $data['attendance_date']
            ],
            $data
        );
    }
}
