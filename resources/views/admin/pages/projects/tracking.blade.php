<x-admin.app>
    <div class="min-h-screen bg-gray-50/50 p-6">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Project Tracking</h1>
                    <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                        <span>Project:</span>
                        <span
                            class="font-semibold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-md">{{ $project->title }}</span>
                    </div>
                </div>
                <div>
                    <a href="{{ route('admin.projects.index') }}"
                        class="group inline-flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                        <i class="bi bi-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        Back to Projects
                    </a>
                </div>
            </div>

            {{-- STATS GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Budget Card --}}
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow duration-200">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Awarded</p>
                            <h3 class="text-2xl font-bold text-gray-900 mt-1">
                                ₹{{ number_format($project->award->bid->bid_amount ?? 0, 2) }}
                            </h3>
                        </div>
                        <div class="p-2 bg-green-50 rounded-lg text-green-600">
                            <i class="bi bi-currency-rupee text-xl"></i>
                        </div>
                    </div>
                    <div
                        class="mt-4 text-xs font-medium text-green-600 bg-green-50 inline-block px-2 py-1 rounded w-fit">
                        <i class="bi bi-check-circle-fill mr-1"></i> Approved Budget
                    </div>
                </div>

                {{-- Contractor Card --}}
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Contractor</p>
                    <div class="flex items-center gap-4">
                        @if ($project->award->awardedTo->profile_photo_path)
                            <img src="{{ asset('storage/' . $project->award->awardedTo->profile_photo_path) }}"
                                class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm">
                        @else
                            <div
                                class="h-12 w-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-lg font-bold border-2 border-white shadow-sm">
                                {{ substr($project->award->awardedTo->name ?? 'U', 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">
                                {{ $project->award->awardedTo->name ?? 'Unknown' }}</h4>
                            <p class="text-xs text-gray-500">{{ $project->award->awardedTo->email ?? 'No email' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Completion Card --}}
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow duration-200">
                    <div class="flex justify-between items-end mb-2">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Progress</p>
                        <span class="text-xl font-bold text-indigo-600">{{ $project->current_progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-indigo-600 h-3 rounded-full transition-all duration-1000 ease-out relative overflow-hidden"
                            style="width: {{ $project->current_progress }}%;">
                            <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-3 text-right">Updated via Contractor Reports</p>
                </div>
            </div>

            {{-- MAIN CONTENT GRID --}}
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

                {{-- LEFT: MILESTONES (7 Cols) --}}
                <div class="xl:col-span-7 space-y-6">
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-full">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <div>
                                <h3 class="font-bold text-gray-900">Milestones</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Payment phases and goals</p>
                            </div>
                            <button onclick="document.getElementById('addMilestoneModal').classList.remove('hidden')"
                                class="inline-flex items-center gap-2 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-wider rounded-lg transition-colors duration-200 shadow-sm shadow-indigo-200">
                                <i class="bi bi-plus-lg"></i> Add New
                            </button>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Title</th>
                                        <th
                                            class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Due</th>
                                        <th
                                            class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Amount</th>
                                        <th
                                            class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($project->milestones as $milestone)
                                        <tr class="hover:bg-gray-50/80 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-900 text-sm">{{ $milestone->title }}
                                                </div>
                                                @if ($milestone->description)
                                                    <div class="text-xs text-gray-500 mt-0.5 line-clamp-1 max-w-[150px]"
                                                        title="{{ $milestone->description }}">
                                                        {{ $milestone->description }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                                {{ $milestone->due_date ? $milestone->due_date->format('M d, Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-mono text-gray-700 whitespace-nowrap">
                                                ₹{{ number_format($milestone->amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClasses = [
                                                        'completed' =>
                                                            'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                        'paid' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                        'in_progress' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                        'default' => 'bg-gray-100 text-gray-600 border-gray-200',
                                                    ];
                                                    $class =
                                                        $statusClasses[$milestone->status] ?? $statusClasses['default'];
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase border {{ $class }}">
                                                    {{ str_replace('_', ' ', $milestone->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                {{-- Simple Actions Dropdown using Hover or Focus --}}
                                                <div class="relative inline-block text-left group/menu" tabindex="0">
                                                    <button
                                                        class="p-1 rounded-full text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>

                                                    {{-- Dropdown Menu --}}
                                                    <div
                                                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 z-20 hidden group-focus-within/menu:block group-hover/menu:block transform transition-all duration-200 origin-top-right">
                                                        <div class="py-1">
                                                            <div
                                                                class="px-4 py-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
                                                                Update Status</div>

                                                            <form
                                                                action="{{ route('admin.milestones.status', $milestone->id) }}"
                                                                method="POST">
                                                                @csrf @method('PATCH')
                                                                <input type="hidden" name="status" value="completed">
                                                                <button
                                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-emerald-600 flex items-center gap-2">
                                                                    <i class="bi bi-check-circle"></i> Complete
                                                                </button>
                                                            </form>

                                                            <form
                                                                action="{{ route('admin.milestones.status', $milestone->id) }}"
                                                                method="POST">
                                                                @csrf @method('PATCH')
                                                                <input type="hidden" name="status" value="paid">
                                                                <button
                                                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 flex items-center gap-2">
                                                                    <i class="bi bi-wallet2"></i> Mark Paid
                                                                </button>
                                                            </form>

                                                            <div class="border-t border-gray-100 my-1"></div>

                                                            <form
                                                                action="{{ route('admin.milestones.destroy', $milestone->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Delete milestone?')">
                                                                @csrf @method('DELETE')
                                                                <button
                                                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                                    <i class="bi bi-trash"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center">
                                                <div
                                                    class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <i class="bi bi-list-task text-2xl text-gray-300"></i>
                                                </div>
                                                <h3 class="text-sm font-medium text-gray-900">No milestones yet</h3>
                                                <p class="text-xs text-gray-500 mt-1">Break the project down to track
                                                    payments.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: TIMELINE (5 Cols) --}}
                <div class="xl:col-span-5 h-full">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full flex flex-col">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-bold text-gray-900">Progress Feed</h3>
                            <p class="text-xs text-gray-500 mt-0.5">Updates from contractor</p>
                        </div>

                        <div class="p-6 flex-1 overflow-y-auto max-h-[600px]">
                            <div class="relative space-y-8">
                                {{-- Vertical Line --}}
                                <div class="absolute top-0 bottom-0 left-[15px] w-[2px] bg-gray-100"></div>

                                @forelse($project->progressUpdates as $update)
                                    <div class="relative pl-10 group">
                                        {{-- Dot --}}
                                        <div
                                            class="absolute left-0 top-1.5 h-8 w-8 rounded-full bg-white border border-gray-200 flex items-center justify-center z-10 shadow-sm group-hover:border-indigo-500 transition-colors">
                                            <div class="h-2.5 w-2.5 rounded-full bg-indigo-500"></div>
                                        </div>

                                        {{-- Content --}}
                                        <div
                                            class="bg-white border border-gray-100 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow duration-200">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                        {{ $update->progress_percentage }}% Complete
                                                    </span>
                                                    <p class="text-[10px] text-gray-400 mt-1 flex items-center gap-1">
                                                        <i class="bi bi-clock"></i>
                                                        {{ $update->created_at->format('M d, h:i A') }}
                                                    </p>
                                                </div>
                                                @if ($update->report_file_path)
                                                    <a href="{{ asset('storage/' . $update->report_file_path) }}"
                                                        target="_blank"
                                                        class="h-8 w-8 flex items-center justify-center rounded-lg bg-gray-50 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all border border-transparent hover:border-indigo-100"
                                                        title="Download Attachment">
                                                        <i class="bi bi-paperclip"></i>
                                                    </a>
                                                @endif
                                            </div>

                                            @if ($update->report_description)
                                                <p
                                                    class="text-sm text-gray-600 leading-relaxed bg-gray-50/50 p-2 rounded-md border border-gray-50">
                                                    {{ $update->report_description }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10 pl-4">
                                        <div
                                            class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="bi bi-chat-square-dots text-gray-300"></i>
                                        </div>
                                        <p class="text-sm text-gray-500">No updates posted yet.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL --}}
        <div id="addMilestoneModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity opacity-0 ease-out duration-300"
                onclick="closeModal()" id="modalBackdrop"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 duration-300 ease-out"
                        id="modalPanel">

                        <form action="{{ route('admin.milestones.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="project_id" value="{{ $project->id }}">

                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="flex items-center gap-4 mb-5">
                                    <div
                                        class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-indigo-100 sm:h-10 sm:w-10">
                                        <i class="bi bi-flag-fill text-indigo-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold leading-6 text-gray-900">New Milestone</h3>
                                        <p class="text-xs text-gray-500">Define a new target for this project.</p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Title <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="title" required
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5"
                                            placeholder="e.g. Foundation Complete">
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Amount
                                                (₹)</label>
                                            <input type="number" step="0.01" name="amount"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5"
                                                placeholder="0.00">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Due
                                                Date</label>
                                            <input type="date" name="due_date"
                                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-700 uppercase mb-1">Description</label>
                                        <textarea name="description" rows="3"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5"
                                            placeholder="Optional details..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-100">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto transition-colors">
                                    Create Milestone
                                </button>
                                <button type="button" onclick="closeModal()"
                                    class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Simple Script for Smooth Modal Animation --}}
    <script>
        const modal = document.getElementById('addMilestoneModal');
        const backdrop = document.getElementById('modalBackdrop');
        const panel = document.getElementById('modalPanel');

        // Observer to handle class changes for animation
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    if (!modal.classList.contains('hidden')) {
                        // Opening
                        setTimeout(() => {
                            backdrop.classList.remove('opacity-0');
                            panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0',
                                'sm:scale-95');
                            panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
                        }, 10);
                    } else {
                        // Reset classes when hidden
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
            // Animate out
            backdrop.classList.add('opacity-0');
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');

            // Wait for animation to finish before hiding
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
</x-admin.app>
