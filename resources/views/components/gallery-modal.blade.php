{{-- Modal Gallery --}}
<div x-data="galleryModal(@json($currentUser ?? null))" x-show="modalOpen" x-cloak
    class="fixed inset-0 z-[999] flex items-center justify-center bg-gradient-to-b from-black to-white backdrop-blur-md transition-all duration-500"
    x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100"
    x-transition:leave-end="opacity-0">

    {{-- Header Modal --}}
    <div class="absolute top-0 left-0 w-full p-8 flex justify-between items-center z-50">
        <div class="text-white">
            <h3 class="text-xs tracking-[0.4em] uppercase opacity-60">Gallery Exhibition</h3>
            <p class="text-2xl font-serif tracking-wide" x-text="galleryTitle"></p>
        </div>
        <button @click="closeModal()"
            class="group flex items-center gap-4 text-white/50 hover:text-white transition-all">
            <span class="text-[10px] tracking-[0.3em] uppercase hidden md:block">Close</span>
            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Body Modal --}}
    <div class="w-full h-full flex flex-col md:flex-row pt-24 pb-12 px-6 md:px-12 gap-8" @click.away="closeModal()">

        {{-- Foto Utama --}}
        <div class="flex-1 relative group flex items-center justify-center overflow-hidden">
            <template x-if="activePhotos.length > 0">
                <div class="relative w-full h-full flex items-center justify-center">
                    <img :src="'/storage/' + activePhotos[currentPhotoIndex].file_path"
                        class="max-w-full max-h-full object-contain transition-all duration-700 rounded-xl"
                        :key="currentPhotoIndex" x-transition:enter="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">

                    {{-- Navigasi Foto --}}
                    <div class="absolute inset-0 flex justify-between items-center px-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button @click.stop="prevPhoto()"
                            class="p-4 bg-white/5 hover:bg-white/10 rounded-full text-white backdrop-blur-sm transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button @click.stop="nextPhoto()"
                            class="p-4 bg-white/5 hover:bg-white/10 rounded-full text-white backdrop-blur-sm transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        {{-- Sidebar Foto --}}
        <div class="w-full md:w-80 flex flex-col border-l border-white/10 pl-0 md:pl-8 overflow-hidden">

            {{-- Likes --}}
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[10px] text-white/40 tracking-[0.2em] uppercase"
                        x-text="(currentPhotoIndex + 1) + ' / ' + activePhotos.length"></span>
                    <div class="h-[1px] flex-1 bg-white/10"></div>
                </div>
                <form :action="'/photos/' + activePhotos[currentPhotoIndex]?.id + '/like'" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-white hover:opacity-70 transition">
                        <svg class="w-5 h-5"
                            :class="activePhotos[currentPhotoIndex]?.is_liked ? 'fill-white' : 'fill-none'"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <span class="text-xs uppercase tracking-widest font-light"
                            x-text="(activePhotos[currentPhotoIndex]?.likes_count || 0) + ' Appreciation'"></span>
                    </button>
                </form>
            </div>

            {{-- Komentar --}}
            <div class="flex-1 overflow-y-auto space-y-6 pr-2 scrollbar-hide">
                <template x-for="comment in activePhotos[currentPhotoIndex]?.comments || []" :key="comment.id">
                    <div class="border-b border-white/5 pb-4">
                        <span class="text-[10px] text-white/40 uppercase tracking-tighter"
                            x-text="comment.name || 'Guest'"></span>
                        <p class="text-sm text-white/80 font-light mt-1 leading-relaxed" x-text="comment.content"></p>
                        <span class="text-[10px] text-white/40 tracking-[0.2em] uppercase mt-2 block"
                            x-text="new Date(comment.created_at).toLocaleString()"></span>
                    </div>
                </template>
            </div>

                {{-- Form Tambah Komentar --}}
                <form action="{{ route('comments.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="photo_id" :value="activePhotos[currentPhotoIndex]?.id">

                    {{-- Nama jika user belum login --}}
                    <template x-if="!currentUser">
                        <input type="text" name="name" required placeholder="NAME"
                            class="w-full bg-transparent border-b border-white/20 text-white text-sm tracking-widest py-2 focus:border-white outline-none transition-colors">
                    </template>

                    {{-- Input komentar --}}
                    <div class="relative group">
                        <input type="text" name="content" required placeholder="ADD A COMMENT"
                            class="w-full bg-transparent border-b border-white/20 text-white text-sm tracking-widest py-4 focus:border-white outline-none transition-colors">
                        <button type="submit"
                            class="absolute right-0 bottom-4 text-white opacity-40 hover:opacity-100 transition-opacity uppercase text-[10px] tracking-widest">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
