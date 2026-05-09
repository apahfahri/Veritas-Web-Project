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

        // Chart Data: Monthly registration for current year
        $year = date('Y');
        $chartData = Pendaftaran::whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, count(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $chartCounts = [];
        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        
        for ($i = 1; $i <= 12; $i++) {
            $chartCounts[] = $chartData[$i] ?? 0;
        }

        return view('admin.dashboard', compact('stats', 'pendaftaranTerbaru', 'chartCounts', 'chartLabels'));
    }
}
