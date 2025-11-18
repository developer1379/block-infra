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
}
