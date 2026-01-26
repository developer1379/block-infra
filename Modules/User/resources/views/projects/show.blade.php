<x-user.user-layout :title="$project->title" header="Project Tracking">

    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">

        {{-- Breadcrumb & Header --}}
        <div class="flex items-center gap-2 text-sm text-slate-500 mb-6">
            <a href="{{ route('user.projects.index') }}" class="hover:text-indigo-600 transition-colors">Projects</a>
            <span>/</span>
            <span class="font-bold text-slate-800 truncate max-w-xs">{{ $project->title }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LEFT COLUMN: Milestones & Progress --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Progress Card --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <h3 class="font-bold text-slate-800 text-lg mb-4">Overall Progress</h3>

                    @php
                        $totalMilestones = $project->milestones->count();
                        $completed = $project->milestones->where('status', 'completed')->count();
                        $percent = $totalMilestones > 0 ? round(($completed / $totalMilestones) * 100) : 0;
                    @endphp

                    <div class="flex items-end justify-between mb-2">
                        <span class="text-4xl font-extrabold text-indigo-600">{{ $percent }}%</span>
                        <span class="text-sm font-medium text-slate-500">{{ $completed }}/{{ $totalMilestones }} Milestones Completed</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-indigo-600 h-3 rounded-full transition-all duration-1000 ease-out"
                            style="width: {{ $percent }}%"></div>
                    </div>
                </div>

                {{-- Milestones List --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 text-lg">Milestones</h3>
                        {{-- Optional: Add Milestone Button --}}
                        {{-- <button class="text-sm font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 px-3 py-1.5 rounded-lg transition-colors">
                            + Add Milestone
                        </button> --}}
                    </div>

                    <div class="divide-y divide-slate-100">
                        @forelse($project->milestones as $milestone)
                            <div class="p-6 hover:bg-slate-50 transition-colors group" x-data="{ showComments: false }">
                                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="mt-1 flex-shrink-0">
                                            @if ($milestone->status == 'completed')
                                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center border border-emerald-200">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center border border-slate-200">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-800 text-base">{{ $milestone->title }}</h4>
                                            <p class="text-sm text-slate-500 mt-1 line-clamp-2">{{ $milestone->description }}</p>
                                            <div class="flex flex-wrap items-center gap-4 mt-2 text-xs font-bold uppercase tracking-wide">
                                                <span class="text-slate-400 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                                    {{ $milestone->due_date ? \Carbon\Carbon::parse($milestone->due_date)->format('M d, Y') : 'N/A' }}
                                                </span>
                                                <span class="text-slate-300">|</span>
                                                <span class="text-slate-600">₹{{ number_format($milestone->amount) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 self-end sm:self-center">
                                        {{-- Update Status Button --}}
                                        <button onclick="openStatusModal({{ $milestone->id }}, '{{ $milestone->status }}')"
                                            class="px-4 py-2 text-xs font-bold border border-slate-200 rounded-lg hover:bg-white hover:border-indigo-300 hover:text-indigo-600 transition-all bg-white shadow-sm">
                                            Update Status
                                        </button>

                                        {{-- Toggle Comments --}}
                                        <button @click="showComments = !showComments"
                                            class="text-slate-400 hover:text-indigo-600 transition-colors relative p-2">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            @if ($milestone->comments && $milestone->comments->count() > 0)
                                                <span class="absolute top-1 right-1 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                                            @endif
                                        </button>
                                    </div>
                                </div>

                                {{-- Comments Section --}}
                                <div x-show="showComments" class="mt-4 pt-4 border-t border-slate-100 pl-0 sm:pl-12" style="display: none;"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 -translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0">

                                    <h5 class="text-xs font-bold text-slate-400 uppercase mb-3 flex items-center gap-2">
                                        Comments
                                    </h5>

                                    <div class="space-y-3 mb-4 max-h-60 overflow-y-auto custom-scrollbar pr-2">
                                        @if($milestone->comments)
                                            @forelse($milestone->comments as $comment)
                                                <div class="bg-slate-50 p-3 rounded-lg rounded-tl-none border border-slate-200 text-sm">
                                                    <div class="flex justify-between items-center mb-1">
                                                        <span class="font-bold text-slate-700">{{ $comment->user->name ?? 'User' }}</span>
                                                        <span class="text-[10px] text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-slate-600">{{ $comment->content }}</p>
                                                </div>
                                            @empty
                                                <p class="text-xs text-slate-400 italic">No comments yet. Start the discussion!</p>
                                            @endforelse
                                        @endif
                                    </div>

                                    {{-- Add Comment Form --}}
                                    <form action="{{ route('user.milestones.comments.store', $milestone->id) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        <input type="text" name="content" required placeholder="Type your comment here..."
                                            class="flex-1 text-sm border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
                                        <button type="submit" class="p-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center text-slate-500">
                                <p class="mb-2">No milestones created for this project yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN: Project Details Sidebar --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- Project Info Card --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200 sticky top-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Project Details</h4>

                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Status</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase
                                {{ $project->status === 'active' ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $project->status }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Budget</p>
                            {{-- FIXED: Using budget_max instead of amount --}}
                            <p class="font-bold text-slate-800 text-xl font-mono tracking-tight">₹{{ number_format($project->budget_max, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Location</p>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <p class="font-medium text-slate-800">{{ $project->location ?? 'Remote' }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-1">Created At</p>
                            <p class="font-medium text-slate-800">{{ $project->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    {{-- Description Section with Modal Trigger --}}
                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-2">Description</p>
                        <div class="text-sm text-slate-600 leading-relaxed line-clamp-4">
                            {{-- FIXED: Strip tags for preview --}}
                            {{ Str::limit(strip_tags($project->description), 150) }}
                        </div>
                        <button onclick="openDescriptionModal()" class="mt-2 text-sm font-bold text-indigo-600 hover:text-indigo-800 hover:underline focus:outline-none">
                            Read Full Description &rarr;
                        </button>
                    </div>
                </div>

                {{-- Contractor Info --}}
                @if ($project->award)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4 border-b border-slate-100 pb-2">Contractor</h4>
                        <div class="flex items-center gap-3">
                            @if ($project->award->awardedTo->profile_photo_path)
                                <img src="{{ asset('storage/' . $project->award->awardedTo->profile_photo_path) }}"
                                    class="w-10 h-10 rounded-full object-cover border border-slate-200">
                            @else
                                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200">
                                    {{ substr($project->award->awardedTo->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="overflow-hidden">
                                <p class="font-bold text-slate-800 truncate">{{ $project->award->awardedTo->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $project->award->awardedTo->email }}</p>
                            </div>
                        </div>
                        <a href="mailto:{{ $project->award->awardedTo->email }}"
                            class="flex items-center justify-center w-full mt-4 py-2 border border-slate-300 rounded-lg text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Send Message
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- 1. Milestone Status Modal --}}
    <div id="statusModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeStatusModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-100">
                    <form id="statusForm" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="bg-white px-6 py-6">
                            <h3 class="text-xl font-bold leading-6 text-slate-900 mb-6">Update Status</h3>
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">New Status</label>
                                    <select name="status" id="modalStatusInput" class="block w-full rounded-xl border-slate-300 py-2.5 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                        <option value="on_hold">On Hold</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Remarks <span class="text-slate-400 font-normal">(Optional)</span></label>
                                    <textarea name="remarks" rows="3" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm placeholder-slate-400" placeholder="Add any notes about this update..."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-slate-100">
                            <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 sm:w-auto transition-colors">
                                Update Status
                            </button>
                            <button type="button" onclick="closeStatusModal()" class="inline-flex w-full justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:w-auto transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Description Modal --}}
    <div id="descriptionModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeDescriptionModal()"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all w-full max-w-2xl border border-slate-100 flex flex-col max-h-[85vh]">

                    {{-- Modal Header --}}
                    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="text-lg font-bold text-slate-900">Project Description</h3>
                        <button onclick="closeDescriptionModal()" class="text-slate-400 hover:text-slate-600 transition-colors p-1 rounded-md hover:bg-slate-200">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    {{-- Modal Content (Scrollable) --}}
                    <div class="px-6 py-6 overflow-y-auto custom-scrollbar">
                        {{-- FIXED: Render HTML Description --}}
                        <div class="prose prose-slate prose-sm max-w-none prose-img:rounded-xl prose-a:text-indigo-600">
                            {!! $project->description !!}
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end">
                        <button type="button" onclick="closeDescriptionModal()" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // --- Status Modal Logic ---
            const statusModal = document.getElementById('statusModal');
            const statusForm = document.getElementById('statusForm');
            const statusInput = document.getElementById('modalStatusInput');

            function openStatusModal(milestoneId, currentStatus) {
                statusForm.action = `/user/milestones/${milestoneId}/status`;
                statusInput.value = currentStatus;
                statusModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }

            function closeStatusModal() {
                statusModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // --- Description Modal Logic ---
            const descModal = document.getElementById('descriptionModal');

            function openDescriptionModal() {
                descModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeDescriptionModal() {
                descModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            // Close modals on Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === "Escape") {
                    closeStatusModal();
                    closeDescriptionModal();
                }
            });
        </script>
    @endpush

</x-user.user-layout>
