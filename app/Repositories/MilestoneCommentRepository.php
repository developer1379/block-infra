<?php

namespace App\Repositories;

use App\Interfaces\MilestoneCommentRepositoryInterface;
use App\Models\MilestoneComment;

class MilestoneCommentRepository implements MilestoneCommentRepositoryInterface
{
    public function createComment(array $data)
    {
        return MilestoneComment::create($data);
    }

    public function getCommentsByMilestone($milestoneId)
    {
        return MilestoneComment::where('milestone_id', $milestoneId)
            ->with('user') // Eager load user for display
            ->latest()
            ->get();
    }
}
