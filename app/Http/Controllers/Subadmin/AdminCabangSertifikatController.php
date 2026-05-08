<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCabangSertifikatController extends Controller
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
        $cabang = Auth::user()->admin?->cabang;
        $sertifikats = Sertifikat::with('pendaftaran.user')->where('cabang', $cabang)->latest()->paginate(15);

        return view('admin.admin-cabang.sertifikat.index', compact('sertifikats'));
    }

    public function create($pendaftaran_id)
    {
        $cabang = Auth::user()->admin?->cabang;
        $pendaftaran = Pendaftaran::with(['user', 'layanan'])->where('cabang', $cabang)->findOrFail($pendaftaran_id);

        if ($pendaftaran->sertifikat) {
            return redirect()->route('admin-cabang.sertifikat.index')
                ->with('error', 'Sertifikat untuk pendaftaran ini sudah ada.');
        }

        return view('admin.admin-cabang.sertifikat.create', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        $cabang = Auth::user()->admin?->cabang;

        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
        ]);

        // Validate that pendaftaran belongs to this cabang
        $pendaftaran = Pendaftaran::where('cabang', $cabang)->findOrFail($request->pendaftaran_id);

        $noSertifikat = $this->generateNoSertifikat();

        Sertifikat::create([
            'no_sertifikat'  => $noSertifikat,
            'pendaftaran_id' => $request->pendaftaran_id,
            'nama_lengkap'   => $request->nama_lengkap,
            'tanggal_terbit' => $request->tanggal_terbit,
            'cabang'         => $cabang,
        ]);

        $pendaftaran->update(['status_progres' => 'selesai']);

        return redirect()->route('admin-cabang.sertifikat.index')
            ->with('success', "Sertifikat {$noSertifikat} berhasil diterbitkan.");
    }

    public function edit($no_sertifikat)
    {
        $cabang = Auth::user()->admin?->cabang;
        $sertifikat = Sertifikat::where('cabang', $cabang)->findOrFail($no_sertifikat);

        return view('admin.admin-cabang.sertifikat.edit', compact('sertifikat'));
    }

    public function update(Request $request, $no_sertifikat)
    {
        $cabang = Auth::user()->admin?->cabang;
        $sertifikat = Sertifikat::where('cabang', $cabang)->findOrFail($no_sertifikat);

        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
        ]);

        $sertifikat->update([
            'nama_lengkap'   => $request->nama_lengkap,
            'tanggal_terbit' => $request->tanggal_terbit,
        ]);

        return redirect()->route('admin-cabang.sertifikat.index')
            ->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy($no_sertifikat)
    {
        $cabang = Auth::user()->admin?->cabang;
        $sertifikat = Sertifikat::where('cabang', $cabang)->findOrFail($no_sertifikat);
        $sertifikat->delete();

        return redirect()->route('admin-cabang.sertifikat.index')
            ->with('success', 'Sertifikat berhasil dihapus.');
    }

    private function generateNoSertifikat(): string
    {
        $year = date('Y');
        $count = Sertifikat::whereYear('created_at', $year)->count() + 1;
        return sprintf('KV-CAB-K3-%s-%06d', $year, $count);
    }
}
