<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jadwal;
use App\Models\Perusahaan;
use App\Models\Pendaftaran;
use App\Models\KategoriLayanan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PendaftaranInvoiceMail;

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {
        // Jika kategori_id = 2 (Konsultasi), force jenis_klien ke perusahaan
        if ($request->input('kategori_id') == 2) {
            $request->merge(['jenis_klien' => 'perusahaan']);
        }

        $jenis = $request->input('jenis_klien'); // 'individu' | 'perusahaan'

        $rules = [
            'jadwal_id'      => 'nullable|exists:jadwal,id_jadwal',
            'kategori_id'    => 'nullable|exists:kategori_layanan,id_kategori',
            'jenis_id'       => 'nullable|exists:jenis_layanan,id_jenis',
            'jenis_klien'    => 'required|in:individu,perusahaan',
            'nama_lengkap'   => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'no_telp'        => 'required|string|max:20',
            'pendidikan'     => 'required|string|max:100',
            'tanggal_usul'   => 'nullable|date|after_or_equal:today',
            'lokasi'         => 'nullable|string|max:255',
            'mode_pertemuan' => 'nullable|in:online,offline,hybrid',
        ];

        if (!$request->jadwal_id && !$request->kategori_id) {
            return back()->withErrors(['jadwal_id' => 'Pilih jadwal atau layanan yang valid.'])->withInput();
        }

        if ($jenis === 'perusahaan') {
            $rules['nama_perusahaan']   = 'required|string|max:255';
            $rules['alamat_perusahaan'] = 'required|string';
            $rules['sektor_industri']   = 'nullable|string|max:100';
            $rules['jumlah_karyawan']   = 'nullable|integer|min:1';
            $rules['jabatan']           = 'nullable|string|max:255';
        }

        $request->validate($rules);

        $result = DB::transaction(function () use ($request, $jenis) {
            $jadwalId = $request->jadwal_id;

            // Jika tidak ada jadwal_id spesifik (misal dari halaman konsultasi/audit),
            // buat jadwal baru bespoke untuk pendaftaran ini
            if (!$jadwalId) {
                $kategori = KategoriLayanan::find($request->kategori_id);
                $jenisObj = JenisLayanan::find($request->jenis_id);

                $topik = $request->topik_layanan ?? ($jenisObj?->nama ?? ($kategori?->nama ?? 'Layanan'));
                if ($topik === 'Lainnya' && $request->catatan) {
                    $topik = 'Lainnya (' . trim($request->catatan) . ')';
                }

                // Cari atau buat jenis_layanan berspoke
                $jenisBespoke = $jenisObj ?? JenisLayanan::firstOrCreate(
                    ['id_kategori' => $kategori?->id_kategori, 'nama' => $topik],
                    ['kode_jenis' => null]
                );

                // Auto-generate kode_jenis if empty
                if (empty($jenisBespoke->kode_jenis)) {
                    $words = explode(' ', preg_replace('/[^a-zA-Z0-9\s]/', '', $jenisBespoke->nama));
                    $code = '';
                    if (count($words) > 1) {
                        foreach ($words as $w) {
                            $code .= strtoupper(substr($w, 0, 1));
                        }
                    } else {
                        $code = strtoupper(substr($words[0] ?? 'KNS', 0, 4));
                    }
                    $code = preg_replace('/[^A-Z0-9]/', '', $code);
                    if (empty($code)) {
                        $code = 'KNS';
                    }
                    $jenisBespoke->kode_jenis = substr($code, 0, 15);
                    $jenisBespoke->save();
                }

                $kategoriKode = $kategori?->kode_kategori ?? 'KST';
                $jenisKode = $jenisBespoke->kode_jenis;
                $urutan = Jadwal::where('id_jenis', $jenisBespoke->id_jenis)->count() + 1;
                $urutanFormat = str_pad($urutan, 2, '0', STR_PAD_LEFT);
                $kode_jadwal = "{$kategoriKode}-{$jenisKode}-{$urutanFormat}";

                $jadwalBespoke = Jadwal::create([
                    'id_kategori'    => $kategori?->id_kategori,
                    'id_jenis'       => $jenisBespoke->id_jenis,
                    'kode_jadwal'    => $kode_jadwal,
                    'jenis_pertemuan'=> $request->mode_pertemuan ?? 'offline',
                    'lokasi'         => $request->mode_pertemuan === 'offline' ? $request->lokasi : null,
                    'harga'          => 0,
                    'kapasitas'      => 1,
                    'deskripsi'      => 'Permintaan dari ' . ($request->nama_perusahaan ?? $request->nama_lengkap),
                ]);
                $jadwalId = $jadwalBespoke->id_jadwal;
            }

            // Cari/Buat User
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $user = User::create([
                    'nama'       => $request->nama_lengkap,
                    'email'      => $request->email,
                    'no_telp'    => $request->no_telp,
                    'pendidikan' => $request->pendidikan,
                ]);
            } else {
                $user->update([
                    'nama'       => $request->nama_lengkap,
                    'no_telp'    => $request->no_telp,
                    'pendidikan' => $request->pendidikan,
                ]);
            }

            $idPerusahaan = null;
            if ($jenis === 'perusahaan') {
                $perusahaan = Perusahaan::firstOrCreate(
                    ['nama' => $request->nama_perusahaan],
                    [
                        'alamat'          => $request->alamat_perusahaan,
                        'sektor_industri' => $request->sektor_industri,
                        'jumlah_karyawan' => $request->jumlah_karyawan,
                    ]
                );
                $idPerusahaan = $perusahaan->id_perusahaan;

                \App\Models\KlienPerusahaan::updateOrCreate(
                    ['id_user' => $user->id_user, 'id_perusahaan' => $idPerusahaan],
                    ['jabatan' => $request->jabatan]
                );
            }

            $kategoriId = $request->kategori_id;
            if ($jadwalId && !$kategoriId) {
                $jTemp = Jadwal::find($jadwalId);
                $kategoriId = $jTemp?->id_kategori;
            }

            $statusProgres = ($kategoriId == 2) ? 'meninjau' : 'menunggu_pembayaran';

            $pendaftaran = Pendaftaran::create([
                'id_jadwal'               => $jadwalId,
                'id_user'                 => $user->id_user,
                'id_perusahaan'           => $idPerusahaan,
                'is_utusan_perusahaan'    => $jenis === 'perusahaan' ? 1 : 0,
                'tanggal_daftar'          => now(),
                'rencana_tanggal_mulai'   => $request->tanggal_usul,
                'rencana_tanggal_selesai' => $request->tanggal_usul,
                'mode_pertemuan'          => $request->mode_pertemuan,
                'status_progres'          => $statusProgres,
                'status_bayar'            => 'belum_bayar',
            ]);

            $jadwalData = $pendaftaran->jadwal()->with(['kategori', 'jenis'])->first();

            return [
                'pendaftaran' => $pendaftaran,
                'user'        => $user,
                'jadwal'      => $jadwalData,
            ];
        });

        // Kirim invoice email (lewati jika konsultasi)
        $invoiceSent = false;
        $emailError  = null;
        try {
            $isKonsultasi = ($result && isset($result['jadwal']) && $result['jadwal']->id_kategori == 2);
            if (!$isKonsultasi && $result && isset($result['pendaftaran'], $result['user'])) {
                Mail::to($result['user']->email)->send(new PendaftaranInvoiceMail(
                    $result['pendaftaran'],
                    $result['user'],
                    $result['jadwal']
                ));
                $invoiceSent = true;
            }
        } catch (\Exception $e) {
            $emailError = $e->getMessage();
            \Illuminate\Support\Facades\Log::error('Error sending invoice: ' . $emailError);
        }

        return redirect()->route('training.status', ['identifier' => $request->email])
            ->with('registration_success', true)
            ->with('is_konsultasi', $isKonsultasi)
            ->with('invoice_email_sent', $invoiceSent)
            ->with('email_error', $emailError);
    }

    public function statusForm(Request $request)
    {
        $identifier   = $request->query('identifier');
        $pendaftarans = null;

        if ($identifier) {
            $user = User::where('email', $identifier)->orWhere('no_telp', $identifier)->first();
            if ($user) {
                $pendaftarans = Pendaftaran::with(['jadwal.jenis', 'jadwal.kategori', 'sertifikat'])
                    ->where('id_user', $user->id_user)
                    ->latest()
                    ->get();
            }
        }

        $rekening = \App\Models\Rekening::where('status_aktif', true)->first();
        return view('pages.training-status', compact('pendaftarans', 'identifier', 'rekening'));
    }

    public function checkStatus(Request $request)
    {
        $request->validate(['identifier' => 'required|string']);

        $user = User::where('email', $request->identifier)
            ->orWhere('no_telp', $request->identifier)
            ->first();

        if (!$user) {
            return back()->withErrors(['identifier' => 'Data tidak ditemukan.'])->withInput();
        }

        $pendaftarans = Pendaftaran::with(['jadwal.jenis', 'jadwal.kategori', 'sertifikat'])
            ->where('id_user', $user->id_user)
            ->latest()
            ->get();

        $rekening = \App\Models\Rekening::where('status_aktif', true)->first();
        $identifier = $request->identifier;
        return view('pages.training-status', compact('pendaftarans', 'identifier', 'rekening'));
    }

    /**
     * Step 1: Verifikasi nomor pendaftaran (AJAX)
     * Menerima nomor_pendaftaran + email, mengembalikan JSON valid/invalid
     */
    public function verifikasiNomor(Request $request)
    {
        $request->validate([
            'nomor_pendaftaran' => 'required|string',
            'email'             => 'required|email',
        ]);

        $pendaftaran = Pendaftaran::where('nomor_pendaftaran', strtoupper(trim($request->nomor_pendaftaran)))
            ->whereHas('user', fn($q) => $q->where('email', $request->email))
            ->with(['jadwal.jenis', 'user'])
            ->first();

        if (!$pendaftaran) {
            return response()->json([
                'valid'   => false,
                'message' => 'Nomor pendaftaran tidak valid atau tidak sesuai dengan email yang terdaftar.',
            ], 422);
        }

        if ($pendaftaran->status_bayar === 'lunas') {
            return response()->json([
                'valid'   => false,
                'message' => 'Pembayaran untuk pendaftaran ini sudah dikonfirmasi lunas.',
            ], 422);
        }

        if ($pendaftaran->status_bayar === 'menunggu_konfirmasi') {
            return response()->json([
                'valid'   => false,
                'message' => 'Bukti pembayaran sudah dikirim dan sedang menunggu konfirmasi admin.',
            ], 422);
        }

        $rekening = \App\Models\Rekening::where('status_aktif', true)->first();
        return response()->json([
            'valid'             => true,
            'id_pendaftaran'    => $pendaftaran->id_pendaftaran,
            'program'           => $pendaftaran->jadwal?->jenis?->nama ?? '-',
            'nomor_pendaftaran' => $pendaftaran->nomor_pendaftaran,
            'bank_name'         => $rekening?->nama_bank ?? 'Bank Mandiri',
            'bank_account'      => $rekening?->nomor_rekening ?? '131-00-1886111-1',
            'bank_recipient'    => $rekening?->atas_nama ?? 'PT Katiga Veritas Indonesia',
        ]);
    }

    /**
     * Step 2: Upload bukti bayar oleh pelanggan
     */
    public function kirimBuktiBayar(Request $request)
    {
        $request->validate([
            'nomor_pendaftaran' => 'required|string',
            'email'             => 'required|email',
            'bukti_bayar'       => 'required|image|mimes:jpeg,png,jpg,webp|max:1024',
        ]);

        $pendaftaran = Pendaftaran::where('nomor_pendaftaran', strtoupper(trim($request->nomor_pendaftaran)))
            ->whereHas('user', fn($q) => $q->where('email', $request->email))
            ->first();

        if (!$pendaftaran) {
            return back()->withErrors(['nomor_pendaftaran' => 'Nomor pendaftaran tidak valid.'])->withInput();
        }

        if ($request->hasFile('bukti_bayar')) {
            $file     = $request->file('bukti_bayar');
            $filename = 'bukti_' . $pendaftaran->id_pendaftaran . '_' . time() . '.' . $file->getClientOriginalExtension();

            if (!file_exists(public_path('uploads/pembayaran'))) {
                mkdir(public_path('uploads/pembayaran'), 0777, true);
            }

            $file->move(public_path('uploads/pembayaran'), $filename);

            $isKonsultasi = ($pendaftaran->jadwal?->id_kategori == 2);
            $pendaftaran->update([
                'bukti_bayar'    => $filename,
                'status_bayar'   => 'menunggu_konfirmasi',
                'status_progres' => $isKonsultasi ? 'pembayaran_ditinjau' : 'menunggu',
            ]);
        }

        return redirect()->route('training.status', ['identifier' => $request->email])
            ->with('bukti_terkirim', true);
    }
}
