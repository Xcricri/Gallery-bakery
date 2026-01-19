<x-app-layout>
    {{-- Header halaman: judul dan tombol "Buat Post Baru" --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            <div>
                {{-- Subjudul --}}
                <span class="text-xs font-medium text-gray-400 dark:text-gray-500 block mb-1">Content Management</span>
                {{-- Judul utama --}}
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    Manajemen Postingan
                </h2>
            </div>

            {{-- Tombol membuat post baru --}}
            <a href="{{ route('posts.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg font-medium text-sm transition-all hover:opacity-80 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Post Baru
            </a>
        </div>
    </x-slot>

    {{-- Konten utama --}}
    <div class="py-12" x-data="{ showDeleteModal: false, deleteUrl: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Grid postingan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @forelse ($posts as $post)
                    {{-- Card setiap post --}}
                    <div
                        class="group bg-white dark:bg-[#121212] rounded-2xl border border-gray-200 dark:border-white/5 shadow-sm hover:border-gray-900 dark:hover:border-white transition-all duration-500 relative flex flex-col h-full">

                        {{-- Header card: kategori + menu opsi --}}
                        <div class="px-6 pt-6 flex justify-between items-start">
                            {{-- Badge kategori --}}
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-md text-[9px] font-bold uppercase tracking-widest bg-gray-100 dark:bg-white/5 text-gray-600 dark:text-gray-400">
                                {{ $post->category->name }}
                            </span>

                            {{-- Menu opsi: detail, ubah status, edit, hapus --}}
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open"
                                    class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                    </svg>
                                </button>

                                {{-- Dropdown menu --}}
                                <div x-show="open" @click.away="open = false"
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#1a1a1a] rounded-xl shadow-2xl ring-1 ring-black ring-opacity-5 z-50 py-2 border border-gray-100 dark:border-white/10"
                                    style="display: none;">

                                    {{-- Link ke detail post --}}
                                    <a href="{{ route('posts.show', $post->id) }}"
                                        class="block px-4 py-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5">Detail</a>

                                    {{-- Ubah status publikasi --}}
                                    <a href="{{ route('posts.changeStatus', $post->id) }}"
                                        class="block px-4 py-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5">
                                        {{ $post->status == 'published' ? 'Arsipkan' : 'Publikasikan' }}
                                    </a>

                                    {{-- Edit post --}}
                                    <a href="{{ route('posts.edit', $post->id) }}"
                                        class="block px-4 py-2 text-xs font-bold uppercase tracking-widest text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5">Ubah</a>

                                    <hr class="my-1 border-gray-100 dark:border-white/5">

                                    {{-- Tombol hapus post --}}
                                    <button
                                        @click="showDeleteModal = true; deleteUrl = '{{ route('posts.destroy', $post->id) }}'; open = false"
                                        class="block w-full text-left px-4 py-2 text-xs font-bold uppercase tracking-widest text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Body card: judul dan status post --}}
                        <div class="p-6 flex-grow">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 duration-500">
                                {{ $post->name ?? ($post->title ?? 'Untitled Post') }}
                            </h3>

                            @if ($post->description)
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">
                                    {{ $post->description }}
                                </p>
                            @endif

                            {{-- Status post --}}
                            <div class="flex items-center">
                                <span
                                    class="flex items-center text-[10px] font-bold uppercase tracking-[0.15em] {{ strtolower($post->status) == 'published' ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">
                                    <span
                                        class="w-1.5 h-1.5 mr-2 rounded-full {{ strtolower($post->status) == 'published' ? 'bg-gray-900 dark:bg-white animate-pulse' : 'bg-gray-300 dark:bg-gray-700' }}"></span>
                                    {{ $post->status == 'published' ? 'Diterbitkan' : 'Draft' }}
                                </span>
                            </div>
                        </div>

                        {{-- Footer card: tombol kelola galeri --}}
                        <div class="px-6 pb-6">
                            <a href="{{ route('posts.addGalleries', $post->id) }}"
                                class="flex items-center justify-center w-full px-4 py-3 bg-gray-50 dark:bg-white/[0.03] text-gray-900 dark:text-white text-[10px] rounded-xl border border-transparent group-hover:border-gray-900 dark:group-hover:border-white transition-all duration-300">
                                <svg class="w-3.5 h-3.5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Kelola Galeri
                            </a>
                        </div>
                    </div>
                @empty
                    {{-- Jika tidak ada post --}}
                    <div
                        class="col-span-full py-24 text-center bg-gray-50/50 dark:bg-white/[0.02] rounded-3xl border-2 border-dashed border-gray-200 dark:border-white/5">
                        <p class="text-xs font-bold uppercase tracking-widest text-gray-400">Belum ada postingan yang
                            dibuat.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Modal konfirmasi hapus post --}}
        <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">

            <div class="bg-white dark:bg-[#121212] rounded-2xl shadow-2xl w-full max-w-sm p-8 border border-white/10"
                @click.away="showDeleteModal = false">
                <div class="text-center">
                    {{-- Icon hapus --}}
                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-50 dark:bg-red-500/10 mb-6">
                        <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>

                    {{-- Pesan konfirmasi --}}
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Hapus Konten?</h3>
                    <p class="mt-2 text-xs text-gray-500 ">Tindakan ini permanen. Seluruh galeri terkait akan ikut
                        terhapus.</p>

                    {{-- Tombol aksi --}}
                    <div class="mt-8 flex flex-col gap-3">
                        {{-- Form hapus --}}
                        <form :action="deleteUrl" method="POST" class="w-full">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-full py-3 bg-red-500 text-white text-[10px] font-bold uppercase tracking-[0.2em] rounded-xl hover:bg-red-600 transition shadow-lg shadow-red-500/20">
                                Konfirmasi Hapus
                            </button>
                        </form>

                        {{-- Tombol batal --}}
                        <button @click="showDeleteModal = false"
                            class="w-full py-3 bg-gray-100 dark:bg-white/5 text-gray-900 dark:text-white text-[10px] font-bold uppercase tracking-[0.2em] rounded-xl transition">
                            Batalkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
