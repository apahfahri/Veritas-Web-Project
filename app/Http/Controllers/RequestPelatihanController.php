<?php
 
namespace App\Http\Controllers;

use App\Models\Perusahaan;
use App\Models\KlienPerusahaan;
use App\Models\JenisLayanan;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RequestPelatihanController extends Controller
{
    public function create()
    {
        $jenisLayanan = JenisLayanan::where('id_kategori', 1)->orderBy('nama', 'asc')->get();
        return view('pages.request-training', compact('jenisLayanan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap'      => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'no_telp'           => 'required|string|max:20',
            'nama_perusahaan'   => 'required|string|max:255',
            'jabatan'           => 'nullable|string|max:255',
            'alamat_perusahaan' => 'required|string',
            'sektor_industri'   => 'nullable|string|max:255',
            'jumlah_peserta'    => 'nullable|integer|min:1',
            'topik_pelatihan'   => 'required|string|max:255',
            'tanggal_harapan'   => 'nullable|date',
            'pesan_tambahan'    => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Upsert data Perusahaan (insert or update by nama)
            $perusahaan = Perusahaan::firstOrCreate(
                ['nama' => $validated['nama_perusahaan']],
                [
                    'alamat'          => $validated['alamat_perusahaan'],
                    'sektor_industri' => $validated['sektor_industri'] ?? null,
                ]
            );

            // 2. Find or create User PIC
            $user = User::where('email', $validated['email'])->first();
            if (!$user) {
                $user = User::create([
                    'nama'       => $validated['nama_lengkap'],
                    'email'      => $validated['email'],
                    'no_telp'    => $validated['no_telp'],
                    'pendidikan' => 'Perusahaan',
                    'password'   => Hash::make('KatigaVeritas123!'), // Default password
                ]);
            }

            // 3. Upsert data KlienPerusahaan (PIC profile)
            KlienPerusahaan::updateOrCreate(
                [
                    'id_perusahaan' => $perusahaan->id_perusahaan,
                    'nama_cp'       => $validated['nama_lengkap'],
                ],
                [
                    'id_user'   => $user->id_user,
                    'jabatan'   => $validated['jabatan'] ?? null,
                    'no_hp_cp'  => $validated['no_telp'],
                ]
            );

            // 4. Find matching JenisLayanan
            $jenis = JenisLayanan::where('nama', $validated['topik_pelatihan'])
                ->where('id_kategori', 1)
                ->first();
            if (!$jenis) {
                $jenis = JenisLayanan::where('id_kategori', 1)->first();
            }

            // 5. Generate custom Jadwal code
            $kategoriKode = 'PLT';
            $jenisKode = $jenis?->kode_jenis ?? 'PLT';
            $urutan = Jadwal::where('id_jenis', $jenis->id_jenis)->count() + 1;
            $urutanFormat = str_pad($urutan, 2, '0', STR_PAD_LEFT);
            $kodeJadwal = "{$kategoriKode}-{$jenisKode}-{$urutanFormat}";

            // 6. Create custom Jadwal record
            $jadwal = Jadwal::create([
                'id_kategori'     => 1, // Pelatihan
                'id_jenis'        => $jenis->id_jenis,
                'kode_jadwal'     => $kodeJadwal,
                'jenis_pertemuan' => 'offline', // default
                'tgl_mulai'       => $validated['tanggal_harapan'] ?? now(),
                'tgl_selesai'     => $validated['tanggal_harapan'] ?? now(),
                'harga'           => 0,
                'kapasitas'       => $validated['jumlah_peserta'] ?? 10,
                'deskripsi'       => $validated['pesan_tambahan'] ?? ('Pelatihan Kustom (Bespoke) untuk ' . $validated['nama_perusahaan']),
            ]);

            // 7. Create custom Pendaftaran record
            Pendaftaran::create([
                'id_jadwal'               => $jadwal->id_jadwal,
                'id_user'                 => $user->id_user,
                'id_perusahaan'           => $perusahaan->id_perusahaan,
                'is_utusan_perusahaan'    => true,
                'is_kustom'               => true,
                'catatan_klien'           => $validated['pesan_tambahan'] ?? null,
                'status_progres'          => 'meninjau',
                'status_bayar'            => 'belum_bayar',
                'tanggal_daftar'          => now(),
                'rencana_tanggal_mulai'   => $validated['tanggal_harapan'] ?? null,
                'rencana_tanggal_selesai' => $validated['tanggal_harapan'] ?? null,
            ]);
        });

        return redirect()
            ->route('training.list')
            ->with('success', 'Permintaan pelatihan kustom berhasil dikirim! Tim kami akan segera meninjau dan menghubungi Anda.');
    }
}
