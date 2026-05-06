<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Worker;
use App\Repositories\Interfaces\AttendanceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    protected $attendance;

    public function __construct(AttendanceRepositoryInterface $attendance)
    {
        $this->attendance = $attendance;
    }

    public function index()
    {
        try {
            $contractor = Auth::user()->contractor;
            $projects = Project::where('contractor_id', $contractor->id)->get();
            $projectIds = $projects->pluck('id')->toArray();

            $attendanceRecords = $this->attendance->getAllPaginated($projectIds, 20);

            return view('contractor.attendance.index', compact('attendanceRecords', 'projects'));
        } catch (\Exception $e) {
            Log::error('Contractor Attendance Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load attendance records.');
        }
    }

    public function create()
    {
        $contractor = Auth::user()->contractor;
        $projects = Project::where('contractor_id', $contractor->id)->get();
        $workers = Worker::where('contractor_id', $contractor->id)->where('status', 'active')->get();
        
        return view('contractor.attendance.create', compact('projects', 'workers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'worker_id' => 'required|exists:workers,id',
            'attendance_date' => 'required|date|after_or_equal:today|before_or_equal:today',
            'status' => 'required|in:present,absent,half_day,on_leave',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'location_address' => 'nullable|string',
            'captured_image' => 'required|string', // Base64 data from camera
            'overtime_hours' => 'nullable|numeric|min:0|max:12',
            'notes' => 'nullable|string|max:255'
        ], [
            'attendance_date.after_or_equal' => 'You can only mark attendance for today.',
            'attendance_date.before_or_equal' => 'You cannot mark attendance for future dates.',
        ]);

        try {
            // Prevent Duplicate Attendance for the same worker on the same day
            $alreadyMarked = \App\Models\ProjectAttendance::where('worker_id', $request->worker_id)
                ->where('attendance_date', $request->attendance_date)
                ->exists();

            if ($alreadyMarked) {
                return back()->with('error', 'Attendance has already been marked for this worker today.')->withInput();
            }

            $data = $request->except(['captured_image', 'verification_photo']);
            
            // Handle Base64 Captured Image
            if ($request->filled('captured_image')) {
                $img = $request->captured_image;
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $imageName = 'attendance_' . time() . '_' . uniqid() . '.jpg';
                \Illuminate\Support\Facades\Storage::disk('public')->put('attendance/verification/' . $imageName, base64_decode($img));
                $data['verification_photo'] = 'attendance/verification/' . $imageName;
            }

            $this->attendance->create($data);

            return redirect()->route('contractor.attendance.index')->with('success', 'Attendance marked with photo and GPS.');
        } catch (\Exception $e) {
            Log::error('Contractor Attendance Store Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to mark attendance. Check GPS and Camera permissions.')->withInput();
        }
    }
}
