<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    protected $projects;
    protected $bids;

    public function __construct(ProjectRepositoryInterface $projects, BidRepositoryInterface $bids)
    {
        $this->projects = $projects;
        $this->bids = $bids;
    }

    public function index()
    {
        try {
            $user = Auth::user();
            $contractor = $user->contractor;

            if (!$contractor) {
                return redirect()->route('website.home')->with('error', 'Contractor profile not found.');
            }

            // Stats Calculation
            $stats = [
                'total_projects' => $this->projects->countProjectsByContractor($contractor->id),
                'active_projects' => $this->projects->getOngoingProjectsByContractor($contractor->id)->count(),
                'total_workers' => \App\Models\Worker::where('contractor_id', $contractor->id)->count(),
                'attendance_today' => \App\Models\ProjectAttendance::whereHas('project', function($q) use ($contractor) {
                        $q->where('contractor_id', $contractor->id);
                    })
                    ->where('attendance_date', date('Y-m-d'))
                    ->where('status', 'present')
                    ->count(),
                'total_payments' => \App\Models\WorkerPayment::where('contractor_id', $contractor->id)->sum('amount'),
                'earnings' => \App\Models\Bid::where('contractor_id', Auth::id())
                    ->where('status', 'accepted')
                    ->sum('bid_amount'),
            ];

            $ongoingProjects = $this->projects->getOngoingProjectsByContractor($contractor->id)->take(5);
            
            // Get some open projects they might be interested in
            $availableProjects = \App\Models\Project::where('status', 'open')
                ->whereDoesntHave('bids', function($q) use ($user) {
                    $q->where('contractor_id', $user->id);
                })
                ->latest()
                ->take(3)
                ->get();

            return view('contractor.dashboard.index', compact('stats', 'ongoingProjects', 'availableProjects'));

        } catch (\Exception $e) {
            Log::error('Contractor Dashboard Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load dashboard data.');
        }
    }
}
