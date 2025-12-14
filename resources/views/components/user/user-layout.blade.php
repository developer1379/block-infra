<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'BlocInfra' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f0fdfa;
        }

        ::-webkit-scrollbar-thumb {
            background: #0f766e;
            border-radius: 10px;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        /* Brand Colors Configuration */
        .bg-primary {
            background-color: #0f766e;
        }

        .text-primary {
            color: #0f766e;
        }

        .hover\:bg-primary-dark:hover {
            background-color: #115e59;
        }

        .bg-primary-light {
            background-color: #ccfbf1;
        }

        /* Safe area for iPhone */
        .pb-safe {
            padding-bottom: env(safe-area-inset-bottom, 20px);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased pb-24 md:pb-0">

    <aside class="fixed inset-y-0 left-0 bg-white w-64 border-r border-gray-200 hidden md:flex flex-col z-10 shadow-lg">
        <div class="p-6 flex items-center gap-3">
            <div
                class="w-9 h-9 bg-primary rounded-lg flex items-center justify-center text-white text-lg font-bold shadow-md">
                <i class="fa-solid fa-cube"></i>
            </div>
            <span class="text-xl font-bold tracking-tight text-slate-800">Bloc<span
                    class="text-primary">Infra</span></span>
        </div>

        <nav class="flex-1 px-4 space-y-2 mt-4">
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 bg-primary-light text-primary rounded-xl font-semibold transition shadow-sm">
                <i class="fa-solid fa-house w-5"></i> Dashboard
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-gray-50 hover:text-slate-700 rounded-xl font-medium transition">
                <i class="fa-solid fa-city w-5"></i> My Properties
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-gray-50 hover:text-slate-700 rounded-xl font-medium transition">
                <i class="fa-solid fa-helmet-safety w-5"></i> Contractors
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-gray-50 hover:text-slate-700 rounded-xl font-medium transition">
                <i class="fa-solid fa-file-contract w-5"></i> Documents
            </a>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-gray-50 hover:text-slate-700 rounded-xl font-medium transition">
                <i class="fa-solid fa-indian-rupee-sign w-5"></i> Payments
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-gray-50 cursor-pointer transition">
                <img src="https://i.pravatar.cc/150?img=68" alt="User"
                    class="w-10 h-10 rounded-full object-cover border-2 border-primary">
                <div>
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name ?? 'Guest User' }}</p>
                    <p class="text-xs text-slate-500">Owner</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="md:ml-64 min-h-screen transition-all duration-300 relative">

        <header
            class="sticky top-0 z-30 bg-white/95 backdrop-blur-md border-b border-gray-200 px-5 py-4 flex justify-between items-center md:hidden shadow-sm">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white text-sm font-bold">
                    <i class="fa-solid fa-cube"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-slate-800 leading-tight">Bloc<span
                            class="text-primary">Infra</span></h1>
                </div>
            </div>
            <button
                class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-600 relative hover:bg-slate-200 transition">
                <i class="fa-regular fa-bell"></i>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
            </button>
        </header>

        <header
            class="hidden md:flex justify-between items-center px-8 py-5 bg-white border-b border-gray-200 sticky top-0 z-20">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $header ?? 'Dashboard' }}</h1>
                <p class="text-sm text-slate-400">Welcome back, {{ auth()->user()->name ?? 'User' }}</p>
            </div>
            <div class="flex items-center gap-5">
                <div class="relative group">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-hover:text-primary transition"></i>
                    <input type="text" placeholder="Search projects..."
                        class="pl-11 pr-4 py-2.5 border border-gray-200 bg-slate-50 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white w-72 transition-all">
                </div>
                <button
                    class="w-10 h-10 bg-white border border-gray-200 rounded-full flex items-center justify-center text-slate-600 hover:text-primary hover:border-primary transition shadow-sm">
                    <i class="fa-solid fa-gear"></i>
                </button>
            </div>
        </header>

        <div class="p-4 md:p-8 space-y-6 max-w-7xl mx-auto">
            {{ $slot }}
        </div>

    </main>

    <nav
        class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 px-6 py-2 flex justify-between items-center z-50 pb-safe shadow-[0_-5px_10px_rgba(0,0,0,0.02)]">
        <a href="#" class="flex flex-col items-center p-2 text-primary">
            <i class="fa-solid fa-house text-xl mb-1"></i>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="#" class="flex flex-col items-center p-2 text-slate-400 hover:text-slate-600 transition">
            <i class="fa-solid fa-magnifying-glass text-xl mb-1"></i>
            <span class="text-[10px] font-medium">Search</span>
        </a>
        <div class="relative -top-8">
            <button
                class="w-14 h-14 bg-primary rounded-2xl rotate-45 flex items-center justify-center text-white shadow-xl shadow-teal-500/40 border-4 border-slate-50 hover:scale-105 transition">
                <i class="fa-solid fa-plus -rotate-45 text-2xl"></i>
            </button>
        </div>
        <a href="#" class="flex flex-col items-center p-2 text-slate-400 hover:text-slate-600 transition">
            <i class="fa-regular fa-comment-dots text-xl mb-1"></i>
            <span class="text-[10px] font-medium">Chat</span>
        </a>
        <a href="#" class="flex flex-col items-center p-2 text-slate-400 hover:text-slate-600 transition">
            <i class="fa-regular fa-user text-xl mb-1"></i>
            <span class="text-[10px] font-medium">Profile</span>
        </a>
    </nav>

</body>

</html>
