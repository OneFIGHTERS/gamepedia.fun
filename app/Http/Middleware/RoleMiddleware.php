<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        // kalau belum login
        if (! $user) {
            abort(403);
        }

        // cek apakah role user ada di daftar $roles (admin / super_admin / dst)
        if (! in_array($user->role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}