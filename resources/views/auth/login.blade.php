<x-guest-layout>
    <div class="min-h-screen bg-[#fafafa] dark:bg-black flex items-center justify-center p-0 sm:p-6 lg:p-10 relative overflow-hidden">

        <div class="w-full max-w-7xl flex flex-col lg:flex-row items-stretch bg-white dark:bg-[#0f0f0f] lg:rounded-[3rem] shadow-[0_0_100px_rgba(0,0,0,0.03)] dark:shadow-none border border-gray-100 dark:border-white/[0.05] overflow-hidden relative z-10 min-h-[100vh] lg:min-h-[85vh]">

            <div class="hidden lg:block w-1/2 relative overflow-hidden group">
                {{-- Image with Zoom Effect --}}
                <img src="{{ asset('img/bakery.jpg') }}"
                     class="absolute inset-0 h-full w-full object-cover grayscale brightness-50 transition-transform duration-[3s] group-hover:scale-110"
                     alt="Background">

                {{-- Overlay Content --}}
                <div class="absolute inset-0 flex flex-col justify-between p-20 z-20">
                    <div class="space-y-2">
                        <span class="text-[10px] font-black uppercase tracking-[0.5em] text-white/60 block">Olland</span>
                        <div class="h-px w-12 bg-white/40"></div>
                    </div>

                    <div class="text-white">
                        <h1 class="text-6xl font-black tracking-tighter leading-[0.85] mb-4">
                            Olland<br><span class="italic text-white/30">Bakery</span>
                        </h1>
                        <p class="text-[11px] font-medium uppercase tracking-[0.3em] text-white/50 leading-relaxed">
                            "Menciptakan kenangan manis di setiap momen"
                        </p>
                    </div>

                    <div class="flex items-center gap-4">
                        <span class="text-[9px] font-bold text-white/30 uppercase tracking-widest">Est.{{ date('Y') }}</span>
                        <div class="flex-1 h-px bg-white/10"></div>
                    </div>
                </div>

                {{-- Subtle Gradient for text readability --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/40"></div>
            </div>

            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative bg-white dark:bg-[#0f0f0f]">
                <div class="w-full max-w-sm space-y-12">

                    {{-- Header Form --}}
                    <div class="space-y-2">
                        <h2 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter uppercase">Login</h2>
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em]">
                            Masukkan identitas anda untuk melanjutkan
                        </p>
                    </div>

                    {{-- Session Status --}}
                    <x-auth-session-status class="mb-4 text-xs font-bold uppercase tracking-widest" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-10">
                        @csrf

                        <div class="group relative">
                            <label for="email" class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-400 group-focus-within:text-black dark:group-focus-within:text-white transition-colors">
                                Email anda
                            </label>
                            <input id="email"
                                class="block mt-1 w-full bg-transparent border-0 border-b border-gray-100 dark:border-white/10 px-0 py-3 text-sm font-bold tracking-tight text-gray-900 dark:text-white focus:ring-0 focus:border-black dark:focus:border-white transition-all placeholder:text-gray-200 dark:placeholder:text-white/5"
                                type="email" name="email" :value="old('email')" required autofocus
                                placeholder="E-mail address" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        <div class="group relative">
                            <label for="password" class="text-[9px] font-black uppercase tracking-[0.3em] text-gray-400 group-focus-within:text-black dark:group-focus-within:text-white transition-colors">
                                Password anda
                            </label>
                            <input id="password"
                                class="block mt-1 w-full bg-transparent border-0 border-b border-gray-100 dark:border-white/10 px-0 py-3 text-sm font-bold tracking-tight text-gray-900 dark:text-white focus:ring-0 focus:border-black dark:focus:border-white transition-all placeholder:text-gray-200 dark:placeholder:text-white/5"
                                type="password" name="password" required
                                placeholder="••••••••" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-[10px] font-bold uppercase" />
                        </div>

                        <div class="pt-6 space-y-8">
                            <button type="submit"
                                class="flex w-full justify-center rounded-full bg-black dark:bg-white px-8 py-5 text-[10px] font-black uppercase tracking-[0.4em] text-white dark:text-black shadow-2xl hover:scale-[1.03] active:scale-[0.98] transition-all duration-300">
                                {{ __('Masuk') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
