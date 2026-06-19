<x-contractor-layout>
    <div class="p-6 space-y-10 animate-fade-in">
        <!-- Header & Stats -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight flex items-center gap-3">
                    {{ __('Project Hub') }}
                    <span class="bg-indigo-100 text-indigo-600 text-[10px] font-black uppercase px-3 py-1 rounded-full tracking-widest border border-indigo-200 shadow-sm cursor-help" data-tooltip="{{ __('Find and manage all your assigned construction projects here.') }}">{{ __('Beta') }}</span>
                </h1>
                <p class="text-gray-500 text-sm mt-2 font-medium">{{ __('Explore, manage, and scale your construction business with ease.') }}</p>
            </div>
            
            <div class="grid grid-cols-2 sm:flex gap-3">
                <div class="bg-white px-5 py-3 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-center">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Total Managed') }}</p>
                    <p class="text-xl font-black text-gray-900">{{ $projects->count() }}</p>
                </div>
                <div class="bg-indigo-600 px-5 py-3 rounded-2xl shadow-xl shadow-indigo-100 flex flex-col justify-center text-white cursor-help" data-tooltip="{{ __('Percentage of successfully completed milestones and projects.') }}">
                    <p class="text-[10px] font-black text-indigo-100 uppercase tracking-widest">{{ __('Success Rate') }}</p>
                    <p class="text-xl font-black">94%</p>
                </div>
            </div>
        </div>

        <!-- Sophisticated Search & Filter -->
        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            <form action="{{ route('contractor.projects.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative group">
                    <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-600 transition-colors"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search by project name or site location...') }}" 
                        class="w-full pl-12 pr-4 py-3.5 bg-gray-50/50 border-transparent rounded-2xl text-sm font-medium focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none">
                </div>

                <div class="flex flex-wrap gap-3">
                    <select name="status" class="pl-4 pr-10 py-3.5 bg-gray-50/50 border-transparent rounded-2xl text-sm font-bold text-gray-700 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none appearance-none cursor-pointer">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>{{ __('Open Opportunities') }}</option>
                        <option value="awarded" {{ request('status') == 'awarded' ? 'selected' : '' }}>{{ __('In Development') }}</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                    </select>

                    <button type="submit" class="px-8 py-3.5 bg-gray-900 text-white rounded-2xl hover:bg-gray-800 transition-all font-black text-sm shadow-xl shadow-gray-200">
                        {{ __('Search') }}
                    </button>
                    
                    @if (auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.projects.create') }}" class="px-6 py-3.5 bg-indigo-600 text-white rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 font-black text-sm">
                            {{ __('New Project') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Premium Full-Fill Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @forelse ($projects as $project)
                <div class="group bg-white sm:rounded-[2.5rem] rounded-none border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-50 hover:border-indigo-100 transition-all duration-500 flex flex-col overflow-hidden relative">
                    
                    <!-- Top Gradient Accent -->
                    <div class="absolute top-0 left-0 right-0 h-2 bg-gradient-to-r {{ $project->status == 'open' ? 'from-emerald-400 to-teal-500' : ($project->status == 'awarded' ? 'from-indigo-500 to-violet-600' : 'from-gray-300 to-gray-400') }}"></div>

                    <!-- Card Header -->
                    <div class="p-8 pb-0">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-all duration-500 border border-gray-100 group-hover:border-indigo-100 group-hover:scale-110">
                                <i class="bi bi-building-gear text-2xl"></i>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border 
                                    {{ $project->status == 'open' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 
                                       ($project->status == 'awarded' ? 'bg-indigo-50 text-indigo-600 border-indigo-100' : 'bg-gray-50 text-gray-400 border-gray-200') }}">
                                    {{ __($project->status) }}
                                </span>
                                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">{{ __('ID: #PRJ-') . $project->id }}</p>
                            </div>
                        </div>

                        <h3 class="text-xl font-black text-gray-900 group-hover:text-indigo-600 transition-colors leading-tight mb-2 line-clamp-2">
                            {{ $project->title }}
                        </h3>

                        <p class="text-xs text-gray-500 line-clamp-2 mb-4 font-medium">
                            {{ $project->description ?? __('No description provided.') }}
                        </p>
                        
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-500 text-[10px] font-black uppercase rounded-lg border border-gray-100">
                                <i class="bi bi-tag-fill"></i> {{ $project->category->name ?? __('General') }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-500 text-[10px] font-black uppercase rounded-lg border border-gray-100">
                                <i class="bi bi-geo-alt-fill"></i> {{ $project->location ?? __('Site A') }}
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-gray-50 text-gray-500 text-[10px] font-black uppercase rounded-lg border border-gray-100">
                                <i class="bi bi-calendar-event-fill"></i> {{ $project->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Progress / Stats Section -->
                    <div class="px-8 mb-8 flex-1">
                        <div class="bg-gray-50/50 rounded-3xl p-6 border border-gray-50 group-hover:bg-white group-hover:border-indigo-50 transition-all">
                            <div class="flex justify-between items-end mb-4">
                                <div class="space-y-1 cursor-help" data-tooltip="{{ __('The budget range allocated by the client.') }}">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Estimated Budget') }}</p>
                                    <p class="text-sm font-black text-gray-900">₹{{ number_format($project->budget_min) }} - ₹{{ number_format($project->budget_max) }}</p>
                                </div>
                                <div class="text-right space-y-1">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ __('Completion') }}</p>
                                    <p class="text-lg font-black text-indigo-600">{{ $project->current_progress ?? 0 }}%</p>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 h-2.5 rounded-full overflow-hidden shadow-inner">
                                <div class="bg-gradient-to-r from-indigo-500 to-violet-600 h-full rounded-full transition-all duration-1000 group-hover:shadow-[0_0_15px_rgba(79,70,229,0.3)]" style="width: {{ $project->current_progress ?? 0 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="px-8 pb-8 mt-auto">
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('contractor.projects.details', $project->id) }}" class="flex items-center justify-center gap-2 py-3.5 bg-white border border-gray-100 text-gray-600 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-gray-50 hover:text-indigo-600 transition-all">
                                <i class="bi bi-search"></i>
                                {{ __('Details') }}
                            </a>
                            
                            @if (auth()->user()->hasRole('contractor'))
                                @if ($project->status == 'awarded')
                                    <a href="{{ route('contractor.projects.show', $project->id) }}" class="flex items-center justify-center gap-2 py-3.5 bg-indigo-600 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all transform group-hover:-translate-y-1" data-tooltip="{{ __('Direct access to project daily reports, attendance, and financials.') }}">
                                        <i class="bi bi-columns-gap"></i>
                                        {{ __('Workspace') }}
                                    </a>
                                @elseif ($project->status == 'open')
                                    @php $hasBid = isset($hasBid[$project->id]) && $hasBid[$project->id]; @endphp
                                    @if ($hasBid)
                                        <div class="flex items-center justify-center gap-2 py-3.5 bg-emerald-50 text-emerald-600 rounded-2xl text-xs font-black uppercase tracking-widest border border-emerald-100">
                                            <i class="bi bi-check2-all"></i>
                                            {{ __('Bid Sent') }}
                                        </div>
                                    @else
                                        <a href="{{ route('contractor.bids.create', $project->id) }}" class="flex items-center justify-center gap-2 py-3.5 bg-gray-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest shadow-xl shadow-gray-100 hover:bg-gray-800 transition-all transform group-hover:-translate-y-1" data-tooltip="{{ __('Submit your technical and financial proposal for this project.') }}">
                                            <i class="bi bi-send-fill"></i>
                                            {{ __('Bid Now') }}
                                        </a>
                                    @endif
                                @else
                                    <div class="flex items-center justify-center gap-2 py-3.5 bg-gray-100 text-gray-400 rounded-2xl text-xs font-black uppercase tracking-widest cursor-not-allowed">
                                        <i class="bi bi-lock-fill"></i>
                                        {{ __('Closed') }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-32 flex flex-col items-center justify-center text-center">
                    <div class="w-32 h-32 bg-gray-50 rounded-full flex items-center justify-center text-gray-200 text-6xl mb-8">
                        <i class="bi bi-layout-wtf"></i>
                    </div>
                    <h3 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">{{ __('No Matches Found') }}</h3>
                    <p class="text-gray-500 mt-3 max-w-sm font-medium leading-relaxed">{{ __('Our search bots couldn\'t find any projects matching your parameters. Try adjusting your scope or status filters.') }}</p>
                    <a href="{{ route('contractor.projects.index') }}" class="mt-10 px-10 py-4 bg-indigo-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-2xl shadow-indigo-100 hover:bg-indigo-700 transition-all">
                        {{ __('Reset All Parameters') }}
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($projects instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                <p class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ __('Displaying') }} {{ $projects->firstItem() }}-{{ $projects->lastItem() }} {{ __('of') }} {{ $projects->total() }}</p>
                <div class="pagination-container">
                    {{ $projects->withQueryString()->links() }}
                </div>
            </div>
        @endif
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .pagination-container nav svg { width: 1.5rem; }
    </style>
</x-contractor-layout>
