<footer class="bg-white dark:bg-[#0f0f0f] border-t border-gray-100 dark:border-white/5 pt-16 pb-12 font-sans">
    <div class="mx-auto w-full max-w-screen-xl px-4 md:px-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12">

            {{-- Logo & Deskripsi --}}
            <div class="md:col-span-5">
                <a href="/" class="flex items-center space-x-3 mb-6 group">
                    <x-application-logo class="block h-8 w-auto opacity-80 group-hover:opacity-100 transition-opacity" />
                    <span class="text-xl font-light tracking-[0.2em] uppercase text-gray-900 dark:text-white">
                        {{ env('APP_NAME') }}
                    </span>
                </a>
                <p class="text-base text-gray-500 dark:text-gray-400 max-w-sm leading-relaxed font-light italic">
                    "Menciptakan kenangan manis di setiap momen."
                </p>
            </div>

            {{-- Links --}}
            <div class="md:col-span-7 grid grid-cols-2 gap-8 sm:grid-cols-3">
                <div>
                    <h2 class="mb-6 text-[11px] font-medium tracking-[0.3em] uppercase text-gray-400 dark:text-gray-500">
                        Sumber Daya
                    </h2>
                    <ul class="text-gray-600 dark:text-gray-300 space-y-4 text-xs tracking-widest uppercase">
                        <li>
                            <a href="https://www.hollandbakery.co.id/menu" target="_blank" class="hover:text-gray-400 transition-colors">E-Commerce</a>
                        </li>
                        <li>
                            <a href="https://www.hollandbakery.co.id/" target="_blank" class="hover:text-gray-400 transition-colors">Official Website</a>
                        </li>
                    </ul>
                </div>
                
                {{-- Media Sosial --}}
                <div>
                    <h2 class="mb-6 text-[11px] font-medium tracking-[0.3em] uppercase text-gray-400 dark:text-gray-500">
                        Media Sosial
                    </h2>
                    <ul class="text-gray-600 dark:text-gray-300 space-y-4 text-xs tracking-widest uppercase">
                        <li>
                            <a href="https://www.instagram.com/hollandbakeryindonesia?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" target="_blank" class="hover:text-gray-400 transition-colors">Instagram</a>
                        </li>
                        <li>
                            <a href="https://www.tiktok.com/@hollandbakerylpg?is_from_webapp=1&sender_device=pc" target="_blank" class="hover:text-gray-400 transition-colors">TikTok</a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/hollandbakery/" target="_blank" class="hover:text-gray-400 transition-colors">Facebook</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Tanggal dan Hak Cipta --}}
        <div class="mt-16 pt-8 border-t border-gray-100 dark:border-white/5 flex flex-col md:flex-row  items-center gap-4">
            <span class="text-[12px] tracking-[0.2em] uppercase text-gray-400 dark:text-gray-500">
                © {{ date('Y') }} {{ env('APP_NAME') }}..
            </span>
        </div>
    </div>
</footer>
