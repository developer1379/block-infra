<x-app-layout>
    {{-- PAGE HEADER --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Breadcrumb & Actions --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <nav class="flex text-sm text-slate-500 mb-2">
                    <a href="{{ route('contractor.projects.index') }}"
                        class="hover:text-teal-600 transition-colors">Projects</a>
                    <span class="mx-2">/</span>
                    <span class="text-slate-800 font-medium truncate">{{ Str::limit($project->title, 30) }}</span>
                </nav>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $project->title }}</h1>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('contractor.projects.index') }}"
                    class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:text-teal-700 hover:border-teal-200 text-sm font-semibold px-4 py-2.5 rounded-xl shadow-sm transition-all">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>

                @can('edit projects')
                    <a href="{{ route('admin.projects.edit', $project->id) }}"
                        class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold px-4 py-2.5 rounded-xl shadow-lg shadow-slate-200 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                @endcan
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

            {{-- LEFT COLUMN: Details & Works --}}
            <div class="xl:col-span-2 space-y-8">

                {{-- PROJECT OVERVIEW CARD --}}
                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
                    <div class="p-6 md:p-8">
                        {{-- Status & Date --}}
                        <div class="flex items-center justify-between mb-6">
                            @php
                                $statusColors = [
                                    'open' => 'bg-emerald-50 text-emerald-700 border-emerald-100 ring-emerald-500/20',
                                    'closed' => 'bg-slate-50 text-slate-600 border-slate-100 ring-slate-500/20',
                                    'awarded' => 'bg-amber-50 text-amber-700 border-amber-100 ring-amber-500/20',
                                ];
                                $statusClass =
                                    $statusColors[$project->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                            @endphp
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide border ring-1 ring-inset {{ $statusClass }}">
                                <span class="w-2 h-2 rounded-full bg-current mr-2 opacity-75"></span>
                                {{ $project->status }}
                            </span>

                            <span
                                class="text-xs font-medium text-slate-400 bg-slate-50 px-3 py-1 rounded-full border border-slate-100">
                                <i class="fa-regular fa-calendar-days mr-1.5"></i>
                                Posted {{ $project->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        {{-- Description --}}
                        <div
                            class="prose prose-slate prose-lg max-w-none prose-headings:font-bold prose-headings:text-slate-800 prose-a:text-teal-600 hover:prose-a:text-teal-500 prose-img:rounded-xl">
                            <h3 class="text-lg font-bold text-slate-900 mb-2">Description</h3>
                            {!! $project->description !!}
                        </div>
                    </div>
                </div>

                {{-- WORKS & ESTIMATION TABLE --}}
                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 flex items-center gap-2 text-lg">
                            <span
                                class="w-8 h-8 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center text-sm">
                                <i class="fa-solid fa-list-check"></i>
                            </span>
                            Works & Estimations
                        </h3>
                        <span
                            class="text-xs font-semibold text-slate-500 uppercase tracking-wider bg-white px-2 py-1 rounded border border-slate-200">
                            {{ $project->works->count() }} Items
                        </span>
                    </div>

                    @if ($project->works->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-xs">
                                    <tr>
                                        <th class="px-6 py-4 tracking-wider">Work Item</th>
                                        <th class="px-6 py-4 tracking-wider text-center">Unit</th>
                                        <th class="px-6 py-4 tracking-wider text-center">Qty</th>
                                        <th class="px-6 py-4 tracking-wider text-right">Est. Cost</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($project->works as $work)
                                        @php
                                            $rate = ($work->labor_material_min + $work->labor_material_max) / 2;
                                            if ($rate == 0) {
                                                $rate = ($work->labor_min + $work->labor_max) / 2;
                                            }
                                            $total = $rate * $work->pivot->quantity;
                                        @endphp
                                        <tr class="hover:bg-slate-50/80 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div
                                                    class="font-semibold text-slate-700 group-hover:text-teal-700 transition-colors">
                                                    {{ $work->name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span
                                                    class="inline-block bg-slate-100 text-slate-500 text-xs px-2 py-1 rounded font-medium">
                                                    {{ $work->unit->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-center font-mono text-slate-600 font-medium">
                                                {{ $work->quantity }}
                                            </td>
                                            <td
                                                class="px-6 py-4 text-right font-mono font-bold text-slate-700 tabular-nums">
                                                ₹{{ number_format($work->amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-slate-50/80 border-t border-slate-200">
                                    <tr>
                                        <td colspan="3"
                                            class="px-6 py-4 text-right text-slate-500 font-bold uppercase text-xs tracking-wider">
                                            Total Estimated Budget
                                        </td>
                                        <td
                                            class="px-6 py-4 text-right text-teal-700 text-lg font-bold font-mono tabular-nums">
                                            ₹{{ number_format($project->budget_max, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="p-12 text-center">
                            <div
                                class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                <i class="fa-regular fa-clipboard text-2xl"></i>
                            </div>
                            <h3 class="text-slate-800 font-medium mb-1">No works listed</h3>
                            <p class="text-slate-400 text-sm">There are no specific line items added to this project
                                yet.</p>
                        </div>
                    @endif
                </div>

            </div>

            {{-- RIGHT COLUMN: Sidebar --}}
            <div class="space-y-6">

                {{-- KEY INFO CARD --}}
                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 p-6">
                    <h4
                        class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 pb-2">
                        Project Summary
                    </h4>

                    <div class="space-y-6">
                        {{-- Budget --}}
                        <div
                            class="relative overflow-hidden rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 p-5 text-white shadow-lg shadow-teal-500/30">
                            <div class="relative z-10">
                                <p class="text-teal-100 text-xs font-bold uppercase tracking-wider mb-1">Total Budget
                                </p>
                                <div class="text-3xl font-extrabold font-mono tracking-tight flex items-baseline gap-1">
                                    <span
                                        class="text-lg opacity-80">₹</span>{{ number_format($project->budget_max, 0) }}
                                </div>
                            </div>
                            {{-- Decorative Circle --}}
                            <div class="absolute -right-4 -bottom-8 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                        </div>

                        {{-- Location --}}
                        <div class="flex items-center gap-4 group">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform shadow-sm">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Location</p>
                                <p class="font-bold text-slate-700">{{ $project->location ?? 'Remote' }}</p>
                            </div>
                        </div>

                        {{-- Posted By --}}
                        <div class="flex items-center gap-4 group">
                            <div
                                class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform shadow-sm">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Posted By</p>
                                <p class="font-bold text-slate-700">{{ $project->createdBy->name ?? 'System Admin' }}
                                </p>
                                <p class="text-xs text-slate-400 truncate max-w-[150px]">
                                    {{ $project->createdBy->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <a href="{{ route('contractor.projects.bids', $project->id) }}"
                            class="flex w-full items-center justify-center gap-2 py-3.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold shadow-lg shadow-slate-200 transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-gavel"></i> View Bids
                        </a>
                    </div>
                </div>

                {{-- CATEGORIES --}}
                <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 p-6">
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">
                        Categories
                    </h4>
                    @if ($project->categories->count())
                        <div class="flex flex-wrap gap-2">
                            @foreach ($project->categories as $cat)
                                <span
                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-50 text-slate-600 border border-slate-200 hover:border-teal-300 hover:text-teal-700 hover:bg-teal-50 transition-colors cursor-default">
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
    </div>
</x-app-layout>
