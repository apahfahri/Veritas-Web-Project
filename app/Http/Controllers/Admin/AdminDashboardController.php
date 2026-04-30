<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Pelatihan;
use App\Models\Petugas;
use App\Models\Sertifikat;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pendaftaran' => Pendaftaran::count(),
            'pelatihan'   => Pelatihan::count(),
            'petugas'     => Petugas::count(),
            'sertifikat'  => Sertifikat::count(),
            'menunggu'    => Pendaftaran::where('status_progres', 'menunggu')->count(),
            'selesai'     => Pendaftaran::where('status_progres', 'selesai')->count(),
        ];

        $pendaftaranTerbaru = Pendaftaran::with(['user', 'layanan', 'petugas'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendaftaranTerbaru'));
    }
}
