<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        // kalau belum login
        if (!$user) {
            abort(403, 'Forbidden');
        }

        // roles bisa banyak: "admin,super_admin"
        $allowed = array_map('trim', explode(',', $roles));

        if (!in_array($user->role, $allowed, true)) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
