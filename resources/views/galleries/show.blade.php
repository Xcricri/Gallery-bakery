<x-app-layout>
    <div x-data="{
        modalOpen: false, // status modal foto
        activePhoto: null, // foto yang sedang dibuka di modal
        comments: [], // komentar foto aktif

        // fungsi membuka modal
        openModal(photo) {
            this.activePhoto = photo;
            this.comments = photo.comments || [];
            this.modalOpen = true;
            document.body.style.overflow = 'hidden';
        },

        // fungsi menutup modal
        closeModal() {
            this.modalOpen = false;
            this.activePhoto = null;
            document.body.style.overflow = 'auto';
        }
    }">

        {{-- Header halaman --}}
        <x-slot name="header">
            <div class="flex justify-between items-center gap-4">
                <h2 class="font-bold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $gallery->title }}</h2>
                <a href="{{ route('galleries.index') }}"
                    class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg> Kembali
                </a>
            </div>
        </x-slot>

        {{-- Konten utama --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                {{-- Info gallery --}}
                <div class="mb-8 text-center max-w-2xl mx-auto">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $gallery->title }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 leading-relaxed">{{ $gallery->description }}</p>
                </div>

                {{-- Cek apakah user owner --}}
                @php $isOwner = Auth::check() && Auth::id() == $gallery->user_id; @endphp

                {{-- Grid Pinterest-style --}}
                <div class="columns-1 sm:columns-2 md:columns-3 lg:columns-4 gap-4">
                    @forelse($photos as $photo)
                        <div
                            class="break-inside-avoid mb-4 relative group rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300">

                            {{-- Foto --}}
                            <img src="{{ asset('storage/' . $photo->file_path) }}" alt="{{ $gallery->title }}"
                                @click="openModal({{ json_encode($photo->load('comments.user')) }})"
                                class="w-full rounded-xl object-cover cursor-pointer transition-transform duration-500 hover:scale-105">

                            {{-- Overlay hover --}}
                            <div
                                class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 flex flex-col justify-between p-2 transition-opacity duration-300">

                                {{-- Stats: like & comment --}}
                                <div class="flex justify-between text-white text-xs font-bold">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        {{ $photo->likes_count }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                                        </svg>
                                        {{ $photo->comments_count }}
                                    </span>
                                </div>

                                {{-- Tombol hapus untuk owner --}}
                                @if ($isOwner)
                                    <form action="{{ route('galleries.photos.destroy', [$gallery->id, $photo->id]) }}"
                                        method="POST" onsubmit="return confirm('Hapus foto?');"
                                        class="mt-2 flex justify-end">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-600 text-white text-xs font-bold rounded-full hover:bg-red-700 transition shadow-lg">
                                            Hapus
                                        </button>
                                    </form>
                                @endif

                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 col-span-full">
                            <p class="text-gray-500 dark:text-gray-400">Belum ada foto.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-8 flex justify-center">{{ $photos->links() }}</div>
            </div>
        </div>

        {{-- Modal Foto (tetap sama, bisa dikembangkan) --}}
        <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70"
            style="display: none;">
            <div class="bg-white dark:bg-gray-900 p-4 rounded-lg max-w-3xl w-full relative">
                <button @click="closeModal()" class="absolute top-2 right-2 text-gray-600 dark:text-gray-300">X</button>
                <template x-if="activePhoto">
                    <img :src="'/storage/' + activePhoto.file_path" class="w-full h-auto rounded-lg">
                </template>
            </div>
        </div>

    </div>
</x-app-layout>
