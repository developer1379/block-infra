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

    protected $appends = ['verification_photo_url'];

    public function getVerificationPhotoUrlAttribute()
    {
        if (empty($this->verification_photo)) {
            return null;
        }
        if (filter_var($this->verification_photo, FILTER_VALIDATE_URL)) {
            return $this->verification_photo;
        }
        return asset('storage/' . $this->verification_photo);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}
