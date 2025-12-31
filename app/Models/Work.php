<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    /**
     * Protect attributes that should not be mass assignable.
     * Using guarded instead of fillable for flexibility.
     */
    protected $guarded = ['id'];

    /**
     * Default attribute casting.
     */
    protected $casts = [
        'labor_min' => 'decimal:2',
        'labor_max' => 'decimal:2',
        'labor_material_min' => 'decimal:2',
        'labor_material_max' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_works');
    }
}
