<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubadminSertifikatController extends Controller
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

    public function index()
    {
        // Sertifikat scope managed via Pendaftaran relation or Global Scope if needed
        $sertifikats = Sertifikat::whereHas('pendaftaran', function($q) {
            $cabang = Auth::user()->cabang;
            if ($cabang) {
                $q->where(function($sub) use ($cabang) {
                    $sub->whereHas('user.klien', function($uq) use ($cabang) {
                        $uq->where('cabang', $cabang);
                    })->orWhere('is_utusan_perusahaan', true);
                });
            }
        })->with('pendaftaran.user')->latest()->paginate(15);

        return view('subadmin.sertifikat.index', compact('sertifikats'));
    }

    public function create($pendaftaran_id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'jadwal.jenis', 'jadwal.kategori'])->findOrFail($pendaftaran_id);

        // Alur Sertifikat: "Sertifikat hanya boleh diterbitkan jika status pendaftaran sudah 'Completed' atau 'Lulus'."
        $allowedStatuses = ['selesai', 'lulus', 'completed'];
        if (!in_array(strtolower($pendaftaran->status_progres), $allowedStatuses)) {
            return redirect()->route('subadmin.pendaftaran.show', $pendaftaran_id)
                ->with('error', 'Sertifikat hanya dapat diterbitkan untuk pendaftaran dengan status Selesai atau Lulus.');
        }

        if ($pendaftaran->sertifikat) {
            return redirect()->route('subadmin.sertifikat.index')
                ->with('error', 'Sertifikat untuk pendaftaran ini sudah ada.');
        }

        return view('subadmin.sertifikat.create', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftaran,id_pendaftaran',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($request->pendaftaran_id);

        // Security check for branch
        $pendaftaranCabang = $pendaftaran->user?->klien?->cabang;
        if ($pendaftaranCabang && $pendaftaranCabang !== Auth::user()->cabang) {
            abort(403, 'Anda tidak memiliki akses ke data cabang lain.');
        }

        $noSertifikat = $this->generateNoSertifikat();

        Sertifikat::create([
            'no_sertifikat'  => $noSertifikat,
            'id_pendaftaran' => $request->pendaftaran_id,
            'nama_lengkap'   => $request->nama_lengkap,
            'tanggal_terbit' => $request->tanggal_terbit,
        ]);

        $pendaftaran->update(['status_progres' => 'selesai']);

        return redirect()->route('subadmin.sertifikat.index')
            ->with('success', "Sertifikat {$noSertifikat} berhasil diterbitkan.");
    }

    public function edit($no_sertifikat)
    {
        $sertifikat = Sertifikat::where('no_sertifikat', $no_sertifikat)->firstOrFail();
        return view('subadmin.sertifikat.edit', compact('sertifikat'));
    }

    public function update(Request $request, $no_sertifikat)
    {
        $sertifikat = Sertifikat::where('no_sertifikat', $no_sertifikat)->firstOrFail();

        $request->validate([
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
        ]);

        $sertifikat->update([
            'nama_lengkap'   => $request->nama_lengkap,
            'tanggal_terbit' => $request->tanggal_terbit,
        ]);

        return redirect()->route('subadmin.sertifikat.index')
            ->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroy($no_sertifikat)
    {
        $sertifikat = Sertifikat::where('no_sertifikat', $no_sertifikat)->firstOrFail();
        $sertifikat->delete();

        return redirect()->route('subadmin.sertifikat.index')
            ->with('success', 'Sertifikat berhasil dihapus.');
    }

    private function generateNoSertifikat(): string
    {
        $year = date('Y');
        $count = Sertifikat::whereYear('created_at', $year)->count() + 1;
        return sprintf('KV-SUB-K3-%s-%06d', $year, $count);
    }
}

