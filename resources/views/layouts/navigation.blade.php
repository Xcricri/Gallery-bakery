<div class="space-y-6"> {{-- Jarak antar grup lebih rapat agar terlihat ringkas --}}

    {{-- Main Group --}}
    <div class="px-3">
        <!-- Label grup utama -->
        <label class="px-4 text-xs font-medium text-gray-400 dark:text-gray-500">
            Utama
        </label>
        <div class="mt-2 space-y-0.5">
            <!-- Link Dashboard -->
            <x-nav-link-sidebar :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="flex items-center px-4 py-2.5 text-sm transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 group">

                <!-- Icon Dashboard -->
                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>

                <!-- Label text -->
                <span class="ml-3 text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                    Dashboard
                </span>
            </x-nav-link-sidebar>

        </div>
    </div>

    {{-- Manage Group (hanya untuk member) --}}
    @if (Auth::user()->role === 'member')
    <div class="px-3">
        <!-- Label grup manajemen -->
        <label class="px-4 text-xs font-medium text-gray-400 dark:text-gray-500">
            Manajemen
        </label>
        <div class="mt-2 space-y-0.5">
            <!-- Link Galeri saya -->
            <x-nav-link-sidebar :href="route('galleries.index')" :active="request()->routeIs('galleries.*')"
                class="flex items-center px-4 py-2.5 text-sm transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 group">

                <!-- Icon Galeri -->
                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>

                <!-- Label text -->
                <span class="ml-3 text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                    Galeri saya
                </span>
            </x-nav-link-sidebar>
        </div>
    </div>
    @endif

    {{-- Admin Group (hanya untuk admin) --}}
    @if (Auth::user()->role === "admin")
    <div class="px-3">
        <!-- Label grup admin -->
        <label class="px-4 text-xs font-medium text-gray-400 dark:text-gray-500">
            Administrator
        </label>
        <div class="mt-2 space-y-0.5">
            <!-- Link Pengguna -->
            <x-nav-link-sidebar :href="route('users.index')" :active="request()->routeIs('users.*')"
                class="flex items-center px-4 py-2.5 text-sm transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 group">

                <!-- Icon Pengguna -->
                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>

                <!-- Label text -->
                <span class="ml-3 text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                    Pengguna
                </span>
            </x-nav-link-sidebar>

            <!-- Link Postingan -->
            <x-nav-link-sidebar :href="route('posts.index')" :active="request()->routeIs('posts.*')"
                class="flex items-center px-4 py-2.5 text-sm transition-colors rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 group">

                <!-- Icon Postingan -->
                <svg class="w-5 h-5 text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>

                <!-- Label text -->
                <span class="ml-3 text-gray-600 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white">
                    Postingan
                </span>
            </x-nav-link-sidebar>
        </div>
    </div>
    @endif
</div>
