<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SuperAdmin\UserController;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/

// root -> daftar artikel
Route::get('/', function () {
    return redirect()->route('articles.index');
});

// daftar artikel publik (hanya yg published untuk guest/user biasa)
Route::get('/articles', [ArticleController::class, 'index'])
    ->name('articles.index');

// filter per game: /articles/game/minecraft, /articles/game/valorant, /articles/game/genshin-impact, /articles/game/lainnya
Route::get('/articles/game/{slug}', [ArticleController::class, 'byGame'])
    ->name('articles.byGame');


/*
|--------------------------------------------------------------------------
| AREA LOGIN (USER / ADMIN / SUPER ADMIN)
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // DASHBOARD PER ROLE
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'super_admin' => view('superadmin.dashboard'),
            'admin'       => view('admin.dashboard'),
            default       => view('dashboard'), // user biasa
        };
    })->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | ARTIKEL – SEMUA USER LOGIN (user, admin, super_admin)
    |----------------------------------------------------------------------
    */

    // form buat artikel
    Route::get('/articles/create', [ArticleController::class, 'create'])
        ->name('articles.create');

    // simpan artikel
    Route::post('/articles', [ArticleController::class, 'store'])
        ->name('articles.store');

    // form edit artikel
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])
        ->name('articles.edit');

    // update artikel
    Route::put('/articles/{article}', [ArticleController::class, 'update'])
        ->name('articles.update');


    /*
    |----------------------------------------------------------------------
    | ARTIKEL – HANYA ADMIN & SUPER ADMIN
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin,super_admin')->group(function () {

        // daftar artikel khusus admin (bisa lihat pending & published)
        Route::get('/admin/articles', [ArticleController::class, 'adminIndex'])
            ->name('admin.articles.index');

        // hapus artikel
        Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])
            ->name('articles.destroy');

        // publish artikel
        Route::put('/articles/{article}/publish', [ArticleController::class, 'publish'])
            ->name('articles.publish');
    });

    /*
    |----------------------------------------------------------------------
    | SUPER ADMIN SAJA – KELOLA USER & AKTIVITAS
    |----------------------------------------------------------------------
    */
    Route::middleware('role:super_admin')->group(function () {

        // daftar user
        Route::get('/superadmin/users', [UserController::class, 'index'])
            ->name('superadmin.users.index');

        // ubah role user
        Route::put('/superadmin/users/{user}/role', [UserController::class, 'updateRole'])
            ->name('superadmin.users.updateRole');

        // buka blokir user
        Route::put('/superadmin/users/{user}/unblock', [UserController::class, 'unblock'])
            ->name('superadmin.users.unblock');

        // hapus user
        Route::delete('/superadmin/users/{user}', [UserController::class, 'destroy'])
            ->name('superadmin.users.destroy');

        // log aktivitas artikel
        Route::get('/superadmin/activity', [ArticleController::class, 'activity'])
            ->name('superadmin.activity');
    });
});


/*
|--------------------------------------------------------------------------
| DETAIL ARTIKEL (PUBLIK)
|--------------------------------------------------------------------------
|
| Penting: letakkan PALING BAWAH supaya tidak nabrak /articles/create,
| /articles/{article}/edit, dll.
|
*/

Route::get('/articles/{article}', [ArticleController::class, 'show'])
    ->name('articles.show');
