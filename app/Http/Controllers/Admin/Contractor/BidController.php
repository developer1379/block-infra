<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\Request;

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

    /**
     * Show Add Bid Page
     */
    public function create($projectId)
    {
        // Load project via repo
        $project = $this->projects->find($projectId);

        // Load the view inside admin/pages (as requested)
        return view('admin.pages.bids.create', compact('project'));
    }

    /**
     * Store Bid (Contractor submission)
     */
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'bid_amount'    => 'required|numeric|min:1',
            'delivery_days' => 'required|integer|min:1',
            'proposal_text' => 'nullable|string'
        ]);

        // Save Bid using Repository
        $this->bids->create([
            'project_id'    => $projectId,
            'contractor_id' => auth()->id(),   // contractor user ID
            'bid_amount'    => $request->bid_amount,
            'delivery_days' => $request->delivery_days,
            'proposal_text' => $request->proposal_text,
        ]);

        return redirect()->route('admin.projects.show', $projectId)
            ->with('success', 'Bid submitted successfully.');
    }


}
