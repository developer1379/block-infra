<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unit', 'price', 'description'];

    const UPDATED_AT = null;

    public function inventory()
    {
        return $this->hasMany(MaterialInventory::class);
    }
}
