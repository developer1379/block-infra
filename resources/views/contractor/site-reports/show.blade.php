<x-contractor-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <a href="{{ route('contractor.site-reports.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors mb-4">
                        <i class="bi bi-arrow-left mr-2"></i> Back to Reports
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $report->project->title }}</h1>
                    <p class="text-gray-500 mt-1">Site report for {{ \Carbon\Carbon::parse($report->report_date)->format('F d, Y') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold text-gray-400 uppercase tracking-widest">Progress:</span>
                    <span class="text-3xl font-black text-indigo-600">{{ $report->progress_percentage }}%</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Report Content -->
                <div class="lg:col-span-2 space-y-8">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-8 space-y-8">
                            <div>
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] mb-4 flex items-center">
                                    <span class="w-8 h-px bg-gray-200 mr-3"></span>
                                    Work Summary
                                </h3>
                                <div class="text-gray-800 leading-relaxed whitespace-pre-wrap bg-gray-50 p-6 rounded-2xl border border-gray-100">
                                    {{ $report->work_summary }}
                                </div>
                            </div>

                            @if($report->challenges)
                            <div>
                                <h3 class="text-xs font-bold text-red-400 uppercase tracking-[0.2em] mb-4 flex items-center">
                                    <span class="w-8 h-px bg-red-100 mr-3"></span>
                                    Challenges & Issues
                                </h3>
                                <div class="text-red-800 leading-relaxed bg-red-50 p-6 rounded-2xl border border-red-100">
                                    <i class="bi bi-exclamation-triangle-fill mr-2"></i>
                                    {{ $report->challenges }}
                                </div>
                            </div>
                            @endif

                            @if($report->next_day_plan)
                            <div>
                                <h3 class="text-xs font-bold text-indigo-400 uppercase tracking-[0.2em] mb-4 flex items-center">
                                    <span class="w-8 h-px bg-indigo-100 mr-3"></span>
                                    Next Day Plan
                                </h3>
                                <div class="text-indigo-800 leading-relaxed bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
                                    <i class="bi bi-calendar-check mr-2"></i>
                                    {{ $report->next_day_plan }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Photo Gallery -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <i class="bi bi-images text-indigo-600"></i>
                            Site Photos
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @forelse($report->photos as $photo)
                                <div class="group relative aspect-square rounded-2xl overflow-hidden bg-gray-100 border border-gray-200 shadow-sm hover:shadow-lg transition-all">
                                    <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Site Photo" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <a href="{{ asset('storage/' . $photo->photo_path) }}" target="_blank" class="p-2 bg-white/20 backdrop-blur-md rounded-full text-white hover:bg-white/40 transition-colors">
                                            <i class="bi bi-zoom-in text-xl"></i>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-12 text-center text-gray-400 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                    <i class="bi bi-camera text-4xl mb-2 opacity-20"></i>
                                    <p>No photos uploaded for this report.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info -->
                <div class="space-y-6">
                    <div class="bg-indigo-600 rounded-3xl p-8 text-white shadow-xl shadow-indigo-100">
                        <h4 class="text-xs font-bold text-indigo-200 uppercase tracking-widest mb-6">Report Metadata</h4>
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 bg-white/10 rounded-xl flex items-center justify-center">
                                    <i class="bi bi-calendar-event text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-indigo-200">Submission Date</p>
                                    <p class="font-bold">{{ $report->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 bg-white/10 rounded-xl flex items-center justify-center">
                                    <i class="bi bi-cloud-sun text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-indigo-200">Weather Condition</p>
                                    <p class="font-bold">{{ $report->weather_condition ?? 'Not recorded' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 bg-white/10 rounded-xl flex items-center justify-center">
                                    <i class="bi bi-person-badge text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-indigo-200">Contractor</p>
                                    <p class="font-bold truncate max-w-[150px]">{{ $report->contractor->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm">
                        <h4 class="text-sm font-bold text-gray-900 mb-4">Project Overview</h4>
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Status</p>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-green-100 text-green-700">
                                    {{ $report->project->status }}
                                </span>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                <p class="text-xs text-gray-500 mb-1">Location</p>
                                <p class="text-sm font-bold text-gray-800">{{ $report->project->location ?? 'Site Location' }}</p>
                            </div>
                        </div>
                        <a href="{{ route('contractor.projects.show', $report->project->id) }}" class="mt-6 w-full inline-flex items-center justify-center px-4 py-3 bg-gray-900 hover:bg-black text-white text-xs font-bold rounded-xl transition-all">
                            View Full Project <i class="bi bi-arrow-up-right-square ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-contractor-layout>
