<x-contractor-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('contractor.payments.index') }}" class="inline-flex items-center text-sm font-semibold text-green-600 hover:text-green-800 transition-colors mb-4">
                    <i class="bi bi-arrow-left mr-2"></i> Back to History
                </a>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Record Wage Payment</h1>
                <p class="text-gray-500 mt-1">Submit a new payment record for a worker.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <form action="{{ route('contractor.payments.store') }}" method="POST" class="p-8 space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Worker Selection -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Select Worker</label>
                            <select name="worker_id" id="worker_select" required class="select2 w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-green-500 focus:ring-green-500 transition-all py-3 px-4">
                                <option value="">Select Worker</option>
                                @foreach($workers as $worker)
                                    <option value="{{ $worker->id }}" data-wage="{{ $worker->daily_wage }}">
                                        {{ $worker->name }} ({{ $worker->specialization ?? 'General' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Amount -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Payment Amount (₹)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400">₹</span>
                                <input type="number" name="amount" id="amount" step="0.01" required placeholder="0.00"
                                    class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-green-500 focus:ring-green-500 transition-all py-3 pl-8 pr-4 text-lg font-bold text-gray-900">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Date -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Payment Date</label>
                            <input type="date" name="payment_date" required value="{{ date('Y-m-d') }}"
                                class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-green-500 focus:ring-green-500 transition-all py-3 px-4">
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Payment Method</label>
                            <select name="payment_method" required class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-green-500 focus:ring-green-500 transition-all py-3 px-4">
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="upi">UPI (GPay/PhonePe)</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <i class="bi bi-calendar-range text-green-600"></i> Wage Period (Optional)
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">Start Date</label>
                                <input type="date" name="period_start" class="w-full rounded-xl border-gray-200 bg-white focus:border-green-500 focus:ring-green-500 transition-all py-2 px-3 text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase mb-1">End Date</label>
                                <input type="date" name="period_end" class="w-full rounded-xl border-gray-200 bg-white focus:border-green-500 focus:ring-green-500 transition-all py-2 px-3 text-sm">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Transaction Reference / UPI ID</label>
                        <input type="text" name="transaction_id" placeholder="e.g. TXN123456789 or UPI Reference"
                            class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-green-500 focus:ring-green-500 transition-all py-3 px-4">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">Notes</label>
                        <textarea name="notes" rows="2" placeholder="e.g. Paid for last week's foundation work..."
                            class="w-full rounded-2xl border-gray-200 bg-gray-50 focus:border-green-500 focus:ring-green-500 transition-all p-4 text-sm"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                        <a href="{{ route('contractor.payments.index') }}" class="px-8 py-3 text-sm font-bold text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-2xl transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="px-12 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-green-200 transition-all transform hover:scale-[1.02] active:scale-[0.98]">
                            Submit Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#worker_select').select2({
                placeholder: 'Search for a worker...',
                width: '100%'
            });

            // Optional: Auto-fill amount based on daily wage if needed
            /*
            $('#worker_select').on('change', function() {
                const wage = $(this).find(':selected').data('wage');
                if (wage) $('#amount').val(wage);
            });
            */
        });
    </script>
    @endpush
</x-contractor-layout>
