<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // guarded to prevent mass assignment issues
    protected $guarded = [];

    /**
     * Admin who created the project
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * All bids by contractors
     */
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    /**
     * Awarded bid
     */
    public function award()
    {
        return $this->hasOne(ProjectAward::class);
    }

    /**
     * Awarded contractor
     */
    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'project_category', 'project_id', 'category_id')
            ->withTimestamps();
    }

    public function works()
    {
        return $this->belongsToMany(Work::class, 'project_works');
    }

    public function milestones()
    {
        return $this->hasMany(ProjectMilestone::class);
    }

    /**
     * Daily/Weekly progress reports uploaded by the contractor
     */
    public function progressUpdates()
    {
        return $this->hasMany(ProjectProgressUpdate::class)->latest();
    }

    /**
     * Helper to get the latest completion percentage
     */
    public function getCurrentProgressAttribute()
    {
        return $this->progressUpdates()->first()->progress_percentage ?? 0;
    }
}
