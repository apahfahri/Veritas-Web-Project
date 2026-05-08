<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSubadmin
{
    /**
     * Izinkan akses hanya untuk user yang memiliki record di tabel admin dengan role subadmin.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isSubadmin()) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Subadmin.');
        }

        return $next($request);
    }
}
