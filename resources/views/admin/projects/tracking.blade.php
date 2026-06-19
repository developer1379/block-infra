<x-admin-layout>
    <div class="min-h-screen bg-gray-50/50 p-6">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Project Tracking</h1>
                    <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                        <span>Project:</span>
                        <span
                            class="font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md text-xs border border-indigo-100">
                            {{ $project->title }}
                        </span>
                    </div>
                </div>
                <div>
                    <a href="{{ route('admin.projects.index') }}"
                        class="group inline-flex items-center px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 shadow-sm hover:bg-gray-50 hover:text-gray-900 transition-all duration-200">
                        <i class="bi bi-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        Back
                    </a>
                </div>
            </div>

            {{-- TOP STATS CARDS (Compact) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- Budget Card (Fixed null crash) --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Total Awarded</p>
                            <h3 class="text-xl font-bold text-gray-900 mt-1">
                                {{-- SAFE ACCESS: Check if award and bid exist first --}}
                                ₹{{ number_format($project->award?->bid?->bid_amount ?? 0, 2) }}
                            </h3>
                        </div>
                        <div class="p-1.5 bg-green-50 rounded-md text-green-600">
                            <i class="bi bi-currency-rupee text-lg leading-none"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span
                            class="text-[10px] font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded-full border border-green-100">
                            Approved Budget
                        </span>
                    </div>
                </div>

                {{-- Contractor Card (Fixed null crash + Added "Not Awarded" state) --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-3">Contractor</p>

                    @if ($project->award)
                        {{-- CASE 1: Project IS Awarded --}}
                        <div class="flex items-center gap-3">
                            @if ($project->award->awardedTo->profile_photo_path)
                                <img src="{{ asset('storage/' . $project->award->awardedTo->profile_photo_path) }}"
                                    class="h-10 w-10 rounded-full object-cover border border-gray-200">
                            @else
                                <div
                                    class="h-10 w-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-sm font-bold border border-indigo-100">
                                    {{ substr($project->award->awardedTo->name ?? 'U', 0, 1) }}
                                </div>
                            @endif
                            <div class="overflow-hidden">
                                <h4 class="text-sm font-bold text-gray-900 truncate">
                                    {{ $project->award->awardedTo->name ?? 'Unknown' }}
                                </h4>
                                <p class="text-xs text-gray-500 truncate">{{ $project->award->awardedTo->email ?? '-' }}
                                </p>
                            </div>
                        </div>
                    @else
                        {{-- CASE 2: Project NOT Awarded Yet --}}
                        <div class="flex items-center gap-3 py-1">
                            <div
                                class="h-10 w-10 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center border border-gray-200">
                                <i class="bi bi-person-slash text-lg"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-500">Not Awarded Yet</h4>
                                <p class="text-xs text-gray-400">Waiting for contractor...</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Progress --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex justify-between items-end mb-2">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Overall Progress</p>
                        <span class="text-lg font-bold text-indigo-600">{{ $overallProgress }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-indigo-600 h-2 rounded-full transition-all duration-1000 ease-out relative"
                            style="width: {{ $overallProgress }}%;">
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2 text-right">Weighted by Milestones</p>
                </div>
            </div>

            {{-- MAIN LAYOUT --}}
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

                {{-- LEFT COLUMN: MILESTONES (Cards Layout) --}}
                <div class="xl:col-span-7 flex flex-col gap-4">

                    {{-- Section Header --}}
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Milestones</h3>
                        <button onclick="document.getElementById('addMilestoneModal').classList.remove('hidden')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-md transition-colors shadow-sm">
                            <i class="bi bi-plus-lg"></i> Add New
                        </button>
                    </div>

                    {{-- Milestones Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($project->milestones as $milestone)
                            <div
                                class="bg-white rounded-lg border border-gray-200 shadow-sm p-4 relative hover:shadow-md transition-shadow group">

                                {{-- Card Top: Header & Actions --}}
                                <div class="flex justify-between items-start mb-3">
                                    <div class="pr-6">
                                        <h4 class="text-sm font-bold text-gray-900 leading-tight">
                                            {{ $milestone->title }}</h4>
                                        @if ($milestone->description)
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2"
                                                title="{{ $milestone->description }}">
                                                {{ $milestone->description }}
                                            </p>
                                        @endif

                                        @if ($milestone->projectWork)
                                            <div class="mt-2 flex items-center gap-1.5">
                                                <span class="px-1.5 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[9px] font-bold uppercase border border-indigo-100">
                                                    <i class="bi bi-gear-wide-connected mr-0.5"></i>
                                                    {{ $milestone->projectWork->work->name ?? 'Work Item' }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Action Dropdown (Absolute Top Right) --}}
                                    <div class="absolute top-2 right-2">
                                        <div class="relative inline-block text-left group/menu" tabindex="0">
                                            <button
                                                class="p-1 rounded-md text-gray-400 hover:text-indigo-600 hover:bg-gray-50 transition-colors">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <div
                                                class="absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-20 hidden group-focus-within/menu:block group-hover/menu:block origin-top-right">
                                                <div class="py-1">
                                                    <form
                                                        action="{{ route('admin.milestones.status', $milestone->id) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="completed">
                                                        <button
                                                            class="w-full text-left px-4 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-emerald-600">
                                                            <i class="bi bi-check-circle mr-2"></i> Complete
                                                        </button>
                                                    </form>
                                                    <form
                                                        action="{{ route('admin.milestones.status', $milestone->id) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <input type="hidden" name="status" value="paid">
                                                        <button
                                                            class="w-full text-left px-4 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                                                            <i class="bi bi-wallet2 mr-2"></i> Mark Paid
                                                        </button>
                                                    </form>
                                                    <div class="border-t border-gray-100 my-1"></div>
                                                    <form
                                                        action="{{ route('admin.milestones.destroy', $milestone->id) }}"
                                                        method="POST" onsubmit="return confirm('Delete milestone?')">
                                                        @csrf @method('DELETE')
                                                        <button
                                                            class="w-full text-left px-4 py-2 text-xs font-medium text-red-600 hover:bg-red-50">
                                                            <i class="bi bi-trash mr-2"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
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
                                                'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                'paid' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                'in_progress' => 'bg-amber-50 text-amber-700 border-amber-100',
                                                'default' => 'bg-gray-50 text-gray-600 border-gray-100',
                                            ];
                                            $class = $isPendingVerification 
                                                ? 'bg-rose-50 text-rose-700 border-rose-100 animate-pulse' 
                                                : ($statusClasses[$milestone->status] ?? $statusClasses['default']);
                                            $statusText = $isPendingVerification 
                                                ? 'Pending Verification' 
                                                : str_replace('_', ' ', $milestone->status);
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase border {{ $class }}">
                                            {{ $statusText }}
                                        </span>
                                        <span class="text-[10px] font-bold text-indigo-600">{{ $milestone->progress }}%</span>
                                    </div>
                                    
                                    <div class="w-full bg-gray-50 rounded-full h-1 overflow-hidden">
                                        <div class="bg-indigo-500 h-full transition-all duration-500" style="width: {{ $milestone->progress }}%"></div>
                                    </div>
                                </div>

                                {{-- Card Bottom: Meta Data --}}
                                <div
                                    class="flex items-center justify-between pt-3 border-t border-gray-100 text-xs text-gray-500">
                                    <div class="flex items-center gap-1" title="Due Date">
                                        <i class="bi bi-calendar"></i>
                                        <span>{{ $milestone->due_date ? $milestone->due_date->format('M d, Y') : '-' }}</span>
                                    </div>
                                    <div class="font-mono font-semibold text-gray-700">
                                        ₹{{ number_format($milestone->amount, 2) }}
                                    </div>
                                </div>

                                @if($isPendingVerification)
                                    <div class="mt-3 pt-3 border-t border-gray-100">
                                        <form action="{{ route('admin.milestones.status', $milestone->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="w-full py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-bold rounded transition-colors shadow-sm flex items-center justify-center gap-1">
                                                <i class="bi bi-shield-check"></i> Verify & Approve Completed
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div
                                class="col-span-full bg-white rounded-lg border border-dashed border-gray-300 p-8 text-center">
                                <div
                                    class="w-10 h-10 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-2 text-gray-400">
                                    <i class="bi bi-list-task text-lg"></i>
                                </div>
                                <p class="text-sm font-medium text-gray-600">No milestones yet</p>
                                <p class="text-xs text-gray-400">Create one to start tracking payments.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- RIGHT COLUMN: FEED (Timeline) --}}
                <div class="xl:col-span-5 flex flex-col gap-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Progress Feed</h3>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-0 flex flex-col h-[500px]">
                        <div class="flex-1 overflow-y-auto p-5 custom-scrollbar">
                            <div class="relative space-y-6">
                                {{-- Timeline Vertical Line --}}
                                <div class="absolute top-2 bottom-2 left-[11px] w-[2px] bg-gray-100"></div>

                                @forelse($project->progressUpdates as $update)
                                    <div class="relative pl-8 group">
                                        {{-- Dot --}}
                                        <div
                                            class="absolute left-0 top-1 h-6 w-6 rounded-full bg-white border-2 border-gray-200 flex items-center justify-center z-10 group-hover:border-indigo-500 transition-colors">
                                            <div class="h-1.5 w-1.5 rounded-full bg-indigo-500"></div>
                                        </div>

                                        {{-- Content --}}
                                        <div class="space-y-1">
                                            <div class="flex justify-between items-start">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-xs font-bold text-gray-800">
                                                        {{ $update->progress_percentage }}%
                                                    </span>
                                                    <span class="text-[10px] text-gray-400">•
                                                        {{ $update->created_at->format('M d, h:i A') }}</span>
                                                </div>
                                                @if ($update->report_file_path)
                                                    <a href="{{ asset('storage/' . $update->report_file_path) }}"
                                                        target="_blank"
                                                        class="text-gray-400 hover:text-indigo-600 transition-colors"
                                                        title="Download Attachment">
                                                        <i class="bi bi-paperclip text-sm"></i>
                                                    </a>
                                                @endif
                                            </div>

                                            @if ($update->report_description)
                                                <div
                                                    class="text-xs text-gray-600 bg-gray-50 p-2.5 rounded-md border border-gray-100">
                                                    {{ $update->report_description }}
                                                </div>
                                            @endif

                                            {{-- Materials consumed for this milestone update --}}
                                            @php
                                                $milestoneMaterials = \App\Models\MaterialInventory::where('milestone_id', $update->milestone_id)
                                                    ->where('entry_date', '>=', $update->created_at->startOfDay())
                                                    ->where('entry_date', '<=', $update->created_at->endOfDay())
                                                    ->with('material')
                                                    ->get();
                                            @endphp
                                            @if($milestoneMaterials->count() > 0)
                                                <div class="mt-2 flex flex-wrap gap-1.5">
                                                    @foreach($milestoneMaterials as $mat)
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-[4px] bg-amber-50 text-[9px] font-bold text-amber-700 border border-amber-100">
                                                            <i class="bi bi-box"></i> {{ $mat->material->name }}: {{ $mat->quantity }} {{ $mat->material->unit }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10 text-gray-400">
                                        <p class="text-xs">No updates posted yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FULL WIDTH: MATERIAL INVENTORY SECTION --}}
                <div class="xl:col-span-12 space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Material Inventory</h3>
                        <button onclick="document.getElementById('allocateMaterialModal').classList.remove('hidden')"
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-md transition-colors shadow-sm">
                            <i class="bi bi-box-seam"></i> Allocate Material
                        </button>
                    </div>

                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Material</th>
                                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Unit Price</th>
                                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-[10px] font-bold text-gray-500 uppercase tracking-wider">Notes</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($project->inventoryLogs as $log)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 text-xs text-gray-600">
                                            {{ $log->entry_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                                    <i class="bi bi-box"></i>
                                                </div>
                                                <span class="text-xs font-bold text-gray-800">{{ $log->material->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-semibold text-gray-700">
                                            {{ $log->quantity }} {{ $log->material->unit }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $typeClasses = [
                                                    'in' => 'bg-green-50 text-green-700 border-green-100',
                                                    'out' => 'bg-red-50 text-red-700 border-red-100',
                                                    'purchase' => 'bg-blue-50 text-blue-700 border-blue-100',
                                                    'consumption' => 'bg-orange-50 text-orange-700 border-orange-100',
                                                ];
                                                $typeClass = $typeClasses[$log->type] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                            @endphp
                                            <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase border {{ $typeClass }}">
                                                {{ $log->type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-600">
                                            ₹{{ number_format($log->unit_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-xs font-bold text-gray-900">
                                            ₹{{ number_format($log->quantity * $log->unit_price, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-500 italic">
                                            {{ Str::limit($log->notes, 30) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-10 text-center text-gray-400 text-xs">
                                            No material logs found for this project.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL (Kept Standard) --}}
    <div id="addMilestoneModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0 ease-out duration-300"
            onclick="closeModal()" id="modalBackdrop"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 duration-300 ease-out"
                    id="modalPanel">

                    <form action="{{ route('admin.milestones.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">

                        <div class="bg-white px-5 pt-5 pb-4">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-indigo-50">
                                    <i class="bi bi-flag-fill text-indigo-600 text-sm"></i>
                                </div>
                                <h3 class="text-base font-bold leading-6 text-gray-900">New Milestone</h3>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Title <span
                                            class="text-red-500">*</span></label>
                                    <input type="text" name="title" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 @error('title') border-red-500 @enderror"
                                        placeholder="e.g. Foundation Complete" value="{{ old('title') }}">
                                    @error('title')
                                        <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Associated Work (Optional)</label>
                                    <select name="project_work_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2">
                                        <option value="">-- No specific work --</option>
                                        @foreach($project->works as $work)
                                            <option value="{{ $work->pivot->id }}">{{ $work->name }} ({{ $work->pivot->quantity }} {{ $work->unit->name ?? '' }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Amount
                                            (₹) <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.01" name="amount" required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2 @error('amount') border-red-500 @enderror"
                                            placeholder="0.00" value="{{ old('amount') }}">
                                        @error('amount')
                                            <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Due
                                            Date</label>
                                        <input type="date" name="due_date"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2">
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-700 uppercase mb-1">Description</label>
                                    <textarea name="description" rows="3"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"
                                        placeholder="Details..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-5 py-3 flex flex-row-reverse gap-2 border-t border-gray-100">
                            <button type="submit"
                                class="inline-flex w-auto justify-center rounded-md bg-indigo-600 px-3 py-2 text-xs font-bold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                                Save
                            </button>
                            <button type="button" onclick="closeModal()"
                                class="inline-flex w-auto justify-center rounded-md bg-white px-3 py-2 text-xs font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ALLOCATE MATERIAL MODAL --}}
    <div id="allocateMaterialModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0 ease-out duration-300" onclick="closeAllocateModal()" id="allocateModalBackdrop"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 duration-300 ease-out" id="allocateModalPanel">
                    <form action="{{ route('admin.projects.allocate-material', $project->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">

                        <div class="bg-white px-5 pt-5 pb-4">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-emerald-50">
                                    <i class="bi bi-box-seam text-emerald-600 text-sm"></i>
                                </div>
                                <h3 class="text-base font-bold leading-6 text-gray-900">Allocate Material</h3>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Select Material <span class="text-red-500">*</span></label>
                                    <select name="material_id" required onchange="updateDefaultPrice(this)"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2">
                                        <option value="">-- Choose Material --</option>
                                        @foreach($materials as $material)
                                            <option value="{{ $material->id }}" data-price="{{ $material->price }}">
                                                {{ $material->name }} ({{ $material->unit }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Quantity <span class="text-red-500">*</span></label>
                                        <input type="number" step="0.01" name="quantity" required
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"
                                            placeholder="0.00">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Unit Price (₹)</label>
                                        <input type="number" step="0.01" name="unit_price" id="alloc_unit_price"
                                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"
                                            placeholder="0.00">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Entry Date <span class="text-red-500">*</span></label>
                                    <input type="date" name="entry_date" required value="{{ date('Y-m-d') }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2">
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Notes</label>
                                    <textarea name="notes" rows="2"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2"
                                        placeholder="Optional allocation notes..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-5 py-3 flex flex-row-reverse gap-2 border-t border-gray-100">
                            <button type="submit"
                                class="inline-flex w-auto justify-center rounded-md bg-emerald-600 px-3 py-2 text-xs font-bold text-white shadow-sm hover:bg-emerald-500 transition-colors">
                                Allocate
                            </button>
                            <button type="button" onclick="closeAllocateModal()"
                                class="inline-flex w-auto justify-center rounded-md bg-white px-3 py-2 text-xs font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        const modal = document.getElementById('addMilestoneModal');
        const backdrop = document.getElementById('modalBackdrop');
        const panel = document.getElementById('modalPanel');

        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    if (!modal.classList.contains('hidden')) {
                        setTimeout(() => {
                            backdrop.classList.remove('opacity-0');
                            panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0',
                                'sm:scale-95');
                            panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
                        }, 10);
                    } else {
                        backdrop.classList.add('opacity-0');
                        panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0',
                            'sm:scale-95');
                        panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
                    }
                }
            });
        });

        observer.observe(modal, {
            attributes: true
        });

        function closeModal() {
            backdrop.classList.add('opacity-0');
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Allocate Modal Logic
        const allocateModal = document.getElementById('allocateMaterialModal');
        const allocateBackdrop = document.getElementById('allocateModalBackdrop');
        const allocatePanel = document.getElementById('allocateModalPanel');

        const allocateObserver = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    if (!allocateModal.classList.contains('hidden')) {
                        setTimeout(() => {
                            allocateBackdrop.classList.remove('opacity-0');
                            allocatePanel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                            allocatePanel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
                        }, 10);
                    } else {
                        allocateBackdrop.classList.add('opacity-0');
                        allocatePanel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                        allocatePanel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
                    }
                }
            });
        });

        allocateObserver.observe(allocateModal, { attributes: true });

        function closeAllocateModal() {
            allocateBackdrop.classList.add('opacity-0');
            allocatePanel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            allocatePanel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            setTimeout(() => {
                allocateModal.classList.add('hidden');
            }, 300);
        }

        function updateDefaultPrice(select) {
            const price = select.options[select.selectedIndex].getAttribute('data-price');
            document.getElementById('alloc_unit_price').value = price || 0;
        }

        {{-- Keep modal open if there are validation errors --}}
        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                @if(old('material_id'))
                    allocateModal.classList.remove('hidden');
                @else
                    modal.classList.remove('hidden');
                @endif
            });
        @endif
    </script>
</x-admin-layout>

