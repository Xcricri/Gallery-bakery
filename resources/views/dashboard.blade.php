<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Galeri Olland Bakery
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Halo, {{ Auth::user()->name }}! 
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Grid Container --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($galleries as $gallery)
                    <a href="{{ route('galleries.show', $gallery->id) }}"
                        class="group block bg-white dark:bg-black/40 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-200">
                        {{-- Cover Image --}}
                        @php
                            $coverImage = $gallery->cover
                                ? asset('storage/' . $gallery->cover)
                                : 'https://dummyimage.com/600x400/ccc/fff&text=No+Image';
                        @endphp
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ $coverImage }}" alt="{{ $gallery->title }}"
                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 dark:group-hover:scale-105">
                            <div class="absolute top-3 right-3 bg-black/40 text-white text-xs px-2 py-1 rounded-full">
                                {{ $gallery->photos_count ?? $gallery->photos->count() }} Foto
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-4">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 group-hover:text-indigo-600 truncate">
                                {{ $gallery->title }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                {{ $gallery->description }}
                            </p>

                            {{-- Footer --}}
                            <div class="mt-3 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <img src="{{ $gallery->user->avatar ? asset('storage/' . $gallery->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($gallery->user->name) . '&background=random' }}"
                                        class="w-6 h-6 rounded-full object-cover">
                                    <span class="text-xs text-gray-600 dark:text-gray-400">{{ $gallery->user->name }}</span>
                                </div>
                                <span class="text-xs text-indigo-600 dark:text-indigo-400 font-medium group-hover:underline">
                                    Lihat Album &rarr;
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    {{-- Jika kosong --}}
                    <div class="col-span-1 sm:col-span-2 lg:col-span-3 mt-10 text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Belum ada galeri</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Nantikan dokumentasi kegiatan terbaru segera.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $galleries->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
