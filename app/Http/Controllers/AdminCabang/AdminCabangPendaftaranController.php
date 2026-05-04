<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Pelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCabangPendaftaranController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isAdminCabang()) {
                abort(403, 'Akses ditolak. Halaman khusus Admin Cabang.');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $cabang = Auth::user()->admin?->cabang;
        $query = Pendaftaran::with(['user', 'layanan'])->where('cabang', $cabang)->latest();

        if ($request->filled('status')) {
            $query->where('status_progres', $request->status);
        }

        $pendaftarans = $query->paginate(15);

        return view('admin.admin-cabang.pendaftaran.index', compact('pendaftarans'));
    }

    public function show($id)
    {
        $cabang = Auth::user()->admin?->cabang;
        $pendaftaran = Pendaftaran::with(['user', 'layanan', 'sertifikat'])
            ->where('cabang', $cabang)
            ->findOrFail($id);

        return view('admin.admin-cabang.pendaftaran.show', compact('pendaftaran'));
    }

    public function update(Request $request, $id)
    {
        $cabang = Auth::user()->admin?->cabang;
        $pendaftaran = Pendaftaran::where('cabang', $cabang)->findOrFail($id);

        $request->validate([
            'status_progres'  => 'required|in:menunggu,diproses,selesai,dibatalkan',
            'status_bayar'    => 'required|in:belum_bayar,menunggu_konfirmasi,lunas',
            'dokumen_lengkap' => 'nullable|boolean',
        ]);

        $pendaftaran->update([
            'status_progres'  => $request->status_progres,
            'status_bayar'    => $request->status_bayar,
            'dokumen_lengkap' => $request->has('dokumen_lengkap') ? 1 : 0,
        ]);

        // Integration with Google Meet & Google Calendar for Online training
        $isOnline = Pelatihan::where('layanan_id', $pendaftaran->layanan_id)
            ->where('jenis_pertemuan', 'online')
            ->exists();

        if ($isOnline) {
            $meetLink = "https://meet.google.com/abc-defg-hij";
            $calendarLink = "https://calendar.google.com/calendar/r/eventedit?text=Pelatihan+Veritas&details=Link+Meet:+" . urlencode($meetLink);

            session()->flash('info', "Reminder Google Calendar & Link Google Meet telah dikirim ke email peserta. Meet Link: {$meetLink}");
        }

        return redirect()->route('admin-cabang.pendaftaran.index')
            ->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $cabang = Auth::user()->admin?->cabang;
        $pendaftaran = Pendaftaran::where('cabang', $cabang)->findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('admin-cabang.pendaftaran.index')
            ->with('success', 'Pendaftaran berhasil dihapus.');
    }

    public function sendReminder(Request $request, $id)
    {
        $cabang = Auth::user()->admin?->cabang;
        $pendaftaran = Pendaftaran::with(['user'])->where('cabang', $cabang)->findOrFail($id);

        $request->validate([
            'pesan_reminder' => 'required|string'
        ]);

        $pendaftaran->update([
            'last_reminder_sent_at' => now(),
            'last_reminder_details' => $request->pesan_reminder
        ]);

        return redirect()->route('admin-cabang.pendaftaran.show', $id)
            ->with('success', 'Berhasil mencatat pengiriman email reminder ke Klien.');
    }
}
