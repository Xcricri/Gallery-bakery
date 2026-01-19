<x-app-layout>
    {{-- Header halaman --}}
    <x-slot name="header">
        <div class="flex justify-between items-end gap-4">
            <div>
                {{-- Subjudul --}}
                <span class="text-xs font-medium text-gray-400 dark:text-gray-500 block mb-1">Manajemen Data</span>
                {{-- Judul utama --}}
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    Profil Pengguna
                </h2>
            </div>

            {{-- Tombol kembali ke halaman sebelumnya --}}
            <a href="{{ url()->previous() }}" class="group flex items-center gap-2 text-xs font-medium text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Layout grid utama: profil + galeri --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">

                {{-- Bagian kiri: Profil pengguna --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">
                        <div class="bg-white dark:bg-[#121212] overflow-hidden sm:rounded-2xl border border-gray-200 dark:border-white/5 shadow-sm">
                            <div class="p-8 flex flex-col items-center text-center">

                                {{-- Foto profil --}}
                                <div class="relative group">
                                    <div class="absolute -inset-1 bg-gray-100 dark:bg-white/5 rounded-full scale-95 group-hover:scale-105 transition duration-500"></div>
                                    <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=256&background=f3f4f6&color=111827' }}"
                                        alt="{{ $user->name }}"
                                        class="relative h-40 w-40 rounded-full object-cover border-[6px] border-white dark:border-[#121212] shadow-2xl">
                                </div>

                                {{-- Nama & email --}}
                                <h3 class="mt-8 text-2xl font-bold text-gray-900 dark:text-white tracking-tight">{{ $user->name }}</h3>
                                <p class="text-gray-400 dark:text-gray-500 text-sm font-medium">{{ $user->email }}</p>

                                {{-- Role pengguna --}}
                                <div class="mt-5">
                                    <span class="px-4 py-1.5 rounded-full bg-gray-900 dark:bg-white text-white dark:text-black text-[10px] font-bold uppercase tracking-[0.15em]">
                                        {{ $user->role === 'admin' ? 'Administrator' : 'Member' }}
                                    </span>
                                </div>

                                {{-- Statistik karya & tanggal bergabung --}}
                                <div class="w-full mt-10 grid grid-cols-2 border-t border-gray-100 dark:border-white/5 pt-8">
                                    <div class="text-center">
                                        <span class="block text-xl font-bold text-gray-900 dark:text-white leading-none">{{ $user->galleries->count() }}</span>
                                        <span class="text-[10px] text-gray-400 uppercase tracking-widest mt-2 block font-bold">Karya</span>
                                    </div>
                                    <div class="text-center border-l border-gray-100 dark:border-white/5">
                                        <span class="block text-xl font-bold text-gray-900 dark:text-white leading-none">{{ $user->created_at->format('M Y') }}</span>
                                        <span class="text-[10px] text-gray-400 uppercase tracking-widest mt-2 block font-bold">Bergabung</span>
                                    </div>
                                </div>

                                {{-- Tombol edit profil --}}
                                <div class="w-full mt-8">
                                    <a href="{{ route('users.edit', $user->id) }}" class="flex justify-center items-center gap-2 w-full py-3 px-4 bg-gray-100 dark:bg-white/5 text-gray-900 dark:text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-900 hover:text-white dark:hover:bg-white dark:hover:text-black transition-all duration-300">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        Edit Profil
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian kanan: Galeri karya --}}
                <div class="lg:col-span-2 space-y-8">
                    <div class="flex items-center justify-between">
                        {{-- Judul galeri --}}
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-[0.2em] flex items-center gap-3">
                            <span class="w-8 h-[1px] bg-gray-300 dark:bg-white/20"></span>
                            Galeri Karya
                        </h3>
                        {{-- Jumlah item --}}
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $user->galleries->count() }} Item</span>
                    </div>

                    {{-- Grid galeri --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        @forelse ($user->galleries as $gallery)
                            {{-- Card setiap karya --}}
                            <a href="{{ route('galleries.show', $gallery->id) }}" class="group block bg-white dark:bg-[#121212] rounded-2xl overflow-hidden border border-gray-200 dark:border-white/5 hover:border-gray-900 dark:hover:border-white transition-all duration-500 shadow-sm">

                                {{-- Cover image --}}
                                <div class="relative h-56 overflow-hidden bg-gray-100 dark:bg-black/40">
                                    <img src="{{ $gallery->cover ? asset('storage/'.$gallery->cover) : 'https://dummyimage.com/600x400/f3f4f6/9ca3af&text=No+Cover' }}"
                                        alt="{{ $gallery->title }}"
                                        class="w-full h-full object-cover transition duration-700">

                                    {{-- Status karya --}}
                                    <div class="absolute top-4 left-4">
                                        <span class="px-2 py-1 text-[9px] font-bold uppercase tracking-widest rounded bg-white/90 dark:bg-black/80 text-gray-900 dark:text-white shadow-sm">
                                            {{ $gallery->status ?? 'Public' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Info karya --}}
                                <div class="p-6">
                                    <h4 class="text-base font-bold text-gray-900 dark:text-white mb-2 line-clamp-1 group-hover:tracking-wide transition-all duration-300">
                                        {{ $gallery->title }}
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                        {{ $gallery->description ?? 'Tidak ada deskripsi untuk karya ini.' }}
                                    </p>
                                    {{-- Footer card --}}
                                    <div class="mt-6 pt-4 border-t border-gray-50 dark:border-white/5 flex justify-between items-center">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $gallery->created_at->format('d/m/Y') }}</span>
                                        <span class="text-[10px] font-bold text-gray-900 dark:text-white uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Detail &rarr;</span>
                                    </div>
                                </div>
                            </a>

                        @empty
                            {{-- Jika tidak ada galeri --}}
                            <div class="col-span-full py-20 flex flex-col items-center justify-center text-center bg-gray-50/50 dark:bg-white/[0.02] rounded-3xl border-2 border-dashed border-gray-200 dark:border-white/5">
                                <svg class="w-12 h-12 text-gray-300 dark:text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest">Belum Ada Galeri</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Pengguna ini belum mengunggah karya apapun.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
