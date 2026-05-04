<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use App\Models\Pelatihan;
use Illuminate\Support\Facades\Auth;

class AdminCabangPelatihanController extends Controller
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
        $pelatihans = Pelatihan::with(['layanan', 'petugas'])->latest()->paginate(15);
        return view('admin.admin-cabang.pelatihan.index', compact('pelatihans'));
    }
}
