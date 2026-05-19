<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class SubadminKonsultasiController extends Controller
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
        // Filter by Konsultasi (ID 2)
        $konsultasis = Jadwal::where('id_kategori', 2)
            ->with(['kategori', 'pemateri', 'jenis'])
            ->withCount(['pendaftarans as pending_count' => function ($query) {
                $query->whereNotIn('status_progres', ['selesai', 'dibatalkan']);
            }])
            ->latest()
            ->paginate(15);
        return view('subadmin.konsultasi.index', compact('konsultasis'));
    }

    public function show($id)
    {
        $konsultasi = Jadwal::with(['kategori', 'pemateri', 'jenis'])->findOrFail($id);
        $pesertas = Pendaftaran::where('id_jadwal', $id)
            ->with(['user', 'perusahaan'])
            ->latest()
            ->get();

        return view('subadmin.konsultasi.show', compact('konsultasi', 'pesertas'));
    }
}
