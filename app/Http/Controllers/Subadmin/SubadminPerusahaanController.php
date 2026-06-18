<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Perusahaan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubadminPerusahaanController extends Controller
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

    public function index(Request $request)
    {
        // Menampilkan daftar semua perusahaan agar subadmin bisa melihat profilnya
        $cabang = Auth::user()->cabang;
        
        $query = Perusahaan::withCount(['pendaftarans']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('sektor_industri', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        $perusahaans = $query->latest()->paginate(15)->withQueryString();

        return view('subadmin.perusahaan.index', compact('perusahaans'));
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        
        // Peserta dari perusahaan ini di cabang admin
        $pesertas = Pendaftaran::where('id_perusahaan', $id)
            ->with(['user', 'layanan.materi'])
            ->latest()
            ->get();

        return view('subadmin.perusahaan.show', compact('perusahaan', 'pesertas'));
    }
}
