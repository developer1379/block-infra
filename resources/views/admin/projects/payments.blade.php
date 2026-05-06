<x-admin-layout>
    <div class="space-y-8 animate-fade-in">
        <!-- Premium Header -->
        <div class="flex items-center justify-between bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <div class="flex items-center gap-5">
                <a href="{{ route('admin.projects.index') }}" class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 hover:text-green-600 hover:bg-green-50 hover:border-green-100 border border-transparent transition-all duration-300">
                    <i class="fa-solid fa-arrow-left-long"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Project Financials</h1>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $project->title }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-green-50 px-4 py-2 rounded-xl border border-green-100">
                    <p class="text-[10px] font-black text-green-600 uppercase tracking-wider">Total Budget</p>
                    <p class="text-lg font-black text-slate-800">₹{{ number_format($project->budget_max, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Milestones -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-flag-checkered text-green-600"></i>
                            Payment Milestones
                        </h3>
                        <button class="px-4 py-2 bg-slate-800 text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-700 transition-all">
                            Add Milestone
                        </button>
                    </div>
                    <div class="p-8">
                        <div class="space-y-4">
                            @forelse($milestones as $milestone)
                                <div class="flex items-center justify-between p-5 bg-slate-50 rounded-2xl border border-slate-100 group hover:border-green-200 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-xl bg-white flex flex-col items-center justify-center border border-slate-200 shadow-sm">
                                            <span class="text-xs font-black text-green-600 leading-none">{{ $milestone->percentage }}%</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">{{ $milestone->title }}</p>
                                            <p class="text-[10px] text-slate-400 font-medium italic">Amount: ₹{{ number_format($milestone->amount, 2) }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 text-[10px] font-black uppercase tracking-tight text-slate-500">
                                            {{ ucfirst($milestone->status) }}
                                        </span>
                                        <i class="fa-solid fa-chevron-right text-slate-300 text-[10px]"></i>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 text-center text-slate-400">
                                    <i class="fa-solid fa-hourglass-start text-3xl mb-3"></i>
                                    <p class="text-sm font-medium italic uppercase tracking-widest">No milestones defined yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Invoices -->
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-file-invoice text-green-600"></i>
                            Recent Invoices
                        </h3>
                    </div>
                    <div class="p-0 overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <tr>
                                    <th class="px-8 py-4">Invoice #</th>
                                    <th class="px-4 py-4">Issue Date</th>
                                    <th class="px-4 py-4">Amount</th>
                                    <th class="px-4 py-4">Status</th>
                                    <th class="px-8 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($invoices as $invoice)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-8 py-5 text-sm font-bold text-slate-800">{{ $invoice->invoice_number }}</td>
                                        <td class="px-4 py-5 text-xs text-slate-500">{{ $invoice->issue_date }}</td>
                                        <td class="px-4 py-5 text-sm font-black text-slate-800">₹{{ number_format($invoice->total_amount, 2) }}</td>
                                        <td class="px-4 py-5 text-xs">
                                            <span class="inline-flex px-2 py-0.5 rounded-full font-bold uppercase tracking-tight text-[9px] 
                                                {{ $invoice->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                                {{ $invoice->status }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 text-right">
                                            <button class="text-green-600 hover:text-green-800 font-black text-[10px] uppercase tracking-widest">Mark Paid</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-8 py-12 text-center text-slate-400 italic text-sm">No billing history found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column: Quick Stats & Actions -->
            <div class="space-y-8">
                <div class="bg-slate-900 rounded-[2rem] p-8 text-white space-y-8 shadow-xl shadow-slate-200">
                    <div class="space-y-2">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Disbursed</p>
                        <p class="text-4xl font-black">₹{{ number_format($invoices->where('status', 'paid')->sum('total_amount'), 2) }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-2">Pending</p>
                            <p class="text-sm font-black text-amber-400">₹{{ number_format($invoices->where('status', '!=', 'paid')->sum('total_amount'), 2) }}</p>
                        </div>
                        <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none mb-2">Completion</p>
                            <p class="text-sm font-black text-green-400">{{ $project->current_progress }}%</p>
                        </div>
                    </div>

                    <div class="pt-4 space-y-3">
                        <button class="w-full py-4 bg-green-500 text-slate-900 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-green-400 transition-all shadow-lg shadow-green-500/20">
                            <i class="fa-solid fa-file-invoice-dollar mr-2"></i> Generate Invoice
                        </button>
                        <button class="w-full py-4 bg-white/10 text-white rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-white/20 transition-all border border-white/10">
                            <i class="fa-solid fa-receipt mr-2"></i> Record Payment
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] border border-slate-100 p-8 space-y-4">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">Financial Summary</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-slate-500">Contractor Payouts</span>
                            <span class="font-bold text-slate-800">85%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-green-500 h-full rounded-full" style="width: 85%"></div>
                        </div>
                        <p class="text-[9px] text-slate-400 italic">Financial health is calculated based on milestone completion vs payouts.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</x-admin-layout>
