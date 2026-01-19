<x-app-layout>
    {{-- Header halaman --}}
    <x-slot name="header">
        <div class="flex justify-between items-end gap-4">
            <div>
                {{-- Subjudul --}}
                <span class="text-xs font-medium text-gray-400 dark:text-gray-500 block mb-1">Registrasi Sistem</span>
                {{-- Judul utama --}}
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    Buat Pengguna Baru
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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Form tambah pengguna baru --}}
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white dark:bg-[#121212] border border-gray-200 dark:border-white/5 sm:rounded-xl overflow-hidden shadow-sm">

                    {{-- Header section form --}}
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-white/5">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">Informasi Kredensial</h3>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Silakan lengkapi data di bawah ini. Pastikan kata sandi yang digunakan kuat dan unik.
                        </p>
                    </div>

                    {{-- Konten form --}}
                    <div class="p-8 space-y-10">

                        {{-- Upload avatar (opsional) --}}
                        <div class="space-y-2">
                            <x-input-label for="avatar" :value="'Foto Profil (Opsional)'" class="text-xs font-bold uppercase tracking-widest text-gray-400" />
                            <input id="avatar" name="avatar" type="file" class="block w-full text-xs text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-[10px] file:font-bold file:uppercase file:tracking-widest
                                file:bg-gray-900 file:text-white dark:file:bg-white dark:file:text-black
                                hover:file:opacity-80 cursor-pointer
                            " />
                            {{-- Informasi format file --}}
                            <p class="text-[10px] text-gray-400 dark:text-gray-500 uppercase tracking-tighter">
                                Format: PNG, JPG. Maksimal 2MB.
                            </p>
                            <x-input-error :messages="$errors->addUser->get('avatar')" class="mt-2" />
                        </div>

                        {{-- Grid input Nama, Role, Email --}}
                        <div class="grid grid-cols-1 gap-y-8 sm:grid-cols-2 sm:gap-x-8">

                            {{-- Input Nama --}}
                            <div class="space-y-2">
                                <x-input-label for="name" :value="'Nama Lengkap'" class="text-xs font-bold uppercase tracking-widest text-gray-400" />
                                <x-text-input id="name" type="text" name="name" :value="old('name')" placeholder="Contoh: Ahmad Subardjo" required
                                    class="block w-full border-gray-200 dark:border-white/10 dark:bg-black/20 focus:ring-gray-900 dark:focus:ring-white placeholder-gray-300 dark:placeholder-gray-700" />
                                {{-- Error validation --}}
                                <x-input-error :messages="$errors->addUser->get('name')" class="mt-1" />
                            </div>

                            {{-- Input Role --}}
                            <div class="space-y-2">
                                <x-input-label for="role" :value="'Level Akses'" class="text-xs font-bold uppercase tracking-widest text-gray-400" />
                                <select name="role" id="role" required
                                    class="block w-full rounded-lg border-gray-200 dark:border-white/10 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-black/20 focus:ring-gray-900 dark:focus:ring-white focus:border-gray-900 dark:focus:border-white transition-all">
                                    <option value="" disabled selected>Pilih hak akses...</option>
                                    <option value="member" {{ old('role') == 'member' ? 'selected' : '' }}>Member</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                {{-- Error validation --}}
                                <x-input-error :messages="$errors->addUser->get('role')" class="mt-1" />
                            </div>

                            {{-- Input Email --}}
                            <div class="sm:col-span-2 space-y-2">
                                <x-input-label for="email" :value="'Alamat Email'" class="text-xs font-bold uppercase tracking-widest text-gray-400" />
                                <x-text-input id="email" type="email" name="email" :value="old('email')" placeholder="nama@domain.com" required
                                    class="block w-full border-gray-200 dark:border-white/10 dark:bg-black/20 focus:ring-gray-900 dark:focus:ring-white placeholder-gray-300 dark:placeholder-gray-700" />
                                {{-- Error validation --}}
                                <x-input-error :messages="$errors->addUser->get('email')" class="mt-1" />
                            </div>

                        </div>

                        {{-- Grid Password & Konfirmasi --}}
                        <div class="pt-4 grid grid-cols-1 gap-y-8 sm:grid-cols-2 sm:gap-x-8">

                            {{-- Input Password --}}
                            <div class="space-y-2">
                                <x-input-label for="password" :value="'Kata Sandi'" class="text-xs font-bold uppercase tracking-widest text-gray-400" />
                                <x-text-input id="password" type="password" name="password" placeholder="••••••••" required
                                    class="block w-full border-gray-200 dark:border-white/10 dark:bg-black/20 focus:ring-gray-900 dark:focus:ring-white" />
                                {{-- Error validation --}}
                                <x-input-error :messages="$errors->addUser->get('password')" class="mt-1" />
                            </div>

                            {{-- Input Konfirmasi Password --}}
                            <div class="space-y-2">
                                <x-input-label for="password_confirmation" :value="'Ulangi Sandi'" class="text-xs font-bold uppercase tracking-widest text-gray-400" />
                                <x-text-input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••" required
                                    class="block w-full border-gray-200 dark:border-white/10 dark:bg-black/20 focus:ring-gray-900 dark:focus:ring-white" />
                                {{-- Error validation --}}
                                <x-input-error :messages="$errors->addUser->get('password_confirmation')" class="mt-1" />
                            </div>

                        </div>
                    </div>

                    {{-- Footer Action --}}
                    <div class="flex items-center justify-end gap-x-6 px-8 py-6 bg-gray-50/50 dark:bg-white/[0.02] border-t border-gray-100 dark:border-white/5">
                        {{-- Tombol batal --}}
                        <a href="{{ route('users.index') }}" class="text-xs font-bold text-gray-400 hover:text-red-500 uppercase tracking-widest transition-colors">
                            Batal
                        </a>
                        {{-- Tombol submit --}}
                        <button type="submit" class="px-8 py-3 bg-gray-900 dark:bg-white text-white dark:text-black text-xs font-bold uppercase tracking-[0.2em] rounded-md hover:opacity-80 transition-all shadow-sm">
                            Simpan Pengguna
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
