{{-- resources/views/superadmin/activity.blade.php --}}
<x-guest-layout>
    <div
        x-data="themeSwitcher()"
        x-init="init()"
        class="min-h-screen bg-slate-50 dark:bg-slate-900"
    >
        {{-- NAVBAR --}}
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

                <div class="flex items-center gap-4 text-sm">
                    <a href="{{ route('articles.index') }}"
                       class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Beranda
                    </a>

                    <a href="{{ route('dashboard') }}"
                       class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Dashboard
                    </a>

                    <a href="{{ route('profile.show') }}"
                       class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Profil
                    </a>

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

        {{-- KONTEN --}}
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="mb-6">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-slate-50">
                    Aktivitas Admin & User
                </h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                    Riwayat artikel: siapa yang membuat, dan siapa yang mem-publish.
                </p>
            </div>

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-600 dark:text-slate-300">
                        <tr>
                            <th class="px-4 py-3 text-left">Judul</th>
                            <th class="px-4 py-3 text-left">Penulis</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Dipublish oleh</th>
                            <th class="px-4 py-3 text-left">Tgl Dibuat</th>
                            <th class="px-4 py-3 text-left">Tgl Publish</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse ($articles as $article)
                            <tr class="text-slate-800 dark:text-slate-100">
                                <td class="px-4 py-3">
                                    {{ $article->title }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $article->author->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($article->status === 'published')
                                        <span class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">
                                            published
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">
                                            pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    {{ $article->publisher->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $article->created_at?->format('d M Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $article->published_at
                                        ? \Carbon\Carbon::parse($article->published_at)->format('d M Y H:i')
                                        : '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('articles.show', $article) }}"
                                       class="inline-flex items-center px-3 py-1.5 text-xs rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-slate-500 dark:text-slate-300">
                                    Belum ada aktivitas artikel.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination (kalau pakai paginate di controller) --}}
            <div class="mt-6">
                {{ $articles->links() }}
            </div>
        </main>
    </div>

    {{-- Alpine theme --}}
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
