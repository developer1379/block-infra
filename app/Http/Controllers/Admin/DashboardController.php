<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contractor;
use App\Models\Project;
use App\Models\Worker;
use App\Models\WorkerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $stats = [
                'total_contractors' => Contractor::count(),
                'total_projects' => Project::count(),
                'total_workers' => Worker::count(),
                'total_payments' => WorkerPayment::sum('amount'),
                'active_projects' => Project::where('status', 'ongoing')->count(),
                'pending_projects' => Project::where('status', 'open')->count(),
            ];

            $recentProjects = Project::with('contractor')->latest()->take(5)->get();
            $recentPayments = WorkerPayment::with(['worker', 'contractor'])->latest()->take(5)->get();

            return view('admin.dashboard.index', compact('stats', 'recentProjects', 'recentPayments'));
        } catch (\Exception $e) {
            Log::error('Admin Dashboard Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load dashboard data.');
        }
    }
}
