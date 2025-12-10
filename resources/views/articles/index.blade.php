{{-- resources/views/articles/index.blade.php --}}
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

                {{-- Link kanan: Login / Register / Dashboard / Logout --}}
                <div class="flex items-center gap-4 text-sm">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                            Dashboard
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                            @csrf
                            <button type="submit"
                                    class="text-slate-600 dark:text-slate-200 hover:text-red-600 dark:hover:text-red-400">
                                Log out
                            </button>
                        </form>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}"
                               class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                                Log in
                            </a>
                        @endif

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                                Register
                            </a>
                        @endif
                    @endauth

                    {{-- Tombol dark mode --}}
                    <button
                        @click="toggle()"
                        type="button"
                        class="inline-flex h-8 w-8 items-center justify-center rounded-full border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
                        :aria-label="dark ? 'Switch to light mode' : 'Switch to dark mode'"
                    >
                        {{-- Icon matahari / bulan --}}
                        <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 3v2.25M18.364 5.636l-1.591 1.591M21 12h-2.25M18.364 18.364l-1.591-1.591M12 18.75V21M7.227 16.773 5.636 18.364M5.25 12H3M7.227 7.227 5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0z"/>
                        </svg>
                        <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 12.79A9 9 0 0 1 12.79 3 6 6 0 0 0 12 15a6 6 0 0 0 9-2.21z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </header>

        {{-- KONTEN UTAMA --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Judul & deskripsi singkat --}}
            <div class="mb-6">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-slate-100">
                    Gamepedia
                </h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">
                    Kumpulan artikel dan pengetahuan seputar game seperti Minecraft, dll.
                </p>
            </div>

            {{-- Notif sukses --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Tombol tambah artikel khusus admin --}}
           {{-- Tombol tambah / tulis artikel: semua user login boleh --}}
            @auth
                <div class="mb-4">
                    <a href="{{ route('articles.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm">
                        @if(in_array(auth()->user()->role, ['admin', 'super_admin']))
                            + Tambah Artikel Gamepedia
                        @else
                            + Tulis Artikel Kamu
                        @endif
                    </a>
                </div>
            @endauth

            {{-- LIST ARTIKEL --}}
            @if ($articles->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($articles as $article)
                        <a href="{{ route('articles.show', $article) }}"
                           class="group bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl p-5 shadow-sm hover:shadow-lg hover:border-indigo-300 dark:hover:border-indigo-500 transition">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-50 group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                    {{ $article->title }}
                                </h2>
                                <span
                                    class="px-2 py-1 text-xs rounded-full bg-indigo-50 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-200">
                                    {{ $article->game }}
                                </span>
                            </div>

                            <p class="text-sm text-slate-600 dark:text-slate-300">
                                {{ \Illuminate\Support\Str::limit($article->content, 130) }}
                            </p>

                            <div class="mt-4 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                                <span>{{ $article->created_at->format('d M Y') }}</span>
                                <span class="inline-flex items-center gap-1 text-indigo-600 dark:text-indigo-400">
                                    Baca selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @else
                <p class="text-slate-600 dark:text-slate-300">
                    Belum ada artikel.
                </p>
            @endif
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
