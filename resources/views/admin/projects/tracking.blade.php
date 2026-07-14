<x-admin-layout>
    <div x-data="{ 
            confirmOpen: false, 
            confirmTitle: '', 
            confirmMessage: '', 
            confirmAction: '', 
            confirmMethod: 'POST', 
            confirmFields: [],
            openMaterialId: null,
            addMilestoneOpen: {{ $errors->any() && !old('material_id') ? 'true' : 'false' }},
            allocateMaterialOpen: {{ $errors->any() && old('material_id') ? 'true' : 'false' }},
            notesModalOpen: false,
            notesModalContent: ''
         }">
         
        {{-- Page Content (Animated) --}}
        <div class="p-6 space-y-8 animate-fade-in">
            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.projects.index') }}" class="h-10 w-10 flex items-center justify-center bg-white border border-slate-200/60 rounded-xl text-slate-400 hover:text-teal-600 hover:border-teal-100 shadow-sm transition-all">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Project Tracking</h1>
                        <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">
                            <span>Project:</span>
                            <span class="bg-teal-50 text-teal-700 px-2.5 py-0.5 rounded-lg border border-teal-100/50">
                                {{ $project->title }}
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="{{ route('admin.projects.index') }}"
                        class="group inline-flex items-center px-4 py-2.5 bg-white border border-slate-200/60 rounded-xl text-xs font-bold text-slate-600 shadow-sm hover:text-teal-600 hover:border-teal-100 transition-all">
                        <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-0.5 transition-transform"></i>
                        Back to Projects
                    </a>
                </div>
            </div>

            {{-- TOP STATS CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Budget Card --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col justify-between group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Total Awarded</p>
                            <h3 class="text-2xl font-bold text-slate-800 mt-1">
                                ₹{{ number_format($project->award?->bid?->bid_amount ?? 0, 2) }}
                            </h3>
                        </div>
                        <div class="w-9 h-9 bg-teal-50 text-teal-600 rounded-xl border border-teal-100/30 flex items-center justify-center">
                            <i class="fa-solid fa-indian-rupee-sign text-sm"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="text-[9px] font-bold text-teal-700 bg-teal-50 px-2.5 py-0.5 rounded-lg border border-teal-100/50 uppercase tracking-wider">
                            Approved Budget
                        </span>
                    </div>
                </div>

                {{-- Contractor Card --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-3">Contractor</p>

                    @if ($project->award)
                        <div class="flex items-center gap-3">
                            @if ($project->award->awardedTo->profile_photo_path)
                                <img src="{{ asset('storage/' . $project->award->awardedTo->profile_photo_path) }}"
                                    class="h-10 w-10 rounded-xl object-cover border border-slate-200">
                            @else
                                <div class="h-10 w-10 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center text-sm font-bold border border-slate-200/50 shadow-sm">
                                    {{ substr($project->award->awardedTo->name ?? 'U', 0, 2) }}
                                </div>
                            @endif
                            <div class="overflow-hidden">
                                <h4 class="text-xs font-bold text-slate-800 truncate">
                                    {{ $project->award->awardedTo->name ?? 'Unknown' }}
                                </h4>
                                <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ $project->award->awardedTo->email ?? '-' }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3 py-1">
                            <div class="h-10 w-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center border border-slate-200/50 shadow-sm">
                                <i class="fa-solid fa-user-slash text-sm"></i>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-500">Not Awarded Yet</h4>
                                <p class="text-[10px] text-slate-400">Waiting for contractor allocation...</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Progress Card --}}
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                    <div class="flex justify-between items-end mb-2">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Overall Progress</p>
                        <span class="text-lg font-bold text-teal-600">{{ $overallProgress }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-teal-500 h-full rounded-full transition-all duration-1000 ease-out"
                            style="width: {{ $overallProgress }}%;">
                        </div>
                    </div>
                    <p class="text-[9px] text-slate-400 mt-2 text-right uppercase font-bold tracking-wider">Weighted by Milestones</p>
                </div>
            </div>

            {{-- MAIN LAYOUT --}}
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
                {{-- LEFT COLUMN: MILESTONES --}}
                <div class="xl:col-span-7 flex flex-col gap-4">
                    {{-- Section Header --}}
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Milestones</h3>
                        <button @click="addMilestoneOpen = true"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                            <i class="fa-solid fa-plus text-[10px]"></i> Add New
                        </button>
                    </div>

                    {{-- Milestones Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($project->milestones as $milestone)
                            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 relative hover:shadow-md transition-all duration-200 group">
                                {{-- Card Top: Header & Actions --}}
                                <div class="flex justify-between items-start mb-4">
                                    <div class="pr-6">
                                        <h4 class="text-xs font-bold text-slate-800 leading-tight">
                                            {{ $milestone->title }}
                                        </h4>
                                        @if ($milestone->description)
                                            <p class="text-[10px] text-slate-400 mt-1 line-clamp-2" title="{{ $milestone->description }}">
                                                {{ $milestone->description }}
                                            </p>
                                        @endif

                                        @if ($milestone->projectWork)
                                            <div class="mt-2.5 flex items-center gap-1.5">
                                                <span class="px-2 py-0.5 bg-teal-50 text-teal-700 rounded-lg text-[8px] font-bold uppercase border border-teal-100/50 tracking-wider">
                                                    <i class="fa-solid fa-diagram-project mr-0.5 text-[8px]"></i>
                                                    {{ $milestone->projectWork->work->name ?? 'Work Item' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Action Dropdown (Absolute Top Right) --}}
                                    <div class="absolute top-3 right-3">
                                        <div class="relative inline-block text-left group/menu" tabindex="0">
                                            <button class="p-1 rounded-lg text-slate-400 hover:text-teal-600 hover:bg-slate-50 transition-all">
                                                <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                                            </button>
                                            <div class="absolute right-0 mt-1.5 w-44 bg-white rounded-xl shadow-lg border border-slate-100 z-20 hidden group-focus-within/menu:block group-hover/menu:block origin-top-right py-1">
                                                <button type="button" 
                                                        @click="confirmTitle = 'Complete Milestone'; confirmMessage = 'Are you sure you want to mark this milestone as Completed?'; confirmAction = '{{ route('admin.milestones.status', $milestone->id) }}'; confirmMethod = 'PATCH'; confirmFields = [{name: 'status', value: 'completed'}]; confirmOpen = true;"
                                                        class="w-full text-left px-4 py-2.5 text-[11px] font-medium text-slate-700 hover:bg-slate-50 hover:text-teal-600 transition-colors flex items-center gap-2">
                                                    <i class="fa-solid fa-circle-check text-slate-400"></i> Mark Completed
                                                </button>
                                                
                                                <button type="button"
                                                        @click="confirmTitle = 'Mark Milestone Paid'; confirmMessage = 'Are you sure you want to mark this milestone as Paid?'; confirmAction = '{{ route('admin.milestones.status', $milestone->id) }}'; confirmMethod = 'PATCH'; confirmFields = [{name: 'status', value: 'paid'}]; confirmOpen = true;"
                                                        class="w-full text-left px-4 py-2.5 text-[11px] font-medium text-slate-700 hover:bg-slate-50 hover:text-teal-600 transition-colors flex items-center gap-2">
                                                    <i class="fa-solid fa-credit-card text-slate-400"></i> Mark Paid
                                                </button>
                                                
                                                <div class="border-t border-slate-100 my-1"></div>
                                                
                                                <button type="button"
                                                        @click="confirmTitle = 'Delete Milestone'; confirmMessage = 'Are you sure you want to delete this milestone? This action cannot be undone.'; confirmAction = '{{ route('admin.milestones.destroy', $milestone->id) }}'; confirmMethod = 'DELETE'; confirmFields = []; confirmOpen = true;"
                                                        class="w-full text-left px-4 py-2.5 text-[11px] font-medium text-rose-600 hover:bg-rose-50 transition-colors flex items-center gap-2">
                                                    <i class="fa-solid fa-trash text-rose-400"></i> Delete Milestone
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Card Middle: Status & Progress --}}
                                <div class="mb-4 space-y-3">
                                    <div class="flex justify-between items-center">
                                        @php
                                            $isPendingVerification = ($milestone->progress >= 100 && !in_array($milestone->status, ['completed', 'paid']));
                                            $statusClasses = [
                                                'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-100/50',
                                                'paid' => 'bg-teal-50 text-teal-700 border-teal-100/50',
                                                'in_progress' => 'bg-amber-50 text-amber-700 border-amber-100/50',
                                                'default' => 'bg-slate-50 text-slate-600 border-slate-100/50',
                                            ];
                                            $class = $isPendingVerification 
                                                ? 'bg-rose-50 text-rose-700 border-rose-100/50 animate-pulse' 
                                                : ($statusClasses[$milestone->status] ?? $statusClasses['default']);
                                            $statusText = $isPendingVerification 
                                                ? 'Pending Verification' 
                                                : str_replace('_', ' ', $milestone->status);
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[9px] font-bold uppercase border {{ $class }} tracking-wider">
                                            {{ $statusText }}
                                        </span>
                                        <span class="text-[10px] font-bold text-teal-600">{{ $milestone->progress }}%</span>
                                    </div>
                                    
                                    <div class="w-full bg-slate-100 rounded-full h-1 overflow-hidden">
                                        <div class="bg-teal-500 h-full rounded-full transition-all duration-500" style="width: {{ $milestone->progress }}%"></div>
                                    </div>
                                </div>

                                {{-- Card Bottom: Meta Data --}}
                                <div class="flex items-center justify-between pt-3.5 border-t border-slate-100 text-[10px] text-slate-400 uppercase tracking-wider font-bold">
                                    <div class="flex items-center gap-1.5" title="Due Date">
                                        <i class="fa-solid fa-calendar text-[10px]"></i>
                                        <span>{{ $milestone->due_date ? $milestone->due_date->format('M d, Y') : '-' }}</span>
                                    </div>
                                    <div class="font-bold text-slate-700 text-xs">
                                        ₹{{ number_format($milestone->amount, 2) }}
                                    </div>
                                </div>

                                @if($isPendingVerification)
                                    <div class="mt-3.5 pt-3.5 border-t border-slate-100">
                                        <button type="button" 
                                                @click="confirmTitle = 'Verify Milestone Completion'; confirmMessage = 'Are you sure you want to verify and approve the completion of this milestone?'; confirmAction = '{{ route('admin.milestones.status', $milestone->id) }}'; confirmMethod = 'PATCH'; confirmFields = [{name: 'status', value: 'completed'}]; confirmOpen = true;"
                                                class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-bold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-1.5">
                                            <i class="fa-solid fa-shield-halved"></i> Verify & Approve Completed
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full bg-white rounded-2xl border border-dashed border-slate-200 p-10 text-center">
                                <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-3 text-slate-400">
                                    <i class="fa-solid fa-list-check text-lg"></i>
                                </div>
                                <p class="text-xs font-bold text-slate-800">No milestones yet</p>
                                <p class="text-[10px] text-slate-400 mt-1">Create one to start tracking project payments.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- RIGHT COLUMN: PROGRESS FEED --}}
                <div class="xl:col-span-5 flex flex-col gap-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Progress Feed</h3>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm flex flex-col h-[500px] overflow-hidden">
                        <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                            <div class="relative space-y-8 pl-5">
                                {{-- Timeline Vertical Line --}}
                                <div class="absolute top-2 bottom-2 left-[9px] w-[1px] bg-slate-100"></div>

                                @forelse($project->progressUpdates as $update)
                                    <div class="relative pl-8 group">
                                        {{-- Dot --}}
                                        <div class="absolute left-0 top-1 h-5 w-5 rounded-xl bg-white border-2 border-slate-200 flex items-center justify-center z-10 group-hover:border-teal-500 transition-colors">
                                            <div class="h-1.5 w-1.5 rounded-full bg-teal-500"></div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="space-y-2">
                                            <div class="flex justify-between items-start">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs font-bold text-slate-800">
                                                        {{ $update->progress_percentage }}%
                                                    </span>
                                                    <span class="text-[9px] text-slate-400 uppercase font-bold tracking-wider">• {{ $update->created_at->format('M d, h:i A') }}</span>
                                                </div>
                                                @if ($update->report_file_path)
                                                    <a href="{{ $update->report_file_url }}"
                                                        target="_blank"
                                                        class="text-slate-400 hover:text-teal-600 transition-colors"
                                                        title="View Attachment">
                                                        <i class="fa-solid fa-paperclip text-xs"></i>
                                                    </a>
                                                @endif
                                            </div>

                                            @if ($update->report_description)
                                                <div class="text-[11px] text-slate-600 bg-slate-50/50 p-3 rounded-xl border border-slate-100 leading-relaxed italic cursor-pointer hover:text-teal-600 hover:underline"
                                                     @click="notesModalContent = @js($update->report_description); notesModalOpen = true;">
                                                    "{{ $update->report_description }}"
                                                </div>
                                            @endif

                                            {{-- Materials consumed for this update --}}
                                            @php
                                                $milestoneMaterials = \App\Models\MaterialInventory::where('milestone_id', $update->milestone_id)
                                                    ->where('entry_date', '>=', $update->created_at->startOfDay())
                                                    ->where('entry_date', '<=', $update->created_at->endOfDay())
                                                    ->with('material')
                                                    ->get();
                                            @endphp
                                            @if($milestoneMaterials->count() > 0)
                                                <div class="mt-2.5 flex flex-wrap gap-1.5">
                                                    @foreach($milestoneMaterials as $mat)
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-amber-50 text-[8px] font-bold text-amber-700 border border-amber-100/50 uppercase tracking-wider">
                                                            <i class="fa-solid fa-box text-[8px]"></i> {{ $mat->material->name }}: {{ $mat->quantity }} {{ $mat->material->unit }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-20 text-slate-400">
                                        <p class="text-xs italic">No progress reports registered yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FULL WIDTH: MATERIAL INVENTORY SECTION --}}
                <div class="xl:col-span-12 space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Material Inventory (Grouped)</h3>
                        <button @click="allocateMaterialOpen = true"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition-colors shadow-sm">
                            <i class="fa-solid fa-box-open text-[10px]"></i> Allocate Material
                        </button>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden relative">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                    <th class="px-6 py-4">Material</th>
                                    <th class="px-6 py-4">Total Received (In)</th>
                                    <th class="px-6 py-4">Total Used (Out)</th>
                                    <th class="px-6 py-4 text-right">Available Stock</th>
                                    <th class="px-6 py-4 text-center w-36">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @forelse($groupedMaterials as $materialId => $logs)
                                    @php
                                        $material = $logs->first()->material;
                                        $totalIn = $logs->whereIn('type', ['in', 'purchase'])->sum('quantity');
                                        $totalOut = $logs->where('type', 'consumption')->sum('quantity');
                                        $balance = $totalIn - $totalOut;
                                    @endphp
                                    <tr class="hover:bg-slate-50/40 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-teal-50/50 flex items-center justify-center text-teal-600 border border-teal-100/30">
                                                    <i class="fa-solid fa-cubes-stacked text-xs"></i>
                                                </div>
                                                <div>
                                                    <p class="font-bold text-slate-800">{{ $material->name }}</p>
                                                    <p class="text-[9px] text-slate-400 uppercase font-bold tracking-wider mt-0.5">{{ $material->unit ?? 'Unit' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-emerald-600">
                                            +{{ $totalIn }}
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-rose-600">
                                            -{{ $totalOut }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="text-sm font-black {{ $balance <= 0 ? 'text-rose-600' : 'text-slate-800' }}">
                                                {{ $balance }}
                                            </span>
                                            <span class="text-[9px] text-slate-400 font-bold uppercase tracking-wider ml-1">{{ $material->unit }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <button @click="openMaterialId = {{ $material->id }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-50 text-teal-600 border border-slate-200/50 hover:bg-teal-600 hover:text-white rounded-lg text-xs font-bold transition-all shadow-sm">
                                                <i class="fa-solid fa-eye text-[10px]"></i> View Log
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-xs italic">
                                            No materials recorded for this site.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Milestone Modal (Viewport relative modal) -->
        <div x-show="addMilestoneOpen" class="fixed inset-0 z-[150] flex items-center justify-center p-4" x-cloak>
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="addMilestoneOpen = false"></div>

            <!-- Modal Content -->
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden relative z-10 animate-fade-in border border-slate-100">
                <form action="{{ route('admin.milestones.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">

                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-50 border border-teal-100/50 text-teal-600">
                                <i class="fa-solid fa-flag text-sm"></i>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">New Milestone</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Title <span class="text-rose-500">*</span></label>
                                <input type="text" name="title" required
                                    class="w-full h-11 px-4 rounded-xl border border-slate-200 text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all @error('title') border-rose-500 @enderror"
                                    placeholder="e.g. Foundation Completed" value="{{ old('title') }}">
                                @error('title')
                                    <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Associated Work (Optional)</label>
                                <select name="project_work_id" class="w-full h-11 px-4 rounded-xl border border-slate-200 text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all cursor-pointer">
                                    <option value="">-- No specific work --</option>
                                    @foreach($project->works as $work)
                                        <option value="{{ $work->pivot->id }}">{{ $work->name }} ({{ $work->pivot->quantity }} {{ $work->unit->name ?? '' }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Amount (₹) <span class="text-rose-500">*</span></label>
                                    <input type="number" step="0.01" name="amount" required
                                        class="w-full h-11 px-4 rounded-xl border border-slate-200 text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all @error('amount') border-rose-500 @enderror"
                                        placeholder="0.00" value="{{ old('amount') }}">
                                    @error('amount')
                                        <p class="text-rose-500 text-[10px] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Due Date</label>
                                    <input type="date" name="due_date"
                                        class="w-full h-11 px-4 rounded-xl border border-slate-200 text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Description</label>
                                <textarea name="description" rows="3"
                                    class="w-full p-4 rounded-xl border border-slate-200 text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all"
                                    placeholder="Provide milestone details..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-2 border-t border-slate-100">
                        <button type="submit"
                            class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                            Save Milestone
                        </button>
                        <button type="button" @click="addMilestoneOpen = false"
                            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-50 transition-all">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Allocate Material Modal (Viewport relative modal) -->
        <div x-show="allocateMaterialOpen" class="fixed inset-0 z-[150] flex items-center justify-center p-4" x-cloak>
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="allocateMaterialOpen = false"></div>

            <!-- Modal Content -->
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden relative z-10 animate-fade-in border border-slate-100">
                <form action="{{ route('admin.projects.allocate-material', $project->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $project->id }}">

                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-50 border border-teal-100/50 text-teal-600">
                                <i class="fa-solid fa-box-open text-sm"></i>
                            </div>
                            <h3 class="text-base font-bold text-slate-800">Allocate Material</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Select Material <span class="text-rose-500">*</span></label>
                                <select name="material_id" required 
                                    @change="const price = $el.options[$el.selectedIndex].getAttribute('data-price'); document.getElementById('alloc_unit_price').value = price || 0;"
                                    class="w-full h-11 px-4 rounded-xl border border-slate-200 text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all cursor-pointer">
                                    <option value="">-- Choose Material --</option>
                                    @foreach($materials as $material)
                                        <option value="{{ $material->id }}" data-price="{{ $material->price }}">
                                            {{ $material->name }} ({{ $material->unit }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Quantity <span class="text-rose-500">*</span></label>
                                    <input type="number" step="0.01" name="quantity" required
                                        class="w-full h-11 px-4 rounded-xl border border-slate-200 text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all"
                                        placeholder="0.00">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Unit Price (₹)</label>
                                    <input type="number" step="0.01" name="unit_price" id="alloc_unit_price"
                                        class="w-full h-11 px-4 rounded-xl border border-slate-200 text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all"
                                        placeholder="0.00">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Entry Date <span class="text-rose-500">*</span></label>
                                <input type="date" name="entry_date" required value="{{ date('Y-m-d') }}"
                                    class="w-full h-11 px-4 rounded-xl border border-slate-200 text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Notes</label>
                                <textarea name="notes" rows="2"
                                    class="w-full p-4 rounded-xl border border-slate-200 text-sm focus:ring-teal-500 focus:border-teal-500 bg-slate-50 transition-all"
                                    placeholder="Optional allocation notes..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-2 border-t border-slate-100">
                        <button type="submit"
                            class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl transition-all shadow-sm">
                            Allocate Material
                        </button>
                        <button type="button" @click="allocateMaterialOpen = false"
                            class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 text-xs font-bold rounded-xl hover:bg-slate-50 transition-all">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modals for Material Transaction Logs (Viewport relative modal) -->
        @foreach($groupedMaterials as $materialId => $logs)
            @php
                $material = $logs->first()->material;
            @endphp
            <div x-show="openMaterialId === {{ $material->id }}" x-cloak
                 class="fixed inset-0 z-[150] flex items-center justify-center p-4">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="openMaterialId = null"></div>

                <!-- Modal Content -->
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[80vh] flex flex-col overflow-hidden relative z-10 animate-fade-in border border-slate-100">
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
                                    <th class="px-6 py-3.5">{{ __('Price/Total') }}</th>
                                    <th class="px-6 py-3.5">{{ __('Vendor/Notes') }}</th>
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
                                        <td class="px-6 py-3.5">
                                            <div class="text-slate-600">₹{{ number_format($log->unit_price, 2) }}</div>
                                            <div class="font-bold text-slate-800 mt-0.5">₹{{ number_format($log->quantity * $log->unit_price, 2) }}</div>
                                        </td>
                                        <td class="px-6 py-3.5">
                                            <div class="font-semibold text-slate-600">{{ $log->vendor_name ?: 'System' }}</div>
                                            @if($log->notes)
                                                <div class="text-[9px] text-slate-400 italic max-w-[150px] truncate mt-0.5 hover:text-teal-600 hover:underline cursor-pointer" 
                                                     @click="notesModalContent = @js($log->notes); notesModalOpen = true;"
                                                     title="Click to view full notes">
                                                    {{ $log->notes }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Generic Confirmation Modal (Viewport relative modal) -->
        <div x-show="confirmOpen" class="fixed inset-0 z-[200] flex items-center justify-center p-4 animate-fade-in" x-cloak>
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="confirmOpen = false"></div>
            
            <!-- Modal Panel -->
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden relative z-[210] animate-scale-up border border-slate-100">
                <div class="p-6 text-center space-y-4">
                    <!-- Icon -->
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-full flex items-center justify-center mx-auto border border-amber-100">
                        <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                    </div>
                    
                    <!-- Content -->
                    <div class="space-y-1.5">
                        <h3 class="text-base font-bold text-slate-800" x-text="confirmTitle"></h3>
                        <p class="text-xs text-slate-500 leading-relaxed" x-text="confirmMessage"></p>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <button @click="confirmOpen = false" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-xl hover:bg-slate-50 transition-all">
                        Cancel
                    </button>
                    <form :action="confirmAction" method="POST" class="inline">
                        @csrf
                        <!-- Dynamic method override -->
                        <input type="hidden" name="_method" :value="confirmMethod">
                        
                        <!-- Dynamic custom inputs -->
                        <template x-for="field in confirmFields" :key="field.name">
                            <input type="hidden" :name="field.name" :value="field.value">
                        </template>
                        
                        <button type="submit" class="px-4 py-2 bg-teal-600 text-white text-xs font-bold rounded-xl hover:bg-teal-700 shadow-sm transition-all">
                            Confirm Action
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Notes Viewer Modal (Viewport relative modal) -->
        <div x-show="notesModalOpen" class="fixed inset-0 z-[200] flex items-center justify-center p-4 animate-fade-in" x-cloak>
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="notesModalOpen = false"></div>
            
            <!-- Modal Panel -->
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden relative z-[210] animate-scale-up border border-slate-100">
                <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-sm font-bold text-slate-800">Detail Notes</h3>
                    <button @click="notesModalOpen = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-rose-50 hover:text-rose-600 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="p-6">
                    <div class="text-xs text-slate-600 leading-relaxed whitespace-pre-line bg-slate-50 p-4 rounded-xl border border-slate-100 max-h-[50vh] overflow-y-auto custom-scrollbar" x-text="notesModalContent"></div>
                </div>
                <div class="bg-slate-50 px-6 py-4 flex justify-end border-t border-slate-100">
                    <button @click="notesModalOpen = false" class="px-4 py-2 bg-slate-800 text-white text-xs font-bold rounded-xl hover:bg-slate-900 transition-all">
                        Close
                    </button>
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
