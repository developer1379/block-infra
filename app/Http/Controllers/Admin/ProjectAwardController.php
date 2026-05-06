<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Project;
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Interfaces\ProjectAwardRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class ProjectAwardController extends Controller
{
    protected $awards, $bids, $projects;

    public function __construct(
        ProjectAwardRepositoryInterface $awards,
        BidRepositoryInterface $bids,
        ProjectRepositoryInterface $projects
    ) {
        $this->awards = $awards;
        $this->bids = $bids;
        $this->projects = $projects;
    }

    public function award($projectId, $bidId)
    {
        try {
            // 1️⃣ Mark selected bid as accepted using repository
            $this->bids->update($bidId, ['status' => 'accepted']);

            // 2️⃣ Reject all other bids for this project
            \App\Models\Bid::where('project_id', $projectId)
                ->where('id', '!=', $bidId)
                ->update(['status' => 'rejected']);

            // 3️⃣ Save award details using repository
            $bid = $this->bids->find($bidId);
            $this->awards->createOrUpdate(
                ['project_id' => $projectId],
                [
                    'bid_id' => $bidId,
                    'awarded_to' => $bid->contractor_id,
                    'awarded_at' => now()
                ]
            );

            // 4️⃣ Update project status to awarded using repository
            $this->projects->update($projectId, ['status' => 'awarded']);

            return redirect()->back()->with('success', 'Bid awarded successfully.');
        } catch (\Exception $e) {
            \Log::error('Project Award Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to award project.');
        }
    }
}
