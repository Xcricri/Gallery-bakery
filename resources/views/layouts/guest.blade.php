<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/Olland-bakery.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-white dark:bg-[#0f0f0f] flex flex-col min-h-screen  text-gray-900 dark:text-gray-100">

    {{-- Navbar --}}
    <nav x-data="{ open: false }" {{-- State menu mobile --}}
        class="bg-white/90 dark:bg-[#0f0f0f]/90 backdrop-blur-md sticky top-0 z-[100] border-b border-gray-100 dark:border-white/5">

        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between p-4 md:px-12">

            <!-- Logo + Nama Aplikasi -->
            <a href="{{ route('welcome') }}" class="flex items-center space-x-4 group">
                <!-- Logo -->
                <x-application-logo class="w-10 h-auto text-gray-900 dark:text-white" />

                <!-- Nama aplikasi -->
                <div class="flex flex-col border-l border-gray-200 dark:border-white/10 pl-4">
                    <span class="text-lg font-bold">
                        {{ config('app.name') }}
                    </span>
                    <span class="text-[10px] tracking-[0.2em] opacity-60 mt-1 font-medium">
                        {{ env('APP_DESCRIPTION', 'Your App Tagline') }}
                    </span>
                </div>
            </a>

            <!-- Toggle Button Mobile -->
            <button @click="open = !open" {{-- Toggle menu --}} type="button"
                class="md:hidden p-2 rounded-md hover:bg-gray-100 dark:hover:bg-white/5 transition">

                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="1.5" d="M4 8h16M4 16h16" />

                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Menu Navigation -->
            <div :class="{ 'block': open, 'hidden': !open }" class="hidden w-full md:block md:w-auto">

                <ul
                    class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-10 mt-6 md:mt-0 uppercase tracking-[0.15em] text-[12px] font-semibold">

                    <!-- Home Menu -->
                    <li>
                        <a href="/"
                            class="transition-colors border-b-2
                            {{ Request::is('/')
                                ? 'border-gray-900 dark:border-white text-gray-900 dark:text-white'
                                : 'border-transparent hover:border-gray-400' }}">
                            Home
                        </a>
                    </li>

                    <!-- Jika belum login -->
                    @guest
                        <li>
                            <a href="{{ route('login') }}"
                                class="px-6 py-2 border border-gray-900 dark:border-white
                                hover:bg-gray-900 dark:hover:text-black
                                dark:hover:bg-white
                                hover:text-white
                                transition text-[11px]">
                                Login
                            </a>
                        </li>
                    @endguest

                    <!-- Jika sudah login -->
                    @auth
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2  transition">
                                <span class="w-2 h-2 bg-teal-500 rounded-full animate-pulse"></span>
                                Dashboard
                            </a>
                        </li>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <main class="flex-grow">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <x-footer />

</body>

</html>
