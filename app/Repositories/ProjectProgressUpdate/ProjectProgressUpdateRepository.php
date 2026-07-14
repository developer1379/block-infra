<?php

namespace App\Repositories\ProjectProgressUpdate;

use App\Models\ProjectProgressUpdate;
use Illuminate\Support\Facades\Storage;
use App\Repositories\ProjectProgressUpdate\Interfaces\ProjectProgressUpdateRepositoryInterface;

class ProjectProgressUpdateRepository implements ProjectProgressUpdateRepositoryInterface
{
    public function getByProjectId(int $projectId)
    {
        return ProjectProgressUpdate::with('user')
            ->where('project_id', $projectId)
            ->latest()
            ->get();
    }

    public function create(array $data)
    {
        // Handle file upload if present
        if (isset($data['report_file']) && $data['report_file']) {
            $file = $data['report_file'];
            if (str_starts_with($file->getMimeType(), 'image/')) {
                $path = app(\App\Services\ImgBBService::class)->upload($file);
            } else {
                $path = $file->store('projects/reports', 'public');
            }
            $data['report_file_path'] = $path;
            unset($data['report_file']); // Remove file object from array before saving
        }

        return ProjectProgressUpdate::create($data);
    }

    public function getLatestProgress(int $projectId)
    {
        return ProjectProgressUpdate::where('project_id', $projectId)
            ->latest()
            ->first();
    }
}
