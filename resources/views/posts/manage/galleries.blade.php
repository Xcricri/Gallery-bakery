<x-app-layout>
    <!-- Slot header halaman -->
    <x-slot name="header">
        <div class="flex justify-between items-end gap-5">
            <div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-gray-500 block mb-1">Curation</span>
                <h2 class="text-2xl text-gray-900 dark:text-white">
                    Kelola Galeri Postingan
                </h2>
            </div>

            <!-- Tombol kembali ke daftar posting -->
            <a href="{{ route('posts.index') }}"
                class="group flex items-center gap-2 text-[10px] uppercase tracking-[0.2em] text-gray-500 hover:text-black dark:hover:text-white transition-all">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <!-- Konten utama halaman -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Form untuk menambahkan gallery ke postingan -->
            <form action="{{ route('posts.storeGalleries', $post->id) }}" method="POST">
                @csrf 

                <div
                    class="bg-white dark:bg-[#0a0a0a] overflow-hidden shadow-sm border border-gray-100 dark:border-white/5 p-8">

                    <!-- Header form/pengantar -->
                    <div class="mb-10 border-l-2 border-gray-900 dark:border-white pl-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pilih Koleksi</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Lampirkan karya seni atau foto ke dalam postingan ini. Klik pada kartu untuk memilih.
                        </p>
                    </div>

                    <!-- Grid gallery -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-h-[60vh] overflow-y-auto pr-2 ">
                        @forelse ($galleries as $gallery)
                            <!-- Setiap gallery sebagai checkbox card -->
                            <label class="relative cursor-pointer group">
                                <input type="checkbox" name="galleries[]" value="{{ $gallery->id }}"
                                    class="peer sr-only"
                                    {{ in_array($gallery->id, $attachedGalleryIds) ? 'checked' : '' }}>
                                <!-- Checkbox akan otomatis dicentang jika gallery sudah terpasang -->

                                {{-- Card Design --}}
                                <div
                                    class="relative flex flex-col p-0 overflow-hidden border border-gray-200 dark:border-white/10 bg-white dark:bg-[#121212] transition-all duration-500
                                    peer-checked:border-gray-900 dark:peer-checked:border-white peer-checked:ring-1 peer-checked:ring-gray-900 dark:peer-checked:ring-white rounded-lg">

                                    {{-- Image Preview --}}
                                    <div class="aspect-video w-full overflow-hidden bg-gray-100 dark:bg-neutral-900">
                                        <img src="{{ $gallery->cover ? asset('storage/' . $gallery->cover) : 'https://dummyimage.com/600x400/1a1a1a/ffffff&text=NO+IMAGE' }}"
                                            alt="{{ $gallery->title }}"
                                            class="h-full w-full object-cover transition-all duration-700">

                                        {{-- Badge ceklist jika dipilih --}}
                                        <div
                                            class="absolute top-3 right-3 opacity-0 peer-checked:group-[]:opacity-100 transition-opacity duration-300 z-10">
                                            <div
                                                class="bg-gray-900 dark:bg-white text-white dark:text-black p-1 shadow-xl">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor" stroke-width="3">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Info gallery --}}
                                    <div class="p-4">
                                        <h4
                                            class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-widest truncate">
                                            {{ $gallery->title }}
                                        </h4>
                                        <p
                                            class="text-[10px] text-gray-500 dark:text-gray-500 uppercase mt-1 truncate tracking-tighter">
                                            {{ $gallery->description ?? 'Tanpa Deskripsi' }}
                                        </p>
                                    </div>

                                    {{-- Overlay hover efek --}}
                                    <div
                                        class="absolute inset-0 bg-black/0 group-hover:bg-black/5 dark:group-hover:bg-white/5 transition-colors pointer-events-none">
                                    </div>
                                </div>
                            </label>
                        @empty
                            <!-- Pesan jika gallery kosong -->
                            <div
                                class="col-span-full text-center py-20 border-2 border-dashed border-gray-100 dark:border-white/5">
                                <p class="text-xs uppercase tracking-[0.3em] text-gray-400">Arsip Kosong</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Tombol aksi (Batalkan & Simpan) -->
                    <div
                        class="mt-12 pt-8 border-t border-gray-100 dark:border-white/5 flex flex-col md:flex-row justify-end gap-4 md:gap-6 items-center">
                        <!-- Tombol Batalkan -->
                        <a href="{{ route('posts.index') }}"
                            class="text-[10px] uppercase tracking-[0.3em] text-gray-400 hover:text-red-500 transition-colors">
                            Batalkan
                        </a>

                        <!-- Tombol Simpan -->
                        <button type="submit"
                            class="px-10 py-3 text-[10px] uppercase tracking-[0.4em] font-bold text-white dark:text-black bg-gray-900 dark:bg-white hover:opacity-80 transition-all shadow-2xl rounded">
                            Simpan Perubahan
                        </button>
                    </div>


                </div>
            </form>

        </div>
    </div>
</x-app-layout>
