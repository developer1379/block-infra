<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'project_id', 'milestone_id', 'contractor_id',
        'amount', 'tax_amount', 'total_amount', 'issue_date', 'due_date',
        'status', 'notes'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function milestone()
    {
        return $this->belongsTo(ProjectMilestone::class, 'milestone_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
