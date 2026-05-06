<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Construction App') }} - Contractor Portal</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        /* Select2 Tailwind Fixes */
        .select2-container .select2-selection--single {
            height: 48px !important;
            border-color: #f1f5f9 !important;
            border-radius: 1rem !important;
            padding-top: 10px;
            background-color: #f8fafc !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 10px !important;
        }

        .select2-dropdown {
            border-color: #f1f5f9 !important;
            border-radius: 1rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            overflow: hidden;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-0 flex flex-col">

            <div class="flex items-center justify-center h-16 border-b border-gray-200 bg-white px-6">
                <div class="flex items-center gap-2">
                    <div
                        class="h-8 w-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                        C
                    </div>
                    <span class="font-bold text-xl text-gray-800 tracking-tight">Contractor<span
                            class="text-indigo-600">Portal</span></span>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar py-4 px-3 space-y-1">

                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-2">{{ __('Menu') }}</p>

                <a href="{{ route('contractor.dashboard.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('contractor.dashboard.index') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <i class="bi bi-grid-1x2-fill"></i>
                    {{ __('Dashboard') }}
                </a>

                <a href="{{ route('contractor.projects.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('contractor.projects*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <i class="bi bi-briefcase-fill"></i>
                    {{ __('My Projects') }}
                </a>

                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">{{ __('Operations') }}</p>

                <a href="{{ route('contractor.workers.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('contractor.workers*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <i class="bi bi-people-fill"></i>
                    {{ __('My Workforce') }}
                </a>

                <a href="{{ route('contractor.attendance.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('contractor.attendance*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <i class="bi bi-geo-alt-fill"></i>
                    {{ __('Worker Attendance') }}
                </a>

                <a href="{{ route('contractor.payments.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('contractor.payments*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <i class="bi bi-cash-stack"></i>
                    {{ __('Worker Payments') }}
                </a>

                <a href="{{ route('contractor.inventory.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('contractor.inventory*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <i class="bi bi-box-seam-fill"></i>
                    {{ __('Material Logs') }}
                </a>

                <a href="{{ route('contractor.site-reports.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('contractor.site-reports*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <i class="bi bi-journal-text"></i>
                    {{ __('Site Reports') }}
                </a>

                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">{{ __('Financials') }}</p>

                <a href="{{ route('contractor.invoices.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('contractor.invoices*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <i class="bi bi-receipt-cutoff"></i>
                    {{ __('Invoices & Payments') }}
                </a>

                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 mt-6">{{ __('Account') }}</p>

                <a href="{{ route('contractor.profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 transition-colors
                    {{ request()->routeIs('contractor.profile.edit') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                    <i class="bi bi-person-gear"></i>
                    {{ __('Profile Settings') }}
                </a>

                <form method="POST" action="{{ route('logout') }}" class="block md:hidden">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                        <i class="bi bi-box-arrow-right"></i>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>

            <div class="border-t border-gray-200 p-4 bg-gray-50">
                <div class="flex items-center gap-3">
                    <div
                        class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200">
                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name ?? 'Contractor' }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 bg-gray-900/50 z-40 md:hidden"></div>

        <div class="flex-1 flex flex-col overflow-hidden">

            <header
                class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-6 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-gray-500 hover:text-gray-700 md:hidden focus:outline-none">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-700 md:hidden">Contractor Portal</h2>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Language Switcher -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-indigo-600 transition-colors bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-200">
                            <i class="bi bi-translate text-lg"></i>
                            <span class="uppercase">{{ app()->getLocale() }}</span>
                            <i class="bi bi-chevron-down text-xs"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-32 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            <a href="{{ route('lang.switch', 'en') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                <span class="text-base">🇺🇸</span> English
                            </a>
                            <a href="{{ route('lang.switch', 'hi') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">
                                <span class="text-base">🇮🇳</span> हिंदी
                            </a>
                        </div>
                    </div>

                    <div class="h-6 w-px bg-gray-200 mx-1 hidden md:block"></div>

                    <button class="text-gray-400 hover:text-gray-600 relative">
                        <i class="bi bi-bell text-xl"></i>
                        <span
                            class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                    </button>

                    <div class="h-6 w-px bg-gray-200 mx-1 hidden md:block"></div>

                    <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                        @csrf
                        <button type="submit"
                            class="text-sm font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-lg transition-colors">
                            <i class="bi bi-box-arrow-right mr-1"></i> {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50/50">

                @if (session('success'))
                    <div class="max-w-7xl mx-auto mt-6 px-6" x-data="{ show: true }" x-show="show"
                        x-init="setTimeout(() => show = false, 3000)">
                        <div
                            class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center shadow-sm">
                            <i class="bi bi-check-circle-fill mr-2 text-xl"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="max-w-7xl mx-auto mt-6 px-6">
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{ $slot }}

                <footer class="mt-auto py-6 px-6 text-center text-sm text-gray-400 border-t border-gray-200">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </footer>
            </main>
        </div>
    </div>
    @include('admin.partials.scripts')
    @stack('scripts')
</body>

</html>
