<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\WorkerRepositoryInterface;
use App\Repositories\Interfaces\ContractorProfileRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WorkerController extends Controller
{
    protected $workers;
    protected $contractors;

    public function __construct(
        WorkerRepositoryInterface $workers,
        ContractorProfileRepositoryInterface $contractors
    ) {
        $this->workers = $workers;
        $this->contractors = $contractors;
    }

    public function index(Request $request)
    {
        try {
            $query = \App\Models\Worker::query();

            if ($request->filled('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('specialization', 'like', "%{$search}%");
                });
            }

            if ($request->filled('specialization')) {
                $query->where('specialization', $request->input('specialization'));
            }

            if ($request->filled('status')) {
                $query->where('status', $request->input('status'));
            }

            $workers = $query->latest()->paginate(25)->withQueryString();
            
            // Get unique specializations for filter dropdown
            $specializations = \App\Models\Worker::whereNotNull('specialization')
                ->where('specialization', '!=', '')
                ->distinct()
                ->pluck('specialization');

            return view('admin.workers.index', compact('workers', 'specializations'));
        } catch (\Exception $e) {
            Log::error('Admin Worker Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load workers.');
        }
    }

    public function create()
    {
        $contractors = \App\Models\Contractor::with('user')->get();
        $works = \App\Models\Work::orderBy('name')->get();
        return view('admin.workers.create', compact('contractors', 'works'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contractor_id' => 'nullable|exists:contractors,id',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:100',
            'daily_wage' => 'nullable|numeric|min:0',
            'identity_type' => 'required|in:aadhar,pan,voter_id,driving_license,other',
            'identity_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $data = $request->except('identity_proof');
            if ($request->hasFile('identity_proof')) {
                $file = $request->file('identity_proof');
                if (str_starts_with($file->getMimeType(), 'image/')) {
                    $data['identity_proof'] = app(\App\Services\ImgBBService::class)->upload($file);
                } else {
                    $data['identity_proof'] = $file->store('workers/identity', 'public');
                }
            }
            
            $this->workers->create($data);
            return redirect()->route('admin.workers.index')->with('success', 'Worker created successfully.');
        } catch (\Exception $e) {
            Log::error('Admin Worker Store Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to create worker.')->withInput();
        }
    }

    public function edit($id)
    {
        $worker = $this->workers->find($id);
        $contractors = \App\Models\Contractor::with('user')->get();
        $works = \App\Models\Work::orderBy('name')->get();
        return view('admin.workers.edit', compact('worker', 'contractors', 'works'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contractor_id' => 'nullable|exists:contractors,id',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:100',
            'daily_wage' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $this->workers->update($id, $request->all());
            return redirect()->route('admin.workers.index')->with('success', 'Worker updated successfully.');
        } catch (\Exception $e) {
            Log::error('Admin Worker Update Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update worker.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $worker = $this->workers->find($id);
            $worker->delete();
            return redirect()->route('admin.workers.index')->with('success', 'Worker deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Admin Worker Delete Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to delete worker.');
        }
    }

    public function attendance($id)
    {
        try {
            $worker = $this->workers->find($id);
            $attendanceRecords = \App\Models\ProjectAttendance::where('worker_id', $id)
                ->with('project')
                ->latest('attendance_date')
                ->paginate(20);
            return view('admin.workers.attendance', compact('worker', 'attendanceRecords'));
        } catch (\Exception $e) {
            Log::error('Admin Worker Attendance Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load attendance history.');
        }
    }

    public function payments($id)
    {
        try {
            $worker = $this->workers->find($id);
            $payments = \App\Models\WorkerPayment::where('worker_id', $id)
                ->latest('payment_date')
                ->paginate(20);
            return view('admin.workers.payments', compact('worker', 'payments'));
        } catch (\Exception $e) {
            Log::error('Admin Worker Payments Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load payment history.');
        }
    }
}
