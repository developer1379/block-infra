<x-admin-layout>
    <div class="space-y-8 animate-fade-in">
        <!-- Header / Welcome Banner -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Executive Dashboard</h1>
                <p class="text-sm text-slate-500 mt-0.5">Welcome back, <span class="font-semibold text-slate-700">{{ auth()->user()->name }}</span>. Here is your platform overview for {{ \Carbon\Carbon::now()->format('l, F j, Y') }}.</p>
            </div>
            <div class="flex items-center self-start md:self-auto gap-2 px-3 py-1.5 bg-slate-50 rounded-xl border border-slate-200/60 shadow-sm">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">System Live</span>
            </div>
        </div>

        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Contractors -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover-lift group relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-indigo-500/10 group-hover:bg-indigo-500 transition-colors duration-300"></div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-user-tie text-lg"></i>
                    </div>
                    <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50/80 px-2 py-0.5 rounded-md">Partners</span>
                </div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Contractors</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1 tracking-tight">{{ number_format($stats['total_contractors']) }}</h3>
                <div class="mt-3 flex items-center text-xs text-slate-500">
                    <i class="fa-solid fa-circle-check text-emerald-500 mr-1.5"></i>
                    <span>All verified profiles</span>
                </div>
            </div>

            <!-- Total Projects -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover-lift group relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-teal-500/10 group-hover:bg-teal-500 transition-colors duration-300"></div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600 group-hover:bg-teal-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-diagram-project text-lg"></i>
                    </div>
                    <span class="text-[10px] font-bold text-teal-600 bg-teal-50/80 px-2 py-0.5 rounded-md">Operations</span>
                </div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Active Projects</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1 tracking-tight">{{ number_format($stats['total_projects']) }}</h3>
                <div class="mt-3 flex items-center text-xs text-slate-500">
                    <span class="font-medium text-teal-600 mr-1">{{ $stats['active_projects'] }} ongoing</span>
                    <span>• {{ $stats['pending_projects'] }} pending</span>
                </div>
            </div>

            <!-- Total Workforce -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover-lift group relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-amber-500/10 group-hover:bg-amber-500 transition-colors duration-300"></div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-users-gear text-lg"></i>
                    </div>
                    <span class="text-[10px] font-bold text-amber-600 bg-amber-50/80 px-2 py-0.5 rounded-md">Labor Pool</span>
                </div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Registered Workforce</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1 tracking-tight">{{ number_format($stats['total_workers']) }}</h3>
                <div class="mt-3 flex items-center text-xs text-slate-500">
                    <i class="fa-solid fa-trend-up text-amber-600 mr-1.5"></i>
                    <span>Across all operation sites</span>
                </div>
            </div>

            <!-- Total Wages -->
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover-lift group relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-rose-500/10 group-hover:bg-rose-500 transition-colors duration-300"></div>
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-rose-50 rounded-xl flex items-center justify-center text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-all duration-300">
                        <i class="fa-solid fa-file-invoice-dollar text-lg"></i>
                    </div>
                    <span class="text-[10px] font-bold text-rose-600 bg-rose-50/80 px-2 py-0.5 rounded-md">Finance</span>
                </div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Disbursed Wages</p>
                <h3 class="text-3xl font-bold text-slate-800 mt-1 tracking-tight">₹{{ number_format($stats['total_payments']) }}</h3>
                <div class="mt-3 flex items-center text-xs text-rose-600 font-medium">
                    <i class="fa-solid fa-clock-rotate-left mr-1.5"></i>
                    <span>{{ $stats['pending_payments'] }} pending verification</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            <!-- Recent Projects (Left, spans 3 cols) -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden lg:col-span-3 flex flex-col justify-between">
                <div>
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div>
                            <h3 class="font-bold text-slate-800">Recent Projects</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Stage and status of latest work assignments</p>
                        </div>
                        <a href="{{ route('admin.projects.index') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700 bg-teal-50 px-3 py-1.5 rounded-lg transition-colors">View All Projects</a>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($recentProjects as $project)
                        <div class="p-5 hover:bg-slate-50/40 transition-colors flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600 shrink-0 mt-0.5">
                                    <i class="fa-solid fa-folder-open text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800 hover:text-teal-600 transition-colors cursor-pointer">{{ $project->title }}</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-slate-300"></i> {{ $project->location }}
                                        <span class="text-slate-300">•</span>
                                        <i class="fa-solid fa-user-tie text-slate-300"></i> Contractor: <span class="font-medium text-slate-500">{{ $project->contractor->user->name ?? 'Unassigned' }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center md:text-right self-end md:self-auto gap-4 shrink-0">
                                <div class="w-28">
                                    <div class="flex items-center justify-between text-[10px] font-bold text-slate-500 mb-1">
                                        <span>Progress</span>
                                        <span>
                                            @if($project->status === 'completed') 100% @elseif($project->status === 'ongoing') 60% @else 20% @endif
                                        </span>
                                    </div>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-500
                                            @if($project->status === 'completed') bg-emerald-500 w-full
                                            @elseif($project->status === 'ongoing') bg-indigo-500 w-3/5
                                            @else bg-slate-400 w-1/5 @endif">
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        @if($project->status === 'completed') bg-emerald-50 text-emerald-700 border border-emerald-200/50
                                        @elseif($project->status === 'ongoing') bg-indigo-50 text-indigo-700 border border-indigo-200/50
                                        @else bg-slate-100 text-slate-700 border border-slate-200/50 @endif">
                                        {{ $project->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center">
                            <p class="text-sm text-slate-400">No projects registered yet.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Workforce Payments (Right, spans 2 cols) -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden lg:col-span-2 flex flex-col justify-between">
                <div>
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                        <div>
                            <h3 class="font-bold text-slate-800">Wage Disbursements</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Real-time payment logs</p>
                        </div>
                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-rose-500 bg-rose-50 px-2.5 py-1 rounded-md animate-pulse">
                            <i class="fa-solid fa-circle text-[6px]"></i> Live Feed
                        </span>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($recentPayments as $payment)
                        <div class="p-5 hover:bg-slate-50/40 transition-colors flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200/50 flex items-center justify-center text-slate-600 font-bold text-xs uppercase shadow-sm">
                                    {{ substr($payment->worker->name, 0, 2) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $payment->worker->name }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">Paid by <span class="font-medium text-slate-500">{{ $payment->contractor->user->name ?? 'Contractor' }}</span></p>
                                    <p class="text-[9px] text-slate-400 mt-0.5">{{ $payment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-sm font-bold text-slate-800">₹{{ number_format($payment->amount) }}</p>
                                <span class="inline-flex items-center gap-1 mt-1 px-1.5 py-0.5 rounded text-[9px] font-semibold uppercase tracking-wider
                                    @if($payment->status === 'paid' || $payment->status === 'approved' || $payment->status === 'completed') bg-emerald-50 text-emerald-700
                                    @else bg-amber-50 text-amber-700 @endif">
                                    @if($payment->status === 'paid' || $payment->status === 'approved' || $payment->status === 'completed')
                                        <i class="fa-solid fa-circle-check text-[8px]"></i> Paid
                                    @else
                                        <i class="fa-solid fa-clock text-[8px]"></i> Pending
                                    @endif
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center">
                            <p class="text-sm text-slate-400">No recent payments recorded.</p>
                        </div>
                        @endforelse
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
            animation: fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</x-admin-layout>
