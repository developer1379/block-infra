<x-admin-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.workers.index') }}" class="inline-flex items-center text-sm font-semibold text-teal-600 hover:text-teal-800 transition-colors mb-2">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back to Workers
                </a>
                <h1 class="text-2xl font-bold text-slate-800">Payment History: {{ $worker->name }}</h1>
                <p class="text-sm text-slate-500">Track all wage disbursements made by the contractor to this worker.</p>
            </div>
            <div class="flex flex-col items-end">
                <div class="bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm flex items-center gap-3 mb-2">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Daily Wage:</span>
                    <span class="text-sm font-black text-teal-600 font-mono">₹{{ number_format($worker->daily_wage, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Amount Paid</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Method</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Period</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Reference ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Contractor Note</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-600">
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-black text-slate-800">₹{{ number_format($payment->amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $methodClasses = [
                                            'cash' => 'bg-amber-50 text-amber-700 border-amber-100',
                                            'bank_transfer' => 'bg-blue-50 text-blue-700 border-blue-100',
                                            'upi' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                            'other' => 'bg-slate-50 text-slate-700 border-slate-100',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-lg border text-[10px] font-black uppercase tracking-tight {{ $methodClasses[$payment->payment_method] ?? 'bg-slate-50 text-slate-700 border-slate-100' }}">
                                        {{ str_replace('_', ' ', $payment->payment_method) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($payment->period_start && $payment->period_end)
                                        <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-md">
                                            {{ \Carbon\Carbon::parse($payment->period_start)->format('M d') }} - {{ \Carbon\Carbon::parse($payment->period_end)->format('M d') }}
                                        </span>
                                    @else
                                        <span class="text-[10px] text-slate-300 font-bold italic">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <code class="text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-0.5 rounded border border-slate-100">
                                        {{ $payment->transaction_id ?? 'No Ref' }}
                                    </code>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 italic max-w-[200px] truncate">
                                    {{ $payment->notes ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-slate-400">
                                    <i class="fa-solid fa-money-bill-transfer text-4xl mb-3"></i>
                                    <p>No payment records found for this worker.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($payments->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
