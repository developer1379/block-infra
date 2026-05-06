<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitePhoto extends Model
{
    use HasFactory;

    protected $fillable = ['report_id', 'photo_path', 'caption'];

    public function report()
    {
        return $this->belongsTo(DailySiteReport::class, 'report_id');
    }
}
