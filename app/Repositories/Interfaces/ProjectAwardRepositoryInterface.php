<?php

namespace App\Repositories\Interfaces;

interface ProjectAwardRepositoryInterface
{
    public function award(array $data);
    public function getByProject($projectId);
}
