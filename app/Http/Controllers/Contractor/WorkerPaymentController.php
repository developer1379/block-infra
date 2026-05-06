<?php

namespace App\Http\Controllers\Contractor;

use App\Http\Controllers\Controller;
use App\Models\Worker;
use App\Models\WorkerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorkerPaymentController extends Controller
{
    public function index()
    {
        try {
            $contractor = Auth::user()->contractor;
            $payments = WorkerPayment::where('contractor_id', $contractor->id)
                ->with('worker')
                ->latest('payment_date')
                ->paginate(15);

            return view('contractor.payments.index', compact('payments'));
        } catch (\Exception $e) {
            Log::error('Contractor Worker Payment Index Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to load payment records.');
        }
    }

    public function create()
    {
        $contractor = Auth::user()->contractor;
        $workers = Worker::where('contractor_id', $contractor->id)->where('status', 'active')->get();
        return view('contractor.payments.create', compact('workers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:workers,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,bank_transfer,upi,other',
            'transaction_id' => 'nullable|string|max:100',
            'period_start' => 'nullable|date',
            'period_end' => 'nullable|date',
            'notes' => 'nullable|string'
        ]);

        try {
            $contractor = Auth::user()->contractor;
            $data = $request->all();
            $data['contractor_id'] = $contractor->id;

            WorkerPayment::create($data);

            return redirect()->route('contractor.payments.index')->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            Log::error('Contractor Worker Payment Store Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to record payment.')->withInput();
        }
    }
}
