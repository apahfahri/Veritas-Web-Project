<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Support\Facades\Auth;

class AdminCabangPetugasController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isAdminCabang()) {
                abort(403, 'Akses ditolak. Halaman khusus Admin Cabang.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $petugases = Petugas::latest()->paginate(15);
        return view('admin.admin-cabang.petugas.index', compact('petugases'));
    }
}
