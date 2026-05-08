<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubadminPendaftaranController extends Controller
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

    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'layanan'])->latest();

        if ($request->filled('status')) {
            $query->where('status_progres', $request->status);
        }

        $pendaftarans = $query->paginate(15);

        return view('subadmin.pendaftaran.index', compact('pendaftarans'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'layanan', 'sertifikat'])
            ->findOrFail($id);

        return view('subadmin.pendaftaran.show', compact('pendaftaran'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $request->validate([
            'status_progres'  => 'required|string',
            'status_bayar'    => 'required|string',
        ]);

        $pendaftaran->update([
            'status_progres'  => $request->status_progres,
            'status_bayar'    => $request->status_bayar,
        ]);

        return redirect()->route('subadmin.pendaftaran.index')
            ->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('subadmin.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
