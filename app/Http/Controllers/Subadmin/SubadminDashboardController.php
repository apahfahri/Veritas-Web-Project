<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Sertifikat;
use App\Models\Layanan;
use App\Models\Pemateri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubadminDashboardController extends Controller
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
        $selectedYear = $request->get('year', date('Y'));
        
        // Stats
        $totalPendaftaran = Pendaftaran::count();
        $totalUser = User::count();
        $totalSertifikat = Sertifikat::count();
        $totalLayanan = Layanan::count();

        // Chart Data (Monthly registrations)
        $chartData = Pendaftaran::whereYear('tanggal_daftar', $selectedYear)
            ->select(DB::raw('MONTH(tanggal_daftar) as label'), DB::raw('count(*) as count'))
            ->groupBy('label')
            ->pluck('count', 'label')
            ->toArray();

        $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chartCounts = array_fill(1, 12, 0);
        foreach ($chartData as $month => $count) {
            $chartCounts[$month] = $count;
        }
        $chartCounts = array_values($chartCounts);

        // Latest registrations
        $latestPendaftarans = Pendaftaran::with(['user', 'layanan'])
            ->latest()
            ->take(5)
            ->get();

        return view('subadmin.dashboard', compact(
            'totalPendaftaran',
            'totalUser',
            'totalSertifikat',
            'totalLayanan',
            'chartCounts',
            'chartLabels',
            'latestPendaftarans',
            'selectedYear'
        ));
    }
}
