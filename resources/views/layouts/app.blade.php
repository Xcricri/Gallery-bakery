<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('img/Olland-bakery.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="font-sans antialiased transition-colors duration-300 bg-white text-gray-900 dark:bg-[#121212] dark:text-gray-200">
    <div x-data="{ sidebarOpen: window.innerWidth >= 1024 }" class="min-h-screen relative flex">

        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 transition-all duration-300 transform bg-gray-50 border-r border-gray-200 shadow-sm dark:bg-[#0a0a0a] dark:border-white/10 dark:shadow-2xl"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            {{-- Logo --}}
            <div
                class="flex items-center justify-between h-20 px-6 border-b border-gray-200 bg-gray-50 dark:border-white/5 dark:bg-[#0a0a0a]">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('img/Olland-bakery.png') }}" class="h-7 w-auto" alt="Logo">
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
                </a>

                <button @click="sidebarOpen = false"
                    class="lg:hidden text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Menu Navigasi --}}
            <nav class="p-4 space-y-2 overflow-y-auto h-[calc(100vh-5rem)]">
                @include('layouts.navigation')
            </nav>
        </aside>

        {{-- Main Wrapper --}}
        <div class="flex flex-col min-h-screen w-full transition-all duration-300 ease-in-out"
            :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-0'">

            {{-- Header --}}
            <header
                class="sticky top-0 z-40 flex items-center justify-between px-8 py-4 bg-white/80 backdrop-blur-xl border-b border-gray-200 dark:bg-[#121212]/80 dark:border-white/5">

                <div class="flex items-center gap-6">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
                        {{-- Hamburger Icon --}}
                        <svg x-show="!sidebarOpen" class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        {{-- Close Icon --}}
                        <svg x-show="sidebarOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <div class="hidden sm:block">
                        <h1 class="text-2xl text-gray-900 dark:text-white uppercase">{{ $header }}</h1>
                    </div>
                </div>

                {{-- Right Side Header --}}
                <div class="flex items-center gap-6">
                    {{-- User Menu --}}
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-4 focus:outline-none group">
                            <div class="text-right hidden md:block">
                                <div
                                    class="text-xs font-semibold text-gray-900 dark:text-white uppercase group-hover:opacity-70 transition">
                                    {{ Auth::user()->name ?? 'User' }}
                                </div>
                                <div class="text-[10px] text-gray-500 uppercase tracking-tighter">
                                    {{ Auth::user()->role }}</div>
                            </div>
                            <img class="h-10 w-10 rounded-full border border-gray-200 dark:border-white/10 transition duration-500"
                                src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'U') . '&background=1a1a1a&color=fff' }}"
                                alt="Avatar">
                        </button>

                        <div x-show="open" @click.away="open = false"
                            x-transition:enter="transition ease-out duration-150"
                            class="absolute right-0 w-48 mt-3 bg-white border border-gray-200 rounded-md shadow-xl py-2 z-50 dark:bg-[#1a1a1a] dark:border-white/10">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-xs uppercase tracking-widest text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white">Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-xs uppercase tracking-widest text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main Content --}}
            <main class="flex-1">
                <div class="px-8 pt-10 pb-6">
                    <div class="mb-8">
                        <x-alert></x-alert>
                    </div>

                    <div class="text-gray-700 dark:text-gray-300">
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>

        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden transition-opacity dark:bg-black/70"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" style="display: none;">
        </div>
    </div>
</body>

</html>
