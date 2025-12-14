<x-admin.app>

    {{-- PAGE HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Projects</h2>
            <p class="text-slate-500 text-sm">Manage construction projects and bids</p>
        </div>

        {{-- Only Admin Can Add Project --}}
        @if (auth()->user()->hasRole('admin'))
            <a href="{{ route('admin.projects.create') }}"
                class="inline-flex items-center gap-2 bg-primary hover:bg-teal-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm transition-colors">
                <i class="fa-solid fa-plus-circle"></i> Add Project
            </a>
        @endif
    </div>

    {{-- FILTER SECTION --}}
    @if (auth()->user()->hasRole('contractor'))
        {{-- Contractor Notice --}}
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-info-circle text-blue-500"></i>
                <p class="text-sm text-blue-700 font-medium">Projects shown below are based on your assigned categories.
                </p>
            </div>
        </div>
    @else
        {{-- Admin Filters --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 mb-6">
            <form action="" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

                    {{-- Search --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Search Title</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="Search project title...">
                    </div>

                    {{-- Status Filter --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status</label>
                        <select name="status"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                            <option value="">All</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                            <option value="awarded" {{ request('status') == 'awarded' ? 'selected' : '' }}>Awarded
                            </option>
                        </select>
                    </div>

                    {{-- Created By --}}
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Created By</label>
                        <select name="created_by"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                            <option value="">All</option>
                            @foreach ($createdByUsers as $user)
                                <option value="{{ $user->id }}"
                                    {{ request('created_by') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filter Button --}}
                    <div class="col-span-1">
                        <button
                            class="w-full md:w-auto px-6 py-2 bg-primary hover:bg-teal-700 text-white text-sm font-bold rounded-lg shadow-sm transition-colors">
                            <i class="fa-solid fa-filter mr-1"></i> Filter
                        </button>
                    </div>

                </div>
            </form>
        </div>
    @endif

    {{-- PROJECT CARD GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($projects as $project)
            <div
                class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition-all duration-200 flex flex-col h-full group">

                {{-- Card Header: Status & ID --}}
                <div class="p-5 pb-0">
                    <div class="flex justify-between items-start mb-2">
                        {{-- Status Badge --}}
                        @if ($project->status == 'open')
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-green-100 text-green-700 border border-green-200 uppercase tracking-wide">
                                Open
                            </span>
                        @elseif ($project->status == 'closed')
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200 uppercase tracking-wide">
                                Closed
                            </span>
                        @elseif ($project->status == 'awarded')
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200 uppercase tracking-wide">
                                Awarded
                            </span>
                        @endif

                        {{-- ID --}}
                        <span class="text-[10px] text-slate-400 font-mono">#{{ $project->id }}</span>
                    </div>
                </div>

                {{-- Card Body --}}
                <div class="p-5 pt-2 flex-1">
                    {{-- Title --}}
                    <h3 class="text-lg font-bold text-slate-800 mb-3 line-clamp-1" title="{{ $project->title }}">
                        {{ $project->title }}
                    </h3>

                    {{-- Budget Box --}}
                    <div
                        class="flex items-center gap-3 text-sm text-slate-700 mb-4 bg-slate-50 p-3 rounded-lg border border-slate-100">
                        <div
                            class="w-8 h-8 rounded-full bg-white flex items-center justify-center border border-slate-200 text-primary shadow-sm shrink-0">
                            <i class="fa-solid fa-sack-dollar"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase leading-none mb-1">Budget Range
                            </p>
                            <span class="font-mono font-bold tracking-tight">
                                ₹{{ number_format($project->budget_min) }} -
                                ₹{{ number_format($project->budget_max) }}
                            </span>
                        </div>
                    </div>

                    {{-- Description Snippet --}}
                    <div class="text-xs text-slate-500 line-clamp-2 mb-4 h-8">
                        {{ \Illuminate\Support\Str::limit(strip_tags($project->description), 90) }}
                    </div>

                    {{-- Meta Info --}}
                    <div class="flex items-center justify-between text-xs text-slate-400 border-t border-slate-50 pt-3">
                        @if (!auth()->user()->hasRole('contractor'))
                            <div class="flex items-center gap-1.5" title="Created By">
                                <i class="fa-regular fa-user"></i> {{ $project->createdBy->name ?? 'Admin' }}
                            </div>
                        @endif
                        <div class="flex items-center gap-1.5" title="Location">
                            <i class="fa-solid fa-location-dot"></i> {{ $project->location ?? 'N/A' }}
                        </div>
                    </div>
                </div>

                {{-- Card Footer / Actions --}}
                <div
                    class="bg-slate-50 px-5 py-3 border-t border-slate-100 rounded-b-xl flex justify-between items-center">

                    {{-- Left: View Bids --}}
                    <a href="{{ route('admin.projects.bids', $project->id) }}"
                        class="text-xs font-bold text-slate-600 hover:text-primary transition-colors flex items-center gap-1.5 group/bid">
                        <i class="fa-solid fa-gavel group-hover/bid:scale-110 transition-transform"></i> View Bids
                    </a>

                    {{-- Right: Actions --}}
                    <div class="flex items-center gap-2">
                        {{-- View --}}
                        <a href="{{ route('admin.projects.show', $project->id) }}"
                            class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-blue-600 hover:bg-blue-50 hover:border-blue-200 flex items-center justify-center transition-all shadow-sm"
                            title="View Details">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </a>

                        @can('edit projects')
                            @if (!auth()->user()->hasRole('contractor'))
                                <a href="{{ route('admin.projects.edit', $project->id) }}"
                                    class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-amber-600 hover:bg-amber-50 hover:border-amber-200 flex items-center justify-center transition-all shadow-sm"
                                    title="Edit Project">
                                    <i class="fa-solid fa-pen text-xs"></i>
                                </a>
                            @endif
                        @endcan

                        @can('delete projects')
                            @if (!auth()->user()->hasRole('contractor'))
                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this project?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 rounded-lg bg-white border border-slate-200 text-red-600 hover:bg-red-50 hover:border-red-200 flex items-center justify-center transition-all shadow-sm"
                                        title="Delete Project">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            @endif
                        @endcan

                        {{-- Contractor Bid Action --}}
                        @if (auth()->user()->hasRole('contractor') && $project->status == 'open')
                            @if (isset($hasBid[$project->id]) && $hasBid[$project->id])
                                <span
                                    class="px-2.5 py-1.5 bg-green-50 text-green-700 text-[10px] font-bold rounded-lg border border-green-200 select-none">
                                    <i class="fa-solid fa-check mr-1"></i> Bid Sent
                                </span>
                            @else
                                <a href="{{ route('admin.projects.bid.create', $project->id) }}"
                                    class="px-3 py-1.5 bg-primary text-white text-xs font-bold rounded-lg shadow-sm hover:bg-teal-700 hover:shadow-md transition-all">
                                    Bid Now
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl shadow-sm border border-slate-100 p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-clipboard-list text-3xl text-slate-300"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-700">No projects found</h3>
                <p class="text-slate-500 text-sm mt-1">Try adjusting your filters or search terms.</p>
                @if (auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.projects.create') }}"
                        class="inline-block mt-4 text-primary font-semibold text-sm hover:underline">
                        Create a new project
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    {{-- PAGINATION (Optional - if your controller sends paginated data) --}}
    @if ($projects instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="mt-6">
            {{ $projects->withQueryString()->links() }}
        </div>
    @endif

</x-admin.app>
