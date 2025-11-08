<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContractorDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractor_id',
        'document_type',
        'file_path',
        'is_verified',
        'verified_by',
        'verified_at'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    // Relationship with contractor
    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id');
    }
}
