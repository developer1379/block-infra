<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\WorkerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorkerController extends Controller
{
    protected $workers;

    public function __construct(WorkerRepositoryInterface $workers)
    {
        $this->workers = $workers;
    }

    public function index()
    {
        try {
            $contractor = Auth::user()->contractor;
            $workers = \App\Models\Worker::where('contractor_id', $contractor->id)->get();
            return view('contractor.workers.index', compact('workers'));
        } catch (\Exception $e) {
            Log::error('Contractor Worker Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load workers.');
        }
    }

    public function create()
    {
        $works = \App\Models\Work::orderBy('name')->get();
        return view('contractor.workers.create', compact('works'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:100',
            'daily_wage' => 'nullable|numeric|min:0',
            'identity_type' => 'required|in:aadhar,pan,voter_id,driving_license,other',
            'identity_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $contractor = Auth::user()->contractor;
            $data = $request->except('identity_proof');
            $data['contractor_id'] = $contractor->id;
            
            if ($request->hasFile('identity_proof')) {
                $file = $request->file('identity_proof');
                if (str_starts_with($file->getMimeType(), 'image/')) {
                    $data['identity_proof'] = app(\App\Services\ImgBBService::class)->upload($file);
                } else {
                    $data['identity_proof'] = $file->store('workers/identity', 'public');
                }
            }
            
            $worker = $this->workers->create($data);
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'worker' => $worker,
                    'message' => 'Worker added successfully.'
                ]);
            }
            return redirect()->route('contractor.workers.index')->with('success', 'Worker added to your team.');
        } catch (\Exception $e) {
            Log::error('Contractor Worker Store Error: ' . $e->getMessage());
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Unable to add worker.']);
            }
            return back()->with('error', 'Unable to add worker.')->withInput();
        }
    }

    public function edit($id)
    {
        $contractor = Auth::user()->contractor;
        $worker = \App\Models\Worker::where('contractor_id', $contractor->id)->findOrFail($id);
        $works = \App\Models\Work::orderBy('name')->get();
        return view('contractor.workers.edit', compact('worker', 'works'));
    }

    public function update(Request $request, $id)
    {
        $contractor = Auth::user()->contractor;
        $worker = \App\Models\Worker::where('contractor_id', $contractor->id)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'specialization' => 'nullable|string|max:100',
            'daily_wage' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $worker->update($request->all());
            return redirect()->route('contractor.workers.index')->with('success', 'Worker profile updated.');
        } catch (\Exception $e) {
            Log::error('Contractor Worker Update Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to update worker.')->withInput();
        }
    }
}
