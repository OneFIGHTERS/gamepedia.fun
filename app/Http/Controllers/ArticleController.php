<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    // LIST ARTIKEL
    public function index(): View
    {
        $user = Auth::user();

        // admin & super_admin lihat semua
        if ($user && in_array($user->role, ['admin', 'super_admin'], true)) {
            $articles = Article::latest()->paginate(12);
        } else {
            // guest & user biasa hanya lihat yg published
            $articles = Article::where('status', 'published')
                ->latest()
                ->paginate(12);
        }

        return view('articles.index', [
            'articles' => $articles,
        ]);
    }

    // DETAIL ARTIKEL
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

    // FORM CREATE (semua user login)
    public function create(): View
    {
        return view('articles.create');
    }

    // SIMPAN ARTIKEL BARU
    public function store(Request $request)
{
    $data = $request->validate([
        'title'   => ['required', 'string', 'max:255'],
        'game'    => ['required', 'string', 'max:255'],
        'content' => ['required', 'string'],
    ]);

    $data['user_id'] = auth()->id();
    $data['status']  = 'pending'; // menunggu persetujuan admin

    Article::create($data);

    return redirect()->route('articles.index')
        ->with('success', 'Artikel berhasil dibuat dan menunggu persetujuan admin.');
}

    // FORM EDIT
    public function edit(Article $article): View
    {
        $user = Auth::user();

        // user biasa hanya boleh edit artikelnya sendiri
        if ($user->role === 'user' && $article->user_id !== $user->id) {
            abort(403);
        }

        // admin & super_admin boleh edit apa saja
        return view('articles.edit', [
            'article' => $article,
        ]);
    }

    // UPDATE ARTIKEL
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

        // kalau user biasa edit artikelnya sendiri dan status sudah published
        // biarkan status tetap seperti sekarang
        $article->update($data);

        return redirect()
            ->route('articles.show', $article)
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    // HAPUS ARTIKEL (admin / super_admin — sudah dijaga oleh middleware)
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()
            ->route('articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    // PUBLISH ARTIKEL (admin / super_admin)
    public function publish(Article $article)
    {
        // hanya admin/super_admin yang sampai di sini (sudah di-filter middleware)

        $article->status       = 'published';
        $article->published_by = auth()->id();
        $article->published_at = now();
        $article->save();

        return back()->with('success', 'Artikel berhasil dipublish.');
    }
    public function activity()
    {
        $articles = Article::with(['author', 'publisher'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('superadmin.activity', compact('articles'));
    }
    public function adminIndex()
{
    // semua artikel, terbaru dulu, termasuk yang pending
    $articles = Article::latest()->paginate(15);

    return view('admin.articles.index', [
        'articles' => $articles,
    ]);
}


}
