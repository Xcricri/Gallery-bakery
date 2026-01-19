<x-app-layout>
    {{-- Header halaman --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            <div>
                <span
                    class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.4em] block mb-2">Editor
                    Konten</span>
                <h2 class="font-light text-3xl text-gray-900 dark:text-white uppercase tracking-[0.2em] leading-tight">
                    Ubah <span class="italic font-extralight text-gray-300 dark:text-white/20">Postingan</span>
                </h2>
            </div>

            <a href="{{ route('posts.index') }}"
                class="group flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-gray-400 hover:text-black dark:hover:text-white transition-all">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Index
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fafafa] dark:bg-black min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('posts.update', $post->id) }}" method="post" class="space-y-8">
                @csrf
                @method('PUT')

                <div
                    class="bg-white dark:bg-[#0f0f0f] shadow-[0_0_50px_rgba(0,0,0,0.02)] lg:rounded-[2rem] border border-gray-100 dark:border-white/[0.05] overflow-hidden">

                    {{-- Form header --}}
                    <div class="px-8 py-10 sm:px-12 border-b border-gray-50 dark:border-white/[0.03]">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="h-px w-8 bg-black dark:bg-white"></div>
                            <h3 class="text-[11px] font-black uppercase tracking-[0.4em] text-black dark:text-white">
                                Detail Manuskrip</h3>
                        </div>
                        <p class="text-[10px] font-light text-gray-400 uppercase tracking-widest leading-relaxed">
                            Modifikasi parameter publikasi dan penempatan konten di bawah ini.
                        </p>
                    </div>

                    <div class="p-8 sm:p-12 space-y-12">
                        {{-- input name --}}
                        <div class="group">
                            <label for="name"
                                class="text-[9px] font-bold uppercase tracking-[0.3em] text-gray-400 group-focus-within:text-black dark:group-focus-within:text-white transition-colors block mb-4">
                                Nama Post
                            </label>
                            <input type="text" name="name" id="name"
                                placeholder="Masukkan nama atau judul post..." value="{{ old('name', $post->name) }}"
                                class="block w-full bg-transparent border-0 border-b border-gray-100 dark:border-white/10 px-0 py-3 text-sm font-light tracking-[0.1em] text-gray-900 dark:text-white placeholder-gray-300 dark:placeholder-gray-600 focus:ring-0 focus:border-black dark:focus:border-white transition-all">
                            <x-input-error :messages="$errors->addPost->get('name')" class="mt-2 text-[10px]" />
                        </div>

                        {{-- input description --}}
                        <div class="group">
                            <label for="description"
                                class="text-[9px] font-bold uppercase tracking-[0.3em] text-gray-400 group-focus-within:text-black dark:group-focus-within:text-white transition-colors block mb-4">
                                Deskripsi Post
                            </label>
                            <textarea name="description" id="description" rows="3" placeholder="Masukkan deskripsi singkat untuk post..."
                                class="block w-full bg-transparent border border-gray-100 dark:border-white/10 rounded-lg px-4 py-3 text-sm font-light tracking-[0.05em] text-gray-900 dark:text-white placeholder-gray-300 dark:placeholder-gray-600 focus:ring-1 focus:ring-black dark:focus:ring-white focus:border-transparent transition-all resize-none">{{ old('description', $post->description) }}</textarea>
                            <x-input-error :messages="$errors->addPost->get('description')" class="mt-2 text-[10px]" />
                        </div>

                        {{-- input category --}}
                        <div class="group">
                            <label for="category_id"
                                class="text-[9px] font-bold uppercase tracking-[0.3em] text-gray-400 group-focus-within:text-black dark:group-focus-within:text-white transition-colors block mb-4">
                                Klasifikasi Kategori
                            </label>
                            <select name="category_id" id="category_id"
                                class="block w-full bg-transparent border-0 border-b border-gray-100 dark:border-white/10 px-0 py-3 text-sm font-light tracking-[0.1em] text-gray-900 dark:text-white focus:ring-0 focus:border-black dark:focus:border-white transition-all appearance-none cursor-pointer">
                                <option value="" disabled class="dark:bg-black">Pilih kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}
                                        class="dark:bg-black">
                                        {{ strtoupper($category->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->addPost->get('category_id')" class="mt-2 text-[10px]" />
                        </div>

                        <div class="grid grid-cols-1 gap-x-12 gap-y-12 sm:grid-cols-3">
                            {{-- select status --}}
                            <div class="group border-l border-gray-100 dark:border-white/10 pl-6">
                                <label for="status"
                                    class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Status
                                    Visibilitas</label>
                                <select name="status" id="status"
                                    class="block w-full bg-transparent border-0 px-0 py-2 text-xs font-light tracking-widest text-gray-900 dark:text-white focus:ring-0 transition-all cursor-pointer">
                                    <option value="published"
                                        {{ old('status', $post->status) == 'published' ? 'selected' : '' }}
                                        class="dark:bg-black">PUBLIKASIKAN</option>
                                    <option value="archived"
                                        {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}
                                        class="dark:bg-black">ARSIPKAN</option>
                                </select>
                                <x-input-error :messages="$errors->addPost->get('status')" class="mt-2 text-[10px]" />
                            </div>

                            {{-- select position --}}
                            <div class="group border-l border-gray-100 dark:border-white/10 pl-6">
                                <label for="position"
                                    class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Urutan
                                    Penempatan</label>
                                <select name="position" id="position"
                                    class="block w-full bg-transparent border-0 px-0 py-2 text-xs font-light tracking-widest text-gray-900 dark:text-white focus:ring-0 transition-all cursor-pointer">
                                    <option value="1"
                                        {{ old('position', $post->position) == '1' ? 'selected' : '' }}
                                        class="dark:bg-black">PERTAMA (PRIMARY)</option>
                                    <option value="2"
                                        {{ old('position', $post->position) == '2' ? 'selected' : '' }}
                                        class="dark:bg-black">KEDUA (SECONDARY)</option>
                                    <option value="3"
                                        {{ old('position', $post->position) == '3' ? 'selected' : '' }}
                                        class="dark:bg-black">KETIGA (TERTIARY)</option>
                                </select>
                                <x-input-error :messages="$errors->addPost->get('position')" class="mt-2 text-[10px]" />
                            </div>

                            {{-- select type --}}
                            <div class="group border-l border-gray-100 dark:border-white/10 pl-6">
                                <label for="type"
                                    class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Arsitektur
                                    Post</label>
                                <select name="type" id="type"
                                    class="block w-full bg-transparent border-0 px-0 py-2 text-xs font-light tracking-widest text-gray-900 dark:text-white focus:ring-0 transition-all cursor-pointer">
                                    <option value="calendar"
                                        {{ old('type', $post->type) == 'calendar' ? 'selected' : '' }}
                                        class="dark:bg-black">KALENDER</option>
                                    <option value="gallery"
                                        {{ old('type', $post->type) == 'gallery' ? 'selected' : '' }}
                                        class="dark:bg-black">GALERI</option>
                                </select>
                                <x-input-error :messages="$errors->addPost->get('type')" class="mt-2 text-[10px]" />
                            </div>
                        </div>
                    </div>

                    {{-- submit button --}}
                    <div
                        class="flex items-center justify-end gap-x-8 px-12 py-8 bg-gray-50/50 dark:bg-white/[0.02] border-t border-gray-50 dark:border-white/[0.03]">
                        <a href="{{ route('posts.index') }}"
                            class="text-[9px] font-light uppercase tracking-[0.3em] text-gray-400 hover:text-black dark:hover:text-white transition-colors">
                            Batalkan
                        </a>
                        <button type="submit"
                            class="bg-black dark:bg-white text-white dark:text-black px-10 py-4 text-[9px] font-bold uppercase tracking-[0.4em] hover:bg-gray-800 dark:hover:bg-gray-200 transition-all shadow-2xl shadow-black/10">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
