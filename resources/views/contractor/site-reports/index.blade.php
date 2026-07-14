<x-contractor-layout>
    <div class="p-3 md:p-6 space-y-4 md:space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-3 md:gap-6">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    {{ __('Daily Site Reports') }}
                    <span class="bg-indigo-100 text-indigo-600 text-[10px] font-black uppercase px-3 py-1 rounded-full tracking-widest border border-indigo-200">
                        {{ $reports->count() }} {{ __('Total') }}
                    </span>
                </h1>
                <p class="text-gray-500 text-sm mt-1 font-medium">{{ __('Manage and track daily progress updates from your construction sites.') }}</p>
            </div>
            <a href="{{ route('contractor.site-reports.create') }}" 
                class="w-full lg:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black px-3 md:px-6 py-3.5 rounded-2xl transition-all shadow-xl shadow-indigo-100 transform active:scale-95">
                <i class="fa-solid fa-plus-circle"></i>
                {{ __('New Site Report') }}
            </a>
        </div>

        <!-- Reports Grid -->
        <div class="grid grid-cols-1 gap-3 md:gap-6">
            @forelse ($reports as $report)
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl hover:shadow-indigo-500/5 transition-all group">
                    <div class="p-4 md:p-8">
                        <div class="flex flex-col xl:flex-row justify-between gap-4 md:gap-8">
                            <!-- Left Section: Info -->
                            <div class="flex-1 space-y-3 md:space-y-6">
                                <div class="flex items-start gap-5">
                                    <div class="h-16 w-16 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform flex-shrink-0">
                                        <i class="fa-solid fa-clipboard-check text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-black text-gray-900">{{ $report->project->title }}</h3>
                                        <div class="flex flex-wrap items-center gap-3 mt-2">
                                            <span class="flex items-center gap-1.5 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                                <i class="fa-solid fa-calendar-day text-indigo-400"></i>
                                                {{ \Carbon\Carbon::parse($report->report_date)->format('M d, Y') }}
                                            </span>
                                            <span class="h-1 w-1 rounded-full bg-gray-200"></span>
                                            @php
                                                $weatherIcons = [
                                                    'Clear' => 'fa-sun text-amber-400',
                                                    'Cloudy' => 'fa-cloud text-blue-400',
                                                    'Rainy' => 'fa-cloud-showers-heavy text-indigo-400',
                                                    'Stormy' => 'fa-bolt text-purple-400',
                                                    'Windy' => 'fa-wind text-slate-400',
                                                ];
                                            @endphp
                                            <span class="flex items-center gap-1.5 text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                                <i class="fa-solid {{ $weatherIcons[$report->weather_condition] ?? 'fa-cloud text-gray-400' }}"></i>
                                                {{ __($report->weather_condition ?? 'Clear') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-6 p-3 md:p-6 bg-gray-50/50 rounded-3xl border border-gray-50">
                                    <div>
                                        <h4 class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">{{ __('Work Performed') }}</h4>
                                        <p class="text-sm font-bold text-gray-600 leading-relaxed line-clamp-3 italic">
                                            "{{ $report->work_summary }}"
                                        </p>
                                    </div>
                                    @if($report->next_day_plan)
                                    <div>
                                        <h4 class="text-[9px] font-black text-indigo-400 uppercase tracking-widest mb-2">{{ __('Next Day Plan') }}</h4>
                                        <p class="text-sm font-bold text-indigo-600/80 leading-relaxed line-clamp-2">
                                            {{ $report->next_day_plan }}
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Right Section: Progress & Media -->
                            <div class="xl:w-80 flex flex-col justify-between gap-3 md:gap-6">
                                <div class="bg-indigo-50/50 p-3 md:p-6 rounded-3xl border border-indigo-100/50">
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">{{ __('Overall Progress') }}</span>
                                        <span class="text-lg font-black text-indigo-600">{{ $report->progress_percentage }}%</span>
                                    </div>
                                    <div class="w-full bg-indigo-100 rounded-full h-3 overflow-hidden">
                                        <div class="bg-indigo-600 h-full rounded-full transition-all duration-1000" style="width: {{ $report->progress_percentage }}%"></div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex -space-x-3">
                                        @forelse($report->photos->take(4) as $photo)
                                            <div class="h-12 w-12 rounded-2xl ring-4 ring-white overflow-hidden shadow-sm hover:-translate-y-1 transition-transform cursor-pointer">
                                                <img class="h-full w-full object-cover" src="{{ $photo->photo_url }}" alt="{{ __('Site Photo') }}">
                                            </div>
                                        @empty
                                            <div class="flex items-center gap-2 text-gray-300">
                                                <i class="fa-solid fa-image-slash"></i>
                                                <span class="text-[10px] font-black uppercase tracking-widest">{{ __('No site photos') }}</span>
                                            </div>
                                        @endforelse
                                        @if($report->photos->count() > 4)
                                            <div class="h-12 w-12 rounded-2xl bg-indigo-600 ring-4 ring-white flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                                +{{ $report->photos->count() - 4 }}
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('contractor.site-reports.show', $report->id) }}" 
                                       class="h-12 px-3 md:px-6 rounded-2xl bg-white border border-gray-100 flex items-center justify-center text-[10px] font-black text-gray-900 uppercase tracking-widest hover:bg-gray-50 transition-all shadow-sm">
                                        {{ __('View Details') }}
                                        <i class="fa-solid fa-arrow-right ml-2 text-indigo-600"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-32 flex flex-col items-center justify-center text-center px-3 md:px-6 bg-white rounded-[2.5rem] border border-gray-100 shadow-sm">
                    <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 text-6xl mb-8">
                        <i class="fa-solid fa-file-contract"></i>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">{{ __('No Site Reports Found') }}</h3>
                    <p class="text-gray-500 mt-3 max-w-sm font-medium leading-relaxed">{{ __('Start tracking your construction progress by submitting your first daily report.') }}</p>
                    <a href="{{ route('contractor.site-reports.create') }}" class="mt-10 px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-2xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform active:scale-95">
                        {{ __('Submit First Report') }}
                    </a>
                </div>
            @endforelse
        </div>

        @if($reports->hasPages())
            <div class="mt-8">
                {{ $reports->links() }}
            </div>
        @endif
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
