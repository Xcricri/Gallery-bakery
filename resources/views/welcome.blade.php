<x-guest-layout>
    <x-state>
        <section class="dark:costum-dark dark:text-gray-200 px-4 md:px-20 py-8 flex-grow min-h-screen">

            {{-- Slider --}}
            <x-slider :post="$post1" />

            {{-- History --}}
            <div
                class="w-full h-screen py-12 bg-white dark:bg-[#0a0a0a] border-y border-gray-100 dark:border-white/[0.05] flex flex-col justify-center">
                <div class="max-w-4xl mx-auto px-6">
                    <div class="grid grid-cols-3 gap-8">

                        <div class="flex flex-col items-center group">
                            <div
                                class="w-16 h-16 mb-4 flex items-center justify-center border border-gray-100 dark:border-white/10 group-hover:border-black dark:group-hover:border-white transition-all duration-700 rotate-45 group-hover:rotate-0">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-6 h-6 -rotate-45 group-hover:rotate-0 transition-all duration-700 text-gray-400 group-hover:text-black dark:group-hover:text-white"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-8a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8" />
                                    <path d="M4 16s.5-1 2-1 2.5 2 4 2 2.5-2 4-2 2.5 2 4 2 2-1 2-1" />
                                    <path d="M2 21h20" />
                                    <path d="M7 8v3" />
                                    <path d="M12 8v3" />
                                    <path d="M17 8v3" />
                                    <path d="M7 4h.01" />
                                    <path d="M12 4h.01" />
                                    <path d="M17 4h.01" />
                                </svg>
                            </div>
                            <span
                                class="text-[10px] font-black uppercase tracking-[0.5em] text-gray-300 group-hover:text-black dark:group-hover:text-white transition-colors">Seni
                                Makanan</span>
                        </div>

                        <div class="flex flex-col items-center group">
                            <div
                                class="w-16 h-16 mb-4 flex items-center justify-center border border-gray-100 dark:border-white/10 group-hover:border-black dark:group-hover:border-white transition-all duration-700 -rotate-12 group-hover:rotate-0">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-6 h-6 rotate-12 group-hover:rotate-0 transition-all duration-700 text-gray-400 group-hover:text-black dark:group-hover:text-white"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                                    <circle cx="9" cy="9" r="2" />
                                    <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                                </svg>
                            </div>
                            <span
                                class="text-[10px] font-black uppercase tracking-[0.5em] text-gray-300 group-hover:text-black dark:group-hover:text-white transition-colors">Arsip
                                Seni</span>
                        </div>

                        <div class="flex flex-col items-center group">
                            <div
                                class="w-16 h-16 mb-4 flex items-center justify-center border border-gray-100 dark:border-white/10 group-hover:border-black dark:group-hover:border-white transition-all duration-700 scale-90 group-hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-6 h-6 text-gray-400 group-hover:text-black dark:group-hover:text-white transition-colors"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M7 21h10" />
                                    <path d="M9 21v-2a3 3 0 0 1 6 0v2" />
                                    <path d="M9 11h6" />
                                    <path d="M12 21l3-18h-6l3 18Z" />
                                    <path d="M12 3v2" />
                                </svg>
                            </div>
                            <span
                                class="text-[10px] font-black uppercase tracking-[0.5em] text-gray-300 group-hover:text-black dark:group-hover:text-white transition-colors">Warisan
                                Budaya</span>
                        </div>

                        <div class="text-center mt-5 col-span-3">
                            <h2 class="text-2xl font-bold mb-2">Olland Bakery</h2>
                            <p class="italic font-light">
                                Menciptakan kenangan manis di setiap momen.

                        </div>
                    </div>
                </div>
            </div>

            {{-- Dua kolom: Agenda & Informasi Terkini --}}
            <div class="flex flex-col md:flex-row gap-8 mt-14">

                {{-- Kiri: Agenda --}}
                <div class="w-full md:w-1/2">
                    <x-agenda :calendars="$calendars" />
                </div>

                {{-- Kanan: Informasi Terkini --}}
                <div class="w-full md:w-1/2">
                    <x-informasi-terkini :posts="$posts" />
                </div>

            </div>

            {{-- 3. Map / lokasi --}}
            <x-location-card />

        </section>

        {{-- 4. Modal Gallery --}}
        <x-gallery-modal :currentUser="Auth::user()" />
    </x-state>
</x-guest-layout>
