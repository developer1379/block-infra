<x-admin-layout>
    <div class="p-6 space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.projects.index') }}" class="h-10 w-10 flex items-center justify-center bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 hover:border-indigo-100 shadow-sm transition-all">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">{{ $project->title }}</h1>
                    <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">
                        <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded border border-indigo-100">
                            {{ __('Project Management') }}
                        </span>
                        <span>•</span>
                        <span><i class="fa-solid fa-location-dot"></i> {{ $project->location ?? __('Remote Site') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @can('edit projects')
                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-slate-900 transition-all">
                        <i class="fa-solid fa-pen-to-square"></i> {{ __('Edit Project') }}
                    </a>
                @endcan
                <span class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 text-sm font-bold flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ strtoupper($project->status) }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sidebar: Stats & Financials (4 columns) -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Workforce Analytics -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 group">
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-users text-indigo-600"></i> {{ __('Workforce Overview') }}
                    </h4>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-slate-50 rounded-2xl p-4">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-tighter">{{ __('Total Workers') }}</p>
                            <p class="text-xl font-black text-slate-900">{{ $workerCount }}</p>
                        </div>
                        <div class="bg-indigo-50 rounded-2xl p-4">
                            <p class="text-[8px] font-black text-indigo-400 uppercase tracking-tighter">{{ __('On Site Today') }}</p>
                            <p class="text-xl font-black text-indigo-600">{{ $attendanceToday }}</p>
                        </div>
                    </div>
                    
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-3">{{ __('Active Workforce') }}</h4>
                    <div class="space-y-3 max-h-[250px] overflow-y-auto custom-scrollbar pr-2">
                        @forelse($linkedWorkers as $worker)
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50/50 border border-transparent hover:border-indigo-100 hover:bg-white transition-all">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white text-[10px] font-black">
                                    {{ substr($worker->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] font-bold text-slate-900 truncate">{{ $worker->name }}</p>
                                    <p class="text-[8px] text-slate-400 uppercase tracking-tighter">{{ $worker->specialization ?? 'General' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-black text-indigo-600">{{ $worker->attendances_count }}</p>
                                    <p class="text-[7px] text-slate-400 uppercase font-bold tracking-tighter">Days</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-[10px] text-slate-300 italic text-center py-4">{{ __('No active workforce logs.') }}</p>
                        @endforelse
                    </div>
                </div>

                <!-- Financial Health -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-chart-line text-emerald-600"></i> {{ __('Financial Integrity') }}
                    </h4>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between items-end mb-1">
                                <span class="text-[10px] font-bold text-slate-400">{{ __('Project Bid Value') }}</span>
                                <span class="text-sm font-black text-slate-900">₹{{ number_format($project->award->bid->bid_amount ?? 0) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full">
                                <div class="bg-indigo-500 h-full rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-end mb-1">
                                <span class="text-[10px] font-bold text-slate-400">{{ __('Verified Payouts') }}</span>
                                <span class="text-sm font-black text-emerald-600">₹{{ number_format($totalProjectPayouts) }}</span>
                            </div>
                            <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                @php 
                                    $bid = $project->award->bid->bid_amount ?? 1;
                                    $paid = $totalProjectPayouts;
                                    $perc = min(100, ($paid / $bid) * 100);
                                @endphp
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000" style="width: {{ $perc }}%"></div>
                            </div>
                        </div>
                        @if($pendingProjectPayouts > 0)
                            <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-amber-700 uppercase tracking-widest">{{ __('Pending Verification') }}</span>
                                    <span class="text-sm font-black text-amber-700">₹{{ number_format($pendingProjectPayouts) }}</span>
                                </div>
                                <p class="text-[8px] text-amber-600 mt-1 italic">{{ __('Contractor has submitted new wage records awaiting your audit.') }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="mt-6 pt-6 border-t border-slate-50">
                        <a href="{{ route('admin.worker-payments.index') }}" class="w-full py-3 bg-slate-50 text-slate-600 text-[10px] font-black rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-money-bill-transfer"></i> {{ __('Verify Worker Wages') }}
                        </a>
                    </div>
                </div>

                <!-- Site Inventory -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                    <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">{{ __('Latest Material Logs') }}</h4>
                    <div class="space-y-3">
                        @forelse($materialLogs as $log)
                            <div class="flex items-center justify-between py-2 border-b border-slate-50 last:border-0">
                                <div>
                                    <p class="text-xs font-bold text-slate-800">{{ $log->material->name }}</p>
                                    <p class="text-[9px] text-slate-400 uppercase">{{ $log->log_type }}</p>
                                </div>
                                <p class="text-xs font-black {{ $log->log_type == 'out' ? 'text-rose-500' : 'text-emerald-500' }}">
                                    {{ $log->log_type == 'out' ? '-' : '+' }}{{ $log->quantity }}
                                </p>
                            </div>
                        @empty
                            <p class="text-[10px] text-slate-300 italic py-4 text-center">{{ __('No recent movement.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Main Content Area (8 columns) -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Project Progress Hub -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Progress Card -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 flex flex-col justify-center text-center">
                        <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-6">{{ __('Verified Site Completion') }}</h3>
                        <div class="relative inline-flex items-center justify-center mx-auto mb-6">
                            <svg class="w-32 h-32 transform -rotate-90">
                                <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-50" />
                                <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" 
                                    stroke-dasharray="364.4" stroke-dashoffset="{{ 364.4 - (364.4 * ($project->current_progress ?? 0) / 100) }}"
                                    class="text-indigo-600 transition-all duration-1000 ease-out" stroke-linecap="round" />
                            </svg>
                            <span class="absolute text-3xl font-black text-slate-900">{{ $project->current_progress ?? 0 }}%</span>
                        </div>
                        <p class="text-xs text-slate-500 max-w-[200px] mx-auto leading-relaxed">
                            {{ __('Based on the latest daily report submitted by the site manager.') }}
                        </p>
                    </div>

                    <!-- Milestones -->
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-8 flex flex-col">
                        <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2 mb-6">
                            <i class="fa-solid fa-flag-checkered text-indigo-600"></i> {{ __('Billing Milestones') }}
                        </h3>
                        <div class="space-y-4 flex-1 overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($project->milestones as $milestone)
                                <div class="flex items-center justify-between p-3 rounded-2xl border {{ $milestone->status == 'paid' ? 'bg-emerald-50 border-emerald-100' : 'bg-slate-50 border-slate-100' }}">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-900">{{ $milestone->title }}</p>
                                        <p class="text-[8px] text-slate-400">{{ $milestone->due_date ? $milestone->due_date->format('M d, Y') : 'Pending' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] font-black text-slate-900">₹{{ number_format($milestone->amount) }}</p>
                                        <span class="text-[8px] font-bold {{ $milestone->status == 'paid' ? 'text-emerald-600' : 'text-slate-400' }}">{{ strtoupper($milestone->status) }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-[10px] text-slate-400 py-8 italic">No milestones defined.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Verified Activity Timeline -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
                        <h3 class="font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-camera-retro text-indigo-600"></i>
                            {{ __('Verified Progress Timeline') }}
                        </h3>
                    </div>
                    <div class="p-8 max-h-[600px] overflow-y-auto custom-scrollbar">
                        <div class="relative space-y-12 pl-6">
                            <div class="absolute top-2 bottom-2 left-[31px] w-[1px] bg-indigo-50"></div>
                            @forelse($project->progressUpdates as $update)
                                <div class="relative pl-12">
                                    <div class="absolute left-0 top-0 h-10 w-10 rounded-2xl bg-white border-2 border-indigo-50 shadow-sm flex items-center justify-center z-10 font-black text-indigo-600 text-[10px]">
                                        {{ $update->progress_percentage }}%
                                    </div>
                                    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-sm font-bold border border-indigo-100">
                                                    {{ substr($update->user->name ?? 'C', 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-900">{{ $update->user->name ?? 'Contractor' }}</p>
                                                    <p class="text-[10px] text-slate-400">{{ $update->created_at->format('M d, Y - h:i A') }}</p>
                                                </div>
                                            </div>
                                            @if($update->latitude)
                                                <a href="https://www.google.com/maps?q={{ $update->latitude }},{{ $update->longitude }}" target="_blank" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 text-[9px] font-bold rounded-lg border border-emerald-100 hover:bg-emerald-600 hover:text-white transition-all flex items-center gap-1">
                                                    <i class="fa-solid fa-location-dot"></i> {{ __('Site Verified') }}
                                                </a>
                                            @endif
                                        </div>
                                        <p class="text-sm text-slate-600 leading-relaxed italic pl-4 border-l-2 border-indigo-200">"{{ $update->report_description }}"</p>
                                        
                                        @if ($update->report_file_path)
                                            <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-1">
                                                    <i class="fa-solid fa-paperclip"></i> {{ __('Site Proof Attached') }}
                                                </span>
                                                <a href="{{ asset('storage/' . $update->report_file_path) }}" target="_blank" class="h-10 w-10 flex items-center justify-center bg-slate-50 rounded-xl text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-24">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-200 text-4xl">
                                        <i class="fa-solid fa-file-waveform"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-slate-900">{{ __('No Verified Activity') }}</h4>
                                    <p class="text-slate-500 text-sm max-w-xs mx-auto">{{ __('All site reports from the contractor will appear here with location verification.') }}</p>
                                </div>
                            @endforelse
                        </div>
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
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f8fafc;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
</x-admin-layout>
