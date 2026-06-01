<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Jadwal;
use App\Models\Pemateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PendaftaranInvoiceMail;
use App\Mail\AuditScheduleMail;
use App\Notifications\PendaftaranStatusNotification;

class SubadminAuditController extends Controller
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
        $query = Pendaftaran::whereHas('jadwal', function($q) {
            $q->where('id_kategori', 3);
        })->with(['user', 'perusahaan', 'jadwal.jenis']);

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
                  });
            });
        }

        $pendaftarans = $query->latest()->paginate(15);

        return view('subadmin.audit.index', compact('pendaftarans'));
    }

    public function show($id)
    {
        $query = Pendaftaran::whereHas('jadwal', function($q) {
            $q->where('id_kategori', 3);
        })->with(['user', 'perusahaan', 'jadwal.jenis', 'jadwal.kategori', 'jadwal.pemateri']);

        $pendaftaran = $query->findOrFail($id);
        $allPemateri = Pemateri::all();

        return view('subadmin.audit.show', compact('pendaftaran', 'allPemateri'));
    }

    public function confirmAudit($id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);
        
        $pendaftaran->update([
            'status_progres' => 'disetujui'
        ]);

        $this->notifyUser($pendaftaran, 'disetujui');

        return redirect()->route('subadmin.audit.show', $id)
            ->with('success', 'Permintaan audit telah disetujui.');
    }

    public function startScheduling($id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);
        
        $pendaftaran->update([
            'status_progres' => 'dijadwalkan'
        ]);

        $this->notifyUser($pendaftaran, 'dijadwalkan');

        return redirect()->route('subadmin.audit.show', $id)
            ->with('success', 'Audit masuk ke tahap penjadwalan.');
    }

    public function scheduleMeeting(Request $request, $id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);
        
        $request->validate([
            'tgl_mulai' => 'required|date|after_or_equal:today',
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
            'tgl_selesai' => $request->tgl_mulai, // default same day
            'jam_pertemuan' => $request->jam_pertemuan,
            'jenis_pertemuan' => $request->mode_pertemuan,
            'lokasi' => $request->mode_pertemuan === 'offline' ? $request->lokasi : 'Online/Hybrid',
            'link_meet' => $request->link_meet,
        ]);

        $jadwal->pemateri()->sync($request->pemateri_ids);

        $pendaftaran->update([
            'status_progres' => 'menunggu_pelaksanaan',
            'mode_pertemuan' => $request->mode_pertemuan,
        ]);

        $this->notifyUser($pendaftaran, 'menunggu_pelaksanaan');

        // Kirim email jadwal audit otomatis ke pelanggan
        try {
            if ($pendaftaran->user && $pendaftaran->user->email) {
                Mail::to($pendaftaran->user->email)->send(new AuditScheduleMail($pendaftaran));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error sending audit schedule email: ' . $e->getMessage());
        }

        return redirect()->route('subadmin.audit.show', $id)
            ->with('success', 'Jadwal audit lapangan dan auditor berhasil ditentukan.');
    }

    public function finishAudit(Request $request, $id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);

        $request->validate([
            'harga' => 'required|numeric|min:0',
        ]);

        $jadwal = $pendaftaran->jadwal;
        $jadwal->update([
            'harga' => $request->harga
        ]);

        $pendaftaran->update([
            'status_progres' => 'menunggu_pembayaran',
            'status_bayar' => 'belum_bayar',
        ]);

        $this->notifyUser($pendaftaran, 'menunggu_pembayaran');

        // Kirim email invoice otomatis karena harga final telah ditentukan
        try {
            Mail::to($pendaftaran->user->email)->send(new PendaftaranInvoiceMail(
                $pendaftaran,
                $pendaftaran->user,
                $pendaftaran->jadwal
            ));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error sending invoice email in finishAudit: ' . $e->getMessage());
        }

        return redirect()->route('subadmin.audit.show', $id)
            ->with('success', 'Proses audit selesai. Tagihan pembayaran telah dikirim ke email pelanggan.');
    }

    public function confirmPayment($id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);

        $pendaftaran->update([
            'status_bayar' => 'lunas',
            'status_progres' => 'selesai',
        ]);

        $this->notifyUser($pendaftaran, 'selesai');

        return redirect()->route('subadmin.audit.show', $id)
            ->with('success', 'Pembayaran audit lunas. Seluruh tahapan audit selesai.');
    }

    public function rejectPayment($id)
    {
        $pendaftaran = $this->getPendaftaranWithBranch($id);

        $pendaftaran->update([
            'status_progres' => 'dibatalkan',
        ]);

        $this->notifyUser($pendaftaran, 'dibatalkan');

        return redirect()->route('subadmin.audit.show', $id)
            ->with('success', 'Permintaan/pembayaran audit dibatalkan.');
    }

    private function getPendaftaranWithBranch($id)
    {
        $query = Pendaftaran::whereHas('jadwal', function($q) {
            $q->where('id_kategori', 3);
        });

        return $query->findOrFail($id);
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
            \Illuminate\Support\Facades\Log::error('Error sending notification in Audit: ' . $e->getMessage());
        }
    }
}
