<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
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
        $audits = Layanan::where('id_kategori', 3)
            ->with(['kategori', 'pemateri'])
            ->latest()
            ->paginate(15);
        return view('subadmin.audit.index', compact('audits'));
    }

    public function show($id)
    {
        $audit = Layanan::with(['kategori', 'pemateri'])->findOrFail($id);
        $pesertas = Pendaftaran::where('id_layanan', $id)
            ->with(['user', 'perusahaan'])
            ->latest()
            ->get();

        return view('subadmin.audit.show', compact('audit', 'pesertas'));
    }
}
