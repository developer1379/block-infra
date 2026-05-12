<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialInventory extends Model
{
    use HasFactory;

    protected $table = 'material_inventory';

    protected $fillable = [
        'project_id', 'material_id', 'quantity', 'type',
        'unit_price', 'vendor_name', 'entry_date', 'notes'
    ];

    protected $casts = [
        'entry_date' => 'date'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
