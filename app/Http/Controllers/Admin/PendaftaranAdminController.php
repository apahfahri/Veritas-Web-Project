<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use App\Exports\PendaftaranExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PendaftaranAdminController extends Controller
{
    public function exportExcel(Request $request)
    {
        $filters = [
            'year' => $request->year ?? date('Y'),
            'month' => $request->month
        ];

        return Excel::download(new PendaftaranExport($filters), 'laporan-pendaftaran-' . now()->format('Ymd') . '.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $query = Pendaftaran::with(['user', 'jadwal.jenis'])->latest();

        if ($request->filled('year')) {
            $query->whereYear('tanggal_daftar', $request->year);
        } else {
            $query->whereYear('tanggal_daftar', date('Y'));
        }

        if ($request->filled('month')) {
            $query->whereMonth('tanggal_daftar', $request->month);
        }

        $pendaftarans = $query->get();
        $year = $request->year ?? date('Y');
        $month = $request->month;

        $pdf = Pdf::loadView('admin.pendaftaran.export_pdf', compact('pendaftarans', 'year', 'month'));
        return $pdf->download('laporan-pendaftaran-' . now()->format('Ymd') . '.pdf');
    }
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'jadwal.jenis', 'jadwal.kategori'])
            ->whereNotIn('status_progres', ['selesai', 'dibatalkan'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status_progres', $request->status);
        }
        if ($request->filled('bayar')) {
            $query->where('status_bayar', $request->bayar);
        }

        $pendaftarans = $query->paginate(5);

        return view('admin.pendaftaran.index', compact('pendaftarans'));
    }

    public function show($id)
    {
        $pendaftaran = Pendaftaran::with(['user', 'perusahaan', 'jadwal.jenis', 'jadwal.kategori', 'jadwal.pemateri', 'sertifikat'])->findOrFail($id);
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    public function update(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $isConsultation = $pendaftaran->jadwal && $pendaftaran->jadwal->id_kategori == 2;
        if ($isConsultation) {
            $request->validate([
                'status_progres' => 'required|in:meninjau,disetujui,dijadwalkan,menunggu_pelaksanaan,menunggu_pembayaran,pembayaran_ditinjau,selesai,dibatalkan',
                'status_bayar'   => 'required|in:belum_bayar,menunggu_konfirmasi,lunas',
            ]);
        } else {
            $request->validate([
                'status_progres' => 'required|in:menunggu_pembayaran,diproses,selesai,dibatalkan',
                'status_bayar'   => 'required|in:belum_bayar,belum_lunas,dp,lunas,menunggu_konfirmasi',
            ]);
        }

        $pendaftaran->update($request->only('status_progres', 'status_bayar'));

        return back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return back()->with('success', 'Pendaftaran berhasil dihapus.');
    }
}

