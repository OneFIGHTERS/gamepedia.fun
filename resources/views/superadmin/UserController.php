<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Tampilkan daftar semua user
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);

        return view('superadmin.users.index', compact('users'));
    }

    // Ubah role user
    public function updateRole(Request $request, User $user)
    {
        // Jangan izinkan super admin mengubah role dirinya sendiri (opsional tapi aman)
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa mengubah role akunmu sendiri.');
        }

        $validated = $request->validate([
            'role' => 'required|in:user,admin,super_admin',
        ]);

        $user->role = $validated['role'];
        $user->save();

        return back()->with('success', 'Role user berhasil diubah.');
    }

    // Hapus user
    public function destroy(User $user)
    {
        // Jangan izinkan hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa menghapus akunmu sendiri.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
