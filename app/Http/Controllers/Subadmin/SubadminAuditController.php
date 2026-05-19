<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class SubadminAuditController extends Controller
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
        // Filter by Audit (ID 3)
        $audits = Jadwal::where('id_kategori', 3)
            ->with(['kategori', 'pemateri', 'jenis'])
            ->withCount(['pendaftarans as pending_count' => function ($query) {
                $query->whereNotIn('status_progres', ['selesai', 'dibatalkan']);
            }])
            ->latest()
            ->paginate(15);
        return view('subadmin.audit.index', compact('audits'));
    }

    public function show($id)
    {
        $audit = Jadwal::with(['kategori', 'pemateri', 'jenis'])->findOrFail($id);
        $pesertas = Pendaftaran::where('id_jadwal', $id)
            ->with(['user', 'perusahaan'])
            ->latest()
            ->get();

        return view('subadmin.audit.show', compact('audit', 'pesertas'));
    }
}
