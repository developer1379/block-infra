<x-contractor-layout>
    <div class="p-6 space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('contractor.projects.index') }}" class="h-10 w-10 flex items-center justify-center bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-indigo-600 hover:border-indigo-100 shadow-sm transition-all">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $project->title }}</h1>
                    <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-0.5">
                        <span class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded border border-indigo-100">
                            {{ __('Project Workspace') }}
                        </span>
                        <span>•</span>
                        <span><i class="bi bi-geo-alt"></i> {{ $project->location ?? __('Remote Site') }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 text-sm font-bold flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ __('Active Project') }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sidebar: Stats & Financials (4 columns) -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Workforce Stats Card -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 group hover:border-indigo-100 transition-all">
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i class="bi bi-people text-indigo-600"></i> {{ __('Workforce Status') }}
                    </h4>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-2xl p-4">
                            <p class="text-[8px] font-black text-gray-400 uppercase tracking-tighter">{{ __('Assigned') }}</p>
                            <p class="text-xl font-black text-gray-900">{{ $workerCount }}</p>
                        </div>
                        <div class="bg-indigo-50 rounded-2xl p-4 cursor-help" data-tooltip="{{ __('Number of workers verified on site today.') }}">
                            <p class="text-[8px] font-black text-indigo-400 uppercase tracking-tighter">{{ __('On Site') }}</p>
                            <p class="text-xl font-black text-indigo-600">{{ $attendanceToday }}</p>
                        </div>
                    </div>
                    
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">{{ __('Linked Workforce') }}</h4>
                    <div class="space-y-3 max-h-[250px] overflow-y-auto custom-scrollbar pr-2">
                        @forelse($linkedWorkers as $worker)
                            <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50/50 border border-transparent hover:border-indigo-100 hover:bg-white transition-all">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center text-white text-[10px] font-black">
                                    {{ substr($worker->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[10px] font-bold text-gray-900 truncate">{{ $worker->name }}</p>
                                    <p class="text-[8px] text-gray-400 uppercase tracking-tighter">{{ $worker->specialization ?? 'General' }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-black text-indigo-600">{{ $worker->attendances_count }}</p>
                                    <p class="text-[7px] text-gray-400 uppercase font-bold tracking-tighter">{{ __('Days') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-[10px] text-gray-300 italic">{{ __('No workers linked yet.') }}</p>
                            </div>
                        @endforelse
                    </div>
                    
                    <a href="{{ route('contractor.attendance.create', ['project_id' => $project->id]) }}" class="mt-4 w-full py-3 bg-indigo-600 text-white text-[10px] font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-geo-alt"></i> {{ __('Mark New Attendance') }}
                    </a>
                </div>

                <!-- Financial Health Card -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 group">
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i class="bi bi-cash-stack text-emerald-600"></i> {{ __('Financial Overview') }}
                    </h4>
                    <div class="space-y-6">
                        <div class="cursor-help" data-tooltip="{{ __('The maximum budget allocated by the client for this project.') }}">
                            <div class="flex justify-between items-end mb-1">
                                <span class="text-[10px] font-bold text-gray-400">{{ __('Total Bid Value') }}</span>
                                <span class="text-sm font-black text-gray-900">₹{{ number_format($project->award?->bid?->bid_amount ?? 0) }}</span>
                            </div>
                            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-indigo-500 h-full rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-end mb-1">
                                <span class="text-[10px] font-bold text-gray-400">{{ __('Payments Disbursed') }}</span>
                                <span class="text-sm font-black text-emerald-600">₹{{ number_format($totalProjectPayouts) }}</span>
                            </div>
                            <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                                @php 
                                    $bid = $project->award?->bid?->bid_amount ?? 1;
                                    $paid = $totalProjectPayouts;
                                    $perc = min(100, ($paid / $bid) * 100);
                                @endphp
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-1000" style="width: {{ $perc }}%"></div>
                            </div>
                            <p class="text-[8px] text-gray-400 mt-1 italic text-right">{{ number_format($perc, 1) }}% {{ __('of bid amount spent on wages') }}</p>
                        </div>
                        <div class="pt-4 border-t border-gray-50">
                            <a href="{{ route('contractor.payments.create', ['project_id' => $project->id]) }}" class="w-full py-3 bg-emerald-50 text-emerald-700 text-[10px] font-black rounded-xl hover:bg-emerald-100 transition-all flex items-center justify-center gap-2">
                                <i class="bi bi-plus-circle"></i> {{ __('Record Wage Payment') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Site Inventory & Stock Card -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 group">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-2">
                            <i class="bi bi-box-seam text-indigo-600"></i> {{ __('Site Stock Inventory') }}
                        </h4>
                        <a href="{{ route('contractor.inventory.index') }}" class="px-3 py-1 bg-gray-50 text-gray-500 rounded-lg text-[8px] font-black uppercase tracking-widest hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            {{ __('Full Log') }}
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($stockLevels as $stock)
                            <div class="p-4 rounded-2xl bg-gray-50/50 border border-transparent hover:border-indigo-100 hover:bg-white transition-all">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                            <i class="bi bi-box"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-900">{{ $stock->material->name }}</p>
                                            <p class="text-[8px] text-gray-400 font-bold">₹{{ number_format($stock->material->price, 2) }} / {{ $stock->material->unit }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs font-black {{ $stock->current_stock > 0 ? 'text-gray-900' : 'text-rose-500' }}">
                                            {{ $stock->current_stock }} {{ $stock->material->unit }}
                                        </p>
                                        <p class="text-[7px] text-gray-400 uppercase font-black tracking-tighter">{{ __('Available') }}</p>
                                    </div>
                                </div>
                                <div class="w-full h-1 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full {{ $stock->current_stock > 10 ? 'bg-indigo-500' : 'bg-rose-500' }} transition-all duration-1000" style="width: {{ min(100, $stock->current_stock * 2) }}%"></div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-[10px] text-gray-300 italic">{{ __('No material stock assigned to this site.') }}</p>
                            </div>
                        @endforelse
                    </div>

                    @if($stockLevels->isNotEmpty())
                        <div class="mt-6 pt-6 border-t border-gray-50">
                            <div class="flex justify-between items-center bg-indigo-50 rounded-2xl p-4">
                                <div>
                                    <p class="text-[8px] font-black text-indigo-400 uppercase tracking-tighter">{{ __('Total Stock Value') }}</p>
                                    <p class="text-sm font-black text-indigo-600">₹{{ number_format($stockLevels->sum(fn($s) => $s->current_stock * $s->material->price)) }}</p>
                                </div>
                                <i class="bi bi-shield-check text-indigo-200 text-2xl"></i>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main Content Area (8 columns) -->
            <div class="lg:col-span-8 space-y-8">
                <!-- Progress Hub Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Placeholder for Milestone-Based Progress (Empty for now) -->
                    <div class="bg-indigo-50 rounded-3xl border border-indigo-100 p-8 flex flex-col items-center justify-center text-center space-y-4">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-indigo-600 text-2xl shadow-sm border border-indigo-50">
                            <i class="bi bi-flag"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm">{{ __('Milestone Progress Tracking') }}</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ __('Click on a project phase to report your progress.') }}</p>
                        </div>
                    </div>

                    <!-- Milestones Visualization -->
                    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 flex flex-col">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2 cursor-help" data-tooltip="{{ __('Track current completion status of each project phase.') }}">
                                <i class="bi bi-check2-square text-indigo-600"></i> {{ __('Project Phases') }}
                            </h3>
                            <span class="text-[10px] font-bold text-gray-400">{{ $project->milestones->where('status', 'paid')->count() }} / {{ $project->milestones->count() }} {{ __('Paid') }}</span>
                        </div>
                        <div class="space-y-4 flex-1 overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($project->milestones as $milestone)
                                <div class="group relative pl-6 pb-6 last:pb-0">
                                    @if(!$loop->last)
                                        <div class="absolute left-[7px] top-4 bottom-0 w-0.5 bg-gray-50 group-hover:bg-indigo-100 transition-all"></div>
                                    @endif
                                    <div class="absolute left-0 top-1 h-4 w-4 rounded-full border-2 {{ $milestone->status == 'paid' ? 'bg-emerald-500 border-emerald-100' : 'bg-white border-gray-200' }} z-10 transition-all"></div>
                                    
                                    <button type="button" 
                                        onclick="openProgressModal('{{ $milestone->id }}', '{{ $milestone->title }}', {{ $milestone->progress ?? 0 }})"
                                        {{ ($milestone->status == 'paid' || $milestone->status == 'completed' || $milestone->progress >= 100) ? 'disabled' : '' }}
                                        class="w-full text-left flex items-center justify-between {{ ($milestone->status == 'paid' || $milestone->status == 'completed') ? 'bg-emerald-50/50' : 'bg-gray-50/50 hover:bg-white hover:shadow-lg hover:border-indigo-50' }} p-4 rounded-2xl border border-transparent transition-all group">
                                        <div class="flex-1">
                                            <div class="flex justify-between items-center mb-2">
                                                <p class="text-[10px] font-bold text-gray-900">{{ $milestone->title }}</p>
                                                <span class="text-[10px] font-black text-indigo-600">{{ $milestone->progress }}%</span>
                                            </div>
                                            <div class="w-full h-1 bg-gray-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-indigo-600 transition-all duration-500" style="width: {{ $milestone->progress }}%"></div>
                                            </div>
                                            <p class="text-[8px] text-gray-400 mt-2">{{ $milestone->due_date ? $milestone->due_date->format('M d, Y') : 'Date Pending' }}</p>
                                        </div>
                                        <div class="text-right pl-6 border-l border-gray-100 ml-6 shrink-0">
                                            <p class="text-[10px] font-black text-gray-900">₹{{ number_format($milestone->amount) }}</p>
                                            @if($milestone->status == 'paid')
                                                <span class="text-[8px] font-bold tracking-tighter text-emerald-600">
                                                    {{ __('PAID') }}
                                                </span>
                                            @elseif($milestone->status == 'completed')
                                                <span class="text-[8px] font-bold tracking-tighter text-teal-600">
                                                    {{ __('COMPLETED') }}
                                                </span>
                                            @elseif($milestone->progress >= 100)
                                                <span class="text-[8px] font-bold tracking-tighter text-amber-500 animate-pulse">
                                                    {{ __('PENDING VERIFICATION') }}
                                                </span>
                                            @else
                                                <span class="text-[8px] font-bold tracking-tighter text-indigo-400">
                                                    {{ __('REPORT PROGRESS') }}
                                                </span>
                                            @endif
                                        </div>
                                    </button>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <p class="text-xs text-gray-300 italic">{{ __('No billing milestones.') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Massive Activity Timeline -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm flex flex-col">
                    <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/20">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <i class="bi bi-clock-history text-indigo-600"></i>
                            {{ __('Historical Site Activity') }}
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
                                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-2xl hover:border-indigo-100 transition-all group">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 text-sm font-bold border border-indigo-100">
                                                    {{ substr($update->user->name ?? 'C', 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-gray-900">{{ $update->user->name ?? 'Site Manager' }}</p>
                                                    <p class="text-[10px] text-gray-400">{{ $update->created_at->format('M d, Y - h:i A') }}</p>
                                                </div>
                                            </div>
                                            @if($update->latitude)
                                                <a href="https://www.google.com/maps?q={{ $update->latitude }},{{ $update->longitude }}" target="_blank" class="px-3 py-1.5 bg-emerald-50 text-emerald-600 text-[9px] font-bold rounded-lg border border-emerald-100 hover:bg-emerald-600 hover:text-white transition-all flex items-center gap-1">
                                                    <i class="bi bi-geo-alt-fill"></i> {{ __('Site Verified') }}
                                                </a>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-600 leading-relaxed italic pl-4 border-l-2 border-indigo-200">"{{ $update->report_description }}"</p>
                                        
                                        @if ($update->report_file_path)
                                            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                                                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-1">
                                                    <i class="bi bi-paperclip"></i> {{ __('Site Proof Attached') }}
                                                </span>
                                                <a href="{{ asset('storage/' . $update->report_file_path) }}" target="_blank" class="h-10 w-10 flex items-center justify-center bg-gray-50 rounded-xl text-indigo-600 hover:bg-indigo-600 hover:text-white transition-all">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </div>
                                        @endif

                                        {{-- Milestone Materials consumed for this update --}}
                                        @php
                                            $milestoneMaterials = \App\Models\MaterialInventory::where('milestone_id', $update->milestone_id)
                                                ->where('entry_date', '>=', $update->created_at->startOfDay())
                                                ->where('entry_date', '<=', $update->created_at->endOfDay())
                                                ->with('material')
                                                ->get();
                                        @endphp
                                        @if($milestoneMaterials->count() > 0)
                                            <div class="mt-4 pt-4 border-t border-gray-50">
                                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-3">{{ __('Inventory Consumed') }}</p>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($milestoneMaterials as $mat)
                                                        <div class="px-3 py-2 bg-indigo-50/50 rounded-xl border border-indigo-100 flex items-center gap-2">
                                                            <div class="w-6 h-6 rounded-lg bg-white flex items-center justify-center text-[10px] text-indigo-600 font-bold shadow-sm">
                                                                <i class="bi bi-box"></i>
                                                            </div>
                                                            <span class="text-[10px] font-bold text-indigo-800">{{ $mat->material->name }}: {{ $mat->quantity }} {{ $mat->material->unit }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-24">
                                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-200 text-4xl">
                                        <i class="bi bi-journal-text"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ __('No Site Logs') }}</h4>
                                    <p class="text-gray-500 text-sm max-w-xs mx-auto">{{ __('Historical records will appear here as you submit daily reports.') }}</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Reporting Modal -->
    <div id="reportProgressModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[9999] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[32px] w-full max-w-xl overflow-hidden shadow-2xl animate-fade-in">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-indigo-600 text-white">
                <div>
                    <h3 class="font-bold text-sm flex items-center gap-2">
                        <i class="bi bi-flag-fill"></i> {{ __('Report Milestone Progress') }}
                    </h3>
                    <p class="text-[10px] text-indigo-100 mt-1" id="modalMilestoneTitle"></p>
                </div>
                <button onclick="closeProgressModal()" class="text-white/80 hover:text-white transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            
            <form action="{{ route('contractor.projects.progress.store', $project->id) }}" method="POST" id="progressForm" class="p-8 space-y-6" onsubmit="return validateProgressForm()">
                @csrf
                <input type="hidden" name="milestone_id" id="modalMilestoneId">
                <input type="hidden" name="verification_photo" id="verification_photo">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="location_address" id="location_address">

                <div x-data="{ progress: 0 }" id="sliderContainer">
                    <div class="flex justify-between items-end mb-3">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Phase Completion') }}</label>
                        <span class="text-2xl font-black text-indigo-600" x-text="progress + '%'" id="progressDisplay">0%</span>
                    </div>
                    <input type="range" name="progress_percentage" x-model="progress" id="progressSlider" min="0" max="100" step="1" 
                        class="w-full h-2 bg-gray-100 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                </div>

                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 block">{{ __('Daily Progress Report') }}</label>
                    <textarea name="report_description" rows="3" required 
                        class="w-full rounded-2xl border-gray-100 text-sm bg-gray-50/50 p-4 transition-all focus:bg-white" 
                        placeholder="{{ __('What work was completed for this milestone today?') }}"></textarea>
                </div>

                {{-- Material Consumption Section --}}
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Material Used for this Milestone') }}</label>
                        <button type="button" onclick="addMilestoneMaterialRow()" class="text-[10px] font-black text-indigo-600 hover:text-indigo-700 uppercase tracking-tighter">
                            + {{ __('Add Material') }}
                        </button>
                    </div>
                    <div id="milestoneMaterialRows" class="space-y-3">
                        <!-- Dynamic Rows -->
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button type="button" onclick="startCamera()" class="py-3 bg-gray-50 border border-gray-100 text-gray-600 text-[10px] font-bold rounded-xl hover:bg-indigo-50 hover:text-indigo-600 transition-all flex items-center justify-center gap-2">
                        <i class="bi bi-camera"></i> {{ __('Site Photo') }}
                    </button>
                    <button type="submit" class="py-3 bg-indigo-600 text-white text-[10px] font-black rounded-xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all">
                        {{ __('Verify & Submit') }}
                    </button>
                </div>
                <div id="locationStatus" class="text-[9px] text-gray-400 italic text-center"></div>
            </form>
        </div>
    </div>

    <div id="cameraModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[9999] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-[32px] w-full max-w-lg overflow-hidden shadow-2xl">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-900">{{ __('Verify Site Progress') }}</h3>
                <button onclick="stopCamera()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="relative aspect-video bg-gray-900">
                <video id="video" class="w-full h-full object-cover" autoplay playsinline></video>
                <canvas id="canvas" class="hidden"></canvas>
                <div class="absolute bottom-6 left-0 right-0 flex justify-center">
                    <button onclick="takeSnapshot()" class="h-16 w-16 bg-white rounded-full border-4 border-indigo-600 flex items-center justify-center shadow-2xl transform active:scale-90 transition-all">
                        <div class="h-10 w-10 bg-indigo-600 rounded-full"></div>
                    </button>
                </div>
            </div>
            <div class="p-4 text-center">
                <p class="text-[10px] text-gray-400">{{ __('Position the camera at the work site before capturing.') }}</p>
            </div>
        </div>
    </div>

    <script>
        let stream = null;

        function openProgressModal(milestoneId, title, progressValue) {
            document.getElementById('modalMilestoneId').value = milestoneId;
            document.getElementById('modalMilestoneTitle').innerText = title;
            
            // Sync with Alpine.js if it's already initialized
            const slider = document.getElementById('progressSlider');
            if (slider.__x) {
                slider.__x.$data.progress = progressValue;
            } else {
                slider.value = progressValue;
                document.getElementById('progressDisplay').innerText = progressValue + '%';
            }

            document.getElementById('reportProgressModal').classList.remove('hidden');
            getLocation();
        }

        function validateProgressForm() {
            const photo = document.getElementById('verification_photo').value;
            const lat = document.getElementById('latitude').value;
            
            if (!photo) {
                alert('Please capture a site photo before submitting.');
                return false;
            }
            if (!lat) {
                alert('Location data is required. Please allow location access.');
                return false;
            }
            return true;
        }

        function closeProgressModal() {
            document.getElementById('reportProgressModal').classList.add('hidden');
            document.getElementById('verification_photo').value = ''; 
            stopCamera();
        }

        function startCamera() {
            const modal = document.getElementById('cameraModal');
            const video = document.getElementById('video');
            modal.classList.remove('hidden');

            navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
                .then(s => {
                    stream = s;
                    video.srcObject = stream;
                })
                .catch(err => {
                    console.error("Error accessing camera:", err);
                    alert("{{ __('Unable to access camera. Please check permissions.') }}");
                    modal.classList.add('hidden');
                });
            
            // Start Geolocation as well
            getLocation();
        }

        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            document.getElementById('cameraModal').classList.add('hidden');
        }

        function takeSnapshot() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const photoInput = document.getElementById('verification_photo');
            
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            
            const dataUrl = canvas.toDataURL('image/jpeg');
            photoInput.value = dataUrl;
            
            stopCamera();
            alert("{{ __('Photo captured successfully!') }}");
        }

        function addMilestoneMaterialRow() {
            const container = document.getElementById('milestoneMaterialRows');
            const rowId = Date.now();
            const html = `
                <div class="flex gap-2 items-start animate-fade-in" id="row-${rowId}">
                    <div class="flex-1">
                        <select name="materials[${rowId}][id]" required class="w-full rounded-xl border-gray-100 text-[10px] bg-gray-50/50 p-2 focus:bg-white transition-all">
                            <option value="">{{ __('Select Material') }}</option>
                            @foreach(\App\Models\Material::orderBy('name')->get() as $material)
                                <option value="{{ $material->id }}">{{ $material->name }} ({{ $material->unit }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-24">
                        <input type="number" name="materials[${rowId}][quantity]" step="0.01" required placeholder="{{ __('Qty') }}" 
                            class="w-full rounded-xl border-gray-100 text-[10px] bg-gray-50/50 p-2 focus:bg-white transition-all">
                    </div>
                    <button type="button" onclick="document.getElementById('row-${rowId}').remove()" class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-all">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function getLocation() {
            const status = document.getElementById('locationStatus');
            const latInput = document.getElementById('latitude');
            const lonInput = document.getElementById('longitude');

            if (!navigator.geolocation) {
                status.textContent = "{{ __('Geolocation is not supported by your browser') }}";
                return;
            }

            status.textContent = "{{ __('Fetching GPS coordinates...') }}";

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    latInput.value = position.coords.latitude;
                    lonInput.value = position.coords.longitude;
                    status.textContent = `{{ __('Location Captured') }}: ${position.coords.latitude.toFixed(4)}, ${position.coords.longitude.toFixed(4)}`;
                },
                (error) => {
                    status.textContent = "{{ __('Unable to retrieve your location') }}";
                    console.error(error);
                }
            );
        }
    </script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-10px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
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
</x-contractor-layout>
