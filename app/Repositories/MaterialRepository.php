<?php

namespace App\Repositories;

use App\Models\Material;
use App\Models\MaterialInventory;
use App\Repositories\Interfaces\MaterialRepositoryInterface;
use Illuminate\Support\Facades\DB;

class MaterialRepository implements MaterialRepositoryInterface
{
    public function getAll()
    {
        return Material::latest()->get();
    }

    public function find($id)
    {
        return Material::findOrFail($id);
    }

    public function create(array $data)
    {
        return Material::create($data);
    }

    public function recordInventory(array $data)
    {
        return MaterialInventory::create($data);
    }

    public function getStockByProject($projectId)
    {
        return MaterialInventory::where('project_id', $projectId)
            ->select('material_id', DB::raw('SUM(CASE WHEN type = "purchase" THEN quantity ELSE -quantity END) as current_stock'))
            ->groupBy('material_id')
            ->with('material')
            ->get();
    }
}
