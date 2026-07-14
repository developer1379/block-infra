<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectProgressUpdate extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The contractor who submitted this update
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function milestone()
    {
        return $this->belongsTo(ProjectMilestone::class, 'milestone_id');
    }

    public function getReportFileUrlAttribute()
    {
        if (empty($this->report_file_path)) {
            return null;
        }
        if (filter_var($this->report_file_path, FILTER_VALIDATE_URL)) {
            return $this->report_file_path;
        }
        return asset('storage/' . $this->report_file_path);
    }
}
