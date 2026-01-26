<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index(Request $request, ProjectRepositoryInterface $projectRepository, BidRepositoryInterface $bidRepository)
    {
        $contractor = Auth::user()->contractor;

        $totalProjects = $projectRepository->countProjectsByContractor($contractor->id);

        $totalBids = $projectRepository->countBidsByContractor($contractor->id);

        $ongoingProjects = $projectRepository->getOngoingProjectsByContractor($contractor->id);

        return view('contractor.dashboard.index', compact('totalProjects', 'totalBids', 'ongoingProjects'));
    }
}
