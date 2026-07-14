<x-contractor-layout>
    <div class="p-3 md:p-6 space-y-4 md:space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-3 md:gap-6">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    {{ __('Worker Attendance') }}
                    <span class="bg-indigo-100 text-indigo-600 text-[10px] font-black uppercase px-3 py-1 rounded-full tracking-widest border border-indigo-200">
                        {{ $attendanceRecords->total() }}
                    </span>
                </h1>
                <p class="text-gray-500 text-sm mt-1 font-medium">{{ __('Track and manage geo-tagged attendance for your workforce.') }}</p>
            </div>
            <a href="{{ route('contractor.attendance.create') }}" 
                class="w-full lg:w-auto inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-black px-3 md:px-6 py-3.5 rounded-2xl transition-all shadow-xl shadow-indigo-100 transform active:scale-95">
                <i class="fa-solid fa-location-crosshairs"></i>
                {{ __('Mark New Attendance') }}
            </a>
        </div>

        <!-- Filters Section -->
        <div class="bg-white p-4 rounded-[2.5rem] border border-gray-100 shadow-sm flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-[200px] relative group">
                <i class="fa-solid fa-calendar-day absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-600 transition-colors"></i>
                <input type="date" class="w-full pl-12 pr-4 py-3 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all outline-none cursor-pointer">
            </div>
            <div class="flex-1 min-w-[200px]">
                <select class="w-full px-4 py-3 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-4 focus:ring-indigo-500/10 focus:bg-white transition-all outline-none cursor-pointer appearance-none">
                    <option value="">{{ __('All Projects') }}</option>
                </select>
            </div>
            <button class="px-3 md:px-6 py-3 bg-gray-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gray-800 transition-all shadow-lg shadow-gray-100">
                {{ __('Apply Filters') }}
            </button>
        </div>

        <!-- Attendance Content -->
        <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-sm overflow-hidden">
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-50">
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Date') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Worker') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Project') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Status') }}</th>
                            <th class="px-4 md:px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">{{ __('Verification') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($attendanceRecords as $record)
                            <tr class="hover:bg-gray-50/80 transition-all group">
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <span class="text-sm font-black text-gray-900">{{ \Carbon\Carbon::parse($record->attendance_date)->format('M d, Y') }}</span>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xs group-hover:scale-110 transition-transform">
                                            {{ substr($record->worker->name, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-black text-gray-900">{{ $record->worker->name }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ __($record->worker->specialization) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <p class="text-sm font-bold text-gray-600 truncate max-w-[200px]">{{ $record->project->title }}</p>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    @php
                                        $statusClasses = [
                                            'present' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                            'absent' => 'bg-red-50 text-red-600 border-red-100',
                                            'half_day' => 'bg-amber-50 text-amber-600 border-amber-100',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $statusClasses[$record->status] ?? 'bg-gray-100 text-gray-600 border-gray-200' }}">
                                        {{ __(str_replace('_', ' ', $record->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 md:px-8 py-3 md:py-6">
                                    <div class="flex items-center justify-center gap-3">
                                        @if($record->verification_photo)
                                            <a href="{{ $record->verification_photo_url }}" target="_blank" 
                                               class="h-12 w-12 rounded-2xl overflow-hidden border-2 border-white shadow-md hover:scale-125 transition-transform relative group/img">
                                                <img src="{{ $record->verification_photo_url }}" class="h-full w-full object-cover">
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/img:opacity-100 flex items-center justify-center text-white transition-opacity">
                                                    <i class="fa-solid fa-eye text-xs"></i>
                                                </div>
                                            </a>
                                        @endif
                                        @if($record->latitude)
                                            <a href="https://www.google.com/maps?q={{ $record->latitude }},{{ $record->longitude }}" target="_blank"
                                               class="h-12 w-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 transition-all border border-gray-100">
                                                <i class="fa-solid fa-map-location-dot text-lg"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Empty State Desktop -->
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-gray-50">
                @forelse ($attendanceRecords as $record)
                    <div class="p-3 md:p-6 space-y-4 bg-white hover:bg-gray-50 transition-all">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-3">
                                <div class="h-12 w-12 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 font-black">
                                    {{ substr($record->worker->name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="text-base font-black text-gray-900">{{ $record->worker->name }}</h4>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($record->attendance_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $statusClasses[$record->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ __(str_replace('_', ' ', $record->status)) }}
                            </span>
                        </div>
                        
                        <div class="p-4 bg-gray-50/50 rounded-2xl border border-gray-50">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Project') }}</p>
                            <p class="text-sm font-bold text-gray-700 truncate">{{ $record->project->title }}</p>
                        </div>

                        <div class="flex gap-3">
                            @if($record->verification_photo)
                                <a href="{{ $record->verification_photo_url }}" target="_blank" class="flex-1 h-12 bg-white rounded-2xl border border-gray-100 flex items-center justify-center gap-2 text-xs font-black text-gray-600 uppercase tracking-widest shadow-sm">
                                    <i class="fa-solid fa-camera"></i> {{ __('View Photo') }}
                                </a>
                            @endif
                            @if($record->latitude)
                                <a href="https://www.google.com/maps?q={{ $record->latitude }},{{ $record->longitude }}" target="_blank" class="flex-1 h-12 bg-white rounded-2xl border border-gray-100 flex items-center justify-center gap-2 text-xs font-black text-indigo-600 uppercase tracking-widest shadow-sm">
                                    <i class="fa-solid fa-map-pin"></i> {{ __('Location') }}
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <!-- Empty State Mobile -->
                @endforelse
            </div>

            <!-- Global Empty State -->
            @if($attendanceRecords->isEmpty())
                <div class="py-32 flex flex-col items-center justify-center text-center px-3 md:px-6">
                    <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 text-6xl mb-8">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">{{ __('No Attendance History') }}</h3>
                    <p class="text-gray-500 mt-3 max-w-sm font-medium leading-relaxed">{{ __('Your workforce haven\'t registered any attendance yet. Start by marking attendance for today.') }}</p>
                    <a href="{{ route('contractor.attendance.create') }}" class="mt-10 px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-2xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform active:scale-95">
                        {{ __('Mark Today\'s Attendance') }}
                    </a>
                </div>
            @endif
        </div>

        @if($attendanceRecords->hasPages())
            <div class="mt-8">
                {{ $attendanceRecords->links() }}
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
