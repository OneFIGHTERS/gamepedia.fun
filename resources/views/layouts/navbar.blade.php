{{-- resources/views/layouts/navbar.blade.php --}}
<header class="border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur">
    <div class="max-w-7xl mx-auto h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">

        {{-- Logo --}}
        <a href="{{ route('articles.index') }}" class="flex items-center gap-2">
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-indigo-600 text-white font-bold">
                G
            </span>
            <span class="font-semibold text-lg text-slate-900 dark:text-slate-100">
                Gamepedia
            </span>
        </a>

        {{-- Menu kanan --}}
        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('articles.index') }}"
               class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                Beranda
            </a>

        @auth
            <a href="{{ route('dashboard') }}"
            class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                Dashboard
            </a>

            <a href="{{ route('profile.show') }}"
            class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                Profil
            </a>

            {{-- Logout biasa (di-klik user) --}}
            <form id="manual-logout-form" method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                @csrf
                <button type="submit"
                        class="text-slate-600 dark:text-slate-200 hover:text-red-600 dark:hover:text-red-400">
                    Log out
                </button>
            </form>

            {{-- Logout otomatis kalau idle --}}
            <form id="auto-logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Lama idle dalam menit (silakan ganti)
                    const MAX_IDLE_MINUTES = 15;

                    let idleTimeout = null;

                    function doLogout() {
                        // Kirim form logout otomatis
                        const form = document.getElementById('auto-logout-form');
                        if (form) {
                            form.submit();
                        }
                    }

                    function resetIdleTimer() {
                        if (idleTimeout) {
                            clearTimeout(idleTimeout);
                        }
                        idleTimeout = setTimeout(doLogout, MAX_IDLE_MINUTES * 60 * 1000);
                    }

                    // Event yang dianggap "aktif"
                    const events = ['click', 'mousemove', 'keydown', 'scroll', 'touchstart'];

                    events.forEach(eventName => {
                        document.addEventListener(eventName, resetIdleTimer, {passive: true});
                    });

                    // Set timer pertama kali
                    resetIdleTimer();
                });
            </script>
        @else
            <a href="{{ route('login') }}"
            class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                Log in
            </a>
            <a href="{{ route('register') }}"
            class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                Register
            </a>
        @endauth


            {{-- Tombol dark mode --}}
            <button
                @click="toggle()"
                type="button"
                class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-300 dark:border-slate-600
                       text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                :aria-label="dark ? 'Switch to light mode' : 'Switch to dark mode'">
                <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 3v2.25M18.364 5.636l-1.591 1.591M21 12h-2.25M18.364 18.364l-1.591-1.591M12 18.75V21M7.227 16.773 5.636 18.364M5.25 12H3M7.227 7.227 5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0z"/>
                </svg>
                <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 12.79A9 9 0 0 1 12.79 3 6 6 0 0 0 12 15a6 6 0 0 0 9-2.21z"/>
                </svg>
            </button>
        </div>
    </div>
</header>
