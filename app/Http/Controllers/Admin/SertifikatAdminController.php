<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Sertifikat;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SertifikatAdminController extends Controller
{
    public function index()
    {
        $sertifikats = Sertifikat::with(['pendaftaran.user', 'pendaftaran.layanan'])->latest()->paginate(5);
        
        // Hanya pendaftaran Selesai & Lunas yang belum punya sertifikat
        $pendaftaranTersedia = Pendaftaran::with(['user', 'layanan'])
            ->where('status_progres', 'selesai')
            ->where('status_bayar', 'lunas')
            ->whereDoesntHave('sertifikat')
            ->latest()
            ->get();

        return view('admin.sertifikat.index', compact('sertifikats', 'pendaftaranTersedia'));
    }

    public function create($id_pendaftaran)
    {
        $pendaftaran = Pendaftaran::with(['user', 'layanan'])
            ->where('status_progres', 'selesai')
            ->where('status_bayar', 'lunas')
            ->findOrFail($id_pendaftaran);

        if ($pendaftaran->sertifikat) {
            return redirect()->route('admin.sertifikat.index')
                ->with('error', 'Sertifikat untuk pendaftaran ini sudah ada.');
        }

        return view('admin.sertifikat.create', compact('pendaftaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pendaftaran' => 'required|exists:pendaftaran,id_pendaftaran',
            'no_sertifikat'  => 'required|string|unique:sertifikat,no_sertifikat',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penerbit'          => 'required|string|max:255',
            'masa_berlaku'      => 'nullable|date',
            'file_pdf'          => 'required|file|mimes:pdf|max:5120', // 5MB
        ]);

        $exists = Sertifikat::where('id_pendaftaran', $request->id_pendaftaran)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Sertifikat untuk pendaftaran ini sudah diterbitkan.');
        }

        // Simpan File
        $file = $request->file('file_pdf');
        $filename = Str::slug($request->no_sertifikat) . '_' . time() . '.pdf';
        $path = $file->storeAs('sertifikat/uploads', $filename, 'public');

        Sertifikat::create([
            'no_sertifikat'  => $request->no_sertifikat,
            'id_pendaftaran' => $request->id_pendaftaran,
            'nama_lengkap'   => $request->nama_lengkap,
            'tanggal_terbit' => $request->tanggal_terbit,
            'penerbit'          => $request->penerbit,
            'masa_berlaku'      => $request->masa_berlaku,
            'file_pdf'          => $path,
        ]);

        return redirect()->route('admin.sertifikat.index')
            ->with('success', "Sertifikat {$request->no_sertifikat} berhasil diunggah.");
    }

    public function show($no_sertifikat)
    {
        $sertifikat = Sertifikat::findOrFail($no_sertifikat);

        if ($sertifikat->file_pdf && Storage::disk('public')->exists($sertifikat->file_pdf)) {
            return response()->file(storage_path('app/public/' . $sertifikat->file_pdf));
        }

        return redirect()->route('admin.sertifikat.index')->with('error', 'Dokumen fisik tidak ditemukan di server.');
    }

    public function edit($no_sertifikat)
    {
        $sertifikat = Sertifikat::with('pendaftaran.user')->findOrFail($no_sertifikat);
        return view('admin.sertifikat.edit', compact('sertifikat'));
    }

    public function update(Request $request, $no_sertifikat)
    {
        $sertifikat = Sertifikat::findOrFail($no_sertifikat);

        $request->validate([
            'no_sertifikat'  => 'required|string|unique:sertifikat,no_sertifikat,' . $no_sertifikat . ',no_sertifikat',
            'nama_lengkap'   => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'penerbit'          => 'required|string|max:255',
            'masa_berlaku'      => 'nullable|date',
            'file_pdf'          => 'nullable|file|mimes:pdf|max:5120',
        ]);

        DB::transaction(function () use ($request, $sertifikat, $no_sertifikat) {
            $oldNo = $sertifikat->no_sertifikat;
            $newNo = $request->no_sertifikat;

            $data = [
                'no_sertifikat'  => $newNo,
                'nama_lengkap'   => $request->nama_lengkap,
                'tanggal_terbit' => $request->tanggal_terbit,
                'penerbit'          => $request->penerbit,
                'masa_berlaku'      => $request->masa_berlaku,
            ];

            if ($request->hasFile('file_pdf')) {
                // Hapus file lama
                if ($sertifikat->file_pdf) {
                    Storage::disk('public')->delete($sertifikat->file_pdf);
                }
                
                $file = $request->file('file_pdf');
                $filename = Str::slug($newNo) . '_' . time() . '.pdf';
                $path = $file->storeAs('sertifikat/uploads', $filename, 'public');
                $data['file_pdf'] = $path;
            }

            // Jika nomor berubah, kita perlu update manual karena primary key di Eloquent bisa rese
            if ($oldNo !== $newNo) {
                // Update verifikasi jika ada
                Verifikasi::where('sertifikat_no', $oldNo)->update(['sertifikat_no' => $newNo]);
                
                // Gunakan query builder untuk update PK
                DB::table('sertifikat')->where('no_sertifikat', $oldNo)->update($data);
            } else {
                $sertifikat->update($data);
            }
        });

        return redirect()->route('admin.sertifikat.index')
            ->with('success', "Data sertifikat berhasil diperbarui.");
    }

    public function destroy(Request $request, $no_sertifikat)
    {
        $sertifikat = Sertifikat::findOrFail($no_sertifikat);
        $idPendaftaran = $sertifikat->id_pendaftaran;

        $statusBaru = $request->input('kembalikan_ke_proses') ? 'proses' : 'selesai';

        DB::transaction(function () use ($sertifikat, $idPendaftaran, $statusBaru) {
            // Hapus file fisik
            if ($sertifikat->file_pdf) {
                Storage::disk('public')->delete($sertifikat->file_pdf);
            }
            $sertifikat->delete();
            Pendaftaran::where('id_pendaftaran', $idPendaftaran)->update(['status_progres' => $statusBaru]);
        });

        return redirect()->route('admin.sertifikat.index')
            ->with('success', "Sertifikat {$no_sertifikat} telah dihapus.");
    }
}
