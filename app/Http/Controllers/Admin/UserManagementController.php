<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    // TAMPILKAN DAFTAR USER
    public function index()
    {
        // Kamu bisa pakai pagination kalau mau
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('superadmin.users', [
            'users' => $users,
        ]);
    }

    // UPDATE ROLE USER
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin,super_admin',
        ]);

        // Kalau mau: cegah super_admin terakhir diturunkan rolenya
        if ($user->role === 'super_admin' && User::where('role', 'super_admin')->count() === 1 && $request->role !== 'super_admin') {
            return back()->with('error', 'Tidak bisa menurunkan role super admin terakhir.');
        }

        $user->role = $request->role;
        $user->save();

        return back()->with('success', "Role pengguna {$user->name} berhasil diubah menjadi {$request->role}.");
    }

    // HAPUS USER (OPSIONAL)
    public function destroy(User $user)
    {
        // Optional safety: jangan hapus diri sendiri
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        $user->delete();

        return back()->with('success', "Pengguna {$user->name} berhasil dihapus.");
    }
}
