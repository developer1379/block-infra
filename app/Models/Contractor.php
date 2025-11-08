<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contractor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company_name',
        'category',
        'city',
        'is_active'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];

   // ✅ Link to Category table
    public function categoryRelation()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // ✅ Link to contractor_documents table
    public function documents()
    {
        return $this->hasMany(ContractorDocument::class, 'contractor_id');
    }
}
