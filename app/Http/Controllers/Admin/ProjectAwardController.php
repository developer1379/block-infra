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

            // 4️⃣ Update project status to awarded and sync all works to this contractor
            $this->projects->directAllocate($projectId, $bid->contractor_id);

            return redirect()->back()->with('success', 'Bid awarded successfully.');
        } catch (\Exception $e) {
            \Log::error('Project Award Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to award project.');
        }
    }

    public function directAllocate(\Illuminate\Http\Request $request, $projectId)
    {
        $request->validate([
            'contractor_id' => 'nullable|exists:users,id'
        ]);

        try {
            $this->projects->directAllocate($projectId, $request->contractor_id);

            $this->awards->createOrUpdate(
                ['project_id' => $projectId],
                [
                    'bid_id' => null,
                    'awarded_to' => $request->contractor_id,
                    'awarded_at' => $request->contractor_id ? now() : null
                ]
            );

            return redirect()->back()->with('success', 'Project allocation updated successfully.');
        } catch (\Exception $e) {
            \Log::error('Direct Allocation Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to allocate project.');
        }
    }

    public function allocateWork(\Illuminate\Http\Request $request, $projectWorkId)
    {
        $request->validate([
            'contractor_id' => 'nullable|exists:users,id'
        ]);

        try {
            $this->projects->assignWorkToContractor($projectWorkId, $request->contractor_id);

            return redirect()->back()->with('success', 'Work assignment updated.');
        } catch (\Exception $e) {
            \Log::error('Work Allocation Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to assign work.');
        }
    }
}
