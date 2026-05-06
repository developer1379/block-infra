<x-admin-layout>
    <div class="p-6 space-y-6 animate-fade-in">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Worker Payment Verification</h2>
                <p class="text-slate-500 text-sm italic">Audit and verify wage disbursements from contractors to workers.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-100 text-slate-500 font-bold uppercase text-[10px] tracking-widest">
                        <tr>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4">Worker</th>
                            <th class="px-6 py-4">Contractor</th>
                            <th class="px-6 py-4">Project</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td class="px-6 py-4">
                                    <div class="flex justify-center">
                                        @if($payment->status == 'verified')
                                            <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[10px] font-black border border-emerald-100 flex items-center gap-1">
                                                <i class="fa-solid fa-circle-check"></i> VERIFIED
                                            </span>
                                        @elseif($payment->status == 'rejected')
                                            <span class="px-2 py-1 bg-rose-50 text-rose-600 rounded-lg text-[10px] font-black border border-rose-100 flex items-center gap-1">
                                                <i class="fa-solid fa-circle-xmark"></i> REJECTED
                                            </span>
                                        @else
                                            <span class="px-2 py-1 bg-amber-50 text-amber-600 rounded-lg text-[10px] font-black border border-amber-100 flex items-center gap-1">
                                                <i class="fa-solid fa-clock"></i> PENDING
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-slate-700">
                                    {{ $payment->worker->name }}
                                    <p class="text-[10px] text-slate-400 font-medium">{{ $payment->worker->specialization ?? 'General' }}</p>
                                </td>
                                <td class="px-6 py-4 text-slate-600 font-medium">
                                    {{ $payment->contractor->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-indigo-600 font-bold text-xs">{{ $payment->project->title ?? 'General' }}</span>
                                    <p class="text-[10px] text-slate-400 italic">Paid on {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</p>
                                </td>
                                <td class="px-6 py-4 font-black text-slate-900">
                                    ₹{{ number_format($payment->amount) }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($payment->status == 'pending')
                                        <div class="flex justify-end gap-2">
                                            <form action="{{ route('admin.worker-payments.verify', $payment->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="h-8 w-8 flex items-center justify-center bg-emerald-50 text-emerald-600 rounded-lg border border-emerald-100 hover:bg-emerald-600 hover:text-white transition-all shadow-sm shadow-emerald-100" title="Verify Payment">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </form>
                                            <button onclick="rejectPayment({{ $payment->id }})" class="h-8 w-8 flex items-center justify-center bg-rose-50 text-rose-600 rounded-lg border border-rose-100 hover:bg-rose-600 hover:text-white transition-all shadow-sm shadow-rose-100" title="Reject Payment">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    @else
                                        <span class="text-[9px] font-bold text-slate-400 italic">
                                            Handled by {{ $payment->verifiedBy->name ?? 'System' }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-24 text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200 text-3xl">
                                        <i class="fa-solid fa-receipt"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-slate-900">No Payment Records Found</h4>
                                    <p class="text-slate-500 text-sm">Contractor submissions will appear here for verification.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($payments->hasPages())
                <div class="px-6 py-4 border-t border-slate-50">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Rejection Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-md shadow-2xl overflow-hidden animate-fade-in">
            <div class="p-6 bg-rose-600 text-white flex justify-between items-center">
                <h3 class="font-bold flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation"></i> Reject Payment</h3>
                <button onclick="closeRejectModal()" class="text-white/50 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form id="rejectForm" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PATCH')
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Reason for Rejection</label>
                    <textarea name="reason" required rows="3" class="w-full rounded-2xl border-slate-200 focus:border-rose-500 focus:ring-rose-500 p-4 text-sm" placeholder="Explain why this payment is being flagged..."></textarea>
                </div>
                <div class="flex gap-4">
                    <button type="button" onclick="closeRejectModal()" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all">Cancel</button>
                    <button type="submit" class="flex-1 py-3 bg-rose-600 text-white font-bold rounded-xl hover:bg-rose-700 shadow-lg shadow-rose-100 transition-all">Confirm Reject</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function rejectPayment(id) {
            const form = document.getElementById('rejectForm');
            form.action = `/admin/worker-payments/${id}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</x-admin-layout>
