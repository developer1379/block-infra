<?php

namespace App\Repositories\Contracts;

use App\Models\Bid;
use App\Repositories\Interfaces\BidRepositoryInterface;

class BidRepository implements BidRepositoryInterface
{
    public function getByProject($projectId)
    {
        return Bid::where('project_id', $projectId)
            ->with('contractor')
            ->orderBy('bid_amount', 'asc')
            ->get();
    }

    public function find($id)
    {
        return Bid::with('contractor', 'project')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Bid::create($data);
    }

    public function updateStatus($id, $status)
    {
        $bid = $this->find($id);
        $bid->update(['status' => $status]);
        return $bid;
    }
}
