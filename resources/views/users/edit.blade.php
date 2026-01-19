<x-app-layout>
    {{-- Header halaman --}}
    <x-slot name="header">
        <div class="flex justify-between items-end gap-4">
            {{-- Judul halaman --}}
            <div>
                <span class="text-xs font-medium text-gray-400 dark:text-gray-500 block mb-1">Pengaturan Akun</span>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    Ubah Pengguna
                </h2>
            </div>

            {{-- Tombol kembali --}}
            <a href="{{ url()->previous() }}" class="group flex items-center gap-2 text-xs font-medium text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Form Edit User --}}
            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="bg-white dark:bg-[#121212] border border-gray-200 dark:border-white/5 sm:rounded-xl overflow-hidden">

                    {{-- Section Header --}}
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-white/5">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Informasi Profil</h3>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">
                            Pastikan data nama dan alamat email sesuai dengan identitas resmi pengguna.
                        </p>
                    </div>

                    {{-- Konten Form --}}
                    <div class="p-8 space-y-10">

                        {{-- Avatar --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                            <div class="shrink-0 relative">
                                <img class="h-20 w-20 object-cover rounded-full border border-gray-100 dark:border-white/10 shadow-sm"
                                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=f3f4f6&color=6b7280' }}"
                                    alt="Foto profil">
                            </div>
                            <div class="flex-1">
                                <label for="avatar" class="block text-xs font-bold text-gray-700 dark:text-gray-300 mb-2">Foto Profil</label>
                                <input id="avatar" name="avatar" type="file" class="block w-full text-xs text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-[10px] file:font-bold file:uppercase file:tracking-widest
                                    file:bg-gray-900 file:text-white dark:file:bg-white dark:file:text-black
                                    hover:file:opacity-80 cursor-pointer" />
                                <p class="mt-2 text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-tighter">
                                    Format: JPG, PNG. Maks 2MB. Biarkan kosong jika tidak ingin diubah.
                                </p>
                            </div>
                        </div>

                        {{-- Input Fields --}}
                        <div class="grid grid-cols-1 gap-y-8 sm:grid-cols-2 sm:gap-x-8">

                            {{-- Nama --}}
                            <div class="space-y-2">
                                <x-input-label for="name" :value="'Nama Lengkap'" class="text-xs font-bold uppercase tracking-widest text-gray-400" />
                                <x-text-input id="name" type="text" name="name" :value="old('name', $user->name)" required
                                    class="block w-full border-gray-200 dark:border-white/10 dark:bg-black/20 focus:ring-gray-900 dark:focus:ring-white" />
                                <x-input-error :messages="$errors->editUser->get('name')" class="mt-1" />
                            </div>

                            {{-- Role --}}
                            <div class="space-y-2">
                                <x-input-label for="role" :value="'Level Akses'" class="text-xs font-bold uppercase tracking-widest text-gray-400" />
                                <select id="role" name="role"
                                    class="block w-full rounded-lg border-gray-200 dark:border-white/10 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-black/20 focus:ring-gray-900 dark:focus:ring-white focus:border-gray-900 dark:focus:border-white transition-all">
                                    <option value="member" {{ old('role', $user->role) == 'member' ? 'selected' : '' }}>Member</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                <x-input-error :messages="$errors->editUser->get('role')" class="mt-1" />
                            </div>

                            {{-- Email --}}
                            <div class="sm:col-span-2 space-y-2">
                                <x-input-label for="email" :value="'Alamat Email'" class="text-xs font-bold uppercase tracking-widest text-gray-400" />
                                <x-text-input id="email" type="email" name="email" :value="old('email', $user->email)" required
                                    class="block w-full border-gray-200 dark:border-white/10 dark:bg-black/20 focus:ring-gray-900 dark:focus:ring-white" />
                                <x-input-error :messages="$errors->editUser->get('email')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-end gap-x-6 px-8 py-6 bg-gray-50/50 dark:bg-white/[0.02] border-t border-gray-100 dark:border-white/5">
                        <a href="{{ route('users.index') }}" class="text-xs font-bold text-gray-400 hover:text-red-500 uppercase tracking-widest transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 bg-gray-900 dark:bg-white text-white dark:text-black text-xs font-bold uppercase tracking-[0.2em] rounded-md hover:opacity-80 transition-all shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
