<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Halaman daftar semua user
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        // Sesuaikan dengan lokasi view milikmu:
        // resources/views/superadmin/users.blade.php
        return view('superadmin.users', compact('users'));
    }

    /**
     * Update role user (user → admin → super admin)
     */
    public function updateRole(Request $request, User $user)
    {
        // Tidak boleh ubah role diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa mengubah role akunmu sendiri.');
        }

        $data = $request->validate([
            'role' => 'required|in:user,admin,super_admin',
        ]);

        $user->role = $data['role'];
        $user->save();

        return back()->with('success', 'Role user berhasil diubah.');
    }

    /**
     * Hapus user
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akunmu sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }

    /**
     * 🔓 Membuka blokir user yang salah password 5x
     */
    public function unblock(User $user)
    {
        // Jika user sebenarnya tidak diblokir, tidak perlu unblock
        if (!$user->is_blocked) {
            return back()->with('error', 'User ini tidak sedang diblokir.');
        }

        $user->update([
            'is_blocked'    => false,
            'failed_logins' => 0,
            'blocked_at'    => null,
            'blocked_by'    => auth()->id(), // super admin yang membuka blokir
        ]);

        return back()->with('success', 'Akun ' . $user->name . ' berhasil dibuka blokirnya.');
    }
}
