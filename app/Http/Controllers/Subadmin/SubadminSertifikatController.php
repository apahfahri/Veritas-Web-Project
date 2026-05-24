<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Sertifikat;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $cabang = Auth::user()->cabang;

        $sertifikats = Sertifikat::whereHas('pendaftaran', function($q) use ($cabang) {
            if ($cabang) $q->where('cabang', $cabang);
        })->with(['pendaftaran.user', 'pendaftaran.jadwal.jenis', 'pendaftaran.jadwal.kategori'])
          ->latest()
          ->paginate(15);

        // Hanya pendaftaran Selesai & Lunas yang belum punya sertifikat
        $pendaftaranTersedia = Pendaftaran::with(['user', 'jadwal.jenis', 'jadwal.kategori'])
            ->where('status_progres', 'selesai')
            ->where('status_bayar', 'lunas')
            ->whereDoesntHave('sertifikat')
            ->when($cabang, function($q) use ($cabang) {
                $q->where('cabang', $cabang);
            })
            ->latest()
            ->get();

        return view('subadmin.sertifikat.index', compact('sertifikats', 'pendaftaranTersedia'));
    }

    public function create($pendaftaran_id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'jadwal.jenis', 'jadwal.kategori'])->findOrFail($pendaftaran_id);

        // Branch security
        $cabang = Auth::user()->cabang;
        if ($cabang && $pendaftaran->cabang && $pendaftaran->cabang !== $cabang) {
            abort(403, 'Anda tidak memiliki akses ke data cabang lain.');
        }

        $allowedStatuses = ['selesai', 'lulus', 'completed'];
        if (!in_array(strtolower($pendaftaran->status_progres), $allowedStatuses)) {
            return redirect()->route('subadmin.pendaftaran.show', $pendaftaran_id)
                ->with('error', 'Sertifikat hanya dapat diterbitkan untuk pendaftaran dengan status Selesai atau Lulus.');
        }

        if ($pendaftaran->sertifikat) {
            return redirect()->route('subadmin.sertifikat.index')
                ->with('error', 'Sertifikat untuk pendaftaran ini sudah ada.');
        }
        
        if ($pendaftaran->jumlah_absen > 1) {
            return redirect()->route('subadmin.sertifikat.index')
                ->with('error', 'Tidak dapat menerbitkan sertifikat: Peserta memiliki jumlah absen lebih dari 1x.');
        }

        return view('subadmin.sertifikat.create', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran',
            'no_sertifikat'  => 'required|string|unique:sertifikat,no_sertifikat',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penerbit'       => 'required|string|max:255',
            'masa_berlaku'   => 'nullable|date',
            'file_pdf'       => 'required|file|mimes:pdf|max:5120',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($request->id_pendaftaran);

        // Branch security
        $cabang = Auth::user()->cabang;
        if ($cabang && $pendaftaran->cabang && $pendaftaran->cabang !== $cabang) {
            abort(403, 'Anda tidak memiliki akses ke data cabang lain.');
        }
        
        if ($pendaftaran->jumlah_absen > 1) {
            return redirect()->back()->with('error', 'Tidak dapat menerbitkan sertifikat: Peserta memiliki jumlah absen lebih dari 1x.');
        }

        $exists = Sertifikat::where('id_pendaftaran', $request->id_pendaftaran)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Sertifikat untuk pendaftaran ini sudah diterbitkan.');
        }

        // Save file
        $file = $request->file('file_pdf');
        $filename = Str::slug($request->no_sertifikat) . '_' . time() . '.pdf';
        $path = $file->storeAs('sertifikat/uploads', $filename, 'public');

        Sertifikat::create([
            'no_sertifikat'  => $request->no_sertifikat,
            'id_pendaftaran' => $request->id_pendaftaran,
            'nama_lengkap'   => $request->nama_lengkap,
            'tanggal_terbit' => $request->tanggal_terbit,
            'penerbit'       => $request->penerbit,
            'masa_berlaku'   => $request->masa_berlaku,
            'file_pdf'       => $path,
        ]);

        $pendaftaran->update(['status_progres' => 'selesai']);

        return redirect()->route('subadmin.sertifikat.index')
            ->with('success', "Sertifikat {$request->no_sertifikat} berhasil diunggah.");
    }

    public function show($no_sertifikat)
    {
        $sertifikat = Sertifikat::findOrFail($no_sertifikat);

        if ($sertifikat->file_pdf && Storage::disk('public')->exists($sertifikat->file_pdf)) {
            return response()->file(storage_path('app/public/' . $sertifikat->file_pdf));
        }

        return redirect()->route('subadmin.sertifikat.index')->with('error', 'Dokumen fisik tidak ditemukan di server.');
    }

    public function edit($no_sertifikat)
    {
        $sertifikat = Sertifikat::with('pendaftaran.user')->findOrFail($no_sertifikat);
        return view('subadmin.sertifikat.edit', compact('sertifikat'));
    }

    public function update(Request $request, $no_sertifikat)
    {
        $sertifikat = Sertifikat::findOrFail($no_sertifikat);

        $request->validate([
            'no_sertifikat'  => 'required|string|unique:sertifikat,no_sertifikat,' . $no_sertifikat . ',no_sertifikat',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penerbit'       => 'required|string|max:255',
            'masa_berlaku'   => 'nullable|date',
            'file_pdf'       => 'nullable|file|mimes:pdf|max:5120',
        ]);

        DB::transaction(function () use ($request, $sertifikat, $no_sertifikat) {
            $oldNo = $sertifikat->no_sertifikat;
            $newNo = $request->no_sertifikat;

            $data = [
                'no_sertifikat'  => $newNo,
                'nama_lengkap'   => $request->nama_lengkap,
                'tanggal_terbit' => $request->tanggal_terbit,
                'penerbit'       => $request->penerbit,
                'masa_berlaku'   => $request->masa_berlaku,
            ];

            if ($request->hasFile('file_pdf')) {
                if ($sertifikat->file_pdf) {
                    Storage::disk('public')->delete($sertifikat->file_pdf);
                }
                $file = $request->file('file_pdf');
                $filename = Str::slug($newNo) . '_' . time() . '.pdf';
                $path = $file->storeAs('sertifikat/uploads', $filename, 'public');
                $data['file_pdf'] = $path;
            }

            if ($oldNo !== $newNo) {
                Verifikasi::where('sertifikat_no', $oldNo)->update(['sertifikat_no' => $newNo]);
                DB::table('sertifikat')->where('no_sertifikat', $oldNo)->update($data);
            } else {
                $sertifikat->update($data);
            }
        });

        return redirect()->route('subadmin.sertifikat.index')
            ->with('success', "Data sertifikat berhasil diperbarui.");
    }

    public function destroy(Request $request, $no_sertifikat)
    {
        try {
            $sertifikat = Sertifikat::findOrFail($no_sertifikat);
            $idPendaftaran = $sertifikat->id_pendaftaran;
            $statusBaru = $request->input('kembalikan_ke_proses') ? 'proses' : 'selesai';

            DB::transaction(function () use ($sertifikat, $idPendaftaran, $statusBaru) {
                if ($sertifikat->file_pdf) {
                    Storage::disk('public')->delete($sertifikat->file_pdf);
                }
                $sertifikat->delete();
                Pendaftaran::where('id_pendaftaran', $idPendaftaran)->update(['status_progres' => $statusBaru]);
            });

            return redirect()->route('subadmin.sertifikat.index')
                ->with('success', "Sertifikat {$no_sertifikat} telah dihapus.");
        } catch (\Exception $e) {
            return redirect()->route('subadmin.sertifikat.index')
                ->with('error', 'Gagal menghapus sertifikat: ' . $e->getMessage());
        }
    }
}
