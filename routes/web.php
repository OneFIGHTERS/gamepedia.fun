<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SuperAdmin\UserController;

// ===================
// HALAMAN PUBLIK
// ===================

// Root diarahkan ke list artikel
Route::get('/', function () {
    return redirect()->route('articles.index');
});

// List artikel (publik, biasanya hanya yang published di-filter di controller)
Route::get('/articles', [ArticleController::class, 'index'])
    ->name('articles.index');


// ===================
// AREA LOGIN (USER / ADMIN / SUPER ADMIN)
// ===================
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // ===================
    // DASHBOARD PER ROLE
    // ===================
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'super_admin' => view('superadmin.dashboard'),
            'admin'       => view('admin.dashboard'),
            default       => view('dashboard'), // user biasa
        };
    })->name('dashboard');

    // =====================================================
    // ARTIKEL – BOLEH UNTUK SEMUA ROLE YANG SUDAH LOGIN
    // (user, admin, super_admin)
    // =====================================================

    // Form buat artikel
    Route::get('/articles/create', [ArticleController::class, 'create'])
        ->name('articles.create');

    // Simpan artikel (status default: pending)
    Route::post('/articles', [ArticleController::class, 'store'])
        ->name('articles.store');

    // Edit artikel:
    //  - user: hanya artikelnya sendiri (dicek di controller)
    //  - admin & super_admin: boleh semua (dicek di controller)
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])
        ->name('articles.edit');

    Route::put('/articles/{article}', [ArticleController::class, 'update'])
        ->name('articles.update');

    // =====================================================
    // ARTIKEL – HANYA ADMIN & SUPER ADMIN
    // (hapus + publish)
    Route::middleware('role:admin,super_admin')->group(function () {

    // daftar artikel khusus admin (bisa lihat pending & published)
    Route::get('/admin/articles', [ArticleController::class, 'adminIndex'])
        ->name('admin.articles.index');

    // Hapus artikel
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])
        ->name('articles.destroy');

    // Publish artikel (status: pending -> published)
    Route::put('/articles/{article}/publish', [ArticleController::class, 'publish'])
        ->name('articles.publish');
});

    // =====================================================
    // SUPER ADMIN SAJA – KELOLA USER & ROLE + AKTIVITAS
    // =====================================================
Route::middleware('role:super_admin')->group(function () {

    // Daftar user
    Route::get('/superadmin/users', [UserController::class, 'index'])
        ->name('superadmin.users.index');

    // Ubah role user
    Route::put('/superadmin/users/{user}/role', [UserController::class, 'updateRole'])
        ->name('superadmin.users.updateRole');

    // Buka blokir user
    Route::put('/superadmin/users/{user}/unblock', [UserController::class, 'unblock'])
        ->name('superadmin.users.unblock');

    // Hapus user
    Route::delete('/superadmin/users/{user}', [UserController::class, 'destroy'])
        ->name('superadmin.users.destroy');

    // Log aktivitas artikel
    Route::get('/superadmin/activity', [ArticleController::class, 'activity'])
        ->name('superadmin.activity');
});


    });



// ===================
// DETAIL ARTIKEL (PUBLIK)
// ===================
// DITARUH PALING BAWAH SUPAYA TIDAK NUBRUK /articles/create & /articles/{article}/edit
Route::get('/articles/{article}', [ArticleController::class, 'show'])
    ->name('articles.show');
