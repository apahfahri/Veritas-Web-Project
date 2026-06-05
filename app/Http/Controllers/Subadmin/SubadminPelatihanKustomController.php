<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Jadwal;
use App\Models\Pemateri;
use App\Models\User;
use App\Models\KlienPerusahaan;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\PendaftaranInvoiceMail;
use App\Mail\TrainingScheduleMail;
use App\Notifications\PendaftaranStatusNotification;

class SubadminPelatihanKustomController extends Controller
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

    public function index(Request $request)
    {
        $query = Pendaftaran::where('is_kustom', true)
            ->whereHas('user', function($qu) {
                $qu->whereExists(function($q) {
                    $q->select(DB::raw(1))
                      ->from('klien_perusahaan')
                      ->whereColumn('klien_perusahaan.id_user', 'users.id_user')
                      ->whereColumn('klien_perusahaan.id_perusahaan', 'pendaftaran.id_perusahaan');
                });
            })
            ->with(['user', 'perusahaan', 'jadwal.jenis']);

        if ($request->filled('status')) {
            $query->where('status_progres', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_pendaftaran', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($qUser) use ($search) {
                      $qUser->where('nama', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('perusahaan', function($qPerus) use ($search) {
                      $qPerus->where('nama', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('jadwal.jenis', function($qJenis) use ($search) {
                      $qJenis->where('nama', 'LIKE', "%{$search}%");
                  });
            });
        }

        $pendaftarans = $query->latest()->paginate(15)->withQueryString();

        return view('subadmin.pelatihan-kustom.index', compact('pendaftarans'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::where('is_kustom', true)
            ->whereHas('user', function($qu) {
                $qu->whereExists(function($q) {
                    $q->select(DB::raw(1))
                      ->from('klien_perusahaan')
                      ->whereColumn('klien_perusahaan.id_user', 'users.id_user')
                      ->whereColumn('klien_perusahaan.id_perusahaan', 'pendaftaran.id_perusahaan');
                });
            })
            ->with(['user', 'perusahaan', 'jadwal.jenis', 'jadwal.pemateri'])
            ->findOrFail($id);

        $pemateris = Pemateri::all();

        // Fetch other participants registered in the same custom training schedule (id_jadwal)
        $participants = Pendaftaran::where('id_jadwal', $pendaftaran->id_jadwal)
            ->where('id_pendaftaran', '!=', $pendaftaran->id_pendaftaran)
            ->with('user')
            ->get();

        return view('subadmin.pelatihan-kustom.show', compact('pendaftaran', 'pemateris', 'participants'));
    }

    public function addParticipant(Request $request, $id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'whatsapp' => 'required|string|max:50',
        ]);

        DB::transaction(function() use ($pendaftaran, $request) {
            // Find or create User dummy for participant
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $user = User::create([
                    'nama'       => $request->nama,
                    'email'      => $request->email,
                    'no_telp'    => $request->whatsapp,
                    'pendidikan' => 'Perusahaan',
                    'password'   => Hash::make('KatigaVeritas123!'), // Default password
                ]);
            }

            // Create Pendaftaran record linked to the custom Jadwal
            Pendaftaran::create([
                'id_jadwal'               => $pendaftaran->id_jadwal,
                'id_user'                 => $user->id_user,
                'id_perusahaan'           => $pendaftaran->id_perusahaan,
                'is_utusan_perusahaan'    => true,
                'is_kustom'               => true,
                'status_progres'          => $pendaftaran->status_progres, // align status with parent PIC
                'status_bayar'            => 'lunas', // set automatically as paid collectively via corporate
                'tanggal_daftar'          => now(),
                'rencana_tanggal_mulai'   => $pendaftaran->rencana_tanggal_mulai,
                'rencana_tanggal_selesai' => $pendaftaran->rencana_tanggal_selesai,
            ]);
        });

        return redirect()->route('subadmin.pelatihan-kustom.show', $id)
            ->with('success', 'Peserta utusan berhasil ditambahkan.');
    }

    public function removeParticipant($id)
    {
        // Find and delete the participant registration (only if it is a B2B custom child registration)
        $part = Pendaftaran::where('is_kustom', true)
            ->where('is_utusan_perusahaan', true)
            ->findOrFail($id);

        $part->delete();

        return back()->with('success', 'Peserta utusan berhasil dihapus.');
    }

    public function importParticipants(Request $request, $id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv_file');
        $filePath = $file->getRealPath();

        // Auto-detect delimiter: comma vs semicolon
        $delimiter = ',';
        if (($handle = fopen($filePath, 'r')) !== false) {
            $firstLine = fgets($handle);
            if ($firstLine !== false) {
                if (substr_count($firstLine, ';') > substr_count($firstLine, ',')) {
                    $delimiter = ';';
                }
            }
            fclose($handle);
        }

        $rows = [];
        if (($handle = fopen($filePath, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, $delimiter);
            if ($header) {
                $header = array_map(function($h) {
                    return strtolower(trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $h)));
                }, $header);
            }

            while (($data = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (count($data) >= count($header)) {
                    $rows[] = array_combine(array_slice($header, 0, count($data)), $data);
                } else {
                    $row = [];
                    foreach ($header as $index => $colName) {
                        $row[$colName] = $data[$index] ?? null;
                    }
                    $rows[] = $row;
                }
            }
            fclose($handle);
        }

        if (empty($rows)) {
            return back()->with('error', 'Berkas CSV kosong atau format tidak sesuai.');
        }

        $importedCount = 0;
        DB::transaction(function() use ($pendaftaran, $rows, &$importedCount) {
            foreach ($rows as $row) {
                $nama = trim($row['nama'] ?? '');
                $email = trim($row['email'] ?? '');
                $whatsapp = trim($row['whatsapp'] ?? $row['no_telp'] ?? $row['no_hp'] ?? '');

                if (empty($nama) || empty($email) || empty($whatsapp)) {
                    continue;
                }

                // Find or create User dummy
                $user = User::where('email', $email)->first();
                if (!$user) {
                    $user = User::create([
                        'nama'       => $nama,
                        'email'      => $email,
                        'no_telp'    => $whatsapp,
                        'pendidikan' => 'Perusahaan',
                        'password'   => Hash::make('KatigaVeritas123!'),
                    ]);
                }

                // Check if already enrolled in this schedule
                $exists = Pendaftaran::where('id_jadwal', $pendaftaran->id_jadwal)
                    ->where('id_user', $user->id_user)
                    ->exists();

                if (!$exists) {
                    Pendaftaran::create([
                        'id_jadwal'               => $pendaftaran->id_jadwal,
                        'id_user'                 => $user->id_user,
                        'id_perusahaan'           => $pendaftaran->id_perusahaan,
                        'is_utusan_perusahaan'    => true,
                        'is_kustom'               => true,
                        'status_progres'          => $pendaftaran->status_progres,
                        'status_bayar'            => 'lunas',
                        'tanggal_daftar'          => now(),
                        'rencana_tanggal_mulai'   => $pendaftaran->rencana_tanggal_mulai,
                        'rencana_tanggal_selesai' => $pendaftaran->rencana_tanggal_selesai,
                    ]);
                    $importedCount++;
                }
            }
        });

        return redirect()->route('subadmin.pelatihan-kustom.show', $id)
            ->with('success', "Berhasil mengimport {$importedCount} peserta utusan.");
    }

    public function confirmRegistration($id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);

        $pendaftaran->update([
            'status_progres' => 'disetujui'
        ]);

        $this->notifyUser($pendaftaran, 'disetujui');

        return redirect()->route('subadmin.pelatihan-kustom.show', $id)
            ->with('success', 'Pendaftaran pelatihan kustom berhasil disetujui.');
    }

    public function startScheduling($id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);

        $pendaftaran->update([
            'status_progres' => 'dijadwalkan'
        ]);

        $this->notifyUser($pendaftaran, 'dijadwalkan');

        return redirect()->route('subadmin.pelatihan-kustom.show', $id)
            ->with('success', 'Status pendaftaran diubah ke Penjadwalan.');
    }

    public function scheduleMeeting(Request $request, $id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);
        
        $request->validate([
            'tgl_mulai' => 'required|date|after_or_equal:today',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'jam_pertemuan' => 'required',
            'mode_pertemuan' => 'required|in:online,offline,hybrid',
            'lokasi' => 'nullable|string|max:255',
            'link_meet' => 'nullable|url',
            'pemateri_ids' => 'required|array',
            'pemateri_ids.*' => 'exists:pemateri,id_pemateri',
        ]);

        if (in_array($request->mode_pertemuan, ['online', 'hybrid']) && empty($request->link_meet)) {
            return back()->withErrors(['link_meet' => 'Link meet wajib diisi untuk pertemuan online atau hybrid.'])->withInput();
        }

        $jadwal = $pendaftaran->jadwal;
        $jadwal->update([
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $request->tgl_selesai,
            'jam_pertemuan' => $request->jam_pertemuan,
            'jenis_pertemuan' => $request->mode_pertemuan,
            'lokasi' => $request->mode_pertemuan === 'offline' ? $request->lokasi : 'Online/Hybrid',
            'link_meet' => $request->link_meet,
        ]);

        $jadwal->pemateri()->sync($request->pemateri_ids);

        // Also sync participant records' schedule dates to make sure they match!
        Pendaftaran::where('id_jadwal', $jadwal->id_jadwal)->update([
            'rencana_tanggal_mulai' => $request->tgl_mulai,
            'rencana_tanggal_selesai' => $request->tgl_selesai,
            'mode_pertemuan' => $request->mode_pertemuan,
        ]);

        $pendaftaran->update([
            'status_progres' => 'menunggu_pelaksanaan',
        ]);

        $this->notifyUser($pendaftaran, 'menunggu_pelaksanaan');

        // Kirim email jadwal pelatihan kustom otomatis ke pelanggan
        try {
            if ($pendaftaran->user && $pendaftaran->user->email) {
                Mail::to($pendaftaran->user->email)->send(new TrainingScheduleMail($pendaftaran));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error sending training schedule email: ' . $e->getMessage());
        }

        return redirect()->route('subadmin.pelatihan-kustom.show', $id)
            ->with('success', 'Jadwal pelatihan kustom berhasil disimpan & email konfirmasi dikirim.');
    }

    public function finishTraining(Request $request, $id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);

        $request->validate([
            'harga' => 'required|numeric|min:0',
        ]);

        $jadwal = $pendaftaran->jadwal;
        $jadwal->update([
            'harga' => $request->harga,
        ]);

        // Update all related pendaftaran status to 'menunggu_pembayaran'
        Pendaftaran::where('id_jadwal', $jadwal->id_jadwal)->update([
            'status_progres' => 'menunggu_pembayaran',
        ]);

        $this->notifyUser($pendaftaran, 'menunggu_pembayaran');

        // Kirim email invoice ke pelanggan
        try {
            if ($pendaftaran->user && $pendaftaran->user->email) {
                Mail::to($pendaftaran->user->email)->send(new PendaftaranInvoiceMail($pendaftaran));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error sending invoice email in custom training: ' . $e->getMessage());
        }

        return redirect()->route('subadmin.pelatihan-kustom.show', $id)
            ->with('success', 'Proses pelaksanaan pelatihan kustom selesai. Tagihan berhasil diterbitkan & email invoice dikirim.');
    }

    public function confirmPayment($id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);

        // Update both parent and participants status to completed
        Pendaftaran::where('id_jadwal', $pendaftaran->id_jadwal)->update([
            'status_bayar' => 'lunas',
            'status_progres' => 'selesai',
        ]);

        $this->notifyUser($pendaftaran, 'selesai');

        return redirect()->route('subadmin.pelatihan-kustom.show', $id)
            ->with('success', 'Bukti pembayaran berhasil dikonfirmasi. Status pendaftaran selesai & lunas.');
    }

    public function rejectPayment($id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);

        Pendaftaran::where('id_jadwal', $pendaftaran->id_jadwal)->update([
            'status_progres' => 'dibatalkan',
        ]);

        $this->notifyUser($pendaftaran, 'dibatalkan');

        return redirect()->route('subadmin.pelatihan-kustom.show', $id)
            ->with('success', 'Pendaftaran pelatihan kustom dibatalkan.');
    }

    private function getPendaftaranWithBranch($id)
    {
        return Pendaftaran::where('is_kustom', true)
            ->whereHas('user', function($qu) {
                $qu->whereExists(function($q) {
                    $q->select(DB::raw(1))
                      ->from('klien_perusahaan')
                      ->whereColumn('klien_perusahaan.id_user', 'users.id_user')
                      ->whereColumn('klien_perusahaan.id_perusahaan', 'pendaftaran.id_perusahaan');
                });
            })
            ->findOrFail($id);
    }

    private function notifyUser($pendaftaran, $status)
    {
        try {
            $notification = new PendaftaranStatusNotification($pendaftaran, $status);
            $pendaftaran->user?->notify($notification);

            if ($pendaftaran->user?->no_telp) {
                $notification->sendWhatsapp($pendaftaran->user->no_telp);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error sending notification in custom training: ' . $e->getMessage());
        }
    }
}
