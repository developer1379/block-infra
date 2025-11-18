<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Project this bid belongs to
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Contractor who submitted the bid
     */
    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }
}
