<x-app-layout>
    {{-- Header halaman --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            <div>
                {{-- Subjudul kecil --}}
                <span class="text-xs font-medium text-gray-400 dark:text-gray-500 block mb-1">Content Management</span>
                {{-- Judul utama halaman --}}
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    Manajemen Galeri
                </h2>
            </div>

            {{-- Tombol untuk membuat gallery baru --}}
            <a href="{{ route('galleries.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg font-medium text-sm transition-all hover:opacity-80 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Gallery Baru
            </a>
        </div>
    </x-slot>

    {{-- Konten utama --}}
    <div class="py-12" x-data="{ showDeleteModal: false, deleteUrl: '' }">
        <div class="max-w-[95%] mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Grid untuk menampilkan semua gallery --}}
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-12">
                @forelse ($galleries as $gallery)
                    <div class="relative group">

                        {{-- Tombol dropdown action (edit, add assets, delete) --}}
                        <div class="absolute -top-4 -right-2 z-30" x-data="{ open: false }">
                            <button @click.prevent="open = !open"
                                class="w-10 h-10 bg-white dark:bg-black border border-gray-100 dark:border-white/10 rounded-full flex items-center justify-center shadow-xl group-hover:border-black dark:group-hover:border-white transition-all">
                                {{-- Icon titik-titik --}}
                                <div class="space-y-0.5">
                                    <div class="w-1 h-1 bg-black dark:bg-white rounded-full"></div>
                                    <div class="w-1 h-1 bg-black dark:bg-white rounded-full"></div>
                                </div>
                            </button>

                            {{-- Menu dropdown --}}
                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                class="absolute right-0 mt-2 w-48 bg-black dark:bg-white text-white dark:text-black rounded-2xl shadow-2xl py-3 z-40 overflow-hidden"
                                style="display: none;">
                                <a href="{{ route('galleries.photos.create', $gallery->id) }}"
                                    class="block px-6 py-2 text-[9px] font-black uppercase tracking-widest hover:opacity-50 transition">Add
                                    Assets</a>
                                <a href="{{ route('galleries.edit', $gallery->id) }}"
                                    class="block px-6 py-2 text-[9px] font-black uppercase tracking-widest hover:opacity-50 transition">Edit
                                    Collection</a>
                                <button
                                    @click="showDeleteModal = true; deleteUrl = '{{ route('galleries.destroy', $gallery->id) }}'; open = false"
                                    class="block w-full text-left px-6 py-2 text-[9px] font-black uppercase tracking-widest text-red-500 hover:opacity-50 transition">Purge
                                    Archive</button>
                            </div>
                        </div>

                        {{-- Card gallery --}}
                        <a href="{{ route('galleries.show', $gallery->id) }}" class="block space-y-6">

                            {{-- Gambar gallery, lebih lebar dan lebih pendek --}}
                            <div
                                class="relative overflow-hidden rounded-sm bg-gray-50 dark:bg-white/[0.02] aspect-[16/9]">
                                <img src="{{ asset('storage/' . $gallery->cover) }}" alt="{{ $gallery->title }}"
                                    class="w-full ease-out">

                                {{-- Overlay tahun --}}
                                <div class="absolute top-6 left-6">
                                    <span
                                        class="text-[40px] font-black text-white/20 dark:text-white/10 tracking-tighter italic">
                                        {{ $gallery->created_at->format('y') }}
                                    </span>
                                </div>
                            </div>

                            {{-- Judul & deskripsi gallery --}}
                            <div class="relative pr-8">
                                {{-- garis horizontal --}}
                                <div class="flex items-baseline gap-4 mb-2">
                                    <div class="h-px flex-1 bg-gray-100 dark:bg-white/5"></div>
                                </div>

                                {{-- Judul gallery --}}
                                <h3
                                    class="text-2xl font-black text-gray-900 dark:text-white uppercase tracking-tighter leading-none group-hover:ml-4 transition-all duration-500">
                                    {{ $gallery->title }}
                                </h3>

                                {{-- Deskripsi singkat --}}
                                <p
                                    class="mt-4 text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-widest leading-relaxed line-clamp-2 max-w-[80%]">
                                    {{ $gallery->description ?? 'No metadata provided for this visual archive.' }}
                                </p>

                                {{-- Indikator aksi saat hover --}}
                                <div
                                    class="mt-6 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-all duration-500 translate-x-[-10px] group-hover:translate-x-0">
                                    <div class="w-8 h-px bg-black dark:bg-white"></div>
                                    <span
                                        class="text-[9px] font-black uppercase tracking-[0.3em] text-black dark:text-white">
                                        View Project</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    {{-- Jika tidak ada gallery --}}
                    <div
                        class="col-span-full py-40 flex flex-col items-center justify-center border border-dashed border-gray-200 dark:border-white/10 rounded-[4rem]">
                        <span class="text-[10px] font-black uppercase tracking-[0.5em] text-gray-300">Tidak ada Galeri disini</span>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-20">
                {{ $galleries->links() }}
            </div>
        </div>

        {{-- Modal konfirmasi hapus gallery --}}
        <div x-show="showDeleteModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-white/90 dark:bg-black/95 backdrop-blur-xl">
            <div class="text-center max-w-sm p-8">
                <h3 class="text-3xl font-black uppercase tracking-tighter text-black dark:text-white">Konfirmasi Penghapusan</h3>
                <p class="mt-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] leading-relaxed">Arsip ini akan dihapus secara permanen.</p>
                <div class="mt-10 space-y-4">
                    {{-- Form hapus --}}
                    <form :action="deleteUrl" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full py-4 bg-red-600 text-white font-black text-[10px] uppercase tracking-widest hover:bg-black transition-colors">Hapus</button>
                    </form>
                    {{-- Tombol batal --}}
                    <button @click="showDeleteModal = false"
                        class="w-full py-4 border border-black/10 dark:border-white/10 font-black text-[10px] uppercase tracking-widest">batal</button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
