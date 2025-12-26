<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'BlocInfra Admin' }}</title>

    {{-- Fonts & Icons --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Scripts & Styles --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0f766e', // Teal 700
                        'primary-hover': '#0d9488', // Teal 600
                        'primary-light': '#f0fdfa', // Teal 50
                        secondary: '#64748b', // Slate 500
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'glow': '0 0 15px rgba(15, 118, 110, 0.3)',
                    }
                }
            }
        }
    </script>

    {{-- Alpine.js (Core + Collapse Plugin) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Custom Scrollbar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 4px;
        }

        .sidebar-scroll:hover::-webkit-scrollbar-thumb {
            background: #cbd5e1;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-800 font-sans antialiased overflow-x-hidden">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        @include('components.user.common.sidebar')

        {{-- MOBILE OVERLAY BACKDROP --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity duration.300
            class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 md:hidden" style="display: none;">
        </div>

        {{-- MAIN CONTENT WRAPPER --}}
        <div class="flex-1 flex flex-col h-full relative overflow-y-auto no-scrollbar">

            {{-- TOP HEADER --}}
            <header
                class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-30 px-4 sm:px-6 flex items-center justify-between shrink-0">

                {{-- Left: Mobile Toggle & Page Title --}}
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="md:hidden p-2 -ml-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <h1 class="text-lg font-bold text-slate-800 hidden sm:block">{{ $header ?? 'Dashboard' }}</h1>
                </div>

                {{-- Right: Header Actions --}}
                <div class="flex items-center gap-3 sm:gap-4">
                    {{-- Search --}}
                    <div class="hidden md:block relative">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Type to search..."
                            class="pl-9 pr-4 py-2 bg-slate-50 border-none rounded-lg text-sm w-64 focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all placeholder:text-slate-400 outline-none">
                    </div>

                    {{-- Notification Bell --}}
                    <button
                        class="relative w-9 h-9 flex items-center justify-center text-slate-500 hover:text-primary hover:bg-primary-light rounded-full transition-colors">
                        <i class="fa-regular fa-bell text-lg"></i>
                        <span
                            class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>

                    {{-- Logout Text Button (Desktop) --}}
                    <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                        @csrf
                        <button type="submit"
                            class="text-xs font-semibold text-slate-500 hover:text-red-600 transition-colors ml-2">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            {{-- PAGE CONTENT SLOT --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">
                {{ $slot }}
            </main>

        </div>

    </div>

    {{-- FLOATING CHAT BUTTON --}}
    <button
        class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-primary text-white rounded-full shadow-lg shadow-primary/40 hover:bg-primary-hover hover:scale-110 hover:-rotate-3 transition-all duration-300 flex items-center justify-center group"
        onclick="alert('Chat system opening...')" title="Support Chat">
        <i class="fa-solid fa-comment-dots text-2xl group-hover:animate-pulse"></i>
        <span class="absolute top-0 right-0 w-4 h-4 bg-red-500 border-2 border-white rounded-full"></span>
    </button>

    @stack('scripts')
</body>

</html>
