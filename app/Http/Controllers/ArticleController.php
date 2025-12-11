<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * LIST ARTIKEL (halaman utama)
     */
    public function index(): View
    {
        $user = Auth::user();

        // admin & super_admin lihat semua artikel (pending + published)
        if ($user && in_array($user->role, ['admin', 'super_admin'], true)) {
            $articles = Article::latest()->paginate(12);
        } else {
            // guest & user biasa hanya lihat artikel yang sudah published
            $articles = Article::where('status', 'published')
                ->latest()
                ->paginate(12);
        }

        return view('articles.index', [
            'articles'    => $articles,
            'currentGame' => 'all', // dipakai di menu filter game
            'gameTitle'   => null,
        ]);
    }

    /**
     * LIST ARTIKEL PER GAME (minecraft, valorant, genshin-impact, lainnya, dll)
     */
    public function byGame(string $slug): View
    {
        $slug = strtolower($slug);

        // daftar game resmi dalam bentuk "slug" (huruf kecil + spasi jadi "-")
        // pastikan sama dengan yang dipakai di menu:
        //   minecraft, valorant, genshin-impact
        $officialGameSlugs = [
            'minecraft',
            'valorant',
            'genshin-impact',
        ];

        // =========================
        //  KATEGORI "LAINNYA"
        // =========================
        if ($slug === 'lainnya') {
            // siapkan placeholder untuk NOT IN (?, ?, ?)
            $placeholders = implode(',', array_fill(0, count($officialGameSlugs), '?'));

            $articles = Article::where('status', 'published')
                ->where(function ($q) use ($officialGameSlugs, $placeholders) {
                    $q
                        // game kosong / null
                        ->whereNull('game')
                        ->orWhere('game', '')
                        // "Semua Game" (case-insensitive)
                        ->orWhereRaw('LOWER(game) = ?', ['semua game'])
                        // nama game bukan salah satu dari daftar resmi
                        ->orWhereRaw(
                            'LOWER(REPLACE(game, " ", "-")) NOT IN ('.$placeholders.')',
                            $officialGameSlugs
                        );
                })
                ->latest()
                ->paginate(12);

            return view('articles.index', [
                'articles'    => $articles,
                'currentGame' => 'lainnya',
                'gameTitle'   => 'Lainnya',
            ]);
        }

        // =========================
        //  KATEGORI GAME TERTENTU
        // =========================
        $articles = Article::where('status', 'published')
            // contoh:
            //   "Minecraft"        -> minecraft
            //   "mine craft"       -> mine-craft
            //   "Genshin Impact"   -> genshin-impact
            ->whereRaw('LOWER(REPLACE(game, " ", "-")) = ?', [$slug])
            ->latest()
            ->paginate(12);

        // bikin judul cantik: "genshin-impact" -> "Genshin Impact"
        $title = Str::headline(str_replace('-', ' ', $slug));

        return view('articles.index', [
            'articles'    => $articles,
            'currentGame' => $slug,
            'gameTitle'   => $title,
        ]);
    }

    /**
     * DETAIL ARTIKEL
     */
    public function show(Article $article): View
    {
        $user = Auth::user();

        // kalau artikel belum published:
        // hanya penulis + admin + super_admin yg boleh lihat
        if ($article->status !== 'published') {
            if (
                !$user ||
                !(
                    $user->id === $article->user_id ||
                    in_array($user->role, ['admin', 'super_admin'], true)
                )
            ) {
                abort(403, 'Artikel ini belum dipublish.');
            }
        }

        return view('articles.show', [
            'article' => $article,
        ]);
    }

    /**
     * FORM CREATE (semua user login)
     */
    public function create(): View
    {
        return view('articles.create');
    }

    /**
     * SIMPAN ARTIKEL BARU
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'game'    => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $data['user_id'] = auth()->id();
        $data['status']  = 'pending'; // menunggu persetujuan admin/superadmin

        Article::create($data);

        return redirect()
            ->route('articles.index')
            ->with('success', 'Artikel berhasil dibuat dan menunggu persetujuan admin.');
    }

    /**
     * FORM EDIT
     */
    public function edit(Article $article): View
    {
        $user = Auth::user();

        // user biasa hanya boleh edit artikelnya sendiri
        if ($user->role === 'user' && $article->user_id !== $user->id) {
            abort(403);
        }

        return view('articles.edit', [
            'article' => $article,
        ]);
    }

    /**
     * UPDATE ARTIKEL
     */
    public function update(Request $request, Article $article): RedirectResponse
    {
        $user = Auth::user();

        // user biasa hanya boleh update artikelnya sendiri
        if ($user->role === 'user' && $article->user_id !== $user->id) {
            abort(403);
        }

        $data = $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'game'    => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $article->update($data);

        return redirect()
            ->route('articles.show', $article)
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * HAPUS ARTIKEL (admin / super_admin — sudah dijaga oleh middleware)
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * PUBLISH ARTIKEL (admin / super_admin)
     */
    public function publish(Article $article): RedirectResponse
    {
        $article->status       = 'published';
        $article->published_by = auth()->id();
        $article->published_at = now();
        $article->save();

        return back()->with('success', 'Artikel berhasil dipublish.');
    }

    /**
     * LOG AKTIVITAS ARTIKEL UNTUK SUPER ADMIN
     */
    public function activity(): View
    {
        $articles = Article::with(['author', 'publisher'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('superadmin.activity', compact('articles'));
    }

    /**
     * LIST ARTIKEL UNTUK HALAMAN ADMIN
     */
    public function adminIndex(): View
    {
        $articles = Article::latest()->paginate(15);

        return view('admin.articles.index', [
            'articles' => $articles,
        ]);
    }
}
