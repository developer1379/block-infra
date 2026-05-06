<?php

namespace App\Repositories\Interfaces;

interface MaterialRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function create(array $data);
    public function recordInventory(array $data);
    public function getStockByProject($projectId);
}
