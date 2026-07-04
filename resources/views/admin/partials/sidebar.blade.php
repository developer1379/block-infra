<nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto">

    {{-- DASHBOARD --}}
    <a href="{{ route('dashboard') }}"
        class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
       {{ request()->routeIs('dashboard')
           ? 'bg-teal-600/90 text-white border-teal-500 shadow-sm'
           : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
        <i class="fa-solid fa-gauge w-5 text-center text-base transition-colors {{ request()->routeIs('dashboard') ? 'text-teal-300' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
        <span class="ml-3">Dashboard</span>
    </a>

    {{-- SECTION LABEL --}}
    <div class="pt-5 pb-1.5 px-4">
        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Management</p>
    </div>

    {{-- CATEGORIES --}}
    @can('view categories')
        <div x-data="{ open: {{ request()->routeIs('admin.categories.*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open"
                class="w-full group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
                {{ request()->routeIs('admin.categories.*') ? 'bg-slate-800/50 text-white border-teal-500' : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
                <div class="flex items-center">
                    <i class="fa-solid fa-layer-group w-5 text-center text-base transition-colors {{ request()->routeIs('admin.categories.*') ? 'text-teal-400' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
                    <span class="ml-3">Categories</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 transition-transform duration-200"
                    :class="open ? 'rotate-90 text-teal-400' : ''"></i>
            </button>

            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                {{-- Vertical Guide Line --}}
                <div class="absolute left-[24px] top-0 bottom-0 w-[1px] bg-slate-800"></div>

                @can('view categories')
                    <a href="{{ route('admin.categories.index') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.categories.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.categories.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        All Categories
                    </a>
                @endcan
                @can('create categories')
                    <a href="{{ route('admin.categories.create') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.categories.create') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.categories.create') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        Add New
                    </a>
                @endcan
            </div>
        </div>
    @endcan

    {{-- WORKS --}}
    @can('view works')
        <div x-data="{ open: {{ request()->routeIs('admin.works.*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open"
                class="w-full group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
                {{ request()->routeIs('admin.works.*') ? 'bg-slate-800/50 text-white border-teal-500' : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
                <div class="flex items-center">
                    <i class="fa-solid fa-person-digging w-5 text-center text-base transition-colors {{ request()->routeIs('admin.works.*') ? 'text-teal-400' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
                    <span class="ml-3">Works</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 transition-transform duration-200"
                    :class="open ? 'rotate-90 text-teal-400' : ''"></i>
            </button>

            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                <div class="absolute left-[24px] top-0 bottom-0 w-[1px] bg-slate-800"></div>

                @can('view works')
                    <a href="{{ route('admin.works.index') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.works.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.works.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        All Works
                    </a>
                @endcan
                @can('create works')
                    <a href="{{ route('admin.works.create') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.works.create') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.works.create') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        Add Work
                    </a>
                @endcan
            </div>
        </div>
    @endcan

    {{-- UNITS --}}
    @can('view units')
        <div x-data="{ open: {{ request()->routeIs('admin.units.*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open"
                class="w-full group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
                {{ request()->routeIs('admin.units.*') ? 'bg-slate-800/50 text-white border-teal-500' : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
                <div class="flex items-center">
                    <i class="fa-solid fa-ruler-combined w-5 text-center text-base transition-colors {{ request()->routeIs('admin.units.*') ? 'text-teal-400' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
                    <span class="ml-3">Units</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 transition-transform duration-200"
                    :class="open ? 'rotate-90 text-teal-400' : ''"></i>
            </button>
            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                <div class="absolute left-[24px] top-0 bottom-0 w-[1px] bg-slate-800"></div>
                @can('view units')
                    <a href="{{ route('admin.units.index') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.units.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.units.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        All Units
                    </a>
                @endcan
                @can('create units')
                    <a href="{{ route('admin.units.create') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.units.create') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.units.create') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        Add Unit
                    </a>
                @endcan
            </div>
        </div>
    @endcan

    {{-- CONTRACTORS --}}
    @can('view contractors')
        <div x-data="{ open: {{ request()->routeIs('admin.contractors.*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open"
                class="w-full group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
                {{ request()->routeIs('admin.contractors.*') ? 'bg-slate-800/50 text-white border-teal-500' : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
                <div class="flex items-center">
                    <i class="fa-solid fa-helmet-safety w-5 text-center text-base transition-colors {{ request()->routeIs('admin.contractors.*') ? 'text-teal-400' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
                    <span class="ml-3">Contractors</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 transition-transform duration-200"
                    :class="open ? 'rotate-90 text-teal-400' : ''"></i>
            </button>
            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                <div class="absolute left-[24px] top-0 bottom-0 w-[1px] bg-slate-800"></div>
                @can('view contractors')
                    <a href="{{ route('admin.contractors.index') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.contractors.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.contractors.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        All Contractors
                    </a>
                @endcan
                @can('create contractors')
                    <a href="{{ route('admin.contractors.create') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.contractors.create') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.contractors.create') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        Add Contractor
                    </a>
                @endcan
            </div>
        </div>
    @endcan

    {{-- PROJECTS --}}
    @can('view projects')
        <div x-data="{ open: {{ request()->routeIs('admin.projects.*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open"
                class="w-full group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
                {{ request()->routeIs('admin.projects.*') ? 'bg-slate-800/50 text-white border-teal-500' : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
                <div class="flex items-center">
                    <i class="fa-solid fa-diagram-project w-5 text-center text-base transition-colors {{ request()->routeIs('admin.projects.*') ? 'text-teal-400' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
                    <span class="ml-3">Projects</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 transition-transform duration-200"
                    :class="open ? 'rotate-90 text-teal-400' : ''"></i>
            </button>
            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                <div class="absolute left-[24px] top-0 bottom-0 w-[1px] bg-slate-800"></div>
                @can('view projects')
                    <a href="{{ route('admin.projects.index') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.projects.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.projects.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        All Projects
                    </a>
                @endcan
                @can('create projects')
                    <a href="{{ route('admin.projects.create') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.projects.create') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.projects.create') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        Add Project
                    </a>
                @endcan
            </div>
        </div>
    @endcan

    {{-- WORKFORCE --}}
    <div x-data="{ open: {{ request()->routeIs('admin.workers.*') ? 'true' : 'false' }} }" class="space-y-1">
        <button @click="open = !open"
            class="w-full group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
            {{ request()->routeIs('admin.workers.*') ? 'bg-slate-800/50 text-white border-teal-500' : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <div class="flex items-center">
                <i class="fa-solid fa-users-gear w-5 text-center text-base transition-colors {{ request()->routeIs('admin.workers.*') ? 'text-teal-400' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
                <span class="ml-3">Workforce</span>
            </div>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 transition-transform duration-200"
                :class="open ? 'rotate-90 text-teal-400' : ''"></i>
        </button>
        <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
            <div class="absolute left-[24px] top-0 bottom-0 w-[1px] bg-slate-800"></div>
            <a href="{{ route('admin.workers.index') }}"
                class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
               {{ request()->routeIs('admin.workers.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.workers.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                All Workers
            </a>
        </div>
    </div>

    {{-- INVENTORY --}}
    <div x-data="{ open: {{ request()->routeIs('admin.materials.*') ? 'true' : 'false' }} }" class="space-y-1">
        <button @click="open = !open"
            class="w-full group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
            {{ request()->routeIs('admin.materials.*') ? 'bg-slate-800/50 text-white border-teal-500' : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <div class="flex items-center">
                <i class="fa-solid fa-boxes-stacked w-5 text-center text-base transition-colors {{ request()->routeIs('admin.materials.*') ? 'text-teal-400' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
                <span class="ml-3">Inventory</span>
            </div>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 transition-transform duration-200"
                :class="open ? 'rotate-90 text-teal-400' : ''"></i>
        </button>
        <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
            <div class="absolute left-[24px] top-0 bottom-0 w-[1px] bg-slate-800"></div>
            <a href="{{ route('admin.materials.index') }}"
                class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
               {{ request()->routeIs('admin.materials.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.materials.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                Materials
            </a>
        </div>
    </div>

    {{-- FINANCE --}}
    <div x-data="{ open: {{ request()->routeIs('admin.finance.*') || request()->routeIs('admin.worker-payments.*') ? 'true' : 'false' }} }" class="space-y-1">
        <button @click="open = !open"
            class="w-full group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
            {{ request()->routeIs('admin.finance.*') || request()->routeIs('admin.worker-payments.*') ? 'bg-slate-800/50 text-white border-teal-500' : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <div class="flex items-center">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center text-base transition-colors {{ request()->routeIs('admin.finance.*') || request()->routeIs('admin.worker-payments.*') ? 'text-teal-400' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
                <span class="ml-3">Finance</span>
            </div>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 transition-transform duration-200"
                :class="open ? 'rotate-90 text-teal-400' : ''"></i>
        </button>
        <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
            <div class="absolute left-[24px] top-0 bottom-0 w-[1px] bg-slate-800"></div>
            <a href="{{ route('admin.finance.index') }}"
                class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
               {{ request()->routeIs('admin.finance.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.finance.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                Invoices
            </a>
            <a href="{{ route('admin.worker-payments.index') }}"
                class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
               {{ request()->routeIs('admin.worker-payments.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.worker-payments.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                Wage Verification
            </a>
        </div>
    </div>

    {{-- SITE REPORTS --}}
    <div x-data="{ open: {{ request()->routeIs('admin.site-reports.*') ? 'true' : 'false' }} }" class="space-y-1">
        <button @click="open = !open"
            class="w-full group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
            {{ request()->routeIs('admin.site-reports.*') ? 'bg-slate-800/50 text-white border-teal-500' : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <div class="flex items-center">
                <i class="fa-solid fa-clipboard-list w-5 text-center text-base transition-colors {{ request()->routeIs('admin.site-reports.*') ? 'text-teal-400' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
                <span class="ml-3">Site Reports</span>
            </div>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 transition-transform duration-200"
                :class="open ? 'rotate-90 text-teal-400' : ''"></i>
        </button>
        <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
            <div class="absolute left-[24px] top-0 bottom-0 w-[1px] bg-slate-800"></div>
            <a href="{{ route('admin.site-reports.index') }}"
                class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
               {{ request()->routeIs('admin.site-reports.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.site-reports.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                Daily Logs
            </a>
        </div>
    </div>

    {{-- SUPPORT & FEEDBACK --}}
    <div x-data="{ open: {{ request()->routeIs('admin.feedback.*') ? 'true' : 'false' }} }" class="space-y-1">
        <button @click="open = !open"
            class="w-full group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
            {{ request()->routeIs('admin.feedback.*') ? 'bg-slate-800/50 text-white border-teal-500' : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <div class="flex items-center">
                <i class="fa-solid fa-headset w-5 text-center text-base transition-colors {{ request()->routeIs('admin.feedback.*') ? 'text-teal-400' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
                <span class="ml-3">Support & Issues</span>
            </div>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 transition-transform duration-200"
                :class="open ? 'rotate-90 text-teal-400' : ''"></i>
        </button>
        <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
            <div class="absolute left-[24px] top-0 bottom-0 w-[1px] bg-slate-800"></div>
            <a href="{{ route('admin.feedback.index') }}"
                class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
               {{ request()->routeIs('admin.feedback.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.feedback.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                Contractor Tickets
            </a>
        </div>
    </div>

    {{-- ACCESS CONTROL --}}
    @canany(['view roles', 'view permissions'])
        <div x-data="{ open: {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open"
                class="w-full group flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
                {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'bg-slate-800/50 text-white border-teal-500' : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
                <div class="flex items-center">
                    <i class="fa-solid fa-user-shield w-5 text-center text-base transition-colors {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'text-teal-400' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
                    <span class="ml-3">Access Control</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-500 transition-transform duration-200"
                    :class="open ? 'rotate-90 text-teal-400' : ''"></i>
            </button>
            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                <div class="absolute left-[24px] top-0 bottom-0 w-[1px] bg-slate-800"></div>
                @can('view roles')
                    <a href="{{ route('admin.roles.index') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.roles.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.roles.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        Roles
                    </a>
                @endcan
                @can('view permissions')
                    <a href="{{ route('admin.permissions.index') }}"
                        class="group flex items-center py-2 pl-4 text-xs font-semibold rounded-lg transition-colors duration-150
                       {{ request()->routeIs('admin.permissions.index') ? 'text-teal-300 bg-slate-800/40' : 'text-slate-400 hover:text-teal-300 hover:bg-slate-800/30' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 transition-colors {{ request()->routeIs('admin.permissions.index') ? 'bg-teal-400' : 'bg-slate-600 group-hover:bg-teal-400' }}"></span>
                        Permissions
                    </a>
                @endcan
            </div>
        </div>
    @endcanany

    {{-- EMAIL SETTINGS --}}
    @if (auth()->user()->hasRole('admin'))
        <a href="{{ route('admin.settings.edit') }}"
            class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
           {{ request()->routeIs('admin.settings.edit')
               ? 'bg-teal-600/90 text-white border-teal-500 shadow-sm'
               : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <i class="fa-solid fa-envelope-open-text w-5 text-center text-base transition-colors {{ request()->routeIs('admin.settings.edit') ? 'text-teal-300' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
            <span class="ml-3">Email Settings</span>
        </a>
    @endif

    {{-- CONTRACTOR PROFILE --}}
    @if (auth()->user()->hasRole('contractor'))
        <a href="{{ route('contractor.profile.edit') }}"
            class="group flex items-center px-4 py-2.5 text-sm font-medium rounded-xl border-l-4 transition-all duration-200
           {{ request()->routeIs('contractor.profile.edit')
               ? 'bg-teal-600/90 text-white border-teal-500 shadow-sm'
               : 'border-transparent text-slate-400 hover:bg-slate-800/60 hover:text-white' }}">
            <i class="fa-solid fa-user-gear w-5 text-center text-base transition-colors {{ request()->routeIs('contractor.profile.edit') ? 'text-teal-300' : 'text-slate-500 group-hover:text-teal-400' }}"></i>
            <span class="ml-3">My Profile</span>
        </a>
    @endif

</nav>
