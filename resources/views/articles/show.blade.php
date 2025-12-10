{{-- resources/views/articles/show.blade.php --}}
<x-guest-layout>
    <div
        x-data="themeSwitcher()"
        x-init="init()"
        class="min-h-screen bg-slate-50 dark:bg-slate-900"
    >
        {{-- NAVBAR --}}
        @include('layouts.navbar')

        @php
            // daftar game yang “resmi” jadi kategori
            $knownGames = ['minecraft', 'valorant'];

            $gameSlug = null;

            if ($article->game) {
                $lowerGame = strtolower($article->game);
                // bikin slug: "Mine Craft" -> "mine-craft"
                $slug = \Illuminate\Support\Str::slug($lowerGame, '-');

                // kalau "semua game" atau bukan salah satu dari $knownGames -> kategori Lainnya
                if ($lowerGame === 'semua game' || ! in_array($slug, $knownGames)) {
                    $gameSlug = 'lainnya';
                } else {
                    $gameSlug = $slug;
                }
            }
        @endphp

        {{-- KONTEN ARTIKEL --}}
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

            {{-- Tombol kembali --}}
            <a href="{{ route('articles.index') }}" class="text-sm text-indigo-500 hover:text-indigo-400">
                ← Kembali ke Gamepedia
            </a>

            {{-- Header Artikel --}}
            <header class="mb-6 mt-4">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-slate-50 flex items-center gap-2">
                    {{ $article->title }}

                    @if ($article->game)
                        @if($gameSlug)
                            {{-- Badge game yang bisa diklik ke kategori game --}}
                            <a href="{{ route('articles.byGame', $gameSlug) }}"
                               class="px-2 py-1 text-xs rounded-full bg-indigo-50 text-indigo-700
                                      dark:bg-indigo-900/40 dark:text-indigo-200 hover:bg-indigo-100
                                      dark:hover:bg-indigo-900/70 transition">
                                {{ $article->game }}
                            </a>
                        @else
                            {{-- fallback kalau nggak ke-detect --}}
                            <span class="px-2 py-1 text-xs rounded-full bg-indigo-50 text-indigo-700
                                         dark:bg-indigo-900/40 dark:text-indigo-200">
                                {{ $article->game }}
                            </span>
                        @endif
                    @endif
                </h1>

                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Ditulis oleh
                    <span class="font-medium">{{ $article->author->name ?? 'User' }}</span>
                    • {{ $article->created_at->format('d M Y') }}

                    @if ($article->status === 'published' && $article->publisher)
                        <br>
                        <span class="text-xs text-slate-500 dark:text-slate-400">
                            Dipublish oleh
                            <span class="font-medium">{{ $article->publisher->name }}</span>
                            pada {{ $article->published_at?->format('d M Y H:i') }}
                        </span>
                    @else
                        <br>
                        <span class="text-xs text-amber-500">
                            Status: BELUM DIPUBLISH (menunggu persetujuan admin)
                        </span>
                    @endif
                </p>
            </header>

            {{-- TOMBOL ADMIN & SUPER ADMIN --}}
            @auth
                @php
                    $role = auth()->user()->role ?? 'guest';
                    $isAdminLike = in_array($role, ['admin', 'super_admin']);
                    $isOwner = auth()->id() === $article->user_id;
                @endphp

                {{-- USER BISA EDIT ARTIKELNYA SENDIRI --}}
                @if($isOwner && !$isAdminLike)
                    <div class="mb-6">
                        <a href="{{ route('articles.edit', $article) }}"
                           class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 shadow-sm">
                            ✏️ Edit Artikel Saya
                        </a>
                    </div>
                @endif

                {{-- ADMIN / SUPER ADMIN --}}
                @if($isAdminLike)
                    <div class="mb-6 flex flex-wrap gap-3">

                        {{-- Edit --}}
                        <a href="{{ route('articles.edit', $article) }}"
                           class="px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 shadow-sm">
                            ✏️ Edit Artikel
                        </a>

                        {{-- Delete --}}
                        <form action="{{ route('articles.destroy', $article) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="px-4 py-2 rounded-xl bg-rose-600 text-white text-sm font-medium hover:bg-rose-700 shadow-sm">
                                🗑️ Hapus Artikel
                            </button>
                        </form>

                        {{-- Publish --}}
                        @if($article->status !== 'published')
                            <form action="{{ route('articles.publish', $article) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <button type="submit"
                                        class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm">
                                    ✅ Publish Artikel
                                </button>
                            </form>
                        @endif

                    </div>
                @endif
            @endauth

            {{-- Isi artikel --}}
            <article
                class="bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl p-6 sm:p-8
                       text-slate-800 dark:text-slate-100 leading-relaxed">
                {!! nl2br(e($article->content)) !!}
            </article>
        </main>
    </div>

    {{-- Alpine Theme Switch --}}
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
