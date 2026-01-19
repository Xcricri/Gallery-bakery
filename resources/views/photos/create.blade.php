
<x-app-layout>
    <!-- Header halaman -->
    <x-slot name="header">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            <div>
                <!-- Label konteks halaman -->
                <span
                    class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.4em] block mb-1">
                    Asset Acquisition
                </span>

                <!-- Judul halaman + nama galeri -->
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white">
                    Unggah ke:
                    <span class="text-gray-400">{{ $gallery->title }}</span>
                </h2>
            </div>

            <!-- Tombol kembali ke halaman galeri -->
            <a href="{{ route('galleries.show', $gallery->id) }}"
                class="group text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-black dark:hover:text-white flex items-center gap-2 transition-all">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Galeri
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Alpine.js state untuk upload foto -->
            <div x-data="photoUpload()"
                class="bg-white dark:bg-[#0f0f0f] shadow-2xl shadow-black/5 rounded-[3rem]
                        border border-gray-100 dark:border-white/[0.03] overflow-hidden p-10">

                <!-- Form upload foto -->
                <form action="{{ route('galleries.photos.store', $gallery->id) }}" method="POST"
                    enctype="multipart/form-data" @submit="isUploading = true">

                    @csrf <!-- Token keamanan -->

                    {{-- 1. DROPZONE AREA --}}
                    <div class="mb-12">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-4 block">
                            Source Selection
                        </label>

                        <!-- Area drag & drop -->
                        <div class="relative group border-2 border-dashed rounded-[2rem] p-12 text-center transition-all duration-500"
                            :class="isDragging
                                ?
                                'border-black dark:border-white bg-gray-50 dark:bg-white/[0.02]' :
                                'border-gray-100 dark:border-white/5 hover:border-gray-300 dark:hover:border-white/20'"
                            @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                            @drop.prevent="handleDrop($event)">
                            <!-- Input file tersembunyi -->
                            <input type="file" name="photos[]" id="photos" multiple
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20"
                                @change="handleFiles($event.target.files)"
                                accept="image/png, image/jpeg, image/jpg, image/gif">

                            <!-- Konten visual dropzone -->
                            <div class="space-y-4 relative z-10">
                                <div
                                    class="w-16 h-16 bg-gray-50 dark:bg-black rounded-full flex items-center justify-center mx-auto
                                            group-hover:scale-110 transition-transform duration-500 border border-gray-100 dark:border-white/5">
                                    <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </div>

                                <div>
                                    <p
                                        class="text-[11px] font-black uppercase tracking-[0.2em] text-gray-900 dark:text-white">
                                        Impor Aset Visual
                                    </p>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">
                                        Seret foto atau klik untuk menelusuri
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Error validasi upload -->
                        <x-input-error :messages="$errors->get('photos')" class="mt-4" />
                    </div>

                    {{-- 2. PREVIEW / CONTACT SHEET --}}
                    <div x-show="files.length > 0" x-transition.opacity class="mb-12">
                        <!-- Header preview -->
                        <div
                            class="flex items-end justify-between mb-6 border-b border-gray-50 dark:border-white/5 pb-4">
                            <div>
                                <h3
                                    class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-900 dark:text-white">
                                    Contact Sheet
                                </h3>
                                <p class="text-[9px] text-gray-400 uppercase tracking-widest mt-1">
                                    <span x-text="files.length"></span> Item siap diproses
                                </p>
                            </div>

                            <!-- Hapus semua file -->
                            <button type="button" @click="clearAll()"
                                class="text-[9px] font-black uppercase tracking-widest text-red-500 hover:opacity-50 transition">
                                Purge Selection
                            </button>
                        </div>

                        <!-- Grid preview foto -->
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                            <template x-for="(file, index) in files" :key="index">
                                <div
                                    class="relative group aspect-[3/4] rounded-2xl overflow-hidden
                                            bg-gray-50 dark:bg-black border border-gray-100 dark:border-white/5 shadow-sm">

                                    <!-- Preview gambar -->
                                    <img :src="file.preview"
                                        class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">

                                    <!-- Overlay kontrol -->
                                    <div
                                        class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100
                                                transition-opacity flex flex-col justify-between p-3">
                                        <!-- Hapus file tertentu -->
                                        <button type="button" @click="removeFile(index)"
                                            class="self-end bg-white/10 hover:bg-red-500 text-white p-1.5
                                                rounded-full backdrop-blur-md transition-colors">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>

                                        <!-- Nama file -->
                                        <p class="text-[8px] font-bold text-white truncate uppercase tracking-tighter"
                                            x-text="file.name"></p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- 3. SHARED METADATA --}}
                    <div class="mb-12">
                        <label for="description"
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-3 block text-center">
                            Deskripsi Kolektif (Opsional)
                        </label>

                        <!-- Deskripsi bersama untuk semua foto -->
                        <textarea id="description" name="description" rows="2"
                            placeholder="Metadata ini akan disematkan pada setiap aset dalam batch ini..."
                            class="block w-full bg-gray-50 dark:bg-black border-none rounded-2xl
                                        py-4 px-6 text-[11px] font-medium text-gray-900 dark:text-white
                                        focus:ring-2 focus:ring-black dark:focus:ring-white transition-all
                                        text-center italic"></textarea>
                    </div>

                    {{-- 4. ACTION BUTTONS --}}
                    <div class="flex flex-col items-center gap-6 pt-8 border-t border-gray-50 dark:border-white/5">
                        <!-- Tombol submit upload -->
                        <button type="submit" :disabled="files.length === 0 || isUploading"
                            class="group relative px-12 py-5 bg-black dark:bg-white
                                    text-white dark:text-black rounded-full transition-all duration-500
                                    disabled:opacity-30 shadow-2xl overflow-hidden">

                            <div class="relative z-10 flex items-center gap-3">
                                <!-- Spinner saat upload -->
                                <svg x-show="isUploading" class="animate-spin h-4 w-4" fill="none"
                                    viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>

                                <!-- Label tombol -->
                                <span class="text-[10px] font-black uppercase tracking-[0.4em]"
                                    x-text="isUploading ? 'Processing...' : 'Commit Assets'"></span>
                            </div>
                        </button>

                        <!-- Batalkan & kembali -->
                        <a href="{{ route('galleries.show', $gallery->id) }}"
                            class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-red-500 transition-colors">
                            Discard and Exit
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Logic Alpine.js untuk upload & preview -->
    <script>
        function photoUpload() {
            return {
                files: [], // List file terpilih
                isDragging: false, // State drag & drop
                isUploading: false, // State submit

                // Handle input file / drag-drop
                handleFiles(newFiles) {
                    for (let i = 0; i < newFiles.length; i++) {
                        let file = newFiles[i]; // Masukkan file ke array
                        if (!file.type.match('image.*')) continue; // Hanya gambar
                        file.preview = URL.createObjectURL(file); // Buat preview URL
                        this.files.push(file); // Tambahkan ke list
                    }
                    this.updateInputFiles();
                },

                // Handle drop event
                handleDrop(event) {
                    this.isDragging = false;
                    this.handleFiles(event.dataTransfer.files);
                },

                // Hapus satu file
                removeFile(index) {
                    this.files.splice(index, 1);
                    this.updateInputFiles();
                },

                // Hapus semua file
                clearAll() {
                    this.files = [];
                    this.updateInputFiles();
                },

                // Sinkronisasi files
                updateInputFiles() {
                    const dataTransfer = new DataTransfer();
                    this.files.forEach(file => dataTransfer.items.add(file));
                    document.getElementById('photos').files = dataTransfer.files;
                }
            }
        }
    </script>
</x-app-layout>
