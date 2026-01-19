@props(['posts']) {{-- Sekarang menerima collection posts --}}

<div class="w-full font-sans">
    {{-- Header Section --}}
    <div class="flex items-center gap-4 mb-8">
        <h3 class="text-xl md:text-2xl font-light tracking-[0.2em] uppercase text-gray-900 dark:text-white">
            Informasi Terkini
        </h3>
        <div class="flex-1 h-[1px] bg-gray-200 dark:bg-white/10"></div>
    </div>

    <div class="space-y-8">
        @forelse ($posts as $post)
            @if ($post && $post->galleries->first())
                @php
                    $gallery = $post->galleries->first();
                    $photos = $gallery->photos->map(fn ($photo) => [
                        'src' => asset($photo->file_path),
                        'description' => $photo->description,
                    ]);
                    $cover = $gallery->cover
                        ? asset('storage/' . $gallery->cover)
                        : 'https://dummyimage.com/1200x800/1a1a1a/ffffff&text=Information';
                    $title = $post->title ?? 'Informasi';
                    $description = $post->description ?? 'Tidak ada deskripsi tersedia.';
                @endphp

                <div
                    class="group relative bg-[#1a1a1a] overflow-hidden cursor-pointer"
                    x-data
                    @click="$dispatch('open-info-modal', {
                        title: '{{ $title }}',
                        description: '{{ $description }}',
                        images: {{ $photos->toJson() }}
                    })"
                >
                    <div class="relative h-[400px] w-full overflow-hidden">
                        <img src="{{ $cover }}"
                            class="w-full h-full object-cover grayscale-[30%]
                                group-hover:grayscale-0 group-hover:scale-105
                                transition-all duration-700 ease-in-out">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
                    </div>

                    <div class="absolute bottom-0 left-0 w-full p-8 md:p-12 transition-transform duration-500">
                        <h2 class="text-2xl md:text-4xl font-light text-white mb-4 leading-tight tracking-tight uppercase">
                            {{ $title }}
                        </h2>

                        <div class="max-w-xl">
                            <p class="text-gray-300 font-light leading-relaxed line-clamp-2 mb-6
                                    opacity-0 group-hover:opacity-100
                                    transition-opacity duration-500 text-xl">
                                {{ $description }}
                            </p>
                        </div>

                        <div class="inline-flex items-center gap-2 text-white text-[10px]
                                    tracking-[0.3em] uppercase border-b border-white/20 pb-1
                                    group-hover:border-white transition-all">
                            Baca Selengkapnya
                            <svg class="w-3 h-3 transform group-hover:translate-x-1 transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @endif
        @empty
            <div class="py-20 border border-dashed border-gray-200 dark:border-white/10 text-center">
                <p class="text-gray-400 font-light tracking-[0.2em] uppercase text-xs">
                    Belum ada informasi terbaru
                </p>
            </div>
        @endforelse
    </div>
</div>

{{-- Modal Gallery --}}
<div
    x-data="{ open: false, images: [], current: 0, title: '' }"
    x-on:open-info-modal.window="
        images = $event.detail.images;
        title = $event.detail.title;
        current = 0;
        open = true;
    "
    x-show="open"
    class="fixed inset-0 bg-black/95 flex items-center justify-center z-[100] p-4"
    x-transition
    class="hidden"
>
    <div class="relative max-w-5xl w-full flex flex-col items-center">
        <button @click="open = false"
                class="absolute -top-12 right-0 text-white/50 hover:text-white transition-colors">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <img :src="images[current]?.src" class="max-h-[75vh] object-contain shadow-2xl">

        <div class="mt-6 text-center text-white">
            <h3 class="text-lg font-light tracking-widest uppercase mb-2" x-text="title"></h3>
            <p x-text="images[current]?.description"
                class="text-white/60 text-xs italic font-light"></p>
        </div>

        <template x-if="images.length > 1">
            <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex justify-between px-4 pointer-events-none">
                <button @click="current = (current - 1 + images.length) % images.length"
                        class="pointer-events-auto text-white/20 hover:text-white transition-all">
                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="current = (current + 1) % images.length"
                        class="pointer-events-auto text-white/20 hover:text-white transition-all">
                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </template>
    </div>
</div>
