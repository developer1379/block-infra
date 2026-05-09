<?php

namespace App\Repositories\Interfaces;

interface ProjectAwardRepositoryInterface
{
    public function award(array $data);
    public function createOrUpdate(array $attributes, array $values);
    public function getByProject($projectId);
}
