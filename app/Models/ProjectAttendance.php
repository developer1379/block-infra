<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAttendance extends Model
{
    use HasFactory;

    protected $table = 'project_attendance';

    protected $fillable = [
        'project_id', 
        'worker_id', 
        'attendance_date', 
        'status',
        'latitude',
        'longitude',
        'verification_photo',
        'location_address',
        'overtime_hours', 
        'notes'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
