<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::with(['contractor', 'project'])->latest()->paginate(15);
        return view('admin.feedback.index', compact('feedbacks'));
    }

    public function show(Feedback $feedback)
    {
        return view('admin.feedback.show', compact('feedback'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
            'admin_reply' => 'nullable|string'
        ]);

        $feedback->update([
            'status' => $request->status,
            'admin_reply' => $request->admin_reply,
        ]);

        return redirect()->route('admin.feedback.show', $feedback->id)
            ->with('success', 'Feedback ticket updated successfully.');
    }
}
