<?php

namespace App\Repositories\Interfaces;

interface SiteReportRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function create(array $data);
    public function getByProject($projectId);
    public function addPhotos($reportId, array $photos);
}
