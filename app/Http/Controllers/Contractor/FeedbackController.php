<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $contractorId = Auth::user()->contractor->id;
        $feedbacks = Feedback::where('contractor_id', $contractorId)
            ->with('project')
            ->latest()
            ->paginate(10);

        return view('contractor.feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        $contractor = Auth::user()->contractor;
        $projects = \App\Models\Project::where('contractor_id', $contractor->id)->get();
        return view('contractor.feedback.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'nullable|exists:projects,id',
            'type' => 'required|in:issue,bug,suggestion,other',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|image|max:5120', // Max 5MB
        ]);

        $data = $request->only('project_id', 'type', 'subject', 'description');
        $data['contractor_id'] = Auth::user()->contractor->id;
        $data['status'] = 'pending';

        if ($request->hasFile('attachment')) {
            $data['attachment'] = app(\App\Services\ImgBBService::class)->upload($request->file('attachment'));
        }

        Feedback::create($data);

        return redirect()->route('contractor.feedback.index')
            ->with('success', 'Your feedback/issue has been submitted successfully.');
    }

    public function show(Feedback $feedback)
    {
        if ($feedback->contractor_id !== Auth::user()->contractor->id) {
            abort(403);
        }

        return view('contractor.feedback.show', compact('feedback'));
    }
}
