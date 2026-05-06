<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProjectProgressUpdate\Interfaces\ProjectProgressUpdateRepositoryInterface;

class ProjectProgressController extends Controller
{
    protected $progressRepo;

    public function __construct(ProjectProgressUpdateRepositoryInterface $progressRepo)
    {
        $this->progressRepo = $progressRepo;
    }

    /**
     * Store a progress update (Percentage + Report File)
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id'          => 'required|exists:projects,id',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'report_description'  => 'nullable|string',
            'report_file'         => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120', // Max 5MB
        ]);

        // Ensure the logged-in user is actually the assigned contractor
        $project = \App\Models\Project::findOrFail($request->project_id);

        // Optional: Add security check
        if ($project->award->awarded_to !== Auth::id()) {
           abort(403, 'Unauthorized');
        }

        $data = $request->all();
        $data['user_id'] = Auth::id(); // Assign to current user

        $this->progressRepo->create($data);

        return back()->with('success', 'Progress report submitted successfully.');
    }
}
