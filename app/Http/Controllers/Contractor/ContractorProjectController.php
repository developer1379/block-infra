<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContractorProjectController extends Controller
{
    /**
     * Display a listing of the projects assigned to this contractor.
     */
    public function index()
    {
        // Fetch projects where the award belongs to the logged-in user
        // Assuming you have an 'award' relationship on Project
        // and a 'user_id' or 'contractor_id' on the Award model
        $projects = Project::whereHas('award', function ($query) {
            $query->where('user_id', Auth::id()); // Adjust 'user_id' to your actual foreign key column
        })
            ->with(['award', 'createdBy']) // Eager load for performance
            ->latest()
            ->paginate(10);

        return view('contractor.projects.index', compact('projects'));
    }

    /**
     * Show the specific project workspace (The UI created in the previous step).
     */
    public function show($id)
    {
        $project = Project::find($id);
        return view('admin.pages.projects.show', compact('project'));
    }

    /**
     * Handle the progress report submission.
     */
    public function storeProgress(Request $request, Project $project)
    {
        // 1. SECURITY: Check authorization again
        $isAssigned = $project->award->awarded_to === Auth::id();
        abort_unless($isAssigned, 403, 'You are not authorized to update this project.');

        // 2. Validate Input
        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'report_description'  => 'required|string|max:2000',
            'report_file'         => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // Max 5MB
        ]);

        // 3. Handle File Upload
        $filePath = null;
        if ($request->hasFile('report_file')) {
            // Stores in storage/app/public/progress-reports
            $filePath = $request->file('report_file')->store('progress-reports', 'public');
        }

        // 4. Create the History Record
        $project->progressUpdates()->create([
            'user_id'             => Auth::id(), // Optional: track who posted it
            'progress_percentage' => $request->progress_percentage,
            'report_description'  => $request->report_description,
            'report_file_path'    => $filePath,
        ]);

        // 5. Update the Main Project Progress
        $project->update([
            'current_progress' => $request->progress_percentage
        ]);

        // Optional: If progress is 100%, you might want to change status to 'completed_pending_review'
        if ($request->progress_percentage == 100) {
            // $project->update(['status' => 'completed']);
        }

        // 6. Redirect back with success message
        return back()->with('success', 'Progress report submitted successfully!');
    }
}
