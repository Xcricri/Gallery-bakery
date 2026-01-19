<x-app-layout>
    <!-- Header halaman -->
    <x-slot name="header">
        <div class="max-w-4xl mx-auto flex justify-between items-end gap-4">
            <div>
                <!-- Label kecil halaman -->
                <span
                    class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.4em] block mb-1">
                    Curation Studio
                </span>
                <!-- Judul halaman -->
                <h2 class="font-black text-3xl text-gray-900 dark:text-white tracking-tighter leading-tight">
                    Ubah Galeri
                </h2>
            </div>

            <!-- Tombol kembali ke daftar galeri -->
            <a href="{{ route('galleries.index') }}"
                class="group text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-black dark:hover:text-white flex items-center gap-2 transition-all">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Form update galeri -->
            <form action="{{ route('galleries.update', $gallery->id) }}" method="post" enctype="multipart/form-data">

                @csrf <!-- Token keamanan -->
                @method('PUT') <!-- Method spoofing untuk update -->

                <div
                    class="bg-white dark:bg-[#0f0f0f] shadow-2xl shadow-black/5 rounded-[2.5rem] border border-gray-100 dark:border-white/[0.03] overflow-hidden">

                    {{-- Header form --}}
                    <div class="px-10 py-10 border-b border-gray-50 dark:border-white/[0.03]">
                        <h3 class="text-xs font-black uppercase tracking-[0.3em] text-gray-900 dark:text-white">
                            Modifikasi Arsip
                        </h3>
                        <p
                            class="mt-2 text-[11px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-widest leading-relaxed">
                            Sesuaikan metadata koleksi visual Anda untuk menjaga relevansi arsip.
                        </p>
                    </div>

                    <div class="p-10 space-y-10">
                        {{-- Input Judul Galeri --}}
                        <div class="relative">
                            <label for="title"
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">
                                Judul Koleksi
                            </label>

                            <!-- Menggunakan old() + fallback ke data galeri -->
                            <input id="title" type="text" name="title"
                                value="{{ old('title', $gallery->title) }}"
                                class="block w-full bg-gray-50 dark:bg-black border-none rounded-2xl py-4 px-6 text-sm font-bold tracking-tight text-gray-900 dark:text-white focus:ring-2 focus:ring-black dark:focus:ring-white transition-all"
                                required />

                            <!-- Error validasi -->
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        {{-- Input Deskripsi Galeri --}}
                        <div>
                            <label for="description"
                                class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">
                                Narasi Koleksi
                            </label>

                            <textarea id="description" name="description" rows="4"
                                class="block w-full bg-gray-50 dark:bg-black border-none rounded-3xl py-4 px-6 text-sm font-medium leading-relaxed text-gray-900 dark:text-white focus:ring-2 focus:ring-black dark:focus:ring-white transition-all">
                                {{ old('description', $gallery->description) }}
                            </textarea>

                            <!-- Error validasi -->
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        {{-- Input Cover Galeri --}}
                        <div x-data="{ preview: null }">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">
                                Foto Sampul Galeri
                            </label>

                            <div class="flex flex-col md:flex-row gap-6 items-start">
                                {{-- Preview cover lama (jika ada) --}}
                                @if ($gallery->cover)
                                    <div
                                        class="relative w-full md:w-48 aspect-[3/4] rounded-2xl overflow-hidden shadow-lg">
                                        <img src="{{ asset('storage/' . $gallery->cover) }}"
                                            class="w-full h-full object-cover" alt="Current Cover">
                                    </div>
                                @endif

                                {{-- Input cover baru --}}
                                <div class="relative group cursor-pointer flex-1 w-full">
                                    <!-- Input file tersembunyi -->
                                    <input id="cover" name="cover" type="file"
                                        class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                        @change="const file = $event.target.files[0]; if (file) { preview = URL.createObjectURL(file) }" />

                                    <!-- Area drop / preview -->
                                    <div
                                        class="flex flex-col items-center justify-center h-full min-h-[160px] rounded-[2rem]
                                                border-2 border-dashed border-gray-100 dark:border-white/5
                                                py-8 bg-gray-50/50 dark:bg-white/[0.02]
                                                group-hover:bg-gray-100 dark:group-hover:bg-white/[0.05]
                                                transition-all overflow-hidden relative">

                                        <!-- State: belum pilih gambar -->
                                        <template x-if="!preview">
                                            <div class="text-center">
                                                <svg class="mx-auto h-6 w-6 text-gray-300 mb-2" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5" d="M12 4v16m8-8H4" />
                                                </svg>
                                                <span
                                                    class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400">
                                                    Ganti Asset
                                                </span>
                                            </div>
                                        </template>

                                        <!-- State: preview gambar baru -->
                                        <template x-if="preview">
                                            <img :src="preview"
                                                class="absolute inset-0 w-full h-full object-cover grayscale brightness-50" />
                                        </template>

                                        <template x-if="preview">
                                            <div
                                                class="relative z-20 text-white text-[9px] font-black uppercase tracking-widest
                                                        bg-black/50 px-4 py-2 rounded-full">
                                                New Asset Selected
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Error validasi cover -->
                            <x-input-error :messages="$errors->get('cover')" class="mt-2" />
                        </div>

                        {{-- Input tanggal & status --}}
                        <div class="grid grid-cols-1 gap-10 sm:grid-cols-3">
                            {{-- Tanggal mulai --}}
                            <div>
                                <label for="start_date"
                                    class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">
                                    Tgl Mulai
                                </label>
                                <input id="start_date" type="date" name="start_date"
                                    value="{{ old('start_date', $gallery->start_date) }}"
                                    class="block w-full bg-gray-50 dark:bg-black border-none rounded-xl py-3 px-4
                                            text-xs font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-black dark:focus:ring-white transition-all" />
                                <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                            </div>

                            {{-- Tanggal selesai --}}
                            <div>
                                <label for="end_date"
                                    class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">
                                    Tgl Selesai
                                </label>
                                <input id="end_date" type="date" name="end_date"
                                    value="{{ old('end_date', $gallery->end_date) }}"
                                    class="block w-full bg-gray-50 dark:bg-black border-none rounded-xl py-3 px-4
                                            text-xs font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-black dark:focus:ring-white transition-all" />
                                <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                            </div>

                            {{-- Status visibilitas --}}
                            <div>
                                <label for="status"
                                    class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block">
                                    Visibility
                                </label>
                                <select name="status" id="status"
                                    class="block w-full bg-gray-50 dark:bg-black border-none rounded-xl py-3 px-4
                                            text-xs font-bold text-gray-900 dark:text-white focus:ring-2 focus:ring-black dark:focus:ring-white transition-all appearance-none cursor-pointer">
                                    <option value="active"
                                        {{ old('status', $gallery->status) == 'active' ? 'selected' : '' }}>
                                        PUBLIC ARCHIVE
                                    </option>
                                    <option value="inactive"
                                        {{ old('status', $gallery->status) == 'inactive' ? 'selected' : '' }}>
                                        HIDDEN / PRIVATE
                                    </option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- Footer form --}}
                    <div
                        class="flex items-center justify-end gap-x-6 px-10 py-8 bg-gray-50/50 dark:bg-white/[0.02]
                                border-t border-gray-50 dark:border-white/[0.03]">

                        <!-- Batalkan perubahan -->
                        <a href="{{ route('galleries.index') }}"
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-black dark:hover:text-white transition-colors">
                            Discard Changes
                        </a>

                        <!-- Submit update -->
                        <button type="submit"
                            class="px-10 py-4 bg-black dark:bg-white text-white dark:text-black
                                    text-[10px] font-black uppercase tracking-[0.3em]
                                    rounded-full hover:scale-105 transition-all shadow-xl">
                            Update Gallery
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
