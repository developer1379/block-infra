<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Interfaces\MilestoneCommentRepositoryInterface;
use App\Models\ProjectMilestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MilestoneCommentController extends Controller
{
    private MilestoneCommentRepositoryInterface $commentRepository;

    public function __construct(MilestoneCommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(Request $request, $milestoneId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Ensure milestone exists
        $milestone = ProjectMilestone::findOrFail($milestoneId);

        // Security Check: Ensure user is associated with the project (Optional but recommended)
        // if ($milestone->project->created_by !== Auth::id() && $milestone->project->award->awarded_to !== Auth::id()) {
        //    abort(403);
        // }

        $data = [
            'milestone_id' => $milestone->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ];

        $this->commentRepository->createComment($data);

        return back()->with('success', 'Comment added successfully.');
    }
}
