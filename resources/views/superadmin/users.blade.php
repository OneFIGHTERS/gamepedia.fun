{{-- resources/views/superadmin/users.blade.php --}}
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
                    Kelola User
                </h1>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                    Di sini Super Admin bisa melihat semua akun, mengubah role, dan membuka blokir user.
                </p>
            </div>

            {{-- Alert --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-2 rounded border border-emerald-300 bg-emerald-50 text-emerald-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 px-4 py-2 rounded border border-rose-300 bg-rose-50 text-rose-800 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-hidden">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-600 dark:text-slate-300">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Role</th>
                            <th class="px-4 py-3 text-left">Status</th> {{-- 👈 kolom baru --}}
                            <th class="px-4 py-3 text-left">Dibuat</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse ($users as $user)
                            <tr class="text-slate-800 dark:text-slate-100">
                                <td class="px-4 py-3">
                                    {{ $user->name }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $user->email }}
                                </td>

                                {{-- ROLE --}}
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                        @if($user->role === 'super_admin')
                                            bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-900/40 dark:text-fuchsia-200
                                        @elseif($user->role === 'admin')
                                            bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-200
                                        @else
                                            bg-slate-100 text-slate-700 dark:bg-slate-900/40 dark:text-slate-200
                                        @endif
                                    ">
                                        {{ $user->role }}
                                    </span>
                                </td>

                                {{-- STATUS LOGIN / BLOKIR --}}
                                <td class="px-4 py-3">
                                    @if($user->is_blocked)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-200">
                                            ● Diblokir
                                            @if($user->failed_logins)
                                                <span class="ml-1">(gagal {{ $user->failed_logins }}x)</span>
                                            @endif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-200">
                                            ● Aktif
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>

                                {{-- AKSI --}}
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2 flex-wrap">

                                        {{-- Form ganti role --}}
                                        @if(auth()->id() !== $user->id)
                                            <form method="POST" action="{{ route('superadmin.users.updateRole', $user) }}" class="flex items-center gap-1">
                                                @csrf
                                                @method('PUT')

                                                <select name="role"
                                                        class="text-xs rounded-md border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100">
                                                    <option value="user" @selected($user->role === 'user')>user</option>
                                                    <option value="admin" @selected($user->role === 'admin')>admin</option>
                                                    <option value="super_admin" @selected($user->role === 'super_admin')>super_admin</option>
                                                </select>

                                                <button type="submit"
                                                        class="px-2 py-1 text-xs rounded-md bg-indigo-600 text-white hover:bg-indigo-700">
                                                    Simpan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-slate-400">Akun sendiri</span>
                                        @endif

                                        {{-- Tombol BUKA BLOKIR (hanya jika diblokir) --}}
                                        @if($user->is_blocked)
                                            <form method="POST"
                                                  action="{{ route('superadmin.users.unblock', $user) }}"
                                                  onsubmit="return confirm('Buka blokir akun {{ $user->name }}?');">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                        class="px-2 py-1 text-xs rounded-md bg-emerald-600 text-white hover:bg-emerald-700">
                                                    Buka Blokir
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Hapus user --}}
                                        @if(auth()->id() !== $user->id)
                                            <form method="POST"
                                                  action="{{ route('superadmin.users.destroy', $user) }}"
                                                  onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-2 py-1 text-xs rounded-md bg-rose-600 text-white hover:bg-rose-700">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-slate-500 dark:text-slate-300">
                                    Belum ada user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
