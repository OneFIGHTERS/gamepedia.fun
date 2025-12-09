{{-- resources/views/admin/dashboard.blade.php --}}
<x-guest-layout>
    <div
        x-data="themeSwitcher()"
        x-init="init()"
        class="min-h-screen bg-slate-50 dark:bg-slate-900"
    >
        {{-- NAVBAR --}}
        <header class="border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur">
            <div class="max-w-7xl mx-auto h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                {{-- Logo + Judul --}}
                <a href="{{ route('articles.index') }}" class="flex items-center gap-2">
                    <span
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-indigo-600 text-white font-bold">
                        G
                    </span>
                    <span class="font-semibold text-lg text-slate-900 dark:text-slate-100">
                        Gamepedia
                    </span>
                </a>

                {{-- Link kanan: Beranda / Profile / Log out --}}
                <div class="flex items-center gap-4 text-sm">
                    {{-- Beranda --}}
                    <a href="{{ route('articles.index') }}"
                       class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Beranda
                    </a>

                    {{-- Profile --}}
                    <a href="{{ route('profile.show') }}"
                       class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Profile
                    </a>

                    {{-- Log out --}}
                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                        @csrf
                        <button type="submit"
                                class="text-slate-600 dark:text-slate-200 hover:text-red-600 dark:hover:text-red-400">
                            Log out
                        </button>
                    </form>

                    {{-- Tombol dark mode --}}
                    <button
                        @click="toggle()"
                        type="button"
                        class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                        :aria-label="dark ? 'Switch to light mode' : 'Switch to dark mode'">
                        {{-- icon matahari --}}
                        <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 3v2.25M18.364 5.636l-1.591 1.591M21 12h-2.25M18.364 18.364l-1.591-1.591M12 18.75V21M7.227 16.773 5.636 18.364M5.25 12H3M7.227 7.227 5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0z"/>
                        </svg>
                        {{-- icon bulan --}}
                        <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 12.79A9 9 0 0 1 12.79 3 6 6 0 0 0 12 15a6 6 0 0 0 9-2.21z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        {{-- KONTEN DASHBOARD ADMIN --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="mb-6">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-slate-50">
                    Admin Dashboard
                </h1>
                <p class="mt-4 text-sm text-slate-600 dark:text-slate-200">
                    Halo, Admin {{ auth()->user()->name }} 👋
                </p>
            </div>

            <div
                class="bg-slate-100 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 text-slate-900 dark:text-slate-100 shadow-lg">
                <h2 class="text-xl font-semibold mb-3">
                    Panel Kendali Gamepedia
                </h2>
                <p class="text-sm text-slate-600 dark:text-slate-300 mb-4">
                    Dari sini kamu bisa mengelola konten Gamepedia. Gunakan tombol di bawah untuk membuat, mengecek
                    artikel pending, dan mem-publish artikel yang dibuat user maupun admin.
                </p>

                <div class="mt-4 flex flex-wrap gap-3">
                    {{-- Halaman publik --}}
                    <a href="{{ route('articles.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm">
                        Lihat Halaman Gamepedia
                    </a>

                    {{-- Buat artikel baru (admin juga bisa bikin artikel sendiri) --}}
                    <a href="{{ route('articles.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 shadow-sm">
                        Buat Artikel Baru
                    </a>

                    {{-- Kelola & publish artikel user/admin --}}
                    <a href="{{ route('admin.articles.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-500 text-white text-sm font-medium hover:bg-amber-600 shadow-sm">
                        Kelola & Publish Artikel
                    </a>
                </div>
            </div>
        </main>
    </div>

    {{-- Alpine component untuk dark mode --}}
    <script>
        function themeSwitcher() {
            return {
                dark: false,
                init() {
                    this.dark = localStorage.getItem('theme') === 'dark';
                    document.documentElement.classList.toggle('dark', this.dark);
                },
                toggle() {
                    this.dark = !this.dark;
                    document.documentElement.classList.toggle('dark', this.dark);
                    localStorage.setItem('theme', this.dark ? 'dark' : 'light');
                },
            }
        }
    </script>
</x-guest-layout>
