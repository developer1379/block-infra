<?php

namespace App\Repositories;

use App\Models\DailySiteReport;
use App\Models\SitePhoto;
use App\Repositories\Interfaces\SiteReportRepositoryInterface;

class SiteReportRepository implements SiteReportRepositoryInterface
{
    public function getAll()
    {
        return DailySiteReport::latest()->get();
    }

    public function find($id)
    {
        return DailySiteReport::with('photos')->findOrFail($id);
    }

    public function create(array $data)
    {
        return DailySiteReport::create($data);
    }

    public function getByProject($projectId)
    {
        return DailySiteReport::where('project_id', $projectId)->with('photos')->latest()->get();
    }

    public function addPhotos($reportId, array $photos)
    {
        foreach ($photos as $photo) {
            SitePhoto::create([
                'report_id' => $reportId,
                'photo_path' => $photo['path'],
                'caption' => $photo['caption'] ?? null
            ]);
        }
    }
}
