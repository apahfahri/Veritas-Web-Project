<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class SubadminPelatihanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isSubadmin()) {
                abort(403, 'Akses ditolak.');
            }
            return $next($request);
        });
    }

    public function index()
    {
        // Subadmin hanya bisa melihat list pelatihan (Read-only)
        $pelatihans = Layanan::with(['kategori', 'pemateri'])->latest()->paginate(15);
        return view('subadmin.pelatihan.index', compact('pelatihans'));
    }

    public function show($id)
    {
        $pelatihan = Layanan::with(['kategori', 'pemateri'])->findOrFail($id);
        
        // Mengambil peserta yang mendaftar ke layanan ini di cabang subadmin
        // Global Scope di Pendaftaran akan otomatis memfilter berdasarkan 'cabang'
        $pesertas = Pendaftaran::where('id_layanan', $id)
            ->with(['user', 'perusahaan'])
            ->latest()
            ->get();

        return view('subadmin.pelatihan.show', compact('pelatihan', 'pesertas'));
    }
}
