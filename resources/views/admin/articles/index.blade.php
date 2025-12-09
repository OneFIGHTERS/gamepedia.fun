{{-- resources/views/admin/articles/index.blade.php --}}
<x-guest-layout>
    <div
        x-data="themeSwitcher()"
        x-init="init()"
        class="min-h-screen bg-slate-50 dark:bg-slate-900"
    >
        <header class="border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur">
            <div class="max-w-7xl mx-auto h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="{{ route('articles.index') }}" class="flex items-center gap-2">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-indigo-600 text-white font-bold">
                        G
                    </span>
                    <span class="font-semibold text-lg text-slate-900 dark:text-slate-100">
                        Gamepedia
                    </span>
                </a>

                <div class="flex items-center gap-4 text-sm">
                    <a href="{{ route('dashboard') }}"
                       class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-50 mb-4">
                Kelola & Publish Artikel
            </h1>

            <table class="min-w-full text-sm bg-white dark:bg-slate-800 rounded-xl overflow-hidden shadow border border-slate-200 dark:border-slate-700">
                <thead class="bg-slate-100 dark:bg-slate-700/60 text-left text-slate-700 dark:text-slate-100">
                    <tr>
                        <th class="px-4 py-2">Judul</th>
                        <th class="px-4 py-2">Penulis</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Dibuat</th>
                        <th class="px-4 py-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($articles as $article)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/70">
                            <td class="px-4 py-2">
                                <a href="{{ route('articles.show', $article) }}"
                                   class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $article->title }}
                                </a>
                            </td>
                            <td class="px-4 py-2">
                                {{ $article->user->name ?? '-' }}
                            </td>
                            <td class="px-4 py-2">
                                @if($article->status === 'published')
                                    <span class="px-2 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300">
                                        Published
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                {{ $article->created_at->format('d M Y') }}
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex justify-end gap-2">
                                    {{-- Publish hanya kalau masih pending --}}
                                    @if($article->status !== 'published')
                                        <form action="{{ route('articles.publish', $article) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                    class="px-3 py-1 text-xs rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                                                Publish
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('articles.edit', $article) }}"
                                       class="px-3 py-1 text-xs rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">
                                        Edit
                                    </a>

                                    <form action="{{ route('articles.destroy', $article) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1 text-xs rounded-lg bg-rose-600 text-white hover:bg-rose-700">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-slate-500 dark:text-slate-400">
                                Belum ada artikel.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $articles->links() }}
            </div>
        </main>
    </div>
</x-guest-layout>
