@props([
    $title = 'Lokasi',
    $description = 'Kunjungi Toko Kami.',
    $address = 'Champ de Mars, 5 Avenue Anatole France, 75007 Paris, Prancis',
    $mapQuery = 'Menara Eiffel Paris',
    $mapZoom = 16,
]){{-- Menerima properti dari parent component --}}

<div class="mt-20 mb-10 font-sans">
    <div class="flex items-center gap-4 mb-10">
        <h3 class="text-xl md:text-2xl font-light tracking-[0.2em] uppercase text-gray-900 dark:text-white">
            {{ $title }}
        </h3>
        <div class="flex-1 h-[1px] bg-gray-200 dark:bg-white/10"></div>
    </div>

    <div class="flex flex-col md:flex-row-reverse gap-12 items-start">
        {{-- Map --}}
        <div class="relative h-96 w-full md:w-2/3 transition-all duration-700 ease-in-out border border-gray-100 dark:border-white/5 overflow-hidden shadow-2xl grayscale hover:grayscale-0">
            <iframe
                src="https://maps.google.com/maps?q={{ urlencode($mapQuery) }}&t=m&z={{ $mapZoom }}&output=embed&iwloc=near"
                width="100%" height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                class="absolute inset-0">
            </iframe>
        </div>

        <div class="w-full md:w-1/3 space-y-8">
            <div class="relative">
                {{-- Deskripsi --}}
                <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed font-light tracking-wide uppercase italic border-l-2 border-gray-200 dark:border-white/20 pl-6">
                    {{ $description }}
                </p>
            </div>

            <div class="pt-8 border-t border-gray-100 dark:border-white/5">
                <span class="block text-[10px] tracking-[0.4em] uppercase text-gray-400 dark:text-gray-500 mb-3 font-medium">
                    Alamat Resmi
                </span>

                {{-- Alamat --}}
                <h4 class="text-lg font-normal text-gray-800 dark:text-white leading-snug">
                    {{ $address }}
                </h4>

                {{-- Link Google Maps --}}
                <div class="mt-8">
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($address) }}"
                        target="_blank"
                        class="inline-flex items-center gap-3 text-gray-900 dark:text-white border-b border-gray-900/20 dark:border-white/20 pb-1 hover:border-gray-900 dark:hover:border-white transition-all text-xs tracking-widest uppercase">
                        Buka di Google Maps
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
