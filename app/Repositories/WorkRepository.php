<?php

namespace App\Repositories;

use App\Models\Work;
use App\Repositories\Contracts\WorkRepositoryInterface;

class WorkRepository implements WorkRepositoryInterface
{
    public function all()
    {
        return Work::with(['category', 'unit'])->orderBy('id', 'desc')->get();
    }

    public function find(int $id)
    {
        return Work::with(['category', 'unit'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Work::create($data);
    }

    public function update(int $id, array $data)
    {
        $work = Work::findOrFail($id);
        $work->update($data);
        return $work;
    }

    public function delete(int $id): bool
    {
        $work = Work::findOrFail($id);
        return (bool) $work->delete();
    }
}
