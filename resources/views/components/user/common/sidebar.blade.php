{{-- SIDEBAR WRAPPER --}}
<aside
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col shadow-soft"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    {{-- BRAND LOGO --}}
    <div class="h-16 flex items-center px-6 border-b border-slate-100 shrink-0 bg-white">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group w-full">
            <div
                class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary to-teal-600 flex items-center justify-center text-white shadow-md group-hover:shadow-glow transition-all duration-300">
                <i class="fa-solid fa-cube text-sm"></i>
            </div>
            <span class="text-lg font-bold text-slate-800 tracking-tight">Bloc<span
                    class="text-primary">Infra</span></span>
        </a>

        {{-- Mobile Close Button --}}
        <button @click="sidebarOpen = false" class="md:hidden ml-auto text-slate-400 hover:text-slate-600">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>

    {{-- NAVIGATION LINKS --}}
    <div class="flex-1 overflow-y-auto sidebar-scroll py-2 px-3 space-y-1">

        {{-- Dashboard Link (Example) --}}
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-primary/5 text-primary font-medium shadow-sm ring-1 ring-primary/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <i
                class="fa-solid fa-house w-5 text-center {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-slate-400 group-hover:text-slate-600' }}"></i>
            <span class="text-sm">Dashboard</span>
        </a>

        {{-- Projects Link (Newly Added) --}}
        <a href="{{ route('user.projects.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200 group {{ request()->routeIs('user.projects.*') ? 'bg-primary/5 text-primary font-medium shadow-sm ring-1 ring-primary/10' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            {{-- Icon: Briefcase or Layer Group --}}
            <i
                class="fa-solid fa-briefcase w-5 text-center {{ request()->routeIs('user.projects.*') ? 'text-primary' : 'text-slate-400 group-hover:text-slate-600' }}"></i>
            <span class="text-sm">Projects</span>
        </a>

    </div>

    {{-- SIDEBAR FOOTER (Profile & Logout) --}}
    <div class="p-4 border-t border-slate-100 shrink-0 bg-slate-50/50">
        <div class="flex items-center justify-between gap-2 p-2 rounded-xl bg-white border border-slate-200 shadow-sm">
            <div class="flex items-center gap-2 min-w-0">
                <div
                    class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center text-xs font-bold border border-primary/20 shrink-0">
                    {{ substr(auth()->user()->name, 0, 2) }}
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold text-slate-700 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[9px] font-medium text-slate-400 uppercase tracking-wide truncate">
                        {{ auth()->user()->getRoleNames()->first() ?? 'User' }}
                    </p>
                </div>
            </div>

            {{-- Logout Button (Icon) --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors"
                    title="Logout">
                    <i class="fa-solid fa-power-off text-xs"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
