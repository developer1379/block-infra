<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractorCategory extends Model
{
    protected $table = 'contractor_category';

    protected $fillable = [
        'contractor_id',
        'category_id',
    ];

    // Relationships
    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'contractor_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
