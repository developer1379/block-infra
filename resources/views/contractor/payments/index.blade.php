<x-contractor-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Worker Payments</h1>
                    <p class="text-gray-500 mt-1">Track wages and payment history for your construction workforce.</p>
                </div>
                <a href="{{ route('contractor.payments.create') }}" 
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                    <i class="bi bi-cash-coin mr-2"></i>
                    Record New Payment
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                            <i class="bi bi-wallet2 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Paid (This Month)</p>
                            <p class="text-2xl font-black text-gray-900">₹{{ number_format($payments->where('payment_date', '>=', now()->startOfMonth())->sum('amount'), 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payments Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-list-ul text-green-600"></i>
                        Recent Transactions
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Worker</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Method</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Period</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Reference</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($payments as $payment)
                                <tr class="hover:bg-gray-50/80 transition-colors group">
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-xs">
                                                {{ substr($payment->worker->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-semibold text-gray-900">{{ $payment->worker->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-bold text-gray-900">₹{{ number_format($payment->amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $methodClasses = [
                                                'cash' => 'bg-amber-100 text-amber-700',
                                                'bank_transfer' => 'bg-blue-100 text-blue-700',
                                                'upi' => 'bg-indigo-100 text-indigo-700',
                                                'other' => 'bg-gray-100 text-gray-700',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide {{ $methodClasses[$payment->payment_method] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ str_replace('_', ' ', $payment->payment_method) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500">
                                        @if($payment->period_start && $payment->period_end)
                                            {{ \Carbon\Carbon::parse($payment->period_start)->format('M d') }} - {{ \Carbon\Carbon::parse($payment->period_end)->format('M d') }}
                                        @else
                                            <span class="text-gray-300 italic">No period</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs font-mono text-gray-400">
                                        {{ $payment->transaction_id ?? 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="bi bi-wallet2 text-4xl mb-2 opacity-20"></i>
                                            <p>No payment records found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($payments->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $payments->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-contractor-layout>
