@php
    // Mengecek apakah $post ada dan memiliki galeri
    $hasSlides = $post && $post->galleries->count() > 0;

    // Menentukan jumlah slide, jika tidak ada galeri, set ke 1
    $totalSlides = $hasSlides ? $post->galleries->count() : 1;
@endphp

<!-- Container utama carousel -->
<div x-data="{
    activeSlide: 0, // Slide aktif saat ini (index)
    totalSlides: {{ $totalSlides }}, // Total jumlah slide
    timer: null, // Variabel untuk interval auto-slide
    next() { this.activeSlide = (this.activeSlide === this.totalSlides - 1) ? 0 : this.activeSlide + 1; }, // Fungsi next slide
    prev() { this.activeSlide = (this.activeSlide === 0) ? this.totalSlides - 1 : this.activeSlide - 1; }, // Fungsi prev slide
    startAuto() { this.timer = setInterval(() => this.next(), 6000); }, // Mulai auto-slide tiap 6 detik
    stopAuto() { clearInterval(this.timer); } // Stop auto-slide
}" x-init="startAuto()" @mouseenter="stopAuto()" @mouseleave="startAuto()"
class="relative w-full h-[500px] md:h-[600px] overflow-hidden bg-[#1a1a1a] font-sans">

    <div class="relative w-full h-full">
        @if ($hasSlides)
            @foreach ($post->galleries as $index => $gallery)
                @php
                    // Load foto-foto galeri dengan hitungan likes dan comments
                    $gallery->load(['photos' => function ($q) {
                        $q->with(['comments'])->withCount(['likes', 'comments']);
                    }]);

                    $title = $gallery->title; // Judul galeri
                    $image = $gallery->cover ? asset('storage/' . $gallery->cover) : 'https://dummyimage.com/1200x800/1a1a1a/1f1f1f1f&text=No+Cover'; // Gambar cover atau default
                    $category = $post->category->name ?? 'Exhibition'; // Nama kategori atau default
                    $photosJson = json_encode($gallery->photos); // Foto-foto galeri dalam format JSON
                @endphp

                {{-- Slide --}}
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                    x-show="activeSlide === {{ $index }}"
                    x-transition:enter="transition opacity-0 duration-1000"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition opacity-100 duration-1000"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">

                    <!-- Overlay gelap -->
                    <div class="absolute inset-0 bg-black/40 z-10"></div>

                    <!-- Gambar background slide -->
                    <img src="{{ $image }}" class="absolute block w-full h-full rounded-xl object-cover grayscale-[10%]" alt="{{ $title }}">

                    <!-- Konten slide (judul, kategori, tombol galeri) -->
                    <div class="relative z-20 h-full max-w-7xl mx-auto px-6 md:px-12 flex flex-col justify-center items-start">
                        <div class="flex items-center gap-4 mb-4">
                            <span class="text-white/80 uppercase tracking-[0.2em] text-xs font-medium">{{ $category }}</span>
                            <div class="h-[1px] w-12 bg-white/40"></div>
                        </div>

                        <h2 class="text-white text-4xl md:text-6xl font-light tracking-tight leading-tight max-w-2xl mb-8 uppercase">
                            {{ $title }}
                        </h2>
                        
                        <!-- Tombol untuk membuka modal galeri -->
                        <button @click="openModal({{ $photosJson }}, '{{ addslashes($title) }}')"
                            class="group flex items-center gap-3 text-white border-b border-white/30 pb-1 hover:border-white transition-all duration-300">
                            <span class="uppercase tracking-widest text-xs">Lihat Galeri</span>
                            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Kontrol slide (prev/next dan indikator) -->
    <div class="absolute bottom-10 right-6 md:right-12 z-30 flex items-center gap-6 text-white">
        <button @click="prev()" class="hover:opacity-50 transition-opacity"> <!-- Tombol previous -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"/></svg>
        </button>

        <!-- Indikator slide saat ini / total slide -->
        <div class="flex items-center font-light tracking-widest text-sm">
            <span x-text="activeSlide + 1"></span>
            <span class="mx-2 opacity-30">/</span>
            <span x-text="totalSlides" class="opacity-50"></span>
        </div>

        <button @click="next()" class="hover:opacity-50 transition-opacity"> <!-- Tombol next -->
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
        </button>
    </div>

</div>
