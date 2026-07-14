<x-admin-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.workers.index') }}" class="inline-flex items-center text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors mb-2">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Back to Workers
                </a>
                <h1 class="text-2xl font-bold text-slate-800">Attendance History: {{ $worker->name }}</h1>
                <p class="text-sm text-slate-500">Detailed geo-tagged logs for this worker across all projects.</p>
            </div>
            <div class="flex items-center gap-3 bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Specialization:</span>
                <span class="text-sm font-bold text-slate-700">{{ $worker->specialization ?? 'General Labor' }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Project Site</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Location</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Verification</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Notes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($attendanceRecords as $record)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-600">
                                    {{ \Carbon\Carbon::parse($record->attendance_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-800">{{ $record->project->title }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-tighter">{{ $record->project->location ?? 'Unknown Location' }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClasses = [
                                            'present' => 'bg-green-50 text-green-700 border-green-100',
                                            'absent' => 'bg-red-50 text-red-700 border-red-100',
                                            'half_day' => 'bg-amber-50 text-amber-700 border-amber-100',
                                            'on_leave' => 'bg-blue-50 text-blue-700 border-blue-100',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-lg border text-[10px] font-black uppercase tracking-tight {{ $statusClasses[$record->status] ?? 'bg-slate-50 text-slate-700 border-slate-100' }}">
                                        {{ str_replace('_', ' ', $record->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($record->latitude && $record->longitude)
                                        <div class="flex flex-col items-center gap-1">
                                            <a href="https://www.google.com/maps?q={{ $record->latitude }},{{ $record->longitude }}" target="_blank" 
                                               class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-2 py-1 rounded-md border border-indigo-100 transition-all">
                                                <i class="fa-solid fa-location-dot"></i> Maps
                                            </a>
                                            @if($record->location_address)
                                                <span class="text-[9px] text-slate-500 font-medium max-w-[150px] truncate block" title="{{ $record->location_address }}">{{ $record->location_address }}</span>
                                            @else
                                                <span class="text-[8px] text-slate-400 font-semibold uppercase tracking-wider">{{ $record->latitude }}, {{ $record->longitude }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-[10px] text-slate-300 font-bold italic">No GPS</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($record->verification_photo)
                                        <button type="button" onclick="window.open('{{ $record->verification_photo_url }}', '_blank')" class="group relative inline-block h-10 w-10 rounded-lg overflow-hidden border border-slate-200 shadow-sm transition-transform hover:scale-105">
                                            <img src="{{ $record->verification_photo_url }}" class="h-full w-full object-cover">
                                            <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <i class="fa-solid fa-eye text-white text-[10px]"></i>
                                            </div>
                                        </button>
                                    @else
                                        <i class="fa-solid fa-image-slash text-slate-200 text-lg"></i>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-500 italic max-w-[200px] truncate">
                                    {{ $record->notes ?? '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center text-slate-400">
                                    <i class="fa-solid fa-calendar-xmark text-4xl mb-3"></i>
                                    <p>No attendance records found for this worker.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($attendanceRecords->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                    {{ $attendanceRecords->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
