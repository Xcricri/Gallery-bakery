@props(['calendars' => null])

<div class="w-full font-sans">
    {{-- Header Agenda --}}
    <div class="flex items-center gap-4 mb-8">
        <h3 class="text-xl md:text-2xl font-light tracking-[0.2em] uppercase text-gray-900 dark:text-white">
            Agenda Kegiatan
        </h3>
        <div class="flex-1 h-[1px] bg-gray-200 dark:bg-white/10"></div>
    </div>

    <div class="space-y-6">
        @forelse ($calendars ?? [] as $agenda)
            @php
                $gallery = $agenda->galleries->first();
                $startDate = \Carbon\Carbon::parse($gallery->start_time ?? $agenda->created_at);
                $endDate = \Carbon\Carbon::parse($gallery->end_time ?? $agenda->created_at);
                $photos = $gallery
                    ? $gallery->photos->map(
                        fn($p) => [
                            'src' => asset($p->file_path),
                            'description' => $p->description,
                        ],
                    )
                    : collect([]);
                $cover =
                    $gallery && $gallery->cover
                        ? asset('storage/' . $gallery->cover)
                        : 'https://dummyimage.com/1200x800/1a1a1a/ffffff&text=Agenda';
                $title = $agenda->title ?? ($gallery->title ?? 'Agenda');
                $description = $gallery->description ?? 'Detail agenda tidak tersedia.';
            @endphp

            {{-- Card agenda --}}
            <div class="group flex bg-white dark:bg-[#1a1a1a] border border-gray-100 dark:border-white/5 overflow-hidden cursor-pointer transition-all duration-300 hover:border-gray-400 dark:hover:border-white/30"
                x-data
                @click="$dispatch('open-info-modal', {
                    title: '{{ $title }}',
                    description: '{{ $description }}',
                    images: {{ $photos->toJson() }}
                })">
                {{-- Tanggal kiri --}}
                <div
                    class="w-20 md:w-24 bg-gray-50 dark:bg-white/5 flex flex-col items-center justify-center border-r border-gray-100 dark:border-white/5 py-4">
                    <span
                        class="text-[10px] tracking-[0.3em] uppercase text-gray-400 dark:text-gray-200 mb-1">{{ $startDate->format('M') }}</span>
                    <span
                        class="text-2xl md:text-3xl font-light text-gray-800 dark:text-white">{{ $startDate->format('d') }}</span>
                    <span class="text-[10px] text-gray-400 mt-1">{{ $startDate->format('Y') }}</span>
                </div>

                {{-- Konten kanan --}}
                <div class="p-5 flex-1 flex flex-col justify-center">
                    <h4
                        class="font-medium text-gray-900 dark:text-white text-lg group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors">
                        {{ $title }}
                    </h4>
                    <p
                        class="text-xs text-gray-500 dark:text-gray-400 mt-2 line-clamp-1 font-light tracking-wide uppercase italic">
                        {{ $description }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 line-clamp-2 font-light tracking-wide">
                        Agenda berlangsung dari {{ $startDate->format('d M Y') }} hingga {{ $endDate->format('d M Y') }}
                    </p>
                    <div
                        class="mt-4 flex items-center gap-2 text-[10px] tracking-widest uppercase text-gray-400 group-hover:text-teal-600 dark:group-hover:text-white transition-all">
                        <span>Lihat Dokumentasi</span>
                        <svg class="w-3 h-3 transform group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-20 border border-dashed border-gray-200 dark:border-white/10 text-center">
                <p class="text-gray-400 font-light tracking-[0.2em] uppercase text-xs">
                    Belum ada agenda kegiatan
                </p>
            </div>
        @endforelse
    </div>
</div>

{{-- Modal gallery tunggal untuk Informasi & Agenda --}}
<div x-data="{ open: false, images: [], current: 0, title: '', description: '' }"
    x-on:open-info-modal.window="
        images = $event.detail.images;
        title = $event.detail.title;
        description = $event.detail.description;
        current = 0;
        open = true;
    "
    x-show="open" class="fixed inset-0 bg-black/95 flex items-center justify-center z-[100] p-4" x-transition>
    <div class="relative max-w-5xl w-full flex flex-col items-center">

        {{-- Tombol close --}}
        <button @click="open = false" class="absolute -top-12 right-0 text-white/50 hover:text-white transition-colors">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Gambar aktif --}}
        <img :src="images[current]?.src" class="max-h-[75vh] object-contain shadow-2xl">

        {{-- Caption --}}
        <div class="mt-6 text-center text-white">
            <h3 class="text-lg font-light tracking-widest uppercase mb-2" x-text="title"></h3>
            <p x-text="images[current]?.description || description" class="text-white/60 text-xs italic font-light"></p>
        </div>

        {{-- Navigasi kiri kanan --}}
        <template x-if="images.length > 1">
            <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex justify-between px-4 pointer-events-none">
                <button @click="current = (current - 1 + images.length) % images.length"
                    class="pointer-events-auto text-white/20 hover:text-white transition-all">
                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="current = (current + 1) % images.length"
                    class="pointer-events-auto text-white/20 hover:text-white transition-all">
                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </template>
    </div>
</div>
