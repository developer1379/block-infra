<?php

namespace App\Repositories;

use App\Models\Unit;
use App\Repositories\Contracts\UnitRepositoryInterface;

class UnitRepository implements UnitRepositoryInterface
{
    public function all()
    {
        return Unit::where('is_active', 1)->orderBy('name')->get();
    }

    public function find(int $id)
    {
        return Unit::findOrFail($id);
    }

    public function create(array $data)
    {
        return Unit::create($data);
    }

    public function update(int $id, array $data)
    {
        $unit = Unit::findOrFail($id);
        $unit->update($data);
        return $unit;
    }

    public function delete(int $id): bool
    {
        $unit = Unit::findOrFail($id);
        return (bool) $unit->delete();
    }
}
