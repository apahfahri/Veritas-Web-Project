<?php

namespace App\Http\Controllers;

use App\Models\KlienIndividu;
use App\Models\KlienPerusahaan;
use App\Models\Pendaftaran;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $jenis = $request->input('jenis_klien'); // 'individu' | 'perusahaan'

        // ── Validasi umum ──────────────────────────────────────────────────
        $rules = [
            'jenis_klien'    => 'required|in:individu,perusahaan',
            'layanan_id'     => 'required|exists:layanan,id',
            'tanggal_daftar' => 'required|date|after_or_equal:today',
        ];

        // ── Validasi khusus per jenis ──────────────────────────────────────
        if ($jenis === 'individu') {
            $rules['nama_lengkap'] = 'required|string|max:255';
            $rules['no_hp']        = 'required|string|max:20';
            $rules['nik']          = 'nullable|string|max:16';
        } else {
            $rules['nama_lengkap']     = 'required|string|max:255';
            $rules['jabatan']          = 'nullable|string|max:255';
            $rules['nama_perusahaan']  = 'required|string|max:255';
            $rules['alamat_perusahaan']= 'required|string';
            $rules['npwp_perusahaan']  = 'nullable|string|max:30';
            $rules['nib_oss']          = 'nullable|string|max:50';
            $rules['sektor_industri']  = 'nullable|string|max:100';
            $rules['jumlah_karyawan']  = 'nullable|integer|min:1';
        }

        $request->validate($rules);

        DB::transaction(function () use ($request, $jenis) {

            $userId = Auth::id();

            // ── Simpan/update profil klien ─────────────────────────────────
            if ($jenis === 'individu') {
                KlienIndividu::updateOrCreate(
                    ['user_id' => $userId],
                    [
                        'nama_lengkap' => $request->nama_lengkap,
                        'no_hp'        => $request->no_hp,
                        'nik'          => $request->nik,
                    ]
                );
            } else {
                // Cari atau buat record perusahaan
                $perusahaan = Perusahaan::firstOrCreate(
                    ['nama' => $request->nama_perusahaan],
                    [
                        'alamat'          => $request->alamat_perusahaan,
                        'npwp_perusahaan' => $request->npwp_perusahaan,
                        'nib_oss'         => $request->nib_oss,
                        'sektor_industri' => $request->sektor_industri,
                        'jumlah_karyawan' => $request->jumlah_karyawan,
                    ]
                );

                KlienPerusahaan::updateOrCreate(
                    ['user_id' => $userId],
                    [
                        'perusahaan_id' => $perusahaan->id,
                        'nama_lengkap'  => $request->nama_lengkap,
                        'jabatan'       => $request->jabatan,
                    ]
                );
            }

            // ── Buat record pendaftaran ────────────────────────────────────
            Pendaftaran::create([
                'layanan_id'     => $request->layanan_id,
                'user_id'        => $userId,
                'tanggal_daftar' => $request->tanggal_daftar,
                'status_progres' => 'menunggu',
                'status_bayar'   => 'belum_bayar',
            ]);
        });

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::where('user_id', Auth::id())->findOrFail($id);

        if ($pendaftaran->status_progres !== 'menunggu') {
            return back()->with('error', 'Pendaftaran tidak dapat dibatalkan karena sudah diproses.');
        }

        $pendaftaran->update(['status_progres' => 'dibatalkan']);

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
