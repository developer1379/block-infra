<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id', 'contractor_id', 'project_id', 'amount', 'payment_date',
        'payment_method', 'transaction_id', 'period_start',
        'period_end', 'notes', 'status', 'verified_by', 'verified_at'
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
