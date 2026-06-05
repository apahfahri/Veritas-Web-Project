<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PendaftaranStatusNotification;
use App\Exports\PendaftaranExport;
use Maatwebsite\Excel\Facades\Excel;

class SubadminPendaftaranController extends Controller
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

    public function index(Request $request)
    {
        $query = Pendaftaran::whereHas('jadwal.kategori', function($q) {
            $q->where('nama', 'like', '%Pelatihan%');
        })->with(['user', 'jadwal.jenis', 'jadwal.kategori']);

        $query->latest();

        if ($request->filled('status')) {
            $query->where('status_progres', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_pendaftaran', 'LIKE', "%{$search}%")
                  ->orWhere('id_pendaftaran', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($qUser) use ($search) {
                      $qUser->where('nama', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%")
                            ->orWhere('no_telp', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('jadwal.jenis', function($qJenis) use ($search) {
                      $qJenis->where('nama', 'LIKE', "%{$search}%");
                  });
            });
        }

        $pendaftarans = $query->paginate(15);

        return view('subadmin.pendaftaran.index', compact('pendaftarans'));
    }

    public function show($id)
    {
        $query = Pendaftaran::whereHas('jadwal.kategori', function($q) {
            $q->where('nama', 'like', '%Pelatihan%');
        })->with(['user', 'jadwal.jenis', 'sertifikat']);

        $pendaftaran = $query->findOrFail($id);
        $rekening = \App\Models\Rekening::where('status_aktif', true)->first();

        return view('subadmin.pendaftaran.show', compact('pendaftaran', 'rekening'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = $this->findByBranch($id);
        
        // Prevent finishing if not paid
        if ($request->status_progres == 'selesai' && $request->status_bayar != 'lunas') {
            return redirect()->back()->with('error', 'Pendaftaran tidak dapat diselesaikan karena status pembayaran belum LUNAS.');
        }

        $oldStatus = $pendaftaran->status_progres;

        $request->validate([
            'status_progres'  => 'required|string',
            'status_bayar'    => 'required|string',
        ]);

        $pendaftaran->update([
            'status_progres'  => $request->status_progres,
            'status_bayar'    => $request->status_bayar,
        ]);

        // Trigger Notification if status changed
        if ($oldStatus !== $request->status_progres) {
            $notification = new PendaftaranStatusNotification($pendaftaran, $request->status_progres);
            
            // Send via database (standard via())
            $pendaftaran->user?->notify($notification);
            
            // Manually trigger WhatsApp as per generic request
            if ($pendaftaran->user?->no_telp) {
                try {
                    $notification->sendWhatsapp($pendaftaran->user->no_telp);
                } catch (\Exception $e) {
                    // Log error or ignore
                }
            }
        }

        return redirect()->route('subadmin.pendaftaran.show', ['id' => $id, 'context' => $request->query('context')])
            ->with('success', 'Status pendaftaran berhasil diperbarui dan notifikasi telah dikirim.');
    }

    public function exportExcel(Request $request)
    {
        $filters = [
            'year' => $request->year ?? date('Y'),
            'month' => $request->month,
            'category_name_like' => 'Pelatihan',
        ];

        return Excel::download(new PendaftaranExport($filters), 'laporan-pendaftaran-' . now()->format('Ymd') . '.xlsx');
    }

    public function destroy($id)
    {
        $pendaftaran = $this->findByBranch($id);
        $pendaftaran->delete();

        return redirect()->route('subadmin.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dihapus.');
    }

    public function updateNote(Request $request, $id)
    {
        $pendaftaran = $this->findByBranch($id);

        $request->validate([
            'admin_note' => 'required|string',
        ]);

        $pendaftaran->update([
            'last_reminder_sent_at' => now(), // Still using same column for timestamp
            'last_reminder_details' => $request->admin_note, // Still using same column for note text
        ]);

        return redirect()->route('subadmin.pendaftaran.show', ['id' => $id, 'context' => $request->query('context')])
            ->with('success', 'Catatan internal admin berhasil diperbarui.');
    }

    public function uploadPaymentProof(Request $request, $id)
    {
        $pendaftaran = $this->findByBranch($id);
        $cabang = Auth::user()->cabang;

        // Auto-assign branch logic removed due to klien_individu deprecation.

        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $filename = 'bukti_' . $id . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Ensure directory exists
            if (!file_exists(public_path('uploads/pembayaran'))) {
                mkdir(public_path('uploads/pembayaran'), 0777, true);
            }
            
            $file->move(public_path('uploads/pembayaran'), $filename);
            
            $pendaftaran->update([
                'bukti_bayar' => $filename
            ]);
        }

        return redirect()->back()->with('success', 'Bukti pembayaran berhasil diunggah.');
    }

    /**
     * Konfirmasi bukti pembayaran dari pelanggan → lunas + diproses
     */
    public function konfirmasiBukti($id)
    {
        $pendaftaran = $this->findByBranch($id);

        if (!$pendaftaran->bukti_bayar) {
            return redirect()->back()->with('error', 'Tidak ada bukti pembayaran yang ditemukan.');
        }

        $oldStatus = $pendaftaran->status_progres;

        $pendaftaran->update([
            'status_bayar'   => 'lunas',
            'status_progres' => 'diproses',
        ]);

        // Kirim notifikasi ke pelanggan
        if ($oldStatus !== 'diproses') {
            $notification = new PendaftaranStatusNotification($pendaftaran, 'diproses');
            $pendaftaran->user?->notify($notification);
            if ($pendaftaran->user?->no_telp) {
                try { $notification->sendWhatsapp($pendaftaran->user->no_telp); } catch (\Exception $e) {}
            }
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi. Status pendaftaran diperbarui menjadi Terkonfirmasi.');
    }

    /**
     * Batalkan pendaftaran dari bukti yang tidak valid
     */
    public function batalkanPendaftaran($id)
    {
        $pendaftaran = $this->findByBranch($id);
        $oldStatus   = $pendaftaran->status_progres;

        $pendaftaran->update([
            'status_progres' => 'dibatalkan',
        ]);

        if ($oldStatus !== 'dibatalkan') {
            $notification = new PendaftaranStatusNotification($pendaftaran, 'dibatalkan');
            $pendaftaran->user?->notify($notification);
            if ($pendaftaran->user?->no_telp) {
                try { $notification->sendWhatsapp($pendaftaran->user->no_telp); } catch (\Exception $e) {}
            }
        }

        return redirect()->back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }

    /**
     * Helper: find pendaftaran by ID with branch filter
     */
    private function findByBranch($id): Pendaftaran
    {
        $query  = Pendaftaran::whereHas('jadwal.kategori', function($q) {
            $q->where('nama', 'like', '%Pelatihan%');
        });

        return $query->findOrFail($id);
    }
}
