<x-app-layout>
    {{-- Header halaman: judul dan tombol kembali --}}
    <x-slot name="header">
        <div class="flex justify-between items-end gap-4">
            <div>
                {{-- Subjudul --}}
                <span class="text-xs font-medium text-gray-400 dark:text-gray-500 block mb-1">Editor Postingan</span>
                {{-- Judul halaman --}}
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    Buat Post Baru
                </h2>
            </div>

            {{-- Tombol kembali --}}
            <a href="{{ route('posts.index') }}"
                class="group text-xs font-medium text-gray-400 hover:text-gray-900 dark:hover:text-white flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    {{-- Konten utama: form pembuatan post --}}
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Form store post --}}
            <form action="{{ route('posts.store') }}" method="post" class="space-y-8">
                @csrf

                <div
                    class="bg-white dark:bg-[#121212] overflow-hidden sm:rounded-3xl border border-gray-200 dark:border-white/5 shadow-sm">

                    {{-- Header form: informasi dan deskripsi --}}
                    <div
                        class="px-8 py-8 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]">
                        <h3 class="text-sm font-bold uppercase tracking-[0.2em] text-gray-900 dark:text-white">Detail
                            Konfigurasi</h3>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            Konfigurasikan tipe, posisi, dan status visibilitas untuk postingan galeri Anda.
                        </p>
                    </div>

                    <div class="p-8 space-y-10">
                        {{-- Input nama post --}}
                        <div class="relative">
                            <label for="name"
                                class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2 block">Nama
                                Post</label>
                            <input type="text" name="name" id="name"
                                placeholder="Masukkan nama atau judul post..." value="{{ old('name') }}"
                                class="block w-full bg-white dark:bg-black/20 rounded-xl border-gray-200 dark:border-white/10 py-3 px-4 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-1 focus:ring-gray-900 dark:focus:ring-white focus:border-gray-900 dark:focus:border-white transition-all">
                            {{-- Tampilkan error nama --}}
                            <x-input-error :messages="$errors->addPost->get('name')" class="mt-2" />
                        </div>

                        {{-- Input deskripsi post --}}
                        <div class="relative">
                            <label for="description"
                                class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2 block">Deskripsi
                                Post</label>
                            <textarea name="description" id="description" rows="3" placeholder="Masukkan deskripsi singkat untuk post..."
                                class="block w-full bg-white dark:bg-black/20 rounded-xl border-gray-200 dark:border-white/10 py-3 px-4 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-1 focus:ring-gray-900 dark:focus:ring-white focus:border-gray-900 dark:focus:border-white transition-all resize-none">{{ old('description') }}</textarea>
                            {{-- Tampilkan error deskripsi --}}
                            <x-input-error :messages="$errors->addPost->get('description')" class="mt-2" />
                        </div>

                        {{-- Pilih kategori --}}
                        <div class="relative">
                            <label for="category_id"
                                class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 mb-2 block">Pilih
                                Kategori</label>
                            <select name="category_id" id="category_id"
                                class="block w-full bg-white dark:bg-black/20 rounded-xl border-gray-200 dark:border-white/10 py-3 text-sm text-gray-900 dark:text-white focus:ring-1 focus:ring-gray-900 dark:focus:ring-white focus:border-gray-900 dark:focus:border-white transition-all">
                                <option value="" disabled selected>— Pilih kategori yang tersedia —</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- Tampilkan error kategori --}}
                            <x-input-error :messages="$errors->addPost->get('category_id')" class="mt-2" />
                        </div>

                        {{-- Grid untuk status, posisi, dan tipe --}}
                        <div class="grid grid-cols-1 gap-10 sm:grid-cols-3">

                            {{-- Pilih status publikasi --}}
                            <div class="space-y-2">
                                <label for="status"
                                    class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 block">Status
                                    Publikasi</label>
                                <select name="status" id="status"
                                    class="block w-full bg-white dark:bg-black/20 rounded-xl border-gray-200 dark:border-white/10 py-3 text-sm text-gray-900 dark:text-white focus:ring-1 focus:ring-gray-900 dark:focus:ring-white transition-all">
                                    <option value="" disabled selected>Pilih status</option>
                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                        Diterbitkan</option>
                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>
                                        Arsipkan (Draft)</option>
                                </select>
                                {{-- Error status --}}
                                <x-input-error :messages="$errors->addPost->get('status')" class="mt-2" />
                            </div>

                            {{-- Pilih posisi urutan --}}
                            <div class="space-y-2">
                                <label for="position"
                                    class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 block">Posisi
                                    Urutan</label>
                                <select name="position" id="position"
                                    class="block w-full bg-white dark:bg-black/20 rounded-xl border-gray-200 dark:border-white/10 py-3 text-sm text-gray-900 dark:text-white focus:ring-1 focus:ring-gray-900 dark:focus:ring-white transition-all">
                                    <option value="" disabled selected>Pilih posisi</option>
                                    @for ($i = 1; $i <= 3; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('position') == $i ? 'selected' : '' }}>Prioritas
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                                {{-- Error posisi --}}
                                <x-input-error :messages="$errors->addPost->get('position')" class="mt-2" />
                            </div>

                            {{-- Pilih tipe konten --}}
                            <div class="space-y-2">
                                <label for="type"
                                    class="text-[10px] font-bold uppercase tracking-widest text-gray-400 dark:text-gray-500 block">Format
                                    Konten</label>
                                <select name="type" id="type"
                                    class="block w-full bg-white dark:bg-black/20 rounded-xl border-gray-200 dark:border-white/10 py-3 text-sm text-gray-900 dark:text-white focus:ring-1 focus:ring-gray-900 dark:focus:ring-white transition-all">
                                    <option value="" disabled selected>Pilih tipe</option>
                                    <option value="calendar" {{ old('type') == 'calendar' ? 'selected' : '' }}>Format
                                        Kalender</option>
                                    <option value="gallery" {{ old('type') == 'gallery' ? 'selected' : '' }}>Format
                                        Galeri</option>
                                </select>
                                {{-- Error tipe --}}
                                <x-input-error :messages="$errors->addPost->get('type')" class="mt-2" />
                            </div>

                        </div>
                    </div>

                    {{-- Footer form: tombol batal dan submit --}}
                    <div
                        class="flex items-center justify-between px-8 py-6 bg-gray-50 dark:bg-white/[0.02] border-t border-gray-100 dark:border-white/5">
                        {{-- Informasi tambahan --}}
                        <p class="text-[10px] text-gray-400 italic">Pastikan data yang diisi telah sesuai dengan
                            kategori yang dipilih.</p>

                        {{-- Tombol aksi --}}
                        <div class="flex items-center gap-4">
                            {{-- Tombol batal --}}
                            <a href="{{ route('posts.index') }}"
                                class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                                Batal
                            </a>
                            {{-- Tombol submit --}}
                            <button type="submit"
                                class="px-8 py-3 bg-gray-900 dark:bg-white text-white dark:text-black text-[10px] font-bold uppercase tracking-[0.2em] rounded-xl hover:opacity-80 transition shadow-lg dark:shadow-white/5">
                                Simpan Postingan
                            </button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>
