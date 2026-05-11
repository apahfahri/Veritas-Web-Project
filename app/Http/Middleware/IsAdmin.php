<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Izinkan akses hanya untuk user yang memiliki record di tabel admin.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isSuperAdmin()) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Superadmin.');
        }

        return $next($request);
    }
}
