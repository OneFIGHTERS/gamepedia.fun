{{-- resources/views/superadmin/dashboard.blade.php --}}
<x-guest-layout>
    <div x-data="themeSwitcher()" x-init="init()" class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">
        {{-- NAVBAR --}}
        <header class="sticky top-0 z-50 border-b border-slate-200/50 dark:border-slate-800/50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg shadow-sm">
            <div class="max-w-7xl mx-auto h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                
                {{-- Logo --}}
                <a href="{{ route('articles.index') }}" class="flex items-center gap-3 group">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white font-bold shadow-md group-hover:shadow-lg transition-all duration-300">
                        G
                    </span>
                    <span class="font-bold text-xl text-slate-900 dark:text-slate-100 tracking-tight">
                        Gamepedia<span class="text-indigo-600 dark:text-indigo-400">.</span>
                    </span>
                </a>

                {{-- Menu kanan --}}
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-5 text-sm">
                        <a href="{{ route('articles.index') }}" 
                           class="text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 font-medium px-3 py-1 rounded-lg hover:bg-indigo-50 dark:hover:bg-slate-800">
                           <i class="mr-2 fas fa-home"></i>Beranda
                        </a>

                        <a href="{{ route('profile.show') }}" 
                           class="text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors duration-200 font-medium px-3 py-1 rounded-lg hover:bg-indigo-50 dark:hover:bg-slate-800">
                           <i class="mr-2 fas fa-user"></i>Profil
                        </a>
                    </div>

                    <div class="h-6 w-px bg-slate-300 dark:bg-slate-700"></div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                        @csrf
                        <button type="submit"
                            class="text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-400 transition-colors duration-200 font-medium px-3 py-1 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                            <i class="mr-2 fas fa-sign-out-alt"></i>Log out
                        </button>
                    </form>

                    {{-- Badge Super Admin --}}
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold rounded-full shadow-md">
                        <i class="fas fa-crown text-xs"></i>
                        <span>SUPER ADMIN</span>
                    </div>

                    {{-- Tombol dark mode --}}
                    <button
                        @click="toggle()"
                        type="button"
                        class="relative inline-flex h-9 w-9 items-center justify-center rounded-full border 
                               border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 
                               hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-300
                               hover:scale-105 hover:shadow-md"
                    >
                        {{-- Icon Light --}}
                        <svg x-show="!dark" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 3v2.25M18.364 5.636l-1.591 1.591M21 12h-2.25M18.364 18.364l-1.591-1.591M12 18.75V21M7.227 16.773 5.636 18.364M5.25 12H3M7.227 7.227 
                                     5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0z"/>
                        </svg>

                        {{-- Icon Dark --}}
                        <svg x-show="dark" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 12.79A9 9 0 0 1 12.79 3 6 6 0 0 0 12 15a6 6 0 0 0 9-2.21z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        {{-- KONTEN UTAMA --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Header dengan greeting --}}
            <div class="mb-10">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-4xl sm:text-5xl font-bold text-slate-900 dark:text-slate-50 tracking-tight">
                         Hi, <span class="text-indigo-600 dark:text-indigo-400">Super Admin</span>
                    </h1>
                    
                    <div class="hidden lg:flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-full border border-indigo-200 dark:border-indigo-800">
                        <i class="fas fa-user-circle text-indigo-600 dark:text-indigo-400"></i>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ auth()->user()->name }}</span>
                    </div>
                </div>

                <p class="text-lg text-slate-600 dark:text-slate-400 max-w-3xl leading-relaxed">
                    Selamat datang di panel kontrol utama Gamepedia. Sebagai <span class="font-semibold text-amber-500">Super Admin</span>, Anda memiliki akses penuh untuk mengelola seluruh ekosistem platform.
                </p>
            </div>

            {{-- Statistik Ringkas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-700 dark:text-slate-300">Total Pengguna</h3>
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                            <i class="fas fa-users text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">
                        {{ \App\Models\User::count() ?? '0' }}
                    </p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>+12%
                        </span> dari bulan lalu
                    </p>
                </div>

                <div class="bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-700 dark:text-slate-300">Total Artikel</h3>
                        <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                            <i class="fas fa-newspaper text-emerald-600 dark:text-emerald-400"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">
                        {{ \App\Models\Article::count() ?? '0' }}
                    </p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">
                            <i class="fas fa-arrow-up mr-1"></i>+8%
                        </span> dari bulan lalu
                    </p>
                </div>

                <div class="bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-slate-700 dark:text-slate-300">Aktivitas Hari Ini</h3>
                        <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                            <i class="fas fa-chart-line text-amber-600 dark:text-amber-400"></i>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white">42</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">
                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">
                            <i class="fas fa-fire mr-1"></i>Aktif
                        </span> dalam 24 jam terakhir
                    </p>
                </div>
            </div>

            {{-- Panel Kontrol Utama --}}
            <div class="mb-10">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-6 flex items-center gap-3">
                    <i class="fas fa-sliders-h text-indigo-600 dark:text-indigo-400"></i>
                    Kontrol Utama
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Kontrol Artikel --}}
                    <div class="group bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl shadow-md">
                                <i class="fas fa-newspaper text-white text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-full">Artikel</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Kelola Artikel</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm mb-6">
                            Buat, edit, dan kelola semua artikel Gamepedia. Kontrol konten platform dengan akses penuh.
                        </p>
                        <div class="space-y-3">
                            <a href="{{ route('articles.create') }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-xl hover:shadow-lg transition-all duration-300 group-hover:from-indigo-700 group-hover:to-purple-700">
                                <i class="fas fa-plus-circle"></i>
                                Buat Artikel Baru
                            </a>
                            <a href="{{ route('articles.index') }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors duration-300">
                                <i class="fas fa-list"></i>
                                Lihat Semua Artikel
                            </a>
                        </div>
                    </div>

                    {{-- Kontrol Pengguna --}}
                    <div class="group bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl shadow-md">
                                <i class="fas fa-users-cog text-white text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-full">Pengguna</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Kelola Pengguna & Role</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm mb-6">
                            Kelola semua pengguna, atur role, dan kontrol hak akses. Super admin memiliki kontrol penuh.
                        </p>
                        <div class="space-y-3">
                            <a href="{{ route('superadmin.users.index') }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-medium rounded-xl hover:shadow-lg transition-all duration-300 group-hover:from-emerald-700 group-hover:to-teal-700">
                                <i class="fas fa-user-shield"></i>
                                Kelola Semua Pengguna
                            </a>
                            <a href="#"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors duration-300">
                                <i class="fas fa-user-tag"></i>
                                Atur Role & Permission
                            </a>
                        </div>
                    </div>

                    {{-- Kontrol Sistem --}}
                    <div class="group bg-gradient-to-br from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl shadow-md">
                                <i class="fas fa-cogs text-white text-xl"></i>
                            </div>
                            <span class="text-xs font-semibold px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-full">Sistem</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Konfigurasi Sistem</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm mb-6">
                            Pengaturan sistem, backup data, log aktivitas, dan konfigurasi penting lainnya.
                        </p>
                        <div class="space-y-3">
                            <a href="#"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-medium rounded-xl hover:shadow-lg transition-all duration-300 group-hover:from-amber-600 group-hover:to-orange-600">
                                <i class="fas fa-database"></i>
                                Backup & Restore
                            </a>
                            <a href="#"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors duration-300">
                                <i class="fas fa-history"></i>
                                Lihat Log Aktivitas
                            </a>

                            {{-- BARU: tombol aktivitas admin & user --}}
                            <a href="{{ route('superadmin.activity') }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors duration-300">
                                <i class="fas fa-clipboard-list"></i>
                                Aktivitas Admin & User
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
                            Terakhir diakses: {{ now()->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('articles.index') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-slate-800 to-slate-900 dark:from-slate-700 dark:to-slate-800 text-white font-medium rounded-xl hover:shadow-lg transition-all duration-300">
                            <i class="fas fa-globe"></i>
                            Kunjungi Gamepedia
                        </a>
                        <button class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 transition-colors duration-300">
                            <i class="fas fa-sync-alt"></i>
                            Refresh Dashboard
                        </button>
                    </div>
                </div>
            </div>
        </main>

        {{-- Font Awesome Icons --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        {{-- Script Dark Mode --}}
        <script>
            function themeSwitcher() {
                return {
                    dark: false,
                    init() {
                        this.dark = localStorage.getItem("theme") === "dark";
                        document.documentElement.classList.toggle("dark", this.dark);
                    },
                    toggle() {
                        this.dark = !this.dark;
                        document.documentElement.classList.toggle("dark", this.dark);
                        localStorage.setItem("theme", this.dark ? "dark" : "light");
                    },
                };
            }
        </script>
    </div>
</x-guest-layout>
