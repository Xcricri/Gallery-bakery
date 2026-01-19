<div class="mt-20 group">
    <!-- Wrapper utama: layout fleksibel (kolom di mobile, baris di desktop) -->
    <div class="flex flex-col lg:flex-row gap-12 items-center">

        {{-- Image Section: Frame gambar utama --}}
        <div
            class="w-full lg:w-3/5 h-[400px] md:h-[500px] rounded-[3rem] overflow-hidden shadow-2xl group/img cursor-pointer relative bg-gray-100 dark:bg-black"
            {{-- Klik gambar membuka modal galeri --}}
            @click="openModal({{ $photosJson }}, '{{ $title }}')"
        >

            {{-- Overlay profesional (hover / mobile) --}}
            <div class="absolute inset-0 bg-black/40 lg:bg-black/0 lg:group-hover/img:bg-black/40 transition-all duration-700 z-10 flex items-center justify-center">
                <!-- Konten overlay (ikon + teks) -->
                <div class="flex flex-col items-center gap-4 opacity-100 lg:opacity-0 lg:group-hover/img:opacity-100 transition-all duration-500 transform lg:translate-y-8 lg:group-hover/img:translate-y-0">
                    <!-- Ikon zoom -->
                    <div class="w-16 h-16 rounded-full border border-white/30 backdrop-blur-md flex items-center justify-center text-white">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </div>
                    <!-- Teks overlay -->
                    <span class="text-[10px] font-black text-white uppercase tracking-[0.4em]">
                        Expand Collection
                    </span>
                </div>
            </div>

            {{-- Gambar utama dengan efek zoom & grayscale --}}
            <img
                src="{{ $image }}"
                alt="{{ $title }}"
                class="w-full h-full object-cover transition transform scale-[1.02] group-hover/img:scale-110 duration-[2s] ease-out grayscale group-hover/img:grayscale-0"
            >

            {{-- Label kategori (hanya tampil di mobile) --}}
            <div class="absolute bottom-8 left-8 z-20 lg:hidden">
                <span class="px-4 py-2 bg-white/10 backdrop-blur-md border border-white/10 text-white text-[9px] font-black uppercase tracking-widest rounded-full">
                    {{ $post->category->name ?? 'Archive' }}
                </span>
            </div>
        </div>

        {{-- Content Section: teks & informasi --}}
        <div class="w-full lg:w-2/5 space-y-8 px-4 lg:px-0">
            <div>
                <!-- Bar kategori -->
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.4em]">
                        {{ $post->category->name ?? 'Category Index' }}
                    </span>
                    <div class="h-px flex-1 bg-gray-100 dark:bg-white/5"></div>
                </div>

                <!-- Judul koleksi -->
                <h3
                    class="text-4xl md:text-5xl font-black mb-6 text-gray-900 dark:text-white cursor-pointer tracking-tighter leading-tight hover:italic transition-all duration-300"
                    {{-- Klik judul juga membuka modal --}}
                    @click="openModal({{ $photosJson }}, '{{ $title }}')"
                >
                    {{ $title }}
                </h3>

                <div class="relative">
                    {{-- Garis dekoratif di kiri (desktop only) --}}
                    <div class="absolute -left-6 top-0 bottom-0 w-1 bg-gray-100 dark:bg-white/5 hidden lg:block"></div>

                    <!-- Deskripsi singkat (dibatasi 250 karakter) -->
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed text-sm font-medium tracking-wide text-justify italic uppercase md:normal-case">
                        {{ \Illuminate\Support\Str::limit($desc, 250) }}
                    </p>
                </div>
            </div>

            {{-- Tombol aksi membuka modal --}}
            <button
                @click="openModal({{ $photosJson }}, '{{ $title }}')"
                class="inline-flex items-center gap-6 group/btn"
            >
                <!-- Ikon panah -->
                <div class="w-12 h-12 rounded-full border border-black dark:border-white flex items-center justify-center group-hover/btn:bg-black dark:group-hover/btn:bg-white transition-all duration-500">
                    <svg class="w-5 h-5 text-black dark:text-white group-hover/btn:text-white dark:group-hover/btn:text-black transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>
                <!-- Label tombol -->
                <span class="text-[11px] font-black uppercase tracking-[0.3em] text-gray-900 dark:text-white">
                    Full Perspective
                </span>
            </button>
        </div>

    </div>
</div>
