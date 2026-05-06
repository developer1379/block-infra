<x-admin-layout>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Site Progress Reports</h1>
                <p class="text-sm text-slate-500">Monitor daily construction logs and site activity.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Report Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Project</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider">Contractor</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-center">Progress</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($reports as $report)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-800">{{ $report->report_date }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">Weather: {{ $report->weather_condition ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-slate-700">{{ $report->project->name ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-slate-600">{{ $report->contractor->user->name ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-center gap-1 w-24 mx-auto">
                                        <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                            <div class="bg-teal-600 h-full rounded-full" style="width: {{ $report->progress_percentage }}%"></div>
                                        </div>
                                        <span class="text-[9px] font-bold text-teal-600 uppercase">{{ $report->progress_percentage }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.site-reports.show', $report->id) }}" class="inline-flex items-center gap-1 text-xs font-bold text-teal-600 hover:text-teal-800 uppercase">
                                        View Report <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center text-slate-400">
                                    <i class="fa-solid fa-clipboard-list text-4xl mb-3"></i>
                                    <p>No daily site reports submitted yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
