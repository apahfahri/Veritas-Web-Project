<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Layanan;
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
        $query = Pendaftaran::with(['user', 'layanan'])->latest();

        if ($request->filled('status')) {
            $query->where('status_progres', $request->status);
        }

        $pendaftarans = $query->paginate(15);

        return view('subadmin.pendaftaran.index', compact('pendaftarans'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'layanan', 'sertifikat'])
            ->findOrFail($id);

        return view('subadmin.pendaftaran.show', compact('pendaftaran'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
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
            'month' => $request->month
        ];

        return Excel::download(new PendaftaranExport($filters), 'laporan-pendaftaran-' . now()->format('Ymd') . '.xlsx');
    }



    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('subadmin.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dihapus.');
    }

    public function updateNote(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

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
}
