<x-guest-layout>
    <div x-data="themeSwitcher()" x-init="init()" class="min-h-screen bg-slate-50 dark:bg-slate-900">
        {{-- NAVBAR simple, sama seperti yang lain --}}
        <header class="border-b border-slate-200 dark:border-slate-800 bg-white/80 dark:bg-slate-900/80 backdrop-blur">
            <div class="max-w-7xl mx-auto h-16 flex items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="{{ route('articles.index') }}" class="flex items-center gap-2">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-indigo-600 text-white font-bold">G</span>
                    <span class="font-semibold text-lg text-slate-900 dark:text-slate-100">Gamepedia</span>
                </a>

                <div class="flex items-center gap-4 text-sm">
                    <a href="{{ route('dashboard') }}" class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Dashboard
                    </a>
                    <a href="{{ route('profile.show') }}" class="text-slate-600 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                        @csrf
                        <button type="submit" class="text-slate-600 dark:text-slate-200 hover:text-red-600 dark:hover:text-red-400">
                            Log out
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-slate-50 mb-4">
                Kelola User & Role
            </h1>

            @if(session('success'))
                <div class="mb-4 px-4 py-2 rounded-lg bg-emerald-100 text-emerald-800 border border-emerald-200">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 px-4 py-2 rounded-lg bg-rose-100 text-rose-800 border border-rose-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-900/60 text-slate-600 dark:text-slate-300">
                        <tr>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Email</th>
                            <th class="px-4 py-3 text-left">Role</th>
                            <th class="px-4 py-3 text-left">Dibuat</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-900/40">
                                <td class="px-4 py-3 text-slate-900 dark:text-slate-100">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="ml-1 text-xs px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300">Kamu</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300">
                                    {{ $user->email }}
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('superadmin.users.updateRole', $user) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')

                                        <select name="role"
                                                class="text-sm rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-100"
                                                @if($user->id === auth()->id()) disabled @endif>
                                            <option value="user"        @selected($user->role === 'user')>user</option>
                                            <option value="admin"       @selected($user->role === 'admin')>admin</option>
                                            <option value="super_admin" @selected($user->role === 'super_admin')>super_admin</option>
                                        </select>

                                        @if($user->id !== auth()->id())
                                            <button type="submit"
                                                    class="px-3 py-1 rounded-md bg-indigo-600 text-white text-xs font-medium hover:bg-indigo-700">
                                                Simpan
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">
                                    {{ $user->created_at?->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('superadmin.users.destroy', $user) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus user ini?');"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="px-3 py-1 rounded-md bg-rose-600 text-white text-xs font-medium hover:bg-rose-700">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400">Tidak bisa hapus diri sendiri</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400">
                                    Belum ada user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </main>
    </div>

    <script>
        function themeSwitcher() {
            return {
                dark: false,
                init() {
                    this.dark = localStorage.getItem("theme") === "dark";
                    document.documentElement.classList.toggle("dark", this.dark);
                },
                toggle() {
                    this.dark = !this.dark;
                    document.documentElement.classList.toggle("dark", this.dark);
                    localStorage.setItem("theme", this.dark ? "dark" : "light");
                },
            };
        }
    </script>
</x-guest-layout>
