<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitePhoto extends Model
{
    use HasFactory;

    protected $fillable = ['report_id', 'photo_path', 'caption'];

    const UPDATED_AT = null;

    public function report()
    {
        return $this->belongsTo(DailySiteReport::class, 'report_id');
    }

    public function getPhotoUrlAttribute()
    {
        if (empty($this->photo_path)) {
            return null;
        }
        if (filter_var($this->photo_path, FILTER_VALIDATE_URL)) {
            return $this->photo_path;
        }
        return asset('storage/' . $this->photo_path);
    }
}
