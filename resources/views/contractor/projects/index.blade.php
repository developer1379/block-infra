<x-app-layout>
    <div class="min-h-screen bg-gray-50/50 p-6">
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- 1. PAGE HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Project Workspace</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Managing: <span class="font-semibold text-indigo-600">{{ $project->title }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                        Active Project
                    </span>
                    <a href="{{ route('contractor.projects.index') }}"
                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                        <i class="bi bi-arrow-left mr-2"></i> Back
                    </a>
                </div>
            </div>

            {{-- 2. TOP STATS OVERVIEW --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Budget --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Project Value</p>
                    <div class="flex items-baseline gap-1 mt-2">
                        <span
                            class="text-2xl font-bold text-gray-900">₹{{ number_format($project->award->bid->bid_amount ?? 0, 2) }}</span>
                    </div>
                </div>

                {{-- Current Progress --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-end mb-2">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Current Completion</p>
                        <span class="text-xl font-bold text-indigo-600">{{ $project->current_progress }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        <div class="bg-indigo-600 h-2.5 rounded-full transition-all duration-1000"
                            style="width: {{ $project->current_progress }}%"></div>
                    </div>
                </div>

                {{-- Milestones Count --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending Milestones</p>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-2xl font-bold text-gray-900">
                            {{ $project->milestones->where('status', '!=', 'paid')->count() }}
                        </span>
                        <span class="text-sm text-gray-500">/ {{ $project->milestones->count() }} Total</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- LEFT COLUMN: ACTIONS & DATA (7 Cols) --}}
                <div class="lg:col-span-7 space-y-8">

                    {{-- 3. SUBMIT PROGRESS FORM --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="px-6 py-4 bg-indigo-50 border-b border-indigo-100 flex items-center gap-3">
                            <div class="bg-indigo-100 p-2 rounded-lg text-indigo-600">
                                <i class="bi bi-pencil-square text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-indigo-900">Submit Daily Update</h3>
                                <p class="text-xs text-indigo-600">Keep the admin informed to speed up payments</p>
                            </div>
                        </div>

                        <div class="p-6">
                            <form action="{{ route('contractor.projects.progress.store', $project->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Interactive Slider --}}
                                <div class="mb-8" x-data="{ progress: {{ $project->current_progress }} }">
                                    <label class="block text-sm font-bold text-gray-700 mb-4">Total Project Completion
                                        (%)</label>
                                    <div class="relative w-full h-12 flex items-center">
                                        <input type="range" name="progress_percentage" x-model="progress"
                                            min="0" max="100" step="1"
                                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 z-20 relative">

                                        {{-- Dynamic Label following slider --}}
                                        <div class="absolute -top-8 transform -translate-x-1/2 bg-indigo-600 text-white text-xs font-bold px-2 py-1 rounded shadow-sm transition-all"
                                            :style="'left: ' + progress + '%'">
                                            <span x-text="progress + '%'"></span>
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-xs text-gray-400 px-1">
                                        <span>Start (0%)</span>
                                        <span>Halfway (50%)</span>
                                        <span>Finish (100%)</span>
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="mb-6">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Work Description
                                        <span class="text-red-500">*</span></label>
                                    <textarea name="report_description" rows="3" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-3 bg-gray-50 focus:bg-white transition-colors"
                                        placeholder="E.g., Completed the foundation pouring, waiting for curing..."></textarea>
                                </div>

                                {{-- File Upload --}}
                                <div class="mb-6">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Site Photo /
                                        Document</label>
                                    <div class="flex items-center justify-center w-full">
                                        <label for="dropzone-file"
                                            class="flex flex-col items-center justify-center w-full h-24 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-indigo-50 hover:border-indigo-300 transition-all group">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i
                                                    class="bi bi-cloud-arrow-up text-2xl text-gray-400 group-hover:text-indigo-500 mb-1 transition-colors"></i>
                                                <p class="text-xs text-gray-500"><span
                                                        class="font-semibold text-indigo-600">Click to upload</span> or
                                                    drag and drop</p>
                                                <p id="file-name" class="text-[10px] text-gray-400 mt-1">SVG, PNG, JPG
                                                    or PDF (MAX. 5MB)</p>
                                            </div>
                                            <input id="dropzone-file" name="report_file" type="file" class="hidden"
                                                onchange="document.getElementById('file-name').innerHTML = '<span class=\'text-indigo-600 font-bold\'>' + this.files[0].name + '</span>'" />
                                        </label>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-md shadow-indigo-200 transition-all duration-200 transform hover:-translate-y-0.5">
                                    Submit Progress Report
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- 4. MILESTONES (Read Only) --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="font-bold text-gray-900">Project Milestones</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                                    <tr>
                                        <th class="px-6 py-3 font-semibold">Title</th>
                                        <th class="px-6 py-3 font-semibold">Due</th>
                                        <th class="px-6 py-3 font-semibold">Amount</th>
                                        <th class="px-6 py-3 font-semibold">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($project->milestones as $milestone)
                                        <tr class="hover:bg-gray-50/50">
                                            <td class="px-6 py-4 font-medium text-gray-900">{{ $milestone->title }}</td>
                                            <td class="px-6 py-4 text-gray-500">
                                                {{ $milestone->due_date ? $milestone->due_date->format('M d') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 font-mono text-gray-600">
                                                ₹{{ number_format($milestone->amount) }}</td>
                                            <td class="px-6 py-4">
                                                @if ($milestone->status == 'completed')
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Completed</span>
                                                @elseif($milestone->status == 'paid')
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Paid</span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-400 text-xs">No
                                                milestones defined yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: TIMELINE (5 Cols) --}}
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full flex flex-col">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-bold text-gray-900">Update History</h3>
                        </div>

                        <div class="p-6 flex-1 overflow-y-auto max-h-[800px]">
                            <div class="relative space-y-8">
                                {{-- Timeline Line --}}
                                <div class="absolute top-2 bottom-0 left-[19px] w-[2px] bg-gray-100"></div>

                                @forelse($project->progressUpdates->sortByDesc('created_at') as $update)
                                    <div class="relative pl-12 group">
                                        {{-- Timeline Dot --}}
                                        <div
                                            class="absolute left-0 top-0 h-10 w-10 rounded-full bg-white border-2 border-indigo-100 flex items-center justify-center z-10 group-hover:border-indigo-500 transition-colors">
                                            <span
                                                class="text-[10px] font-bold text-indigo-600">{{ $update->progress_percentage }}%</span>
                                        </div>

                                        {{-- Card --}}
                                        <div
                                            class="bg-white border border-gray-100 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                                            <div class="flex justify-between items-start mb-2">
                                                <p class="text-xs text-gray-400 font-medium">
                                                    {{ $update->created_at->format('M d, Y • h:i A') }}
                                                </p>
                                                @if ($update->report_file_path)
                                                    <a href="{{ asset('storage/' . $update->report_file_path) }}"
                                                        target="_blank"
                                                        class="text-gray-400 hover:text-indigo-600 transition-colors">
                                                        <i class="bi bi-paperclip text-lg"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-700 leading-relaxed">
                                                {{ $update->report_description }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12">
                                        <div
                                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="bi bi-clock-history text-2xl text-gray-300"></i>
                                        </div>
                                        <p class="text-sm text-gray-500">No history yet.</p>
                                        <p class="text-xs text-gray-400">Submit your first update!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
