<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkerPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WorkerPaymentController extends Controller
{
    public function index()
    {
        $payments = WorkerPayment::with(['worker', 'contractor', 'project', 'verifiedBy'])
            ->latest('payment_date')
            ->paginate(15);
        return view('admin.payments.index', compact('payments'));
    }

    public function verify(Request $request, $id)
    {
        try {
            $payment = WorkerPayment::findOrFail($id);
            $payment->update([
                'status' => 'verified',
                'verified_by' => Auth::id(),
                'verified_at' => now()
            ]);

            return back()->with('success', 'Payment verified successfully.');
        } catch (\Exception $e) {
            Log::error('Admin Worker Payment Verify Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to verify payment.');
        }
    }

    public function reject(Request $request, $id)
    {
        try {
            $payment = WorkerPayment::findOrFail($id);
            $payment->update([
                'status' => 'rejected',
                'verified_by' => Auth::id(),
                'verified_at' => now(),
                'notes' => $payment->notes . "\n[Rejected by Admin]: " . $request->reason
            ]);

            return back()->with('success', 'Payment rejected.');
        } catch (\Exception $e) {
            Log::error('Admin Worker Payment Reject Error: ' . $e->getMessage());
            return back()->with('error', 'Unable to reject payment.');
        }
    }
}
