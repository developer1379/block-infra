<?php

namespace App\Repositories;

use App\Models\ProjectAttendance;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    public function getAll()
    {
        return ProjectAttendance::with(['project', 'worker'])->latest()->get();
    }

    public function find($id)
    {
        return ProjectAttendance::with(['project', 'worker'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return ProjectAttendance::create($data);
    }

    public function getByProjectAndDate($projectId, $date)
    {
        return ProjectAttendance::where('project_id', $projectId)
            ->where('attendance_date', $date)
            ->with('worker')
            ->get();
    }

    public function getByWorker($workerId)
    {
        return ProjectAttendance::where('worker_id', $workerId)
            ->with('project')
            ->latest()
            ->get();
    }

    public function getAllPaginated(array $projectIds, $perPage = 15)
    {
        return ProjectAttendance::whereIn('project_id', $projectIds)
            ->with(['project', 'worker'])
            ->latest('attendance_date')
            ->paginate($perPage);
    }
}
