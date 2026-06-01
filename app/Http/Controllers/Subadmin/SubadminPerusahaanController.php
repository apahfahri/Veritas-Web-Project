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

    public function index()
    {
        // Menampilkan daftar semua perusahaan agar subadmin bisa melihat profilnya
        $cabang = Auth::user()->cabang;
        
        $perusahaans = Perusahaan::withCount(['pendaftarans' => function($q) use ($cabang) {
            if ($cabang) {
                $q->where(function($sub) use ($cabang) {
                    $sub->whereHas('user.klien', function($uq) use ($cabang) {
                        $uq->where('cabang', $cabang);
                    })->orWhere('is_utusan_perusahaan', true);
                });
            }
        }])->latest()->paginate(15);

        return view('subadmin.perusahaan.index', compact('perusahaans'));
    }

    public function show($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        
        // Peserta dari perusahaan ini di cabang admin
        $pesertas = Pendaftaran::where('id_perusahaan', $id)
            ->with(['user', 'jadwal.jenis', 'jadwal.kategori'])
            ->latest()
            ->get();

        return view('subadmin.perusahaan.show', compact('perusahaan', 'pesertas'));
    }
}
