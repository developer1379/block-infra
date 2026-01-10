<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- 1. HEADER SECTION --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Active Projects</h2>
                    <p class="text-gray-500 text-sm mt-1">Manage construction sites, bids, and progress reports.</p>
                </div>

                {{-- Admin Add Project --}}
                @if (auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.projects.create') }}"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg shadow-sm transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-plus"></i> Create Project
                    </a>
                @endif
            </div>

            {{-- 2. FILTERS --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-8">
                @if (auth()->user()->hasRole('contractor'))
                    <div
                        class="flex items-center gap-3 text-indigo-600 bg-indigo-50 p-3 rounded-lg border border-indigo-100">
                        <i class="fa-solid fa-hard-hat text-xl"></i>
                        <div>
                            <p class="text-sm font-bold text-indigo-900">Contractor Mode</p>
                            <p class="text-xs text-indigo-700">Showing projects matching your trade categories.</p>
                        </div>
                    </div>
                @else
                    <form action="" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            {{-- Search --}}
                            <div class="md:col-span-5">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Search</label>
                                <div class="relative">
                                    <i class="fa-solid fa-search absolute left-3 top-3 text-gray-400"></i>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        placeholder="Project title, ID, or location...">
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="md:col-span-3">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status</label>
                                <select name="status"
                                    class="w-full py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">All Statuses</option>
                                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open For
                                        Bids</option>
                                    <option value="awarded" {{ request('status') == 'awarded' ? 'selected' : '' }}>
                                        Awarded/Ongoing</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed
                                    </option>
                                </select>
                            </div>

                            {{-- Category --}}
                            <div class="md:col-span-3">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Category</label>
                                <select name="category_id"
                                    class="w-full py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">All Categories</option>
                                    @foreach (\App\Models\Category::whereNull('parent_id')->where('is_active', 1)->orderBy('name')->get() as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Button --}}
                            <div class="md:col-span-1">
                                <button type="submit"
                                    class="w-full py-2 bg-gray-900 hover:bg-gray-800 text-white text-sm font-bold rounded-lg transition-colors">
                                    Go
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>

            {{-- 3. PROJECTS GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($projects as $project)
                    <div
                        class="group bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-lg hover:border-indigo-200 transition-all duration-300 flex flex-col h-full relative overflow-hidden">

                        {{-- Top Status Bar --}}
                        <div
                            class="h-1.5 w-full {{ $project->status == 'awarded' ? 'bg-indigo-500' : ($project->status == 'open' ? 'bg-green-500' : 'bg-gray-300') }}">
                        </div>

                        <div class="p-6 flex-1 flex flex-col">

                            {{-- Header --}}
                            <div class="flex justify-between items-start mb-4">
                                <div
                                    class="bg-gray-50 p-2 rounded-lg text-gray-400 group-hover:text-indigo-600 group-hover:bg-indigo-50 transition-colors">
                                    <i class="fa-regular fa-building text-xl"></i>
                                </div>
                                @php
                                    $badges = [
                                        'open' => 'bg-green-100 text-green-700 border-green-200',
                                        'awarded' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                        'closed' => 'bg-gray-100 text-gray-600 border-gray-200',
                                    ];
                                @endphp
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $badges[$project->status] ?? 'bg-gray-100' }}">
                                    {{ $project->status }}
                                </span>
                            </div>

                            {{-- Title & Budget --}}
                            <h3
                                class="text-lg font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors line-clamp-1">
                                {{ $project->title }}
                            </h3>
                            <p class="text-xs text-gray-500 flex items-center gap-1 mb-4">
                                <i class="fa-solid fa-location-dot"></i> {{ $project->location ?? 'Remote Location' }}
                            </p>

                            <div
                                class="mb-4 p-3 bg-gray-50 rounded-lg border border-gray-100 flex justify-between items-center">
                                <span class="text-xs font-semibold text-gray-500 uppercase">Est. Budget</span>
                                <span
                                    class="text-base font-bold text-gray-900">₹{{ number_format($project->budget_max) }}</span>
                            </div>

                            {{-- Description --}}
                            <div class="text-sm text-gray-600 line-clamp-2 mb-4">
                                {{ strip_tags($project->description) }}
                            </div>

                            {{-- Progress Bar (Visual Flair) --}}
                            <div class="mt-auto">
                                <div class="flex justify-between text-[10px] font-bold text-gray-400 uppercase mb-1">
                                    <span>Completion</span>
                                    <span>{{ $project->current_progress ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div class="bg-indigo-600 h-1.5 rounded-full"
                                        style="width: {{ $project->current_progress ?? 0 }}%"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Actions --}}
                        <div
                            class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between gap-3">

                            {{-- LEFT: Info Link --}}
                            <a href="{{ auth()->user()->hasRole('contractor') ? route('contractor.projects.show', $project->id) : route('admin.projects.show', $project->id) }}"
                                class="text-sm font-semibold text-gray-500 hover:text-indigo-600 transition-colors">
                                View Details
                            </a>

                            {{-- RIGHT: Primary Action Button --}}
                            <div class="flex items-center gap-2">

                                {{-- 1. CONTRACTOR LOGIC --}}
                                @if (auth()->user()->hasRole('contractor'))
                                    {{-- Scenario A: Awarded -> Add Progress --}}
                                    @if ($project->status == 'awarded')
                                        <a href="{{ route('contractor.projects.show', $project->id) }}"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-md transition-all">
                                            <i class="fa-solid fa-chart-line"></i> Workspace
                                        </a>

                                        {{-- Scenario B: Open -> Bid Now --}}
                                    @elseif ($project->status == 'open')
                                        @if (isset($hasBid[$project->id]) && $hasBid[$project->id])
                                            <span
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-lg border border-green-200">
                                                <i class="fa-solid fa-check"></i> Bid Sent
                                            </span>
                                        @else
                                            <a href="{{ route('admin.projects.bid.create', $project->id) }}"
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-sm transition-all">
                                                Bid Now
                                            </a>
                                        @endif
                                    @endif

                                    {{-- 2. ADMIN LOGIC --}}
                                @elseif(auth()->user()->hasRole('admin'))
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('admin.projects.bids', $project->id) }}"
                                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-white rounded-lg transition-colors"
                                            title="View Bids">
                                            <i class="fa-solid fa-gavel"></i>
                                        </a>
                                        <a href="{{ route('admin.projects.tracking', $project->id) }}"
                                            class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-white rounded-lg transition-colors"
                                            title="Track Progress">
                                            <i class="fa-solid fa-chart-pie"></i>
                                        </a>
                                        <a href="{{ route('admin.projects.edit', $project->id) }}"
                                            class="p-2 text-gray-400 hover:text-amber-600 hover:bg-white rounded-lg transition-colors"
                                            title="Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full py-16 text-center bg-white rounded-xl border-2 border-dashed border-gray-200">
                        <div
                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <i class="fa-solid fa-clipboard-list text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">No projects found</h3>
                        <p class="text-gray-500 text-sm mt-1">Try adjusting your filters to find what you're looking
                            for.</p>
                    </div>
                @endforelse
            </div>

            {{-- 4. PAGINATION --}}
            @if ($projects instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="mt-8">
                    {{ $projects->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
