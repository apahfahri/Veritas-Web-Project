<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Sertifikat;
use App\Models\Layanan;
use App\Models\Pemateri;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pendaftaran' => Pendaftaran::count(),
            'pelatihan'   => Layanan::count(),
            'petugas'     => Pemateri::count(),
            'sertifikat'  => Sertifikat::count(),
            'user'        => User::count(),
            'menunggu'    => Pendaftaran::where('status_progres', 'like', '%menunggu%')->count(),
            'diproses'    => Pendaftaran::where('status_progres', 'diproses')->count(),
            'selesai'     => Pendaftaran::where('status_progres', 'selesai')->count(),
        ];

        $pendaftaranTerbaru = Pendaftaran::with(['user', 'layanan'])
            ->latest()
            ->take(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'pendaftaranTerbaru'));
    }
}
