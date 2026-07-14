<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractor_id', 'name', 'phone', 'specialization', 'daily_wage',
        'identity_type', 'identity_proof', 'status'
    ];

    protected $appends = ['identity_proof_url'];

    public function getIdentityProofUrlAttribute()
    {
        if (empty($this->identity_proof)) {
            return null;
        }
        if (filter_var($this->identity_proof, FILTER_VALIDATE_URL)) {
            return $this->identity_proof;
        }
        return asset('storage/' . $this->identity_proof);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function attendances()
    {
        return $this->hasMany(ProjectAttendance::class);
    }
}
