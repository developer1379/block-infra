<x-app-layout>
    <div class="min-h-screen bg-gray-50/50 p-6">
        <div class="max-w-7xl mx-auto space-y-6">

            {{-- 1. HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.projects.index') }}"
                        class="h-10 w-10 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-500 hover:text-indigo-600 hover:border-indigo-200 shadow-sm transition-all">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">{{ $project->title }}</h1>
                        <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                            <span
                                class="bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded border border-indigo-100 font-semibold">
                                ID: #{{ $project->id }}
                            </span>
                            <span>•</span>
                            <span><i class="bi bi-geo-alt"></i> {{ $project->location ?? 'Remote' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- LEFT COLUMN: UPLOAD FORM (1 Col) --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- Progress Card --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-4 bg-indigo-600 flex justify-between items-center text-white">
                            <h3 class="font-bold flex items-center gap-2">
                                <i class="bi bi-pencil-square"></i> Update Progress
                            </h3>
                            <span class="text-xs bg-indigo-500 px-2 py-1 rounded">Daily Report</span>
                        </div>

                        <div class="p-6">
                            <form action="{{ route('contractor.projects.progress.store', $project->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Slider --}}
                                <div class="mb-6" x-data="{ progress: {{ $project->current_progress }} }">
                                    <div class="flex justify-between mb-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Current Status</label>
                                        <span class="text-sm font-bold text-indigo-600" x-text="progress + '%'"></span>
                                    </div>
                                    <input type="range" name="progress_percentage" x-model="progress" min="0"
                                        max="100" step="1"
                                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                </div>

                                {{-- Description --}}
                                <div class="mb-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Work
                                        Description</label>
                                    <textarea name="report_description" rows="4" required
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm bg-gray-50"
                                        placeholder="What work was completed today?"></textarea>
                                </div>

                                {{-- File Upload --}}
                                <div class="mb-6">
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Site
                                        Photo</label>
                                    <input type="file" name="report_file"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all">
                                </div>

                                <button type="submit"
                                    class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-md shadow-indigo-200 transition-all active:scale-95">
                                    Submit Report
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Milestones Summary --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                        <h4 class="font-bold text-gray-800 mb-3 text-sm">Milestones</h4>
                        <div class="space-y-3">
                            @forelse($project->milestones as $milestone)
                                <div
                                    class="flex items-center justify-between p-3 rounded-lg border {{ $milestone->status == 'paid' ? 'border-green-100 bg-green-50' : 'border-gray-100 bg-gray-50' }}">
                                    <div>
                                        <p class="text-xs font-bold text-gray-700">{{ $milestone->title }}</p>
                                        <p class="text-[10px] text-gray-500">Due:
                                            {{ $milestone->due_date ? $milestone->due_date->format('M d') : '-' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs font-mono font-bold text-gray-800">
                                            ₹{{ number_format($milestone->amount) }}</p>
                                        @if ($milestone->status == 'paid')
                                            <span class="text-[10px] text-green-600 font-bold"><i
                                                    class="bi bi-check-all"></i> Paid</span>
                                        @else
                                            <span class="text-[10px] text-gray-400">Pending</span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-gray-400 text-center">No milestones set.</p>
                            @endforelse
                        </div>
                    </div>

                </div>

                {{-- RIGHT COLUMN: HISTORY (2 Cols) --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 h-full flex flex-col">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-gray-900">Project History</h3>
                            <span class="text-xs text-gray-500">{{ $project->progressUpdates->count() }} updates</span>
                        </div>

                        <div class="p-6 flex-1 overflow-y-auto">
                            <div class="relative space-y-8 pl-4">
                                {{-- Timeline Line --}}
                                <div class="absolute top-2 bottom-2 left-[23px] w-[2px] bg-gray-100"></div>

                                @forelse($project->progressUpdates->sortByDesc('created_at') as $update)
                                    <div class="relative pl-12 group">
                                        {{-- Dot --}}
                                        <div
                                            class="absolute left-0 top-0 h-12 w-12 rounded-xl bg-white border border-gray-100 flex items-center justify-center z-10 shadow-sm group-hover:border-indigo-500 transition-colors">
                                            <span
                                                class="text-xs font-bold text-indigo-600">{{ $update->progress_percentage }}%</span>
                                        </div>

                                        {{-- Content --}}
                                        <div
                                            class="bg-gray-50 rounded-lg p-4 hover:bg-white hover:shadow-sm border border-transparent hover:border-gray-200 transition-all">
                                            <div class="flex justify-between items-start mb-1">
                                                <p class="text-xs font-bold text-gray-700">
                                                    {{ $update->created_at->format('M d, Y') }}
                                                    <span class="text-gray-400 font-normal">at
                                                        {{ $update->created_at->format('h:i A') }}</span>
                                                </p>
                                                @if ($update->report_file_path)
                                                    <a href="{{ asset('storage/' . $update->report_file_path) }}"
                                                        target="_blank"
                                                        class="text-xs flex items-center gap-1 text-indigo-600 hover:underline">
                                                        <i class="bi bi-paperclip"></i> View File
                                                    </a>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-600 leading-relaxed">
                                                {{ $update->report_description }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-20">
                                        <div
                                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="bi bi-clock-history text-2xl text-gray-300"></i>
                                        </div>
                                        <p class="text-sm text-gray-500">No updates submitted yet.</p>
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
