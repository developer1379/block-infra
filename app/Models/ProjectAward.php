<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAward extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The awarded project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Winning bid
     */
    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    /**
     * Contractor who won
     */
    public function awardedTo()
    {
        return $this->belongsTo(User::class, 'awarded_to');
    }
}
