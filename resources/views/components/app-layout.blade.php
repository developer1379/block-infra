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

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            [x-cloak] { display: none !important; }
            /* Smooth scrolling */
            html { scroll-behavior: smooth; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen flex flex-col">

            <nav class="bg-white border-b border-gray-200 px-6 py-3 sticky top-0 z-40">
                <div class="max-w-7xl mx-auto flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="h-8 w-8 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                            C
                        </div>
                        <span class="font-bold text-xl text-gray-800 tracking-tight">Contractor<span class="text-indigo-600">Portal</span></span>
                    </div>

                    <div class="flex items-center gap-6">
                        <span class="text-sm font-medium text-gray-500 hidden sm:block">
                            Welcome, {{ Auth::user()->name ?? 'Contractor' }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-4 py-2 rounded-lg transition-colors">
                                <i class="bi bi-box-arrow-right mr-1"></i> Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <main class="flex-1">
                {{-- Flash Messages (Success/Error) --}}
                @if (session('success'))
                    <div class="max-w-7xl mx-auto mt-6 px-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)">
                        <div class="bg-green-100 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center shadow-sm">
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

                {{-- The Content Slot --}}
                {{ $slot }}
            </main>

            <footer class="bg-white border-t border-gray-200 mt-auto py-6">
                <div class="max-w-7xl mx-auto px-6 text-center text-sm text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </div>
            </footer>
        </div>
    </body>
</html>
