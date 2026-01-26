<x-user.user-layout :title="$project->title" header="Project Tracking">

    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">

        {{-- Breadcrumb & Header --}}
        <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
            <a href="{{ route('user.projects.index') }}" class="hover:text-indigo-600">Projects</a>
            <span>/</span>
            <span class="font-bold text-slate-800">{{ Str::limit($project->title, 30) }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LEFT COLUMN: Milestones & Progress --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Progress Card --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <h3 class="font-bold text-slate-800 text-lg mb-4">Overall Progress</h3>

                    {{-- Calculate Progress Logic (Example) --}}
                    @php
                        $totalMilestones = $project->milestones->count();
                        $completed = $project->milestones->where('status', 'completed')->count();
                        $percent = $totalMilestones > 0 ? round(($completed / $totalMilestones) * 100) : 0;
                    @endphp

                    <div class="flex items-end justify-between mb-2">
                        <span class="text-4xl font-extrabold text-indigo-600">{{ $percent }}%</span>
                        <span class="text-sm font-medium text-slate-500">{{ $completed }}/{{ $totalMilestones }}
                            Milestones Completed</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-indigo-600 h-3 rounded-full transition-all duration-1000"
                            style="width: {{ $percent }}%"></div>
                    </div>
                </div>

                {{-- Milestones List --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 text-lg">Milestones</h3>
                        {{-- Optional: Add Milestone Button --}}
                        <button
                            class="text-sm font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 px-3 py-1.5 rounded-lg transition-colors">
                            + Add Milestone
                        </button>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse($project->milestones as $milestone)
                            <div class="p-6 hover:bg-slate-50 transition-colors" x-data="{ showComments: false }">
                                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="mt-1">
                                            @if ($milestone->status == 'completed')
                                                <div
                                                    class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center border border-emerald-200">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div
                                                    class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center border border-slate-200">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-800">{{ $milestone->title }}</h4>
                                            <p class="text-sm text-slate-500 mt-1">{{ $milestone->description }}</p>
                                            <div
                                                class="flex items-center gap-4 mt-2 text-xs font-bold uppercase tracking-wide">
                                                <span class="text-slate-400">Due:
                                                    {{ \Carbon\Carbon::parse($milestone->due_date)->format('M d, Y') }}</span>
                                                <span class="text-slate-300">|</span>
                                                <span
                                                    class="text-slate-600">₹{{ number_format($milestone->amount) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        {{-- Status Update Button (Opens Modal) --}}
                                        <button
                                            onclick="openStatusModal({{ $milestone->id }}, '{{ $milestone->status }}')"
                                            class="px-4 py-2 text-xs font-bold border border-slate-200 rounded-lg hover:bg-white hover:border-indigo-300 hover:text-indigo-600 transition-all bg-slate-50">
                                            Update Status
                                        </button>

                                        {{-- Toggle Comments --}}
                                        <button @click="showComments = !showComments"
                                            class="text-slate-400 hover:text-indigo-600 transition-colors relative">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            @if ($milestone->comments->count() > 0)
                                                <span
                                                    class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                                            @endif
                                        </button>
                                    </div>
                                </div>

                                {{-- Comments Section (Toggleable) --}}
                                <div x-show="showComments" class="mt-4 pt-4 border-t border-slate-100 pl-12"
                                    style="display: none;">
                                    <h5 class="text-xs font-bold text-slate-400 uppercase mb-3">Comments</h5>

                                    <div class="space-y-3 mb-4 max-h-40 overflow-y-auto custom-scrollbar">
                                        @forelse($milestone->comments as $comment)
                                            <div
                                                class="bg-slate-50 p-3 rounded-lg rounded-tl-none border border-slate-100">
                                                <div class="flex justify-between items-center mb-1">
                                                    <span
                                                        class="text-xs font-bold text-slate-700">{{ $comment->user->name ?? 'User' }}</span>
                                                    <span
                                                        class="text-[10px] text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                </div>
                                                <p class="text-sm text-slate-600">{{ $comment->content }}</p>
                                            </div>
                                        @empty
                                            <p class="text-xs text-slate-400 italic">No comments yet.</p>
                                        @endforelse
                                    </div>

                                    {{-- Add Comment Form --}}
                                    <form action="{{ route('user.milestones.comments.store', $milestone->id) }}"
                                        method="POST" class="flex gap-2">
                                        @csrf
                                        <input type="text" name="content" required placeholder="Write a comment..."
                                            class="flex-1 text-sm border-slate-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-slate-50">
                                        <button type="submit"
                                            class="p-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-10 text-center text-slate-500">
                                No milestones created for this project yet.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN: Project Details Sidebar --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Project Info Card --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Project Details</h4>

                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500">Status</p>
                            <span
                                class="inline-flex mt-1 items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase
                                {{ $project->status === 'active' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $project->status }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Budget</p>
                            <p class="font-bold text-slate-800 text-lg">₹{{ number_format($project->amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Location</p>
                            <p class="font-medium text-slate-800">{{ $project->location ?? 'Remote' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500">Created At</p>
                            <p class="font-medium text-slate-800">{{ $project->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-2">Description</p>
                        <div class="text-sm text-slate-600 leading-relaxed">
                            {{ $project->description }}
                        </div>
                    </div>
                </div>

                {{-- Contractor Info (Check for null!) --}}
                @if ($project->award)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Contractor</h4>
                        <div class="flex items-center gap-3">
                            @if ($project->award->awardedTo->profile_photo_path)
                                <img src="{{ asset('storage/' . $project->award->awardedTo->profile_photo_path) }}"
                                    class="w-10 h-10 rounded-full object-cover">
                            @else
                                <div
                                    class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                    {{ substr($project->award->awardedTo->name, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-slate-800">{{ $project->award->awardedTo->name }}</p>
                                <p class="text-xs text-slate-500">{{ $project->award->awardedTo->email }}</p>
                            </div>
                        </div>
                        <button
                            class="w-full mt-4 py-2 border border-slate-200 rounded-lg text-sm font-bold text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">
                            Send Message
                        </button>
                    </div>
                @endif
            </div>

        </div>
    </div>

    {{-- Update Status Modal (Hidden by default) --}}
    <div id="statusModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md">
                    <form id="statusForm" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <h3 class="text-lg font-bold leading-6 text-slate-900 mb-4">Update Milestone Status</h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                                    <select name="status" id="modalStatusInput"
                                        class="block w-full rounded-lg border-slate-300 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="on_hold">On Hold</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Remarks
                                        (Optional)</label>
                                    <textarea name="remarks" rows="3"
                                        class="block w-full rounded-lg border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-slate-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-slate-100">
                            <button type="submit"
                                class="inline-flex w-full justify-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-bold text-white shadow-sm hover:bg-indigo-500 sm:ml-3 sm:w-auto">Update</button>
                            <button type="button" onclick="closeStatusModal()"
                                class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-bold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const modal = document.getElementById('statusModal');
            const statusForm = document.getElementById('statusForm');
            const statusInput = document.getElementById('modalStatusInput');

            function openStatusModal(milestoneId, currentStatus) {
                // Set the form action dynamically
                statusForm.action = `/user/milestones/${milestoneId}/status`;
                statusInput.value = currentStatus;
                modal.classList.remove('hidden');
            }

            function closeStatusModal() {
                modal.classList.add('hidden');
            }
        </script>
    @endpush

</x-user.user-layout>
