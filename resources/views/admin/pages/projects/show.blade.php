<x-admin.app>

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Project Details</h2>
            <p class="text-slate-500 text-sm">View details for {{ $project->title }}</p>
        </div>

        <a href="{{ route('admin.projects.index') }}"
            class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 hover:text-slate-900 hover:border-slate-300 text-sm font-medium px-4 py-2.5 rounded-lg shadow-sm transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>
    </div>

    {{-- DETAILS CARD --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

        <div
            class="border-b border-gray-100 px-6 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h3 class="font-bold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-folder-open text-primary"></i> Project Information
            </h3>

            @can('edit projects')
                <a href="{{ route('admin.projects.edit', $project->id) }}"
                    class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold px-4 py-2 rounded-lg shadow-sm transition-colors">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
            @endcan
        </div>

        <div class="p-6 md:p-8">

            {{-- TITLE --}}
            <h1 class="text-3xl font-bold text-slate-900 mb-6">{{ $project->title }}</h1>

            {{-- PROJECT DETAILS GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

                {{-- BUDGET --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Budget Range</p>
                    <h4 class="text-lg font-bold text-slate-800 font-mono">
                        ₹{{ number_format($project->budget_min, 2) }} <span class="text-slate-400 mx-1">-</span>
                        ₹{{ number_format($project->budget_max, 2) }}
                    </h4>
                </div>

                {{-- LOCATION --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Location</p>
                    <h4 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-primary"></i>
                        {{ $project->location ?? '—' }}
                    </h4>
                </div>

                {{-- STATUS --}}
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-1">Status</p>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold uppercase tracking-wide
                        {{ $project->status == 'open' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $project->status == 'closed' ? 'bg-gray-100 text-gray-600' : '' }}
                        {{ $project->status == 'awarded' ? 'bg-amber-100 text-amber-700' : '' }}">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>

            </div>

            {{-- CATEGORIES --}}
            <div class="mb-8">
                <p class="text-sm font-bold text-slate-700 mb-3">Categories</p>
                @if ($project->categories->count())
                    <div class="flex flex-wrap gap-2">
                        @foreach ($project->categories as $cat)
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold bg-primary/10 text-primary border border-primary/20">
                                <i class="fa-solid fa-tag text-xs"></i> {{ $cat->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-400 text-sm italic">No categories assigned.</p>
                @endif
            </div>

            <div class="border-t border-slate-100 my-8"></div>

            {{-- DESCRIPTION (Quill Render) --}}
            <div>
                <p class="text-sm font-bold text-slate-700 mb-4 uppercase tracking-wide">Project Description</p>
                <div
                    class="prose prose-slate max-w-none prose-img:rounded-xl prose-headings:text-slate-800 prose-a:text-primary">
                    {!! $project->description !!}
                </div>
            </div>

            <div class="border-t border-slate-100 my-8"></div>

            {{-- ACTION BUTTONS --}}
            <div class="flex gap-4">
                <a href="{{ route('admin.projects.bids', $project->id) }}"
                    class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold px-6 py-3 rounded-xl shadow-lg shadow-slate-200 transition-all transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-gavel"></i> View Bids
                </a>
            </div>

        </div>
    </div>

</x-admin.app>
