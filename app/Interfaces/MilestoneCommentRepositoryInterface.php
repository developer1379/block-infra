<?php

namespace App\Interfaces;

interface MilestoneCommentRepositoryInterface
{
    public function createComment(array $data);
    public function getCommentsByMilestone($milestoneId);
}
