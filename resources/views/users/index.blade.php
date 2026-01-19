<x-app-layout>
    {{-- Header halaman --}}
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            {{-- Judul halaman --}}
            <div>
                <span class="text-xs font-medium text-gray-400 dark:text-gray-500 block mb-1">Administrasi</span>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white tracking-tight">
                    Manajemen Pengguna
                </h2>
            </div>

            {{-- Tombol tambah pengguna baru --}}
            <a href="{{ route('users.create') }}"
                class="inline-flex items-center px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-lg font-medium text-sm transition-all hover:opacity-80 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah pengguna baru
            </a>
        </div>
    </x-slot>

    {{-- Konten utama --}}
    <div class="py-10" x-data="{ showDeleteModal: false, deleteUrl: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Card tabel pengguna --}}
            <div
                class="bg-white dark:bg-[#121212] overflow-hidden border border-gray-200 dark:border-white/5 sm:rounded-xl">
                <div class="p-0 text-gray-900 dark:text-gray-100">

                    {{-- Header tabel --}}
                    <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-white/5">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Daftar anggota aktif</h3>
                        <span
                            class="text-xs font-medium text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-white/5 px-3 py-1 rounded-full border border-gray-100 dark:border-white/5">
                            {{ $users->count() }} orang terpilih
                        </span>
                    </div>

                    {{-- Tabel daftar pengguna --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-white/5">
                            <thead class="bg-gray-50/50 dark:bg-white/[0.02]">
                                <tr>
                                    <th>Identitas</th>
                                    <th>Peran</th>
                                    <th>Terdaftar</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>

                            {{-- Body tabel --}}
                            <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                                @forelse ($users as $user)
                                    <tr
                                        class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors duration-150">
                                        {{-- Kolom identitas --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img class="h-9 w-9 rounded-full object-cover border border-gray-200 dark:border-white/10"
                                                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/name=' . urlencode($user->name) . '&background=f3f4f6&color=6b7280' }}"
                                                    alt="{{ $user->name }}">
                                                <div class="ml-4">
                                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                        {{ $user->name }}</div>
                                                    <div class="text-xs text-gray-400 dark:text-gray-500">
                                                        {{ $user->email }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Kolom peran --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $roleClasses = match (strtolower($user->role)) {
                                                    'admin'
                                                        => 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-400/10',
                                                    'member'
                                                        => 'text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-white/5',
                                                    default => 'text-gray-500 bg-gray-50',
                                                };
                                            @endphp
                                            <span
                                                class="px-2.5 py-0.5 inline-flex text-[11px] font-medium rounded-md {{ $roleClasses }} border border-current opacity-80">
                                                {{ $user->role }}
                                            </span>
                                        </td>

                                        {{-- Kolom tanggal terdaftar --}}
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                                            {{ $user->created_at->format('d M, Y') }}
                                        </td>

                                        {{-- Kolom aksi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end items-center gap-4">
                                                {{-- Detail --}}
                                                <a href="{{ route('users.show', $user->id) }}"
                                                    class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition"
                                                    title="Detail">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>

                                                {{-- Edit --}}
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition"
                                                    title="Edit">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>

                                                {{-- Hapus --}}
                                                <button
                                                    @click="showDeleteModal = true; deleteUrl = '{{ route('users.destroy', $user->id) }}'"
                                                    class="text-gray-400 hover:text-red-500 transition" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Jika data kosong --}}
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-20 text-center">
                                            <p class="text-xs font-medium text-gray-400 tracking-widest uppercase">Data
                                                tidak tersedia</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Footer/Pagination --}}
                    @if ($users->hasPages())
                        <div class="p-6 border-t border-gray-100 dark:border-white/5">
                            {{ $users->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- Modal Hapus --}}
        <div x-show="showDeleteModal" style="display: none;"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900/20 backdrop-blur-md"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">

            <div class="bg-white dark:bg-[#1a1a1a] border border-gray-200 dark:border-white/10 rounded-xl shadow-2xl w-full max-w-sm p-8"
                @click.away="showDeleteModal = false">

                {{-- Judul modal --}}
                <h3 class="text-lg font-bold text-gray-900 dark:text-white tracking-tight text-center">Hapus Akun?</h3>

                {{-- Pesan --}}
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 text-center leading-relaxed">
                    Data pengguna ini akan dihapus secara permanen dari basis data kami.
                </p>

                {{-- Tombol konfirmasi & batal --}}
                <div class="mt-8 flex flex-col gap-2">
                    <form :action="deleteUrl" method="POST" class="w-full">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full py-2.5 bg-red-500 text-white rounded-lg text-xs font-bold uppercase tracking-widest hover:bg-red-600 transition">
                            Konfirmasi Hapus
                        </button>
                    </form>
                    <button @click="showDeleteModal = false"
                        class="w-full py-2.5 bg-transparent text-gray-500 dark:text-gray-400 text-xs font-bold uppercase tracking-widest hover:text-gray-900 dark:hover:text-white transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
