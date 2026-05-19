<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
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
        // Filter by Pelatihan (ID 1)
        $pelatihans = Jadwal::where('id_kategori', 1)
            ->with(['kategori', 'pemateri', 'jenis'])
            ->withCount(['pendaftarans as pending_count' => function ($query) {
                $query->whereNotIn('status_progres', ['selesai', 'dibatalkan']);
            }])
            ->latest()
            ->paginate(15);
        return view('subadmin.pelatihan.index', compact('pelatihans'));
    }

    public function show($id)
    {
        $pelatihan = Jadwal::with(['kategori', 'pemateri', 'jenis'])->findOrFail($id);
        
        $pesertas = Pendaftaran::where('id_jadwal', $id)
            ->with(['user', 'perusahaan'])
            ->latest()
            ->get();

        return view('subadmin.pelatihan.show', compact('pelatihan', 'pesertas'));
    }
}
