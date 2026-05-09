<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Sertifikat;
use App\Models\Layanan;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubadminDashboardController extends Controller
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
        $selectedYear = $request->get('year', date('Y'));
        $cabang = Auth::user()->admin?->cabang;
        
        // Stats (Global Scopes handle branch isolation)
        $totalPendaftaran = Pendaftaran::count();
        $totalUser = User::whereHas('klien', function($q) use ($cabang) {
            if ($cabang) $q->where('cabang', $cabang);
        })->count();
        
        $totalSertifikat = Sertifikat::whereHas('pendaftaran', function($q) use ($cabang) {
            if ($cabang) $q->where('cabang', $cabang);
        })->count();
        
        $totalJadwal = Jadwal::count();

        // Passing Ratio Calculation
        $passingRatio = $totalPendaftaran > 0 
            ? round(($totalSertifikat / $totalPendaftaran) * 100, 1) 
            : 0;

        // Chart Data: Monthly registrations (Branch Specific)
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
            'totalJadwal',
            'passingRatio',
            'chartCounts',
            'chartLabels',
            'latestPendaftarans',
            'selectedYear'
        ));
    }
}
