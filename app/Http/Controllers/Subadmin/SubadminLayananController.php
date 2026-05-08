<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Support\Facades\Auth;

class SubadminLayananController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isSubadmin()) {
                abort(403, 'Akses ditolak. Halaman khusus Subadmin.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $layanans = Layanan::with(['kategori', 'pemateri'])->latest()->paginate(15);
        return view('subadmin.layanan.index', compact('layanans'));
    }
}
