<x-admin-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Financial Management</h1>
                <p class="text-sm text-slate-500">Review invoices, project budgets, and payment status.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Invoiced</p>
                <p class="text-2xl font-black text-slate-900 mt-1">₹{{ number_format($invoices->sum('total_amount'), 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Paid Amount</p>
                <p class="text-2xl font-black text-green-600 mt-1">₹{{ number_format($invoices->where('status', 'paid')->sum('total_amount'), 2) }}</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pending Collections</p>
                <p class="text-2xl font-black text-amber-600 mt-1">₹{{ number_format($invoices->where('status', '!=', 'paid')->sum('total_amount'), 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Invoice #</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Project</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Amount</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-800">{{ $invoice->invoice_number }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ $invoice->issue_date }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-slate-700">{{ $invoice->project->name ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4 text-center font-mono text-sm font-bold text-slate-900">
                                    ₹{{ number_format($invoice->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $invoice->status == 'paid' ? 'bg-green-100 text-green-800' : ($invoice->status == 'overdue' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.finance.show', $invoice->id) }}" class="text-indigo-600 hover:text-indigo-800 font-bold text-xs uppercase">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center text-slate-400">
                                    <i class="fa-solid fa-file-invoice-dollar text-4xl mb-3"></i>
                                    <p>No invoices or financial records found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
