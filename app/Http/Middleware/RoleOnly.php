<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleOnly
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        $role = $user->role ?? 'student';

        if (!in_array($role, $roles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
