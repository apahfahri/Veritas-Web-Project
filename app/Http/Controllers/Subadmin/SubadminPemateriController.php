<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pemateri;
use Illuminate\Support\Facades\Auth;

class SubadminPemateriController extends Controller
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
        $pemateris = Pemateri::latest()->paginate(15);
        return view('subadmin.petugas.index', compact('pemateris'));
    }
}
