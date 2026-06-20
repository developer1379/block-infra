<x-contractor-layout>
    <div class="p-3 md:p-6 space-y-4 md:space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-3 md:gap-6 bg-white p-4 md:p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 md:gap-6">
                <a href="{{ route('contractor.site-reports.index') }}" class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                    <i class="fa-solid fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-gray-900 tracking-tight">{{ $report->project->title }}</h1>
                    <p class="text-gray-500 text-sm font-medium mt-1">
                        {{ __('Site report for') }} <span class="text-indigo-600 font-bold">{{ \Carbon\Carbon::parse($report->report_date)->format('F d, Y') }}</span>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-4 bg-indigo-50 px-3 md:px-6 py-4 rounded-2xl border border-indigo-100">
                <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">{{ __('Completion') }}</span>
                <span class="text-3xl font-black text-indigo-600">{{ $report->progress_percentage }}%</span>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 md:gap-8">
            <!-- Main Content Area -->
            <div class="xl:col-span-2 space-y-4 md:space-y-8">
                <!-- Detailed Summary Cards -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-4 md:p-8 space-y-10">
                        <!-- Work Summary -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                                    <i class="fa-solid fa-pen-nib text-sm"></i>
                                </div>
                                <h3 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">{{ __('Work Performed Today') }}</h3>
                            </div>
                            <div class="p-4 md:p-8 bg-gray-50/50 rounded-3xl border border-gray-100 text-gray-700 leading-relaxed font-bold italic whitespace-pre-wrap">
                                "{{ $report->work_summary }}"
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                            <!-- Challenges -->
                            @if($report->challenges)
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                                        <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                                    </div>
                                    <h3 class="text-xs font-black text-red-400 uppercase tracking-[0.2em]">{{ __('Challenges & Issues') }}</h3>
                                </div>
                                <div class="p-3 md:p-6 bg-red-50/30 rounded-3xl border border-red-100 text-red-700 text-sm font-bold leading-relaxed">
                                    {{ $report->challenges }}
                                </div>
                            </div>
                            @endif

                            <!-- Next Day Plan -->
                            @if($report->next_day_plan)
                            <div class="space-y-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                                        <i class="fa-solid fa-calendar-check text-sm"></i>
                                    </div>
                                    <h3 class="text-xs font-black text-emerald-400 uppercase tracking-[0.2em]">{{ __('Next Day Strategy') }}</h3>
                                </div>
                                <div class="p-3 md:p-6 bg-emerald-50/30 rounded-3xl border border-emerald-100 text-emerald-700 text-sm font-bold leading-relaxed">
                                    {{ $report->next_day_plan }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Media Gallery -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-4 md:p-8 space-y-3 md:space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <i class="fa-solid fa-camera-retro"></i>
                            </div>
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">{{ __('Site Progress Media') }}</h3>
                        </div>
                        <span class="px-4 py-1.5 bg-gray-100 rounded-full text-[10px] font-black text-gray-400 uppercase tracking-widest">
                            {{ $report->photos->count() }} {{ __('Photos') }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 md:gap-6">
                        @forelse($report->photos as $photo)
                            <div class="group relative aspect-square rounded-[2rem] overflow-hidden bg-gray-50 border border-gray-100 shadow-sm hover:shadow-xl transition-all cursor-pointer">
                                <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="{{ __('Site Photo') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                                    <a href="{{ asset('storage/' . $photo->photo_path) }}" target="_blank" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-indigo-600 shadow-xl hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-expand"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-20 flex flex-col items-center justify-center text-center space-y-4 bg-gray-50/50 rounded-[2rem] border-2 border-dashed border-gray-100">
                                <i class="fa-solid fa-images text-5xl text-gray-200"></i>
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('No photos captured for this update') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar Information -->
            <div class="space-y-4 md:space-y-8">
                <!-- Metadata Card -->
                <div class="bg-indigo-600 rounded-[2.5rem] p-4 md:p-8 text-white shadow-2xl shadow-indigo-200 overflow-hidden relative">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                    <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-indigo-400/20 rounded-full blur-3xl"></div>
                    
                    <h4 class="text-[10px] font-black text-indigo-200 uppercase tracking-widest mb-8 relative">{{ __('Report Intelligence') }}</h4>
                    <div class="space-y-4 md:space-y-8 relative">
                        <div class="flex items-center gap-5">
                            <div class="h-12 w-12 bg-white/10 rounded-2xl flex items-center justify-center text-xl">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-indigo-200 uppercase tracking-widest">{{ __('Submitted On') }}</p>
                                <p class="text-sm font-black">{{ $report->created_at->format('M d, Y • h:i A') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-5">
                            @php
                                $weatherIcons = [
                                    'Clear' => 'fa-sun text-amber-300',
                                    'Cloudy' => 'fa-cloud text-blue-200',
                                    'Rainy' => 'fa-cloud-showers-heavy text-indigo-200',
                                    'Stormy' => 'fa-bolt text-purple-200',
                                    'Windy' => 'fa-wind text-slate-200',
                                ];
                            @endphp
                            <div class="h-12 w-12 bg-white/10 rounded-2xl flex items-center justify-center text-xl">
                                <i class="fa-solid {{ $weatherIcons[$report->weather_condition] ?? 'fa-cloud' }}"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-indigo-200 uppercase tracking-widest">{{ __('Site Conditions') }}</p>
                                <p class="text-sm font-black">{{ __($report->weather_condition ?? 'Clear') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-5">
                            <div class="h-12 w-12 bg-white/10 rounded-2xl flex items-center justify-center text-xl">
                                <i class="fa-solid fa-user-gear"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-indigo-200 uppercase tracking-widest">{{ __('Reporting Agent') }}</p>
                                <p class="text-sm font-black truncate max-w-[150px]">{{ $report->contractor->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Project Snapshot -->
                <div class="bg-white rounded-[2.5rem] border border-gray-100 p-4 md:p-8 shadow-sm space-y-3 md:space-y-6">
                    <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest">{{ __('Project Snapshot') }}</h4>
                    <div class="space-y-4">
                        <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Operational Status') }}</p>
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-700">
                                {{ __($report->project->status) }}
                            </span>
                        </div>
                        <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Jobsite Location') }}</p>
                            <p class="text-sm font-black text-gray-800">{{ $report->project->location ?? __('Primary Site') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('contractor.projects.show', $report->project->id) }}" 
                       class="w-full inline-flex items-center justify-center gap-2 px-3 md:px-6 py-4 bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-black transition-all shadow-lg shadow-gray-200 transform active:scale-95">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        {{ __('Full Project Intelligence') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</x-contractor-layout>
