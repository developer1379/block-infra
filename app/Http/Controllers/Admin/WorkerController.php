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

    public function index()
    {
        try {
            $workers = $this->workers->getAll();
            return view('admin.workers.index', compact('workers'));
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
                $data['identity_proof'] = $request->file('identity_proof')->store('workers/identity', 'public');
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
}
