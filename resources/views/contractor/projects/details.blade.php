<x-admin.app>

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Project Details</h2>
            <p class="text-slate-500 text-sm">View details for <span
                    class="font-semibold text-slate-700">{{ $project->title }}</span></p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('contractor.projects.index') }}"
                class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:text-slate-900 hover:border-slate-300 text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>

            @can('edit projects')
                <a href="{{ route('admin.projects.edit', $project->id) }}"
                    class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold px-4 py-2.5 rounded-lg shadow-sm transition-colors">
                    <i class="fa-solid fa-pen-to-square"></i> Edit Project
                </a>
            @endcan
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT COLUMN: Main Info --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- MAIN CARD --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 md:p-8">

                    {{-- Meta Header --}}
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        @php
                            $statusColors = [
                                'open' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'closed' => 'bg-slate-100 text-slate-600 border-slate-200',
                                'awarded' => 'bg-amber-100 text-amber-700 border-amber-200',
                            ];
                        @endphp
                        <span
                            class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border {{ $statusColors[$project->status] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ $project->status }}
                        </span>
                        <span class="text-xs text-slate-400 font-medium">
                            <i class="fa-regular fa-clock mr-1"></i> Posted {{ $project->created_at->format('M d, Y') }}
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold text-slate-900 mb-6 leading-tight">{{ $project->title }}</h1>

                    {{-- Description --}}
                    <div class="prose prose-slate max-w-none prose-img:rounded-xl prose-a:text-primary">
                        {!! $project->description !!}
                    </div>
                </div>
            </div>

            {{-- WORKS & ESTIMATION TABLE --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-slate-400"></i> Works & Estimations
                    </h3>
                </div>

                @if ($project->works->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead
                                class="bg-slate-50 text-slate-500 uppercase font-bold text-xs border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-3">Work Item</th>
                                    <th class="px-6 py-3 text-center">Unit</th>
                                    <th class="px-6 py-3 text-center">Qty</th>
                                    <th class="px-6 py-3 text-right">Est. Cost (Total)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($project->works as $work)
                                    @php
                                        // Calculate cost based on current work rates (or stored pivot if you added amount column)
                                        $rate = ($work->labor_material_min + $work->labor_material_max) / 2;
                                        if ($rate == 0) {
                                            $rate = ($work->labor_min + $work->labor_max) / 2;
                                        }
                                        $total = $rate * $work->pivot->quantity;
                                    @endphp
                                    <tr class="hover:bg-slate-50/50">
                                        <td class="px-6 py-4 font-medium text-slate-700">{{ $work->name }}</td>
                                        <td class="px-6 py-4 text-center text-slate-500">{{ $work->unit->name ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-center font-mono text-slate-600">
                                            {{ $work->pivot->quantity }}</td>
                                        <td class="px-6 py-4 text-right font-mono font-bold text-slate-700">
                                            ₹{{ number_format($total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-slate-50 font-bold text-slate-800 border-t border-slate-200">
                                <tr>
                                    <td colspan="3" class="px-6 py-3 text-right">Total Estimated Budget</td>
                                    <td class="px-6 py-3 text-right text-primary text-base">
                                        ₹{{ number_format($project->budget_max, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-slate-400 italic">
                        No specific works listed for this project.
                    </div>
                @endif
            </div>

        </div>

        {{-- RIGHT COLUMN: Sidebar Info --}}
        <div class="space-y-6">

            {{-- SUMMARY CARD --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-4">Project Summary</h4>

                <div class="space-y-4">
                    {{-- Budget --}}
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Estimated Budget</p>
                        <div class="text-xl font-bold text-slate-800 font-mono flex items-baseline gap-1">
                            <span class="text-sm text-slate-400">₹</span>{{ number_format($project->budget_max, 2) }}
                        </div>
                    </div>

                    <div class="w-full border-t border-slate-100"></div>

                    {{-- Location --}}
                    <div class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-0.5">Location</p>
                            <p class="font-semibold text-slate-700 text-sm leading-tight">
                                {{ $project->location ?? 'Remote' }}</p>
                        </div>
                    </div>

                    {{-- Creator --}}
                    <div class="flex items-start gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                            <i class="fa-regular fa-user"></i>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 mb-0.5">Posted By</p>
                            <p class="font-semibold text-slate-700 text-sm leading-tight">
                                {{ $project->createdBy->name ?? 'System Admin' }}</p>
                            <p class="text-[10px] text-slate-400">{{ $project->createdBy->email ?? '' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.projects.bids', $project->id) }}"
                        class="block w-full py-3 bg-primary hover:bg-teal-700 text-white text-center rounded-xl font-bold shadow-md shadow-teal-100 transition-all">
                        <i class="fa-solid fa-gavel mr-2"></i> View Bids
                    </a>
                </div>
            </div>

            {{-- CATEGORIES CARD --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-4">Categories</h4>
                @if ($project->categories->count())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($project->categories as $cat)
                            <span
                                class="inline-flex px-3 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                {{ $cat->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-400 text-sm italic">No categories assigned.</p>
                @endif
            </div>

        </div>
    </div>

</x-admin.app>
