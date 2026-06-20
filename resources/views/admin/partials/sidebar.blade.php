<nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

    {{-- DASHBOARD --}}
    <a href="{{ route('dashboard') }}"
        class="group flex items-center px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
       {{ request()->routeIs('dashboard')
           ? 'bg-primary text-white shadow-lg shadow-teal-500/30 translate-x-1'
           : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
        <i class="fa-solid fa-gauge w-5 text-center transition-transform group-hover:scale-110"></i>
        <span class="ml-3">Dashboard</span>
    </a>

    {{-- SECTION LABEL --}}
    <div class="pt-6 pb-2 px-4">
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Management</p>
    </div>

    {{-- CATEGORIES --}}
    @can('view categories')
        <div x-data="{ open: {{ request()->routeIs('admin.categories.*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open"
                class="w-full group flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                {{ request()->routeIs('admin.categories.*') ? 'bg-teal-50 text-primary' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <div class="flex items-center">
                    <i
                        class="fa-solid fa-layer-group w-5 text-center transition-colors {{ request()->routeIs('admin.categories.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Categories</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform duration-300"
                    :class="open ? 'rotate-90 text-primary' : ''"></i>
            </button>

            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                {{-- Vertical Guide Line --}}
                <div class="absolute left-[22px] top-0 bottom-0 w-[1.5px] bg-slate-100"></div>

                @can('view categories')
                    <a href="{{ route('admin.categories.index') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200
                       {{ request()->routeIs('admin.categories.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                        All Categories
                    </a>
                @endcan
                @can('create categories')
                    <a href="{{ route('admin.categories.create') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200
                       {{ request()->routeIs('admin.categories.create') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
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
                class="w-full group flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                {{ request()->routeIs('admin.works.*') ? 'bg-teal-50 text-primary' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <div class="flex items-center">
                    <i
                        class="fa-solid fa-person-digging w-5 text-center transition-colors {{ request()->routeIs('admin.works.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Works</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform duration-300"
                    :class="open ? 'rotate-90 text-primary' : ''"></i>
            </button>

            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                <div class="absolute left-[22px] top-0 bottom-0 w-[1.5px] bg-slate-100"></div>

                @can('view works')
                    <a href="{{ route('admin.works.index') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200
                       {{ request()->routeIs('admin.works.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
                        All Works
                    </a>
                @endcan
                @can('create works')
                    <a href="{{ route('admin.works.create') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200
                       {{ request()->routeIs('admin.works.create') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">
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
                class="w-full group flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                {{ request()->routeIs('admin.units.*') ? 'bg-teal-50 text-primary' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <div class="flex items-center">
                    <i
                        class="fa-solid fa-ruler-combined w-5 text-center transition-colors {{ request()->routeIs('admin.units.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Units</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform duration-300"
                    :class="open ? 'rotate-90 text-primary' : ''"></i>
            </button>
            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                <div class="absolute left-[22px] top-0 bottom-0 w-[1.5px] bg-slate-100"></div>
                @can('view units')
                    <a href="{{ route('admin.units.index') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.units.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">All
                        Units</a>
                @endcan
                @can('create units')
                    <a href="{{ route('admin.units.create') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.units.create') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">Add
                        Unit</a>
                @endcan
            </div>
        </div>
    @endcan

    {{-- CONTRACTORS --}}
    @can('view contractors')
        <div x-data="{ open: {{ request()->routeIs('admin.contractors.*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open"
                class="w-full group flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                {{ request()->routeIs('admin.contractors.*') ? 'bg-teal-50 text-primary' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <div class="flex items-center">
                    <i
                        class="fa-solid fa-helmet-safety w-5 text-center transition-colors {{ request()->routeIs('admin.contractors.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Contractors</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform duration-300"
                    :class="open ? 'rotate-90 text-primary' : ''"></i>
            </button>
            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                <div class="absolute left-[22px] top-0 bottom-0 w-[1.5px] bg-slate-100"></div>
                @can('view contractors')
                    <a href="{{ route('admin.contractors.index') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.contractors.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">All
                        Contractors</a>
                @endcan
                @can('create contractors')
                    <a href="{{ route('admin.contractors.create') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.contractors.create') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">Add
                        Contractor</a>
                @endcan
            </div>
        </div>
    @endcan

    {{-- PROJECTS --}}
    @can('view projects')
        <div x-data="{ open: {{ request()->routeIs('admin.projects.*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open"
                class="w-full group flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                {{ request()->routeIs('admin.projects.*') ? 'bg-teal-50 text-primary' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <div class="flex items-center">
                    <i
                        class="fa-solid fa-diagram-project w-5 text-center transition-colors {{ request()->routeIs('admin.projects.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Projects</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform duration-300"
                    :class="open ? 'rotate-90 text-primary' : ''"></i>
            </button>
            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                <div class="absolute left-[22px] top-0 bottom-0 w-[1.5px] bg-slate-100"></div>
                @can('view projects')
                    <a href="{{ route('admin.projects.index') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.projects.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">All
                        Projects</a>
                @endcan
                @can('create projects')
                    <a href="{{ route('admin.projects.create') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.projects.create') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">Add
                        Project</a>
                @endcan
            </div>
        </div>
    @endcan

    {{-- WORKFORCE --}}
    <div x-data="{ open: {{ request()->routeIs('admin.workers.*') ? 'true' : 'false' }} }" class="space-y-1">
        <button @click="open = !open"
            class="w-full group flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
            {{ request()->routeIs('admin.workers.*') ? 'bg-teal-50 text-primary' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <div class="flex items-center">
                <i class="fa-solid fa-users-gear w-5 text-center transition-colors {{ request()->routeIs('admin.workers.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}"></i>
                <span class="ml-3">Workforce</span>
            </div>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform duration-300"
                :class="open ? 'rotate-90 text-primary' : ''"></i>
        </button>
        <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
            <div class="absolute left-[22px] top-0 bottom-0 w-[1.5px] bg-slate-100"></div>
            <a href="{{ route('admin.workers.index') }}" class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.workers.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">All Workers</a>
        </div>
    </div>

    {{-- INVENTORY --}}
    <div x-data="{ open: {{ request()->routeIs('admin.materials.*') ? 'true' : 'false' }} }" class="space-y-1">
        <button @click="open = !open"
            class="w-full group flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
            {{ request()->routeIs('admin.materials.*') ? 'bg-teal-50 text-primary' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <div class="flex items-center">
                <i class="fa-solid fa-boxes-stacked w-5 text-center transition-colors {{ request()->routeIs('admin.materials.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}"></i>
                <span class="ml-3">Inventory</span>
            </div>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform duration-300"
                :class="open ? 'rotate-90 text-primary' : ''"></i>
        </button>
        <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
            <div class="absolute left-[22px] top-0 bottom-0 w-[1.5px] bg-slate-100"></div>
            <a href="{{ route('admin.materials.index') }}" class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.materials.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">Materials</a>
        </div>
    </div>

    {{-- FINANCE --}}
    <div x-data="{ open: {{ request()->routeIs('admin.finance.*') ? 'true' : 'false' }} }" class="space-y-1">
        <button @click="open = !open"
            class="w-full group flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
            {{ request()->routeIs('admin.finance.*') ? 'bg-teal-50 text-primary' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <div class="flex items-center">
                <i class="fa-solid fa-file-invoice-dollar w-5 text-center transition-colors {{ request()->routeIs('admin.finance.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}"></i>
                <span class="ml-3">Finance</span>
            </div>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform duration-300"
                :class="open ? 'rotate-90 text-primary' : ''"></i>
        </button>
        <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
            <div class="absolute left-[22px] top-0 bottom-0 w-[1.5px] bg-slate-100"></div>
            <a href="{{ route('admin.finance.index') }}" class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.finance.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">Invoices</a>
            <a href="{{ route('admin.worker-payments.index') }}" class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.worker-payments.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">Wage Verification</a>
        </div>
    </div>

    {{-- SITE REPORTS --}}
    <div x-data="{ open: {{ request()->routeIs('admin.site-reports.*') ? 'true' : 'false' }} }" class="space-y-1">
        <button @click="open = !open"
            class="w-full group flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
            {{ request()->routeIs('admin.site-reports.*') ? 'bg-teal-50 text-primary' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <div class="flex items-center">
                <i class="fa-solid fa-clipboard-list w-5 text-center transition-colors {{ request()->routeIs('admin.site-reports.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}"></i>
                <span class="ml-3">Site Reports</span>
            </div>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform duration-300"
                :class="open ? 'rotate-90 text-primary' : ''"></i>
        </button>
        <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
            <div class="absolute left-[22px] top-0 bottom-0 w-[1.5px] bg-slate-100"></div>
            <a href="{{ route('admin.site-reports.index') }}" class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.site-reports.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">Daily Logs</a>
        </div>
    </div>

    {{-- SUPPORT & FEEDBACK --}}
    <div x-data="{ open: {{ request()->routeIs('admin.feedback.*') ? 'true' : 'false' }} }" class="space-y-1">
        <button @click="open = !open"
            class="w-full group flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
            {{ request()->routeIs('admin.feedback.*') ? 'bg-teal-50 text-primary' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <div class="flex items-center">
                <i class="fa-solid fa-headset w-5 text-center transition-colors {{ request()->routeIs('admin.feedback.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}"></i>
                <span class="ml-3">Support & Issues</span>
            </div>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform duration-300"
                :class="open ? 'rotate-90 text-primary' : ''"></i>
        </button>
        <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
            <div class="absolute left-[22px] top-0 bottom-0 w-[1.5px] bg-slate-100"></div>
            <a href="{{ route('admin.feedback.index') }}" class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.feedback.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">Contractor Tickets</a>
        </div>
    </div>

    {{-- ACCESS CONTROL --}}
    @canany(['view roles', 'view permissions'])
        <div x-data="{ open: {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'true' : 'false' }} }" class="space-y-1">
            <button @click="open = !open"
                class="w-full group flex items-center justify-between px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
                {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'bg-teal-50 text-primary' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
                <div class="flex items-center">
                    <i
                        class="fa-solid fa-user-shield w-5 text-center transition-colors {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.permissions.*') ? 'text-primary' : 'text-slate-400 group-hover:text-primary' }}"></i>
                    <span class="ml-3">Access Control</span>
                </div>
                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400 transition-transform duration-300"
                    :class="open ? 'rotate-90 text-primary' : ''"></i>
            </button>
            <div x-show="open" x-collapse x-cloak class="relative pl-9 space-y-1">
                <div class="absolute left-[22px] top-0 bottom-0 w-[1.5px] bg-slate-100"></div>
                @can('view roles')
                    <a href="{{ route('admin.roles.index') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.roles.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">Roles</a>
                @endcan
                @can('view permissions')
                    <a href="{{ route('admin.permissions.index') }}"
                        class="relative block py-2 pl-3 text-sm rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.permissions.index') ? 'text-primary font-semibold bg-teal-50/50' : 'text-slate-500 hover:text-primary hover:bg-slate-50' }}">Permissions</a>
                @endcan
            </div>
        </div>
    @endcanany

    {{-- EMAIL SETTINGS --}}
    @if (auth()->user()->hasRole('admin'))
        <a href="{{ route('admin.settings.edit') }}"
            class="group flex items-center px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
           {{ request()->routeIs('admin.settings.edit')
               ? 'bg-primary text-white shadow-lg shadow-teal-500/30'
               : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <i class="fa-solid fa-envelope-open-text w-5 text-center transition-transform group-hover:scale-110 {{ request()->routeIs('admin.settings.edit') ? 'text-white' : 'text-slate-400 group-hover:text-primary' }}"></i>
            <span class="ml-3">Email Settings</span>
        </a>
    @endif

    {{-- CONTRACTOR PROFILE --}}
    @if (auth()->user()->hasRole('contractor'))
        <a href="{{ route('contractor.profile.edit') }}"
            class="group flex items-center px-3.5 py-2.5 text-sm font-medium rounded-xl transition-all duration-200
           {{ request()->routeIs('contractor.profile.edit')
               ? 'bg-primary text-white shadow-lg shadow-teal-500/30'
               : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">
            <i class="fa-solid fa-user-gear w-5 text-center transition-transform group-hover:scale-110"></i>
            <span class="ml-3">My Profile</span>
        </a>
    @endif

</nav>
