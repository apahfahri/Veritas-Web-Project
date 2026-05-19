<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class RiwayatPendaftaranController extends Controller
{
    /**
     * Tampilkan daftar riwayat pendaftaran (Selesai & Dibatalkan).
     */
    public function index(Request $request)
    {
        $query = Pendaftaran::with(['user', 'jadwal.jenis', 'jadwal.kategori', 'perusahaan', 'sertifikat'])
            ->latest('id_pendaftaran');

        // 1. FILTER PROGRESS STATUS (Selesai & Dibatalkan)
        if ($request->filled('status') && in_array($request->status, ['selesai', 'dibatalkan'])) {
            $query->where('status_progres', $request->status);
        } else {
            $query->whereIn('status_progres', ['selesai', 'dibatalkan']);
        }

        // 2. SEARCH BAR (Nama Peserta, Nama Perusahaan/Mitra, No Registrasi/Invoice)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('perusahaan', function ($p) use ($search) {
                    $p->where('nama', 'like', "%{$search}%");
                })
                ->orWhere('id_pendaftaran', 'like', "%{$search}%");

                // Parse "REG-YYYY-XXXX" format
                if (preg_match('/REG-\d{4}-(\d+)/i', $search, $matches)) {
                    $q->orWhere('id_pendaftaran', intval($matches[1]));
                }
            });
        }

        // 3. DATE RANGE FILTER (created_at)
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Paginate results (5 per page)
        $riwayats = $query->paginate(5)->withQueryString();

        return view('admin.riwayat.index', compact('riwayats'));
    }
}
