<x-contractor-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Daily Site Reports</h1>
                    <p class="text-gray-500 mt-1">Manage and track daily progress updates from your construction sites.</p>
                </div>
                <a href="{{ route('contractor.site-reports.create') }}" 
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                    <i class="bi bi-plus-lg mr-2"></i>
                    New Site Report
                </a>
            </div>

            <!-- Reports List -->
            <div class="grid grid-cols-1 gap-6">
                @forelse ($reports as $report)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                                <div class="flex items-center gap-4">
                                    <div class="h-14 w-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                                        <i class="bi bi-journal-text text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $report->project->title }}</h3>
                                        <div class="flex items-center gap-2 text-sm text-gray-500">
                                            <i class="bi bi-calendar3"></i>
                                            {{ \Carbon\Carbon::parse($report->report_date)->format('M d, Y') }}
                                            <span class="mx-1">•</span>
                                            <i class="bi bi-cloud-sun"></i>
                                            {{ $report->weather_condition ?? 'Clear' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-1 text-xs">Progress</span>
                                    <div class="flex items-center gap-3">
                                        <div class="w-32 bg-gray-100 rounded-full h-2 overflow-hidden">
                                            <div class="bg-indigo-600 h-full rounded-full" style="width: {{ $report->progress_percentage }}%"></div>
                                        </div>
                                        <span class="text-lg font-bold text-indigo-600">{{ $report->progress_percentage }}%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-50">
                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Work Summary</h4>
                                    <p class="text-gray-700 text-sm leading-relaxed line-clamp-3">
                                        {{ $report->work_summary }}
                                    </p>
                                </div>
                                <div class="flex flex-col gap-4">
                                    @if($report->next_day_plan)
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Next Day Plan</h4>
                                        <p class="text-gray-600 text-sm italic">{{ $report->next_day_plan }}</p>
                                    </div>
                                    @endif
                                    
                                    <div class="flex items-center justify-between mt-auto">
                                        <div class="flex -space-x-2 overflow-hidden">
                                            @forelse($report->photos->take(4) as $photo)
                                                <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white object-cover" src="{{ asset('storage/' . $photo->photo_path) }}" alt="Site Photo">
                                            @empty
                                                <span class="text-xs text-gray-400 flex items-center gap-1">
                                                    <i class="bi bi-image"></i> No photos
                                                </span>
                                            @endforelse
                                            @if($report->photos->count() > 4)
                                                <div class="flex items-center justify-center h-8 w-8 rounded-full bg-gray-100 ring-2 ring-white text-[10px] font-bold text-gray-500">
                                                    +{{ $report->photos->count() - 4 }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('contractor.site-reports.show', $report->id) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                                View Details <i class="bi bi-arrow-right ml-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                        <div class="h-20 w-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mx-auto mb-4">
                            <i class="bi bi-journal-x text-4xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900 mb-2">No reports found</h2>
                        <p class="text-gray-500 mb-8">You haven't submitted any site reports yet. Start by creating your first daily update.</p>
                        <a href="{{ route('contractor.site-reports.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all">
                            Submit First Report
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-contractor-layout>
