<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Perusahaan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {
        $jenis = $request->input('jenis_klien'); // 'individu' | 'perusahaan'

        // ── Validasi umum ──────────────────────────────────────────────────
        $rules = [
            'layanan_id'     => 'required|exists:layanan,id_layanan',
            'jenis_klien'    => 'required|in:individu,perusahaan',
            'nama_lengkap'   => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'no_telp'                => 'required|string|max:20',
            'pendidikan'             => 'nullable|string|max:100',
            'rencana_tanggal_mulai'  => 'nullable|date|after_or_equal:today',
            'rencana_tanggal_selesai'=> 'nullable|date|after_or_equal:rencana_tanggal_mulai',
            'mode_pertemuan'         => 'nullable|in:online,offline',
        ];

        // ── Validasi khusus per jenis ──────────────────────────────────────
        if ($jenis === 'perusahaan') {
            $rules['nama_perusahaan']  = 'required|string|max:255';
            $rules['alamat_perusahaan']= 'required|string';
            $rules['sektor_industri']  = 'nullable|string|max:100';
            $rules['jumlah_karyawan']  = 'nullable|integer|min:1';
            $rules['jabatan']          = 'nullable|string|max:255';
        }

        $request->validate($rules);

        DB::transaction(function () use ($request, $jenis) {

            // ── Cari/Buat User ─────────────────────────────────────────────
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $user = User::create([
                    'nama' => $request->nama_lengkap,
                    'email' => $request->email,
                    'no_telp' => $request->no_telp,
                    'pendidikan' => $request->pendidikan,
                ]);
            } else {
                $user->update([
                    'nama' => $request->nama_lengkap,
                    'no_telp' => $request->no_telp,
                    'pendidikan' => $request->pendidikan,
                ]);
            }

            // ── Simpan/update profil perusahaan ────────────────────────────
            if ($jenis === 'perusahaan') {
                $perusahaan = Perusahaan::firstOrCreate(
                    ['nama' => $request->nama_perusahaan],
                    [
                        'alamat'          => $request->alamat_perusahaan,
                        'sektor_industri' => $request->sektor_industri,
                        'jumlah_karyawan' => $request->jumlah_karyawan,
                    ]
                );

                // Pastikan ID perusahaan tidak null (terutama jika baru dibuat)
                $idPerusahaan = $perusahaan->id_perusahaan;

                \App\Models\KlienPerusahaan::updateOrCreate(
                    ['id_user' => $user->id_user, 'id_perusahaan' => $idPerusahaan],
                    ['jabatan' => $request->jabatan]
                );
            }

            // ── Buat record pendaftaran ────────────────────────────────────
            Pendaftaran::create([
                'id_layanan'              => $request->layanan_id,
                'id_user'                 => $user->id_user,
                'tanggal_daftar'          => now(),
                'rencana_tanggal_mulai'   => $request->rencana_tanggal_mulai,
                'rencana_tanggal_selesai' => $request->rencana_tanggal_selesai,
                'mode_pertemuan'          => $request->mode_pertemuan,
                'status_progres'          => 'menunggu_pembayaran',
                'status_bayar'            => 'belum_lunas',
            ]);
        });

        return redirect()->route('training.status', ['identifier' => $request->email])
            ->with('registration_success', true)
            ->with('success_type', 'konsultasi');
    }

    public function statusForm(Request $request)
    {
        $identifier = $request->query('identifier');
        $pendaftarans = null;

        if ($identifier) {
            $user = User::where('email', $identifier)
                ->orWhere('no_telp', $identifier)
                ->first();

            if ($user) {
                $pendaftarans = Pendaftaran::with('layanan')
                    ->where('id_user', $user->id_user)
                    ->latest()
                    ->get();
            }
        }

        return view('pages.training-status', compact('pendaftarans', 'identifier'));
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
        ]);

        $identifier = $request->identifier;

        // Cari user berdasarkan email atau nomor telepon
        $user = User::where('email', $identifier)
            ->orWhere('no_telp', $identifier)
            ->first();

        if (!$user) {
            return back()->withErrors(['identifier' => 'Data pendaftaran tidak ditemukan untuk email/nomor telepon tersebut.'])
                         ->withInput();
        }

        $pendaftarans = Pendaftaran::with('layanan')
            ->where('id_user', $user->id_user)
            ->latest()
            ->get();

        return view('pages.training-status', compact('pendaftarans', 'identifier'));
    }
}
