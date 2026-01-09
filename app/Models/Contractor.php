<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contractor extends Model
{
    use HasFactory;

    protected $guarded = [];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function categoryRelation()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            Category::class,
            'contractor_category',
            'contractor_id',
            'category_id'
        )->withTimestamps();
    }


    //  Link to contractor_documents table
    public function documents()
    {
        return $this->hasMany(ContractorDocument::class, 'contractor_id');
    }
}
