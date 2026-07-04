<x-admin-layout>
    <div x-data="{ activeWorker: null, openMaterialId: null, workers: @js($linkedWorkers) }">
        <!-- Page Content (Animated) -->
        <div class="p-6 space-y-8 animate-fade-in">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.projects.index') }}" class="h-10 w-10 flex items-center justify-center bg-white border border-slate-200/60 rounded-xl text-slate-400 hover:text-teal-600 hover:border-teal-100 shadow-sm transition-all">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">{{ $project->title }}</h1>
                        <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                            <span class="bg-teal-50 text-teal-700 px-2.5 py-0.5 rounded-lg border border-teal-100/50">
                                {{ __('Project Management') }}
                            </span>
                            <span>•</span>
                            <span><i class="fa-solid fa-location-dot text-slate-300"></i> {{ $project->location ?? __('Remote Site') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    @can('edit projects')
                        <a href="{{ route('admin.projects.edit', $project->id) }}" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-bold flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-pen-to-square text-xs text-slate-400"></i> {{ __('Edit Project') }}
                        </a>
                    @endcan
                    <span class="px-4 py-2.5 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 text-sm font-bold flex items-center gap-2 uppercase tracking-wider text-xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        {{ $project->status }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Sidebar: Stats & Financials (4 columns) -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Workforce Analytics -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 group">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-users text-teal-600"></i> {{ __('Workforce Overview') }}
                        </h4>
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-slate-50/50 rounded-xl p-4 border border-slate-100">
                                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">{{ __('Total Workers') }}</p>
                                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $workerCount }}</p>
                            </div>
                            <div class="bg-teal-50/50 rounded-xl p-4 border border-teal-100/30">
                                <p class="text-[9px] font-bold text-teal-600 uppercase tracking-wider">{{ __('On Site Today') }}</p>
                                <p class="text-2xl font-bold text-teal-600 mt-1">{{ $attendanceToday }}</p>
                            </div>
                        </div>
                        
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">{{ __('Active Workforce') }}</h4>
                        <div class="space-y-2.5 max-h-[250px] overflow-y-auto custom-scrollbar pr-1">
                            @forelse($linkedWorkers as $worker)
                                <div @click="activeWorker = workers.find(w => w.id === {{ $worker->id }})" 
                                     class="flex items-center justify-between p-3 rounded-xl bg-slate-50/40 border border-transparent hover:border-teal-100 hover:bg-white transition-all duration-200 cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 border border-slate-200/50 flex items-center justify-center text-slate-600 text-xs font-bold uppercase shadow-sm">
                                            {{ substr($worker->name, 0, 2) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-semibold text-slate-800 truncate">{{ $worker->name }}</p>
                                            <p class="text-[9px] text-slate-400 uppercase tracking-wider mt-0.5">{{ $worker->specialization ?? 'General' }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs font-bold text-teal-600">{{ $worker->attendances_count }}</p>
                                        <p class="text-[8px] text-slate-400 uppercase font-bold tracking-wider">Days</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-[10px] text-slate-300 italic text-center py-4">{{ __('No active workforce logs.') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Financial Health -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-chart-line text-emerald-600"></i> {{ __('Financial Integrity') }}
                        </h4>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-end mb-1.5">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ __('Total Bid Value') }}</span>
                                    <span class="text-sm font-bold text-slate-800">₹{{ number_format($project->award?->bid?->bid_amount ?? 0) }}</span>
                                </div>
                                <div class="w-full bg-slate-100 h-1.5 rounded-full">
                                    <div class="bg-teal-500 h-full rounded-full" style="width: 100%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between items-end mb-1.5">
                                    <span class="text-[10px] font-bold text-slate-400">{{ __('Verified Payouts') }}</span>
                                    <span class="text-sm font-bold text-emerald-600">₹{{ number_format($totalProjectPayouts) }}</span>
                                </div>
                                <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                    @php 
                                        $bid = $project->award?->bid?->bid_amount ?? 1;
                                        $paid = $totalProjectPayouts;
                                        $perc = min(100, ($paid / $bid) * 100);
                                    @endphp
                                    <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000" style="width: {{ $perc }}%"></div>
                                </div>
                            </div>
                            @if($pendingProjectPayouts > 0)
                                <div class="bg-amber-50/50 rounded-xl p-4 border border-amber-100/50">
                                    <div class="flex justify-between items-center">
                                        <span class="text-[10px] font-bold text-amber-700 uppercase tracking-wider">{{ __('Pending Verification') }}</span>
                                        <span class="text-sm font-bold text-amber-700">₹{{ number_format($pendingProjectPayouts) }}</span>
                                    </div>
                                    <p class="text-[9px] text-amber-600 mt-1 italic">{{ __('Contractor has submitted new wage records awaiting your audit.') }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="mt-6 pt-6 border-t border-slate-100">
                            <a href="{{ route('admin.worker-payments.index') }}" class="w-full py-2.5 bg-slate-50 border border-slate-200/60 text-slate-600 text-[10px] font-bold uppercase tracking-wider rounded-xl hover:bg-teal-50 hover:text-teal-700 hover:border-teal-100 transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-money-bill-transfer"></i> {{ __('Verify Worker Wages') }}
                            </a>
                        </div>
                    </div>

                    <!-- Site Inventory -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 relative">
                        <h4 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-4">{{ __('Site Inventory Overview') }}</h4>
                        <div class="space-y-2.5">
                            @forelse($groupedMaterials as $materialId => $logs)
                                @php
                                    $material = $logs->first()->material;
                                    $totalIn = $logs->whereIn('type', ['in', 'purchase'])->sum('quantity');
                                    $totalOut = $logs->where('type', 'consumption')->sum('quantity');
                                    $balance = $totalIn - $totalOut;
                                @endphp
                                <div @click="openMaterialId = {{ $material->id }}" class="flex items-center justify-between p-3 rounded-xl border border-slate-100 hover:border-teal-100 hover:bg-teal-50/20 cursor-pointer transition-all duration-200 group">
                                    <div>
                                        <p class="text-xs font-bold text-slate-800 group-hover:text-teal-600 transition-colors">{{ $material->name }}</p>
                                        <p class="text-[9px] text-slate-400 uppercase flex items-center gap-1 mt-0.5">
                                            <span class="text-emerald-500 font-semibold">In: {{ $totalIn }}</span>
                                            <span class="text-slate-300">|</span> 
                                            <span class="text-rose-500 font-semibold">Out: {{ $totalOut }}</span>
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold {{ $balance <= 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                            {{ $balance }}
                                        </p>
                                        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-wider">{{ $material->unit ?? 'Unit' }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-[10px] text-slate-300 italic py-4 text-center">{{ __('No materials recorded for this site.') }}</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Main Content Area (8 columns) -->
                <div class="lg:col-span-8 space-y-8">
                    <!-- Project Progress Hub -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Progress Card -->
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 flex flex-col justify-center text-center">
                            <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-6">{{ __('Verified Site Completion') }}</h3>
                            <div class="relative inline-flex items-center justify-center mx-auto mb-6">
                                <svg class="w-32 h-32 transform -rotate-90">
                                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" class="text-slate-50" />
                                    <circle cx="64" cy="64" r="58" stroke="currentColor" stroke-width="8" fill="transparent" 
                                        stroke-dasharray="364.4" stroke-dashoffset="{{ 364.4 - (364.4 * ($project->current_progress ?? 0) / 100) }}"
                                        class="text-teal-600 transition-all duration-1000 ease-out" stroke-linecap="round" />
                                </svg>
                                <span class="absolute text-3xl font-bold text-slate-800 tracking-tight">{{ $project->current_progress ?? 0 }}%</span>
                            </div>
                            <p class="text-xs text-slate-500 max-w-[200px] mx-auto leading-relaxed">
                                {{ __('Based on the latest daily report submitted by the site manager.') }}
                            </p>
                        </div>

                        <!-- Milestones -->
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-8 flex flex-col">
                            <h3 class="font-bold text-slate-800 text-sm flex items-center gap-2 mb-6">
                                <i class="fa-solid fa-flag-checkered text-teal-600"></i> {{ __('Billing Milestones') }}
                            </h3>
                            <div class="space-y-3.5 flex-1 overflow-y-auto pr-1 custom-scrollbar">
                                @forelse($project->milestones as $milestone)
                                    <div class="flex items-center justify-between p-3.5 rounded-xl border {{ $milestone->status == 'paid' ? 'bg-emerald-50/50 border-emerald-100/50' : 'bg-slate-50 border-slate-100' }}">
                                        <div>
                                            <p class="text-xs font-semibold text-slate-800">{{ $milestone->title }}</p>
                                            <p class="text-[9px] text-slate-400 mt-0.5">{{ $milestone->due_date ? $milestone->due_date->format('M d, Y') : 'Pending' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-xs font-bold text-slate-800">₹{{ number_format($milestone->amount) }}</p>
                                            <span class="inline-flex mt-1 text-[9px] font-bold {{ $milestone->status == 'paid' ? 'text-emerald-600' : 'text-slate-400' }} uppercase tracking-wider">{{ $milestone->status }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center text-[10px] text-slate-400 py-8 italic">No milestones defined.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Verified Activity Timeline -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm flex flex-col overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-camera-retro text-teal-600"></i>
                                {{ __('Verified Progress Timeline') }}
                            </h3>
                        </div>
                        <div class="p-8 max-h-[600px] overflow-y-auto custom-scrollbar">
                            <div class="relative space-y-12 pl-6">
                                <div class="absolute top-2 bottom-2 left-[31px] w-[1px] bg-slate-100"></div>
                                @forelse($project->progressUpdates as $update)
                                    <div class="relative pl-12">
                                        <div class="absolute left-0 top-0 h-10 w-10 rounded-2xl bg-white border-2 border-teal-100/50 shadow-sm flex items-center justify-center z-10 font-bold text-teal-600 text-xs">
                                            {{ $update->progress_percentage }}%
                                        </div>
                                        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-all duration-200 group">
                                            <div class="flex justify-between items-start mb-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 rounded-full bg-slate-100 border border-slate-200/50 flex items-center justify-center text-slate-600 text-xs font-bold uppercase shadow-sm">
                                                        {{ substr($update->user->name ?? 'C', 0, 2) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-bold text-slate-800">{{ $update->user->name ?? 'Contractor' }}</p>
                                                        <p class="text-[9px] text-slate-400 mt-0.5">{{ $update->created_at->format('M d, Y - h:i A') }}</p>
                                                    </div>
                                                </div>
                                                @if($update->latitude)
                                                    <a href="https://www.google.com/maps?q={{ $update->latitude }},{{ $update->longitude }}" target="_blank" class="px-3 py-1.5 bg-emerald-50 text-emerald-700 text-[9px] font-bold rounded-lg border border-emerald-100 hover:bg-emerald-600 hover:text-white transition-all flex items-center gap-1">
                                                        <i class="fa-solid fa-location-dot"></i> {{ __('Site Verified') }}
                                                    </a>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-600 leading-relaxed italic pl-4 border-l-2 border-teal-200">"{{ $update->report_description }}"</p>
                                            
                                            @if ($update->report_file_path)
                                                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                                        <i class="fa-solid fa-paperclip"></i> {{ __('Site Proof Attached') }}
                                                    </span>
                                                    <a href="{{ asset('storage/' . $update->report_file_path) }}" target="_blank" class="h-10 w-10 flex items-center justify-center bg-slate-50 border border-slate-200/60 rounded-xl text-teal-600 hover:bg-teal-600 hover:text-white transition-all">
                                                        <i class="fa-solid fa-eye text-sm"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-20">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-center mx-auto mb-4 text-slate-400">
                                            <i class="fa-solid fa-file-waveform text-xl"></i>
                                        </div>
                                        <h4 class="text-sm font-bold text-slate-800">{{ __('No Verified Activity') }}</h4>
                                        <p class="text-slate-400 text-xs max-w-xs mx-auto mt-1">{{ __('All site reports from the contractor will appear here with location verification.') }}</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Project Allocation Hub -->
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                        <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <i class="fa-solid fa-handshake text-teal-600"></i>
                                {{ __('Project Allocation & Awards') }}
                            </h3>
                        </div>
                        
                        <div class="p-8 space-y-8">
                            {{-- Direct Whole Project Allocation --}}
                            <div class="bg-teal-50/20 rounded-2xl p-6 border border-teal-100/50">
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-building-user text-teal-600"></i> {{ __('Direct Whole Project Allocation') }}
                                </h4>
                                @if($project->contractor_id)
                                    <div class="bg-white rounded-xl p-4 border border-teal-100 flex items-center justify-between shadow-sm">
                                        <div>
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">{{ __('Allocated Contractor') }}</p>
                                            <p class="text-sm font-bold text-slate-800 mt-1">
                                                {{ $project->contractor->name ?? 'Unknown Contractor' }} 
                                                @if($project->contractor->company_name)
                                                    ({{ $project->contractor->company_name }})
                                                @endif
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-100 text-[10px] font-bold uppercase tracking-wider">
                                                {{ __('Awarded & Allocated') }}
                                            </span>
                                            <form action="{{ route('admin.projects.allocate-direct', $project->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unassign this contractor? This will also revert project status to open.');">
                                                @csrf
                                                <input type="hidden" name="contractor_id" value="">
                                                <button type="submit" class="p-1.5 text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Unassign Contractor">
                                                    <i class="fa-solid fa-circle-xmark text-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <form action="{{ route('admin.projects.allocate-direct', $project->id) }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
                                        @csrf
                                        <div class="flex-1 w-full">
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2 tracking-wider">{{ __('Select Contractor') }}</label>
                                            <select name="contractor_id" class="w-full h-11 px-4 rounded-xl border border-slate-200 text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all cursor-pointer">
                                                <option value="">{{ __('Choose a contractor...') }}</option>
                                                @foreach($contractors as $contractor)
                                                    <option value="{{ $contractor->id }}" {{ $project->contractor_id == $contractor->contractor?->id ? 'selected' : '' }}>
                                                        {{ $contractor->name }} ({{ $contractor->contractor?->company_name ?? 'Individual' }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="px-6 py-2.5 bg-teal-600 text-white text-xs font-bold rounded-xl hover:bg-teal-700 transition-all flex items-center gap-2 whitespace-nowrap h-11">
                                            <i class="fa-solid fa-check-circle text-xs"></i> {{ __('Allocate Project') }}
                                        </button>
                                    </form>
                                @endif
                                <p class="text-[9px] text-slate-400 mt-3 italic">{{ __('This will assign the entire project and all its work items to the selected contractor.') }}</p>
                            </div>

                            {{-- Partial Allocation (By Work) --}}
                            <div>
                                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-4 flex items-center gap-2">
                                    <i class="fa-solid fa-layer-group text-teal-600"></i> {{ __('Partial Allocation (By Work Item)') }}
                                </h4>
                                <div class="border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-slate-50 text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                                <th class="px-6 py-3.5">{{ __('Work Item') }}</th>
                                                <th class="px-6 py-3.5">{{ __('Assigned Contractor') }}</th>
                                                <th class="px-6 py-3.5 text-right w-24">{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-50 text-xs">
                                            @foreach($project->works as $work)
                                                <tr class="hover:bg-slate-50/40 transition-colors">
                                                    <td class="px-6 py-3.5">
                                                        <div class="font-bold text-slate-800">{{ $work->name }}</div>
                                                        <div class="text-[10px] text-slate-400 mt-0.5">₹{{ number_format($work->pivot->amount, 2) }}</div>
                                                    </td>
                                                    <td class="px-6 py-3.5">
                                                        <form action="{{ route('admin.projects.allocate-work', $work->pivot->id) }}" method="POST" id="form-work-{{ $work->pivot->id }}">
                                                            @csrf
                                                            <select name="contractor_id" class="text-xs border border-slate-200 rounded-lg bg-slate-50 focus:ring-teal-500 focus:border-teal-500 py-1 pl-3 pr-8 cursor-pointer transition-all">
                                                                <option value="">{{ __('Unassigned') }}</option>
                                                                @foreach($contractors as $contractor)
                                                                    <option value="{{ $contractor->id }}" {{ $work->pivot->contractor_id == $contractor->id ? 'selected' : '' }}>
                                                                        {{ $contractor->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </form>
                                                    </td>
                                                    <td class="px-6 py-3.5 text-right">
                                                        <button type="submit" form="form-work-{{ $work->pivot->id }}" class="p-2 bg-teal-50 text-teal-600 border border-teal-100 rounded-lg hover:bg-teal-600 hover:text-white transition-all shadow-sm">
                                                            <i class="fa-solid fa-floppy-disk text-xs"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Worker Profile Offcanvas/Drawer (Outside animated parent to prevent fixed layout breaking) -->
        <div x-show="activeWorker !== null" class="fixed inset-0 z-[150] overflow-hidden" x-cloak>
            <!-- Backdrop -->
            <div x-show="activeWorker !== null" 
                 x-transition:enter="ease-in-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in-out duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="activeWorker = null"
                 class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

            <!-- Drawer Content Wrapper -->
            <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
                <div x-show="activeWorker !== null"
                     x-transition:enter="transform transition ease-in-out duration-300"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-300"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="w-screen max-w-md bg-white shadow-2xl flex flex-col h-full">
                     
                     <!-- Drawer Header -->
                     <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                         <div>
                             <h3 class="text-base font-bold text-slate-800">Worker Profile</h3>
                             <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">Details & Attendance Logs</p>
                         </div>
                         <button @click="activeWorker = null" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-colors">
                             <i class="fa-solid fa-xmark text-sm"></i>
                         </button>
                     </div>
                     
                     <!-- Drawer Body -->
                     <div class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-6">
                         <!-- Profile info -->
                         <div class="flex items-center gap-4 p-4 bg-slate-50/50 rounded-2xl border border-slate-100">
                             <div class="w-12 h-12 rounded-2xl bg-teal-600/10 text-teal-600 border border-teal-100/50 flex items-center justify-center text-lg font-bold uppercase shadow-sm">
                                 <span x-text="activeWorker ? activeWorker.name.substring(0, 2).toUpperCase() : ''"></span>
                             </div>
                             <div class="min-w-0 flex-1">
                                 <h4 class="text-sm font-bold text-slate-800 truncate" x-text="activeWorker ? activeWorker.name : ''"></h4>
                                 <span class="inline-flex items-center px-2 py-0.5 rounded text-[9px] font-bold bg-teal-50 text-teal-700 border border-teal-100/50 uppercase tracking-wider mt-1.5" x-text="activeWorker ? (activeWorker.specialization || 'General') : ''"></span>
                             </div>
                         </div>
                         
                         <!-- Stats Grid -->
                         <div class="grid grid-cols-2 gap-4">
                             <div class="bg-slate-50/30 rounded-xl p-3.5 border border-slate-100 text-center">
                                 <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Daily Wage</p>
                                 <p class="text-base font-bold text-slate-800 mt-1" x-text="activeWorker ? '₹' + Number(activeWorker.daily_wage).toLocaleString('en-IN') : '-'"></p>
                             </div>
                             <div class="bg-slate-50/30 rounded-xl p-3.5 border border-slate-100 text-center">
                                 <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total Days</p>
                                 <p class="text-base font-bold text-teal-600 mt-1" x-text="activeWorker ? activeWorker.attendances_count : '0'"></p>
                             </div>
                         </div>
                         
                         <!-- Contact & Identity -->
                         <div class="space-y-3">
                             <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-1.5">Contact & Identity</h5>
                             <div class="grid grid-cols-2 gap-4 text-xs">
                                 <div>
                                     <p class="text-slate-400 font-medium">Phone Number</p>
                                     <p class="font-bold text-slate-700 mt-0.5" x-text="activeWorker ? activeWorker.phone : '-'"></p>
                                 </div>
                                 <div>
                                     <p class="text-slate-400 font-medium">Identity Type</p>
                                     <p class="font-bold text-slate-700 mt-0.5" x-text="activeWorker ? (activeWorker.identity_type || '-') : '-'"></p>
                                 </div>
                                 <div class="col-span-2" x-show="activeWorker && activeWorker.identity_proof">
                                     <p class="text-slate-400 font-medium">Identity Proof Document</p>
                                     <a :href="'/storage/' + (activeWorker ? activeWorker.identity_proof : '')" target="_blank" class="inline-flex items-center gap-1.5 mt-1.5 text-teal-600 hover:text-teal-700 font-bold hover:underline">
                                         <i class="fa-solid fa-file-invoice text-xs"></i> View Attached Proof
                                     </a>
                                 </div>
                             </div>
                         </div>
                         
                         <!-- Attendance logs -->
                         <div class="space-y-3">
                             <h5 class="text-[10px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-1.5">Attendance History on Project</h5>
                             <div class="space-y-2.5 max-h-[350px] overflow-y-auto custom-scrollbar pr-1">
                                 <template x-for="att in (activeWorker ? activeWorker.attendances : [])" :key="att.id">
                                     <div class="p-3.5 rounded-xl border border-slate-100 bg-slate-50/20 space-y-2.5">
                                         <div class="flex justify-between items-center">
                                             <div class="flex items-center gap-1.5">
                                                 <p class="text-xs font-bold text-slate-700" x-text="new Date(att.attendance_date).toLocaleDateString('en-US', {day: 'numeric', month: 'short', year: 'numeric', timeZone: 'UTC'})"></p>
                                                 <template x-if="att.latitude">
                                                     <i class="fa-solid fa-location-dot text-emerald-500 text-xs" title="GPS Location Available"></i>
                                                 </template>
                                             </div>
                                             <span class="inline-flex items-center px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider border" 
                                                   :class="att.status === 'present' ? 'bg-emerald-50 text-emerald-700 border-emerald-100/50' : 'bg-rose-50 text-rose-700 border-rose-100/50'"
                                                   x-text="att.status"></span>
                                         </div>
                                         
                                         <!-- Details -->
                                         <div class="text-[10px] space-y-2 pt-2.5 border-t border-slate-100/80" x-show="att.overtime_hours > 0 || att.location_address || att.verification_photo || att.notes">
                                             <div class="flex justify-between items-center" x-show="att.overtime_hours > 0">
                                                 <span class="text-slate-400 font-semibold">Overtime Hours:</span>
                                                 <span class="font-bold text-slate-700 bg-teal-50 text-teal-700 border border-teal-100/50 px-2 py-0.5 rounded" x-text="att.overtime_hours + ' hrs'"></span>
                                             </div>
                                             
                                             <div x-show="att.location_address" class="space-y-1">
                                                 <span class="text-slate-400 font-semibold">Location Address:</span>
                                                 <p class="font-medium text-slate-600 leading-normal" x-text="att.location_address"></p>
                                                 <a :href="'https://www.google.com/maps?q=' + att.latitude + ',' + att.longitude" target="_blank" class="inline-flex items-center gap-1 mt-1 text-teal-600 hover:text-teal-700 font-bold hover:underline">
                                                     <i class="fa-solid fa-map-pin text-[9px]"></i> View GPS Coordinates
                                                 </a>
                                             </div>

                                             <div x-show="att.verification_photo" class="pt-1">
                                                 <span class="text-slate-400 font-semibold block mb-1">Verification Proof:</span>
                                                 <a :href="'/storage/' + att.verification_photo" target="_blank" class="inline-flex items-center gap-1.5 text-teal-600 hover:text-teal-700 font-bold hover:underline">
                                                     <i class="fa-solid fa-camera text-xs"></i> View Proof Photo
                                                 </a>
                                             </div>

                                             <div x-show="att.notes" class="pt-1.5 border-t border-slate-100/40">
                                                 <span class="text-slate-400 font-semibold">Contractor Notes:</span>
                                                 <p class="text-slate-600 italic font-medium mt-0.5 pl-2.5 border-l-2 border-slate-200" x-text="'&ldquo;' + att.notes + '&rdquo;'"></p>
                                             </div>
                                         </div>
                                     </div>
                                 </template>
                                 <div x-show="!activeWorker || !activeWorker.attendances || activeWorker.attendances.length === 0" class="text-center py-8 text-slate-300 italic text-xs">
                                     No attendance logs registered on this project.
                                 </div>
                             </div>
                         </div>
                     </div>
                </div>
            </div>
        </div>

        <!-- Modals for Material Transactions (Outside animated parent to prevent fixed layout breaking) -->
        @foreach($groupedMaterials as $materialId => $logs)
            @php
                $material = $logs->first()->material;
            @endphp
            <div x-show="openMaterialId === {{ $material->id }}" x-cloak
                 class="fixed inset-0 z-[150] flex items-center justify-center p-4">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openMaterialId = null"></div>

                <!-- Modal Content -->
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden relative z-[160] animate-fade-in">
                    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <div>
                            <h3 class="text-base font-bold text-slate-800">{{ $material->name }} {{ __('Transactions') }}</h3>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider mt-1">{{ __('Unit:') }} <span class="text-slate-700 font-bold">{{ $material->unit ?? 'Unit' }}</span></p>
                        </div>
                        <button @click="openMaterialId = null" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-colors">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="p-0 overflow-y-auto custom-scrollbar flex-1">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50/80 sticky top-0 z-10 backdrop-blur-sm">
                                <tr class="border-b border-slate-100 text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                    <th class="px-6 py-3.5">{{ __('Date') }}</th>
                                    <th class="px-6 py-3.5">{{ __('Type') }}</th>
                                    <th class="px-6 py-3.5">{{ __('Qty') }}</th>
                                    <th class="px-6 py-3.5">{{ __('Vendor') }}</th>
                                    <th class="px-6 py-3.5">{{ __('Notes') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @foreach($logs as $log)
                                    <tr class="hover:bg-slate-50/40 transition-colors">
                                        <td class="px-6 py-3.5">
                                            <p class="font-bold text-slate-700">{{ $log->entry_date ? $log->entry_date->format('M d, Y') : '-' }}</p>
                                        </td>
                                        <td class="px-6 py-3.5">
                                            @if(in_array($log->type, ['in', 'purchase']))
                                                <span class="inline-flex items-center px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded text-[9px] font-bold uppercase tracking-wider">
                                                    <i class="fa-solid fa-arrow-down text-[8px] mr-1"></i> IN
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-100 rounded text-[9px] font-bold uppercase tracking-wider">
                                                    <i class="fa-solid fa-arrow-up text-[8px] mr-1"></i> OUT
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3.5 font-bold {{ in_array($log->type, ['in', 'purchase']) ? 'text-emerald-600' : 'text-rose-600' }}">
                                            {{ in_array($log->type, ['in', 'purchase']) ? '+' : '-' }}{{ number_format($log->quantity, 2) }}
                                        </td>
                                        <td class="px-6 py-3.5 text-slate-600 font-semibold">
                                            {{ $log->vendor_name ?: 'System' }}
                                        </td>
                                        <td class="px-6 py-3.5 text-[10px] text-slate-500 italic max-w-[200px] truncate" title="{{ $log->notes }}">
                                            {{ $log->notes ?: '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
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
