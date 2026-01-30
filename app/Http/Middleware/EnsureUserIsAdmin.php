<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || $request->user()->role !== \App\Models\User::ROLE_ADMIN) {
            abort(403);
        }

        return $next($request);
    }
}
