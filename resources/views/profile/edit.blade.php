<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="font-bold text-2xl text-gray-900 dark:text-white  tracking-[0.2em] leading-tight">
                Data <span class="font-bold text-gray-300 dark:text-white/20">Akun</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-[#fafafa] dark:bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <div class="lg:col-span-8 space-y-12">
                    <div class="p-8 sm:p-12 bg-white dark:bg-[#0f0f0f] shadow-[0_0_50px_rgba(0,0,0,0.02)] lg:rounded-[2rem] border border-gray-100 dark:border-white/[0.05]">

                        {{-- Header Bagian --}}
                        <div class="flex items-start justify-between mb-12">
                            <div class="space-y-3">
                                <h3 class="text-[14px] font-black uppercase tracking-[0.4em] text-black dark:text-white">
                                    Profil Identitas
                                </h3>
                                <div class="h-px w-8 bg-black dark:bg-white"></div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-relaxed max-w-xs">
                                    Perbarui detail autentikasi dan identitas visual Anda.
                                </p>
                            </div>
                        </div>

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-12" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            {{-- Kurasi Avatar --}}
                            <div class="group">
                                <label class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-400 group-focus-within:text-black dark:group-focus-within:text-white transition-colors block mb-6">Identitas Visual</label>
                                <div class="flex flex-col sm:flex-row items-center gap-10">
                                    <div class="relative group/avatar">
                                        <img class="h-32 w-32 object-cover rounded-full grayscale hover:grayscale-0 transition-all duration-700 border border-gray-100 dark:border-white/10 p-1"
                                            src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=000&color=fff' }}"
                                            alt="Foto Profil">
                                        <div class="absolute inset-0 rounded-full border border-black/5 dark:border-white/5 group-hover/avatar:scale-110 transition-transform duration-500"></div>
                                    </div>
                                    <div class="flex-1 w-full space-y-4">
                                        <input id="avatar" name="avatar" type="file" class="block w-full text-[11px] text-gray-400
                                            file:mr-8 file:py-3 file:px-6
                                            file:rounded-none file:border file:border-black dark:file:border-white
                                            file:text-[12px] file:font-light file:uppercase file:tracking-[0.2em]
                                            file:bg-black dark:file:bg-white file:text-white dark:file:text-black
                                            hover:file:bg-transparent hover:file:text-black dark:hover:file:text-white
                                            transition-all cursor-pointer bg-transparent border-b border-gray-100 dark:border-white/5 py-2
                                        "/>
                                        <p class="text-[12px] font-light italic text-gray-400 tracking-wider text-right uppercase">Batas: 2MB . JPG / PNG</p>
                                        <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                {{-- Input Nama --}}
                                <div class="group">
                                    <label for="name" class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-400 group-focus-within:text-black dark:group-focus-within:text-white transition-colors">Nama Lengkap</label>
                                    <input id="name" name="name" type="text"
                                        class="block mt-2 w-full bg-transparent border-0 border-b border-gray-100 dark:border-white/10 px-0 py-3 text-sm font-light tracking-[0.1em] text-gray-900 dark:text-white focus:ring-0 focus:border-black dark:focus:border-white transition-all"
                                        value="{{ old('name', $user->name) }}" required autofocus />
                                    <x-input-error class="mt-2 text-[10px]" :messages="$errors->get('name')" />
                                </div>

                                {{-- Input Email --}}
                                <div class="group">
                                    <label for="email" class="text-[10px] font-bold uppercase tracking-[0.3em] text-gray-400 group-focus-within:text-black dark:group-focus-within:text-white transition-colors">Email Registrasi</label>
                                    <input id="email" name="email" type="email"
                                        class="block mt-2 w-full bg-transparent border-0 border-b border-gray-100 dark:border-white/10 px-0 py-3 text-sm font-bold tracking-[0.1em] text-gray-900 dark:text-white focus:ring-0 focus:border-black dark:focus:border-white transition-all"
                                        value="{{ old('email', $user->email) }}" required />
                                    <x-input-error class="mt-2 text-[10px]" :messages="$errors->get('email')" />
                                </div>
                            </div>

                            <div class="flex items-center gap-8 pt-6">
                                <button type="submit" class="border border-black dark:border-white bg-black dark:bg-white px-10 py-4 text-[10px] font-bold uppercase tracking-[0.4em] text-white dark:text-black hover:bg-transparent hover:text-black dark:hover:text-white transition-all">
                                    Simpan Perubahan
                                </button>
                                @if (session('status') === 'profile-updated')
                                    <span x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-[9px] font-light uppercase tracking-widest text-emerald-500 italic">Tersimpan.</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-12">

                    {{-- UBAH PASSWORD --}}
                    <div class="p-8 bg-white dark:bg-[#0f0f0f] border border-gray-100 dark:border-white/[0.05] lg:rounded-[2rem]">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.3em] mb-8">Kunci Keamanan</h3>

                        <form method="post" action="{{ route('password.update') }}" class="space-y-8">
                            @csrf
                            @method('put')

                            <div class="group">
                                <label class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Sandi Saat Ini</label>
                                <input id="update_password_current_password" name="current_password" type="password" class="block w-full bg-transparent border-0 border-b border-gray-50 dark:border-white/5 px-0 py-2 text-xs font-light tracking-widest text-gray-900 dark:text-white focus:ring-0 focus:border-black dark:focus:border-white transition-all" autocomplete="current-password" />
                            </div>

                            <div class="group">
                                <label class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Sandi Baru</label>
                                <input id="update_password_password" name="password" type="password" class="block w-full bg-transparent border-0 border-b border-gray-50 dark:border-white/5 px-0 py-2 text-xs font-light tracking-widest text-gray-900 dark:text-white focus:ring-0 focus:border-black dark:focus:border-white transition-all" autocomplete="new-password" />
                            </div>

                            <button type="submit" class="w-full border border-gray-200 dark:border-white/10 py-3 text-[8px] font-bold uppercase tracking-[0.4em] hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition-all">
                                Perbarui Sandi
                            </button>
                        </form>
                    </div>

                    {{-- HAPUS AKUN --}}
                    <div class="p-8 bg-white dark:bg-[#0f0f0f] border border-rose-100/50 dark:border-rose-900/20 lg:rounded-[2rem] group/del transition-all hover:border-rose-500/50">
                        <div class="space-y-4">
                            <h3 class="text-[10px] font-black uppercase tracking-[0.3em] text-rose-500">Zona Bahaya</h3>
                            <p class="text-[9px] font-light text-gray-400 uppercase tracking-widest leading-relaxed">
                                Tindakan tidak dapat dibatalkan. Menghapus seluruh arsip data.
                            </p>
                            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                                class="text-[8px] font-black uppercase tracking-[0.3em] text-rose-500 border-b border-rose-200 dark:border-rose-900/30 pb-1 hover:border-rose-500 transition-all text-left">
                                Hapus Akun
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-12 bg-white dark:bg-[#0f0f0f]">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-light text-gray-900 dark:text-white uppercase tracking-widest mb-4">
                Konfirmasi <span class="text-rose-500 italic">Hapus</span>
            </h2>

            <p class="text-[10px] font-light text-gray-400 uppercase tracking-widest leading-relaxed mb-8">
                Seluruh data akan dihapus permanen dari registri kami. Masukkan kata sandi untuk konfirmasi.
            </p>

            <div class="group mb-8">
                <input id="password" name="password" type="password"
                    class="block w-full bg-transparent border-0 border-b border-gray-100 dark:border-white/10 px-0 py-3 text-sm font-light tracking-[0.4em] text-gray-900 dark:text-white focus:ring-0 focus:border-black dark:focus:border-white"
                    placeholder="KATA SANDI KONFIRMASI" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[10px]" />
            </div>

            <div class="flex justify-end gap-6 items-center">
                <button type="button" x-on:click="$dispatch('close')" class="text-[9px] font-light uppercase tracking-widest text-gray-400 hover:text-black dark:hover:text-white transition-colors">
                    Batal
                </button>
                <button type="submit" class="bg-rose-500 text-white px-8 py-4 text-[9px] font-bold uppercase tracking-[0.3em] hover:bg-rose-600 transition-all shadow-xl shadow-rose-500/20">
                    Hapus Sekarang
                </button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
