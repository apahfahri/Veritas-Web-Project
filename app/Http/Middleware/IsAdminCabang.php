<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdminCabang
{
    /**
     * Izinkan akses hanya untuk user yang memiliki record di tabel admin dengan role admin_cabang.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isAdminCabang()) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Admin Cabang.');
        }

        return $next($request);
    }
}
