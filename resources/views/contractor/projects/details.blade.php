<x-contractor-layout>
    <div class="p-6 space-y-8 animate-fade-in">
        <!-- Breadcrumbs & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('contractor.projects.index') }}" class="h-10 w-10 flex items-center justify-center bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-indigo-600 hover:border-indigo-100 shadow-sm transition-all">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <nav class="flex text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">
                        <a href="{{ route('contractor.projects.index') }}" class="hover:text-indigo-600">{{ __('Projects') }}</a>
                        <span class="mx-2 text-gray-300">/</span>
                        <span class="text-indigo-600">{{ __('Details') }}</span>
                    </nav>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $project->name }}</h1>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @if (auth()->user()->hasRole('contractor') && $project->status == 'open')
                    <a href="{{ route('contractor.bids.create', $project->id) }}" class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all shadow-indigo-200 shadow-lg font-bold text-sm">
                        <i class="bi bi-gavel"></i>
                        {{ __('Bid on Project') }}
                    </a>
                @endif
                @if (auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="flex items-center gap-2 px-6 py-2.5 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition-all font-bold text-sm">
                        <i class="bi bi-pencil-square"></i>
                        {{ __('Edit Project') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content Area -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Overview Card -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-8">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest border 
                                {{ $project->status == 'open' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 
                                   ($project->status == 'awarded' ? 'bg-indigo-50 text-indigo-700 border-indigo-100' : 'bg-gray-50 text-gray-600 border-gray-200') }}">
                                {{ __($project->status) }}
                            </span>
                            <span class="text-xs font-bold text-gray-400 bg-gray-50 px-3 py-1 rounded-full border border-gray-100">
                                <i class="bi bi-calendar-event mr-1"></i> {{ __('Posted') }} {{ $project->created_at->format('M d, Y') }}
                            </span>
                        </div>

                        <div class="prose prose-indigo max-w-none">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">{{ __('Project Description') }}</h3>
                            <div class="text-gray-600 leading-relaxed">
                                {!! $project->description !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scope of Works -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                        <h3 class="font-bold text-gray-900 flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm">
                                <i class="bi bi-list-check"></i>
                            </div>
                            {{ __('Scope of Works & Estimations') }}
                        </h3>
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-white px-2 py-1 rounded-lg border border-gray-100">
                            {{ $project->works->count() }} {{ __('Items') }}
                        </span>
                    </div>

                    @if ($project->works->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50/50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                    <tr>
                                        <th class="px-8 py-4">{{ __('Work Item') }}</th>
                                        <th class="px-8 py-4 text-center">{{ __('Unit') }}</th>
                                        <th class="px-8 py-4 text-center">{{ __('Quantity') }}</th>
                                        <th class="px-8 py-4 text-right">{{ __('Estimated Cost') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach ($project->works as $work)
                                        @php
                                            $rate = ($work->labor_material_min + $work->labor_material_max) / 2;
                                            if ($rate == 0) { $rate = ($work->labor_min + $work->labor_max) / 2; }
                                            $total = $rate * $work->pivot->quantity;
                                        @endphp
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-8 py-4">
                                                <div class="font-bold text-gray-900">{{ $work->name }}</div>
                                            </td>
                                            <td class="px-8 py-4 text-center">
                                                <span class="inline-block bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-lg uppercase">
                                                    {{ $work->unit->name ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-8 py-4 text-center font-bold text-gray-700">{{ $work->pivot->quantity }}</td>
                                            <td class="px-8 py-4 text-right font-extrabold text-gray-900">₹{{ number_format($total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50/80 border-t border-gray-100">
                                    <tr>
                                        <td colspan="3" class="px-8 py-5 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                                            {{ __('Total Estimated Budget') }}
                                        </td>
                                        <td class="px-8 py-5 text-right text-indigo-600 text-xl font-extrabold">
                                            ₹{{ number_format($project->budget_max, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="p-16 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-200 text-2xl">
                                <i class="bi bi-clipboard"></i>
                            </div>
                            <h3 class="text-gray-900 font-bold mb-1">{{ __('No works listed') }}</h3>
                            <p class="text-gray-500 text-sm">{{ __('There are no specific line items added to this project yet.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-8">
                <!-- Summary Card -->
                <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 space-y-8">
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 border-b border-gray-50 pb-2">
                        {{ __('Project Summary') }}
                    </h4>

                    <div class="space-y-6">
                        <!-- Budget Widget -->
                        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-700 p-6 text-white shadow-xl shadow-indigo-200">
                            <div class="relative z-10">
                                <p class="text-indigo-100 text-[10px] font-bold uppercase tracking-wider mb-1">{{ __('Total Budget') }}</p>
                                <div class="text-3xl font-extrabold flex items-baseline gap-1">
                                    <span class="text-lg opacity-70">₹</span>{{ number_format($project->budget_max, 0) }}
                                </div>
                            </div>
                            <div class="absolute -right-6 -bottom-10 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                        </div>

                        <!-- Info Items -->
                        <div class="space-y-5">
                            <div class="flex items-center gap-4 group">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform border border-indigo-100 shadow-sm">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">{{ __('Location') }}</p>
                                    <p class="font-bold text-gray-900">{{ $project->location ?? __('Remote') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 group">
                                <div class="w-10 h-10 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform border border-violet-100 shadow-sm">
                                    <i class="bi bi-person-check"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">{{ __('Posted By') }}</p>
                                    <p class="font-bold text-gray-900">{{ $project->createdBy->name ?? __('Administrator') }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4 group">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform border border-emerald-100 shadow-sm">
                                    <i class="bi bi-tags"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">{{ __('Category') }}</p>
                                    <p class="font-bold text-gray-900">{{ $project->category->name ?? __('Uncategorized') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin Bid Summary -->
                @if (auth()->user()->hasRole('admin'))
                    <div class="bg-gray-900 rounded-3xl p-8 text-white space-y-6">
                        <div class="flex justify-between items-center">
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ __('Bid Activity') }}</h4>
                            <span class="px-2 py-0.5 bg-indigo-600 rounded text-[10px] font-bold">{{ $project->bids->count() }} {{ __('Total') }}</span>
                        </div>
                        
                        <a href="{{ route('admin.projects.bids', $project->id) }}" class="flex w-full items-center justify-center gap-2 py-3.5 bg-white text-gray-900 rounded-2xl font-bold hover:bg-indigo-50 transition-all transform hover:-translate-y-1 shadow-xl">
                            <i class="bi bi-gavel"></i>
                            {{ __('Review All Bids') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</x-contractor-layout>
