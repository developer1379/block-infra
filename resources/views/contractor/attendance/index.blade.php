<x-contractor-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Worker Attendance</h1>
                    <p class="text-gray-500 mt-1">Track and manage geo-tagged attendance for your workforce.</p>
                </div>
                <a href="{{ route('contractor.attendance.create') }}" 
                    class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-sm transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98]">
                    <i class="bi bi-geo-alt-fill mr-2"></i>
                    Mark New Attendance
                </a>
            </div>

            <!-- Attendance Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="bi bi-calendar-check text-indigo-600"></i>
                        Attendance History
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50">
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Worker</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Project</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Verification</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($attendanceRecords as $record)
                                <tr class="hover:bg-gray-50/80 transition-colors group">
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                        {{ \Carbon\Carbon::parse($record->attendance_date)->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs">
                                                {{ substr($record->worker->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm font-semibold text-gray-900">{{ $record->worker->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-gray-600 truncate max-w-[150px]">{{ $record->project->title }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'present' => 'bg-green-100 text-green-700',
                                                'absent' => 'bg-red-100 text-red-700',
                                                'half_day' => 'bg-amber-100 text-amber-700',
                                                'on_leave' => 'bg-blue-100 text-blue-700',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide {{ $statusClasses[$record->status] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ str_replace('_', ' ', $record->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($record->latitude && $record->longitude)
                                            <div class="flex flex-col">
                                                <a href="https://www.google.com/maps?q={{ $record->latitude }},{{ $record->longitude }}" target="_blank" 
                                                   class="text-xs font-semibold text-indigo-600 hover:underline flex items-center gap-1">
                                                    <i class="bi bi-geo-alt"></i> View Map
                                                </a>
                                                <span class="text-[10px] text-gray-400 truncate max-w-[120px]">{{ $record->location_address ?? ($record->latitude . ', ' . $record->longitude) }}</span>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-400 italic">No GPS Data</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($record->verification_photo)
                                            <a href="{{ asset('storage/' . $record->verification_photo) }}" target="_blank" class="block h-10 w-10 rounded-lg overflow-hidden border border-gray-200 shadow-sm hover:scale-110 transition-transform">
                                                <img src="{{ asset('storage/' . $record->verification_photo) }}" class="h-full w-full object-cover">
                                            </a>
                                        @else
                                            <i class="bi bi-camera-video-off text-gray-300 text-lg"></i>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="bi bi-calendar-x text-4xl mb-2 opacity-20"></i>
                                            <p>No attendance records found.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($attendanceRecords->hasPages())
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $attendanceRecords->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-contractor-layout>
