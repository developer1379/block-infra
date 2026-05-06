<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'amount', 'payment_date', 'payment_method',
        'transaction_reference', 'attachment_path', 'notes'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
