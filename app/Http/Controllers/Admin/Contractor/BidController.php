<?php

namespace App\Http\Controllers\Admin\Contractor;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\BidRepositoryInterface;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        return view('contractor.bids.create', compact('project'));
    }

    /**
     * Store Bid (Contractor submission)
     */
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'bid_amount'    => 'required|numeric|min:1',
            'delivery_days' => 'required|integer|min:1',
            'proposal_text' => 'nullable|string',
            'proposal_pdf'  => 'nullable|mimes:pdf|max:5120', // max 5MB
        ]);

        $pdfPath = null;

        // 🔥 HANDLE PDF FILE UPLOAD
        if ($request->hasFile('proposal_pdf')) {
            $pdfPath = $request->file('proposal_pdf')
                ->store('bids/pdf', 'public');
        }

        // 🔥 SAVE bid using repository
        $this->bids->create([
            'project_id'    => $projectId,
            'contractor_id' => auth()->id(),
            'bid_amount'    => $request->bid_amount,
            'delivery_days' => $request->delivery_days,
            'proposal_text' => $request->proposal_text,
            'proposal_pdf'  => $pdfPath,   // save path
        ]);

        return redirect()->route('contractor.projects.show', $projectId)
            ->with('success', 'Bid submitted successfully.');
    }
}
