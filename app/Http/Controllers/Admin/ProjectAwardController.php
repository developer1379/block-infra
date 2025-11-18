<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function awardBid($projectId, $bidId)
    {
        $bid = $this->bids->find($bidId);

        // Update bid status
        $this->bids->updateStatus($bidId, 'accepted');

        // Create award entry
        $this->awards->award([
            'project_id' => $projectId,
            'bid_id'     => $bidId,
            'awarded_to' => $bid->contractor_id,
        ]);

        // Mark project as awarded
        $this->projects->update($projectId, [
            'status' => 'awarded'
        ]);

        return redirect()->back()->with('success', 'Bid awarded successfully.');
    }
}
