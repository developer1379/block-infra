<x-user.user-layout title="My Projects" header="My Projects">

    <div class="max-w-7xl mx-auto py-8 sm:px-6 lg:px-8">

        {{-- Page Header --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-3xl font-bold leading-7 text-slate-800 tracking-tight">
                    Project Dashboard
                </h2>
                <p class="mt-2 text-sm text-slate-500">Monitor your active projects, track milestones, and manage
                    progress.</p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="{{ route('user.projects.create') }}"
                    class="inline-flex items-center px-5 py-2.5 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-all hover:-translate-y-0.5 shadow-indigo-200">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Project
                </a>
            </div>
        </div>

        {{-- Filters Section --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8 p-5">
            <form action="{{ route('user.projects.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-5">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="block w-full pl-10 pr-3 py-2.5 border-slate-200 rounded-xl bg-slate-50 text-slate-900 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-shadow"
                            placeholder="Find a project...">
                    </div>
                </div>

                <div class="md:col-span-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                    <select name="status"
                        class="block w-full pl-3 pr-10 py-2.5 text-sm border-slate-200 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl bg-slate-50 text-slate-700">
                        <option value="">All Projects</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div class="md:col-span-3 flex gap-2">
                    <button type="submit"
                        class="flex-1 flex items-center justify-center px-4 py-2.5 border border-slate-200 shadow-sm text-sm font-bold rounded-xl text-slate-700 bg-white hover:bg-slate-50 hover:border-slate-300 transition-all">
                        Filter
                    </button>
                    @if (request('search') || request('status'))
                        <a href="{{ route('user.projects.index') }}"
                            class="flex items-center justify-center px-4 py-2.5 text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Projects Grid --}}
        @if ($projects->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach ($projects as $project)
                    <div
                        class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:border-indigo-200 transition-all duration-300 group flex flex-col h-full relative overflow-hidden">

                        {{-- Status Stripe --}}
                        <div
                            class="absolute top-0 left-0 w-1 h-full
                            {{ $project->status === 'completed' ? 'bg-emerald-500' : ($project->status === 'active' ? 'bg-indigo-500' : 'bg-slate-300') }}">
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            {{-- Header --}}
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide
                                        {{ $project->status === 'active' ? 'bg-indigo-50 text-indigo-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $project->status }}
                                    </span>
                                    <h3
                                        class="text-xl font-bold text-slate-900 mt-2 group-hover:text-indigo-600 transition-colors line-clamp-1">
                                        {{ $project->title }}
                                    </h3>
                                </div>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false"
                                        class="text-slate-400 hover:text-slate-600 p-1 rounded-full hover:bg-slate-100">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </button>
                                    {{-- Dropdown --}}
                                    <div x-show="open"
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 z-10 py-1"
                                        style="display: none;">
                                        <a href="{{ route('user.projects.edit', $project->id) }}"
                                            class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">Edit
                                            Details</a>
                                        <form action="{{ route('user.projects.destroy', $project->id) }}"
                                            method="POST" onsubmit="return confirm('Delete this project?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Delete
                                                Project</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Info Grid --}}
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Budget</p>
                                    <p class="font-mono font-bold text-slate-700">
                                        ₹{{ number_format($project->amount) }}</p>
                                </div>
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Due Date</p>
                                    <p class="font-medium text-slate-700">
                                        {{ $project->due_date ? \Carbon\Carbon::parse($project->due_date)->format('M d') : 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <p class="text-sm text-slate-500 line-clamp-2 mb-6">
                                {{ Str::limit(strip_tags($project->description), 100) }}</p>

                            {{-- Action Button --}}
                            <div class="mt-auto">
                                <a href="{{ route('user.projects.show', $project->id) }}"
                                    class="flex items-center justify-center w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl shadow-md shadow-indigo-100 transition-all hover:-translate-y-0.5 group-hover:shadow-indigo-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    Track Progress & Milestones
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $projects->links() }}
            </div>
        @else
            <div class="text-center py-20">
                <div
                    class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">No projects found</h3>
                <p class="text-slate-500 mt-2 mb-6">Create your first project to get started.</p>
                <a href="{{ route('user.projects.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all">
                    Create Project
                </a>
            </div>
        @endif

    </div>
</x-user.user-layout>
