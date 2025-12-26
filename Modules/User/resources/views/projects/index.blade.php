<x-user.user-layout title="My Projects" header="My Projects">

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-slate-800 sm:text-3xl sm:truncate tracking-tight">
                    Project Management
                </h2>
                <p class="mt-1 text-sm text-slate-500">Manage your active projects and track their status.</p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('user.projects.create') }}"
                    class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Project
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 mb-8 p-6">
            <form action="{{ route('user.projects.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">

                <div class="md:col-span-5 lg:col-span-5">
                    <label for="search" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Search Projects
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2.5 border-slate-300 rounded-lg leading-5 bg-slate-50 text-slate-900 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-150 ease-in-out"
                            placeholder="Search by title...">
                    </div>
                </div>

                <div class="md:col-span-4 lg:col-span-3">
                    <label for="status" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Filter by Status
                    </label>
                    <div class="relative">
                        <select name="status" id="status"
                            class="block w-full pl-3 pr-10 py-2.5 text-base border-slate-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg bg-slate-50 text-slate-900 focus:bg-white transition duration-150 ease-in-out">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                </div>

                <div class="md:col-span-3 lg:col-span-2">
                    <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-2.5 border border-slate-300 shadow-sm text-sm font-medium rounded-lg text-slate-700 bg-white hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <svg class="mr-2 h-4 w-4 text-slate-500" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Apply
                    </button>
                </div>

                @if (request('search') || request('status'))
                    <div
                        class="md:col-span-12 lg:col-span-2 flex items-center justify-end md:justify-start lg:justify-center mt-2 md:mt-0">
                        <a href="{{ route('user.projects.index') }}"
                            class="text-xs font-medium text-red-600 hover:text-red-800 transition-colors flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear
                        </a>
                    </div>
                @endif

            </form>
        </div>

        @if ($projects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-slate-200 hover:shadow-md transition-shadow duration-300 flex flex-col h-full group">

                        <div class="p-5 border-b border-slate-100 flex justify-between items-start">
                            <div class="flex-1 pr-4">
                                <h3
                                    class="text-lg font-bold text-slate-800 line-clamp-1 group-hover:text-indigo-600 transition-colors">
                                    {{ $project->title }}
                                </h3>
                                <div class="mt-1 flex items-center text-xs text-slate-500">
                                    <svg class="mr-1.5 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Created {{ $project->created_at->diffForHumans() }}
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide
                                {{ $project->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $project->status ?? 'Active' }}
                            </span>
                        </div>

                        <div class="p-5 flex-1">
                            <p class="text-slate-600 text-sm line-clamp-3 mb-4 h-16">
                                {{ Str::limit(strip_tags($project->description), 120) }}
                            </p>

                            <div class="grid grid-cols-2 gap-4 mt-auto">
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <p class="text-[10px] uppercase font-bold text-slate-400">Est. Budget</p>
                                    <p class="text-sm font-bold text-slate-700 mt-0.5">
                                        ₹{{ number_format($project->budget_max) }}
                                    </p>
                                </div>
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <p class="text-[10px] uppercase font-bold text-slate-400">Location</p>
                                    <div class="flex items-center mt-0.5">
                                        <p class="text-sm font-medium text-slate-700 truncate">
                                            {{ $project->location ?? 'Remote' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="px-5 py-4 bg-slate-50/50 border-t border-slate-100 rounded-b-xl flex items-center justify-between">
                            <a href="{{ route('user.projects.edit', $project->id) }}"
                                class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Details
                            </a>

                            <form action="{{ route('user.projects.destroy', $project->id) }}" method="POST"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                    class="text-sm font-medium text-red-500 hover:text-red-700 flex items-center gap-1 transition-colors delete-btn">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $projects->links() }}
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-slate-200 border-dashed">
                <div class="mx-auto h-16 w-16 bg-indigo-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900">No projects found</h3>
                <p class="mt-1 text-sm text-slate-500 max-w-sm mx-auto">It looks like you haven't created any projects
                    yet. Start by posting a new requirement.</p>
                <div class="mt-6">
                    <a href="{{ route('user.projects.create') }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Your First Project
                    </a>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Delete Confirmation with visual feedback
                $('.delete-btn').on('click', function(e) {
                    e.preventDefault();
                    let btn = $(this);
                    let form = btn.closest('form');

                    if (confirm(
                            'Are you sure you want to delete this project? This action cannot be undone.')) {
                        btn.addClass('opacity-50 cursor-not-allowed').text('Deleting...');
                        form.submit();
                    }
                });
            });
        </script>
    @endpush

</x-user.user-layout>
