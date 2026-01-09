<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMilestone extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
