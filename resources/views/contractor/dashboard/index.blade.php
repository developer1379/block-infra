<x-contractor-layout>
    <div class="p-6 space-y-8 animate-fade-in">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('Welcome back') }}, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-gray-500 text-sm mt-1">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('contractor.projects.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-xl hover:bg-gray-50 transition-all shadow-sm text-sm font-medium">
                    <i class="bi bi-search"></i>
                    {{ __('Find Projects') }}
                </a>
                <a href="{{ route('contractor.profile.edit') }}" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all shadow-indigo-200 shadow-lg text-sm font-medium">
                    <i class="bi bi-person"></i>
                    {{ __('Update Profile') }}
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Payments -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-green-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-green-600 mb-4">
                        <i class="bi bi-wallet2 text-2xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('Worker Payments') }}</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">₹{{ number_format($stats['total_payments'], 2) }}</h3>
                    <p class="text-xs text-green-600 font-medium mt-2 flex items-center gap-1">
                        <i class="bi bi-check-circle"></i>
                        <span>{{ __('Paid to workforce') }}</span>
                    </p>
                </div>
            </div>

            <!-- Active Projects -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-4">
                        <i class="bi bi-kanban text-2xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('Active Jobs') }}</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['active_projects'] }}</h3>
                    <p class="text-xs text-blue-600 font-medium mt-2 flex items-center gap-1">
                        <i class="bi bi-clock-history"></i>
                        <span>{{ __('In progress') }}</span>
                    </p>
                </div>
            </div>

            <!-- Total Workers -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-yellow-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600 mb-4">
                        <i class="bi bi-people text-2xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('Total Workforce') }}</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_workers'] }}</h3>
                    <p class="text-xs text-yellow-600 font-medium mt-2 flex items-center gap-1">
                        <i class="bi bi-person-check"></i>
                        <span>{{ __('Active workers') }}</span>
                    </p>
                </div>
            </div>

            <!-- Attendance Today -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-purple-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mb-4">
                        <i class="bi bi-calendar-check text-2xl"></i>
                    </div>
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('Attendance Today') }}</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['attendance_today'] }}</h3>
                    <p class="text-xs text-purple-600 font-medium mt-2 flex items-center gap-1">
                        <i class="bi bi-geo-alt"></i>
                        <span>{{ __('Verified on site') }}</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Active Projects Table -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Ongoing Projects') }}</h3>
                    <a href="{{ route('contractor.projects.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                        {{ __('View All Projects') }} &rarr;
                    </a>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50">
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Project Name') }}</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Progress') }}</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">{{ __('Status') }}</th>
                                    <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider text-right">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($ongoingProjects as $project)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold">
                                                {{ substr($project->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-gray-900">{{ $project->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $project->category->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="w-full max-w-[100px]">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-[10px] font-bold text-gray-400">{{ $project->current_progress }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                                <div class="bg-indigo-600 h-1.5 rounded-full" style="width: {{ $project->current_progress }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('contractor.projects.show', $project->id) }}" class="inline-flex items-center gap-1 text-sm font-bold text-indigo-600 hover:text-indigo-800">
                                            {{ __('Manage') }}
                                            <i class="bi bi-chevron-right text-[10px]"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <i class="bi bi-inbox text-4xl mb-2"></i>
                                            <p class="text-sm">{{ __('No ongoing projects found.') }}</p>
                                            <a href="{{ route('contractor.projects.index') }}" class="mt-4 text-indigo-600 text-sm font-bold hover:underline">{{ __('Browse projects') }}</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recommended Projects -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900">{{ __('New Opportunities') }}</h3>
                <div class="space-y-4">
                    @forelse($availableProjects as $p)
                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:border-indigo-200 transition-all group">
                        <div class="flex justify-between items-start mb-3">
                            <span class="px-2 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded uppercase tracking-wider">
                                {{ $p->category->name ?? 'Project' }}
                            </span>
                            <span class="text-[10px] text-gray-400 font-medium">{{ $p->created_at->diffForHumans() }}</span>
                        </div>
                        <h4 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $p->name }}</h4>
                        <p class="text-xs text-gray-500 mt-2 line-clamp-2">{{ Str::limit(strip_tags($p->description), 120) }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center gap-1 text-indigo-600">
                                <i class="bi bi-geo-alt text-xs"></i>
                                <span class="text-[10px] font-bold">{{ $p->location ?? 'Multiple Locations' }}</span>
                            </div>
                            <a href="{{ route('contractor.projects.details', $p->id) }}" class="text-xs font-bold text-gray-900 hover:text-indigo-600 transition-colors">
                                {{ __('Bid Now') }} &rarr;
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="bg-gray-50 border border-dashed border-gray-200 p-6 rounded-2xl text-center">
                        <p class="text-xs text-gray-500">{{ __('Check back later for new projects.') }}</p>
                    </div>
                    @endforelse
                </div>
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
