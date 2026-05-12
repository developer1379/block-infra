<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailySiteReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'contractor_id', 'report_date', 'weather_condition',
        'work_summary', 'challenges', 'next_day_plan', 'progress_percentage'
    ];

    const UPDATED_AT = null;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class);
    }

    public function photos()
    {
        return $this->hasMany(SitePhoto::class, 'report_id');
    }
}
