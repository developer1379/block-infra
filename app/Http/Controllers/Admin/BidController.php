<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;

class BidController extends Controller
{
    protected $bids, $projects;

    public function __construct(
        BidRepositoryInterface $bids,
        ProjectRepositoryInterface $projects
    ) {
        $this->bids = $bids;
        $this->projects = $projects;
    }

    public function projectBids($projectId)
    {
        $project = $this->projects->find($projectId);
        $bids = $this->bids->getByProject($projectId);

        return view('admin.pages.bids.index', compact('project', 'bids'));
    }
}
