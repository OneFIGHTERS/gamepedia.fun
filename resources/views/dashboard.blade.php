{{-- resources/views/dashboard.blade.php --}}
<x-guest-layout>
    <div x-data="themeSwitcher()" x-init="init()" class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-900 dark:to-slate-800">
        {{-- NAVBAR --}}
        <header class="sticky top-0 z-50 border-b border-slate-200/60 dark:border-slate-800/60 bg-white/90 dark:bg-slate-900/90 backdrop-blur-lg shadow-sm">
            <div class="max-w-7xl mx-auto h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                {{-- Logo + Judul --}}
                <a href="{{ route('articles.index') }}" class="flex items-center gap-3 group">
                    <span
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white font-bold shadow-md group-hover:shadow-lg transition-all duration-300">
                        G
                    </span>
                    <span class="font-bold text-xl text-slate-900 dark:text-slate-100 tracking-tight">
                        Gamepedia<span class="text-indigo-600 dark:text-indigo-400">.</span>
                    </span>
                </a>

                {{-- Link kanan: Beranda / Profile / Log out --}}
                <div class="flex items-center gap-6">
                    <div class="hidden md:flex items-center gap-5 text-sm">
                        <a href="{{ route('articles.index') }}"
                           class="flex items-center gap-2 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 font-medium px-3 py-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-slate-800">
                            <i class="fas fa-home text-sm"></i>
                            Beranda
                        </a>

                        <a href="{{ route('profile.show') }}"
                           class="flex items-center gap-2 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 font-medium px-3 py-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-slate-800">
                            <i class="fas fa-user text-sm"></i>
                            Profile
                        </a>
                    </div>

                    <div class="hidden md:block h-6 w-px bg-slate-300 dark:bg-slate-700"></div>

                    {{-- Mobile Menu --}}
                    <div class="md:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2">
                            <i class="fas fa-bars text-slate-700 dark:text-slate-300"></i>
                        </button>
                    </div>

                    {{-- User Info Badge --}}
                    <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-full border border-indigo-200 dark:border-indigo-800">
                        <div class="h-6 w-6 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ auth()->user()->name }}</span>
                    </div>

                    {{-- Log out --}}
                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2 text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-400 transition-colors duration-200 font-medium px-3 py-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                            <i class="fas fa-sign-out-alt text-sm"></i>
                            <span class="hidden sm:inline">Log out</span>
                        </button>
                    </form>

                    {{-- Tombol dark mode --}}
                    <button
                        @click="toggle()"
                        type="button"
                        class="relative inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-300 hover:scale-105 hover:shadow-md"
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

            {{-- Mobile Menu Dropdown --}}
            <div x-data="{ mobileMenuOpen: false }" x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" 
                 class="md:hidden absolute top-16 inset-x-0 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 shadow-lg">
                <div class="px-4 py-3 space-y-2">
                    <a href="{{ route('articles.index') }}"
                       class="flex items-center gap-3 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 font-medium px-3 py-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-slate-800">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                    <a href="{{ route('profile.show') }}"
                       class="flex items-center gap-3 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 font-medium px-3 py-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-slate-800">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                    <div class="pt-2 border-t border-slate-200 dark:border-slate-800">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="flex items-center gap-3 w-full text-left text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-400 transition-colors duration-200 font-medium px-3 py-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                <i class="fas fa-sign-out-alt"></i>
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- KONTEN DASHBOARD USER --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Header Welcome --}}
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-4xl sm:text-5xl font-bold text-slate-900 dark:text-slate-50 tracking-tight">
                            User <span class="text-indigo-600 dark:text-indigo-400">Dashboard</span>
                        </h1>
                        <p class="mt-3 text-lg text-slate-600 dark:text-slate-400">
                            Selamat datang kembali, <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ auth()->user()->name }}</span> 👋
                        </p>
                    </div>
                    
                    <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
                        <i class="fas fa-calendar-day text-indigo-600 dark:text-indigo-400"></i>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Statistik User --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                {{-- Total Artikel Anda --}}
                <div class="bg-gradient-to-br from-white to-blue-50 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-700 dark:text-slate-300">Artikel Anda</h3>
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <i class="fas fa-newspaper text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">
                        @php
                            try {
                                // Coba hitung artikel user dengan cara aman
                                if (class_exists('App\\Models\\Article')) {
                                    $articleCount = App\Models\Article::where('user_id', auth()->id())->count();
                                } else {
                                    $articleCount = 0;
                                }
                            } catch (Exception $e) {
                                $articleCount = 0;
                            }
                        @endphp
                        {{ $articleCount }}
                    </p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                        Total artikel yang Anda buat
                    </p>
                </div>

                {{-- Artikel Terbaru --}}
                <div class="bg-gradient-to-br from-white to-blue-50 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-700 dark:text-slate-300">Artikel Terbaru</h3>
                        <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                            <i class="fas fa-clock text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                    </div>
                    <p class="text-lg font-bold text-slate-900 dark:text-white truncate">
                        @php
                            $latestArticleTitle = 'Belum ada artikel';
                            try {
                                if (class_exists('App\\Models\\Article')) {
                                    $latestArticle = App\Models\Article::where('user_id', auth()->id())->latest()->first();
                                    if ($latestArticle) {
                                        $latestArticleTitle = $latestArticle->title;
                                        $latestArticleTime = $latestArticle->created_at->diffForHumans();
                                    }
                                }
                            } catch (Exception $e) {
                                // Biarkan default value
                            }
                        @endphp
                        {{ $latestArticleTitle }}
                    </p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                        {{ $latestArticleTime ?? 'Mulai tulis sekarang!' }}
                    </p>
                </div>

                {{-- Status Aktivitas --}}
                <div class="bg-gradient-to-br from-white to-blue-50 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-700 dark:text-slate-300">Status</h3>
                        <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                            <i class="fas fa-user-check text-amber-600 dark:text-amber-400"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">Aktif</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                        Member sejak {{ auth()->user()->created_at->format('M Y') }}
                    </p>
                </div>
            </div>

            {{-- Main Content Card --}}
            <div class="mb-10">
                <div class="bg-gradient-to-br from-white to-blue-50 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl shadow-md">
                            <i class="fas fa-gamepad text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100">
                                Jelajahi Dunia Game
                            </h2>
                            <p class="mt-2 text-slate-600 dark:text-slate-300">
                                Selamat datang di Gamepedia! Platform komunitas gamers tempat kamu bisa berbagi pengetahuan, 
                                tips, dan ulasan tentang berbagai game favorit.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                        {{-- Panel Jelajahi --}}
                        <div class="bg-gradient-to-br from-slate-50 to-white dark:from-slate-800/50 dark:to-slate-900/50 rounded-xl p-5 border border-slate-200 dark:border-slate-700">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                    <i class="fas fa-compass text-indigo-600 dark:text-indigo-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Jelajahi Artikel</h3>
                            </div>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                                Temukan artikel menarik dari berbagai genre game. Dari review terbaru hingga tips & trik gameplay.
                            </p>
                            <a href="{{ route('articles.index') }}"
                               class="inline-flex items-center gap-2 px-4 py-2.5 w-full justify-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-300 hover:from-indigo-700 hover:to-purple-700">
                                <i class="fas fa-search"></i>
                                Jelajahi Gamepedia
                            </a>
                        </div>

                        {{-- Panel Buat Artikel --}}
                        <div class="bg-gradient-to-br from-slate-50 to-white dark:from-slate-800/50 dark:to-slate-900/50 rounded-xl p-5 border border-slate-200 dark:border-slate-700">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                                    <i class="fas fa-edit text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Buat Artikel</h3>
                            </div>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                                Bagikan pengetahuan game-mu! Buat artikel tentang review, tips, atau berita game terbaru.
                            </p>
                            <a href="{{ route('articles.create') }}"
                               class="inline-flex items-center gap-2 px-4 py-2.5 w-full justify-center bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-medium rounded-lg hover:shadow-lg transition-all duration-300 hover:from-emerald-700 hover:to-teal-700">
                                <i class="fas fa-plus-circle"></i>
                                Tulis Artikel Baru
                            </a>
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="mt-8 pt-8 border-t border-slate-200 dark:border-slate-700">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Aksi Cepat</h3>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('articles.index') }}?filter=latest"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors duration-300">
                                <i class="fas fa-fire text-orange-500"></i>
                                Trending
                            </a>
                            <a href="{{ route('articles.index') }}?filter=popular"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors duration-300">
                                <i class="fas fa-chart-line text-blue-500"></i>
                                Popular
                            </a>
                            <a href="{{ route('profile.show') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors duration-300">
                                <i class="fas fa-cog text-slate-500"></i>
                                Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer Dashboard --}}
            <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-800">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div>
                        <p class="text-slate-600 dark:text-slate-400 text-sm">
                            <i class="fas fa-info-circle mr-2 text-indigo-600 dark:text-indigo-400"></i>
                            Dashboard diperbarui secara real-time
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('articles.index') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-slate-800 to-slate-900 dark:from-slate-700 dark:to-slate-800 text-white font-medium rounded-xl hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-globe"></i>
                            Kunjungi Gamepedia
                        </a>
                    </div>
                </div>
            </div>
        </main>

        {{-- Font Awesome Icons --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
    </div>
</x-guest-layout>