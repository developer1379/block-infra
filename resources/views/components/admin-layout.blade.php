<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body class="bg-slate-50 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-50/90 border-r border-slate-200/80
               transform transition-transform duration-300 ease-in-out
               lg:relative lg:translate-x-0 lg:flex
               flex flex-col shrink-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <!-- Logo -->
            <div class="flex items-center justify-center h-16 border-b border-slate-200/80 bg-slate-50/90">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-xl font-bold text-slate-800">
                    <div class="w-8 h-8 bg-teal-600 text-white rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-cube"></i>
                    </div>
                    <span>Bloc<span class="text-teal-600">Infra</span></span>
                </a>
            </div>

            <!-- Sidebar Menu -->
            <div class="flex-1 overflow-y-auto">
                @include('admin.partials.sidebar')
            </div>
        </aside>

        <!-- MOBILE OVERLAY -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity
            class="fixed inset-0 z-40 bg-black/50 lg:hidden">
        </div>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col overflow-hidden bg-slate-50">

            @include('admin.partials.header')

            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>

        </div>

    </div>

    @include('admin.partials.scripts')
    @stack('scripts')
</body>

</html>

