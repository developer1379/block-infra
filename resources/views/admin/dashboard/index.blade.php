<x-admin-layout>
    <div class="space-y-8 animate-fade-in">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Platform Overview</h1>
                <p class="text-sm text-slate-500">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-slate-200 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                <span class="text-xs font-bold text-slate-600 uppercase tracking-widest">System Online</span>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Contractors -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover-lift group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-user-tie text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg">Total</span>
                </div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Contractors</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total_contractors']) }}</h3>
            </div>

            <!-- Total Projects -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover-lift group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-teal-50 rounded-2xl flex items-center justify-center text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-building-columns text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-teal-600 bg-teal-50 px-2 py-1 rounded-lg">Live</span>
                </div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Projects</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total_projects']) }}</h3>
            </div>

            <!-- Total Workforce -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover-lift group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-users-gear text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-1 rounded-lg">Workers</span>
                </div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Workforce</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total_workers']) }}</h3>
            </div>

            <!-- Total Payments -->
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover-lift group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-all">
                        <i class="fa-solid fa-money-bill-trend-up text-xl"></i>
                    </div>
                    <span class="text-xs font-bold text-rose-600 bg-rose-50 px-2 py-1 rounded-lg">Cashflow</span>
                </div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-wider">Total Wages</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">₹{{ number_format($stats['total_payments'] / 1000, 1) }}k</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Projects -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800">Recent Projects</h3>
                    <a href="{{ route('admin.projects.index') }}" class="text-xs font-bold text-indigo-600 hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-50">
                            @foreach($recentProjects as $project)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-800">{{ $project->title }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-tighter">{{ $project->location }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded-lg bg-slate-100 text-slate-600 text-[10px] font-black uppercase">
                                        {{ $project->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Workforce Payments -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800">Recent Wage Disbursements</h3>
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Live Feed</span>
                </div>
                <div class="p-6 space-y-6">
                    @forelse($recentPayments as $payment)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-xs">
                                {{ substr($payment->worker->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $payment->worker->name }}</p>
                                <p class="text-[10px] text-slate-400">Paid by <span class="font-bold">{{ $payment->contractor->user->name ?? 'Contractor' }}</span></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-slate-800">₹{{ number_format($payment->amount) }}</p>
                            <p class="text-[10px] text-slate-400 uppercase">{{ $payment->payment_method }}</p>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-sm text-slate-400 py-10">No recent payments recorded.</p>
                    @endforelse
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
