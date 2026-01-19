<x-app-layout>
    <x-slot name="header">
        <div class="max-w-4xl mx-auto flex justify-between items-end gap-4">
            <div>
                <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 block mb-1">Curation Studio</span>
                <h2 class="font-bold text-3xl text-gray-900 dark:text-white ">Buat Galeri</h2>
            </div>
            <a href="{{ route('galleries.index') }}" class="group text-[10px] font-black text-gray-400 hover:text-black dark:hover:text-white flex items-center gap-2 transition-all">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('galleries.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="bg-white dark:bg-[#0f0f0f] shadow-2xl shadow-black/5 rounded-[2.5rem] border border-gray-100 dark:border-white/[0.03] overflow-hidden">
                    <div class="px-10 py-10 border-b border-gray-50 dark:border-white/[0.03]">
                        <h3 class="text-xs font-bold text-gray-900 dark:text-white">Arsip Metadata</h3>
                        <p class="mt-2 text-[11px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-widest leading-relaxed">
                            Definisikan koleksi visual Anda dengan informasi yang mendalam.
                        </p>
                    </div>

                    <div class="p-10 space-y-10">
                        <div class="relative">
                            <label for="title" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">Judul Koleksi</label>
                            <input id="title" type="text" name="title" value="{{ old('title') }}"
                                placeholder="e.g. VISUAL ARCHIVE 2026"
                                class="block w-full bg-gray-50 dark:bg-black border-none rounded-2xl py-4 px-6 text-sm font-bold tracking-tight text-gray-900 dark:text-white focus:ring-2 focus:ring-black dark:focus:ring-white transition-all placeholder:text-gray-300 dark:placeholder:text-gray-700" />
                            <x-input-error :messages="$errors->addGallery->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <label for="description" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">Narasi Koleksi</label>
                            <textarea id="description" name="description" rows="4"
                                placeholder="Tuliskan esensi dari galeri ini..."
                                class="block w-full bg-gray-50 dark:bg-black border-none rounded-3xl py-4 px-6 text-sm font-medium leading-relaxed text-gray-900 dark:text-white focus:ring-2 focus:ring-black dark:focus:ring-white transition-all placeholder:text-gray-300 dark:placeholder:text-gray-700">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->addGallery->get('description')" class="mt-2" />
                        </div>

                        <div x-data="{ preview: null }">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">Foto Sampul Utama</label>
                            <div class="relative group cursor-pointer">
                                <input id="cover" name="cover" type="file" class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                    @change="const file = $event.target.files[0]; if (file) { preview = URL.createObjectURL(file) }"/>

                                <div class="flex flex-col items-center justify-center rounded-[2rem] border-2 border-dashed border-gray-100 dark:border-white/5 py-12 bg-gray-50/50 dark:bg-white/[0.02] group-hover:bg-gray-100 dark:group-hover:bg-white/[0.05] transition-all overflow-hidden relative">
                                    <template x-if="!preview">
                                        <div class="text-center">
                                            <svg class="mx-auto h-8 w-8 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400">Select Master Asset (2MB Max)</span>
                                        </div>
                                    </template>
                                    <template x-if="preview">
                                        <img :src="preview" class="absolute inset-0 w-full h-full object-cover grayscale brightness-50" />
                                    </template>
                                    <template x-if="preview">
                                        <div class="relative z-20 text-white text-[9px] font-black uppercase tracking-widest bg-black/50 px-4 py-2 rounded-full">Ganti Gambar</div>
                                    </template>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->addGallery->get('cover')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 gap-10 sm:grid-cols-3">
                            <div>
                                <label for="start_time" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">Tgl Mulai</label>
                                <input id="start_time" type="date" name="start_time" value="{{ old('start_time') }}"
                                    class="block w-full bg-gray-50 dark:bg-black border-none rounded-xl py-3 px-4 text-xs font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-black dark:focus:ring-white transition-all" />
                                <x-input-error :messages="$errors->addGallery->get('start_time')" class="mt-2" />
                            </div>

                            <div>
                                <label for="end_time" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">Tgl Selesai</label>
                                <input id="end_time" type="date" name="end_time" value="{{ old('end_time') }}"
                                    class="block w-full bg-gray-50 dark:bg-black border-none rounded-xl py-3 px-4 text-xs font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-black dark:focus:ring-white transition-all" />
                                <x-input-error :messages="$errors->addGallery->get('end_time')" class="mt-2" />
                            </div>

                            <div>
                                <label for="status" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">Visibility</label>
                                <select name="status" id="status" class="block w-full bg-gray-50 dark:bg-black border-none rounded-xl py-3 px-4 text-xs font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-black dark:focus:ring-white transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>SET STATUS</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>PUBLIC ARCHIVE</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>HIDDEN / PRIVATE</option>
                                </select>
                                <x-input-error :messages="$errors->addGallery->get('status')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-x-6 px-10 py-8 bg-gray-50/50 dark:bg-white/[0.02] border-t border-gray-50 dark:border-white/[0.03]">
                        <a href="{{ route('galleries.index') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-black dark:hover:text-white transition-colors">Batal</a>
                        <button type="submit" class="px-10 py-3 bg-black dark:bg-white text-white dark:text-black text-[10px] font-black uppercase tracking-[0.3em] rounded-full hover:scale-105 transition-all shadow-xl">Buat</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
