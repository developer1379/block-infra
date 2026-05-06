<x-admin-layout>
    <div class="space-y-6 animate-fade-in">
        
        <!-- Premium Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-white p-6 rounded-2xl border border-slate-200 shadow-sm gap-4 sm:gap-0">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.projects.index') }}" 
                   class="flex-shrink-0 w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-100 transition-all duration-200"
                   aria-label="Back to projects">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Project Financials</h1>
                    <p class="text-sm font-medium text-slate-500 mt-0.5">{{ $project->title }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="bg-indigo-50 px-4 py-2 rounded-lg border border-indigo-100 text-right">
                    <p class="text-[11px] font-semibold text-indigo-600 uppercase tracking-wider mb-0.5">Total Budget</p>
                    <p class="text-lg font-bold text-slate-900 leading-none">₹{{ number_format($project->budget_max, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            
            <!-- Left Column: Milestones & Invoices -->
            <div class="xl:col-span-2 space-y-6">
                
                <!-- Payment Milestones -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
                        <h3 class="font-semibold text-slate-800 flex items-center gap-2.5">
                            <i class="fa-solid fa-flag-checkered text-indigo-500"></i>
                            Payment Milestones
                        </h3>
                        <button type="button" class="px-3 py-1.5 bg-white border border-slate-300 text-slate-700 text-xs font-semibold rounded-lg hover:bg-slate-50 focus:ring-2 focus:ring-slate-200 transition-all shadow-sm">
                            Add Milestone
                        </button>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-3">
                            @forelse($milestones as $milestone)
                                <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-200 hover:border-indigo-300 hover:shadow-sm transition-all group">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center border border-indigo-100 flex-shrink-0">
                                            <span class="text-sm font-bold text-indigo-600">{{ $milestone->percentage }}%</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-900">{{ $milestone->title }}</p>
                                            <p class="text-xs text-slate-500 mt-0.5">Amount: ₹{{ number_format($milestone->amount, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset 
                                            {{ $milestone->status == 'completed' ? 'bg-green-50 text-green-700 ring-green-600/20' : 'bg-slate-50 text-slate-600 ring-slate-500/10' }}">
                                            {{ ucfirst($milestone->status) }}
                                        </span>
                                        <i class="fa-solid fa-chevron-right text-slate-400 text-xs group-hover:text-indigo-500 transition-colors"></i>
                                    </div>
                                </div>
                            @empty
                                <div class="py-10 text-center">
                                    <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center mx-auto mb-3">
                                        <i class="fa-solid fa-flag text-slate-400"></i>
                                    </div>
                                    <p class="text-sm font-medium text-slate-900">No milestones defined</p>
                                    <p class="text-xs text-slate-500 mt-1">Get started by creating your first project milestone.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Invoices Table -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
                        <h3 class="font-semibold text-slate-800 flex items-center gap-2.5">
                            <i class="fa-solid fa-file-invoice text-emerald-500"></i>
                            Recent Invoices
                        </h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    <th class="px-6 py-4">Invoice #</th>
                                    <th class="px-6 py-4">Issue Date</th>
                                    <th class="px-6 py-4">Amount</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($invoices as $invoice)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ $invoice->invoice_number }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-500">{{ $invoice->issue_date }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-slate-900">₹{{ number_format($invoice->total_amount, 2) }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset 
                                                {{ $invoice->status == 'paid' ? 'bg-emerald-50 text-emerald-700 ring-emerald-600/20' : 'bg-amber-50 text-amber-700 ring-amber-600/20' }}">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($invoice->status != 'paid')
                                                <button class="text-indigo-600 hover:text-indigo-900 text-xs font-medium">Mark Paid</button>
                                            @else
                                                <span class="text-slate-400 text-xs">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 text-sm">No billing history found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Direct Project Payments -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-200 flex justify-between items-center bg-slate-50/50">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-money-bill-transfer text-blue-500"></i>
                            <h3 class="font-semibold text-slate-800">Direct Payments</h3>
                        </div>
                        <span class="text-xs font-medium text-slate-500 bg-white px-2 py-1 rounded border border-slate-200">Client to Contractor</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Method</th>
                                    <th class="px-6 py-4">Amount</th>
                                    <th class="px-6 py-4">Reference</th>
                                    <th class="px-6 py-4">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($projectPayments as $pPayment)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 text-sm font-medium text-slate-900">{{ \Carbon\Carbon::parse($pPayment->payment_date)->format('M d, Y') }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-500 capitalize">{{ str_replace('_', ' ', $pPayment->payment_method) }}</td>
                                        <td class="px-6 py-4 text-sm font-semibold text-blue-600">₹{{ number_format($pPayment->amount, 2) }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-500">{{ $pPayment->transaction_reference ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-slate-500 truncate max-w-[200px]" title="{{ $pPayment->notes }}">{{ $pPayment->notes ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-slate-500 text-sm">No direct payments recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Quick Stats & Actions -->
            <div class="space-y-6">
                <!-- Summary Card -->
                <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                    <!-- Decorative background element -->
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/20 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <div class="relative z-10 space-y-6">
                        <div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider mb-1">Total Disbursed</p>
                            @php
                                $totalDirectPayments = $projectPayments->sum('amount');
                                $totalInvoicePayments = $invoices->where('status', 'paid')->sum('total_amount');
                                $grandTotalDisbursed = $totalDirectPayments + $totalInvoicePayments;
                            @endphp
                            <p class="text-3xl font-bold text-white">₹{{ number_format($grandTotalDisbursed, 2) }}</p>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div class="p-3 bg-white/5 rounded-xl border border-white/10 backdrop-blur-sm">
                                <p class="text-xs font-medium text-slate-400 mb-1">Unpaid Balance</p>
                                <p class="text-lg font-semibold text-amber-400">₹{{ number_format($invoices->where('status', '!=', 'paid')->sum('total_amount'), 2) }}</p>
                            </div>
                            <div class="p-3 bg-white/5 rounded-xl border border-white/10 backdrop-blur-sm">
                                <p class="text-xs font-medium text-slate-400 mb-1">Completion</p>
                                <p class="text-lg font-semibold text-emerald-400">{{ $project->current_progress ?? 0 }}%</p>
                            </div>
                        </div>

                        <button onclick="openPaymentModal()" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-medium text-sm transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-offset-slate-900 focus:ring-indigo-500 flex justify-center items-center gap-2">
                            <i class="fa-solid fa-plus"></i> Record Payment
                        </button>
                    </div>
                </div>

                <!-- Financial Health Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h4 class="text-sm font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-slate-400"></i>
                        Budget Utilization
                    </h4>
                    <div class="space-y-2">
                        @php
                            $utilization = ($grandTotalDisbursed / ($project->budget_max ?: 1)) * 100;
                            // Determine bar color based on utilization
                            $barColor = $utilization > 90 ? 'bg-red-500' : ($utilization > 75 ? 'bg-amber-500' : 'bg-indigo-500');
                        @endphp
                        <div class="flex justify-between items-end mb-1">
                            <span class="text-2xl font-bold text-slate-900">{{ number_format($utilization, 1) }}%</span>
                            <span class="text-xs font-medium text-slate-500 mb-1">of total budget</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                            <div class="{{ $barColor }} h-full rounded-full transition-all duration-1000 ease-out" style="width: {{ min(100, $utilization) }}%"></div>
                        </div>
                        <p class="text-xs text-slate-500 mt-3 leading-relaxed">Tracks total funds disbursed to the contractor against the initial authorized budget maximum.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Manual Payment Modal -->
    <div id="paymentModal" class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 sm:p-6 opacity-0 transition-opacity duration-300" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300" id="paymentModalContent">
            
            <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-white">
                <h3 class="font-semibold text-slate-900 text-lg" id="modal-title">Record Direct Payment</h3>
                <button type="button" onclick="closePaymentModal()" class="text-slate-400 hover:text-slate-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded-lg p-1 transition-colors">
                    <span class="sr-only">Close</span>
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('admin.projects.payments.store', $project->id) }}" method="POST" class="p-6">
                @csrf
                <div class="space-y-5">
                    
                    <div>
                        <label for="amount" class="block text-sm font-medium text-slate-700 mb-1">Payment Amount (₹) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-slate-500 sm:text-sm">₹</span>
                            </div>
                            <input type="number" name="amount" id="amount" step="0.01" required class="block w-full pl-8 pr-3 py-2.5 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="payment_date" class="block text-sm font-medium text-slate-700 mb-1">Date <span class="text-red-500">*</span></label>
                            <input type="date" name="payment_date" id="payment_date" required value="{{ date('Y-m-d') }}" class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors">
                        </div>
                        
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-slate-700 mb-1">Method <span class="text-red-500">*</span></label>
                            <select name="payment_method" id="payment_method" required class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors bg-white">
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="upi">UPI</option>
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="transaction_reference" class="block text-sm font-medium text-slate-700 mb-1">Reference Number</label>
                        <input type="text" name="transaction_reference" id="transaction_reference" class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors" placeholder="Transaction ID, Check #, etc.">
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">Internal Notes</label>
                        <textarea name="notes" id="notes" rows="3" class="block w-full px-3 py-2.5 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors resize-none" placeholder="Add any relevant details about this payment..."></textarea>
                    </div>
                </div>
                
                <div class="mt-6 flex gap-3 justify-end border-t border-slate-100 pt-5">
                    <button type="button" onclick="closePaymentModal()" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg font-medium text-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 border border-transparent text-white rounded-lg font-medium text-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm">
                        Save Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('paymentModal');
        const modalContent = document.getElementById('paymentModalContent');

        function openPaymentModal() {
            modal.classList.remove('hidden');
            // Small delay to allow display:block to apply before animating opacity
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
            
            // Focus the first input for accessibility
            setTimeout(() => {
                document.getElementById('amount').focus();
            }, 300);
        }

        function closePaymentModal() {
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            
            // Wait for transition to finish before hiding
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Close on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape" && !modal.classList.contains('hidden')) {
                closePaymentModal();
            }
        });
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }
        
        /* Custom scrollbar for tables */
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9; 
            border-radius: 4px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 4px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }
    </style>
</x-admin-layout>