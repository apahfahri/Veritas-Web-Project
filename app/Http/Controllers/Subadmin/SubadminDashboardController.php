<?php

namespace App\Http\Controllers\Subadmin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\User;
use App\Models\Sertifikat;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $selectedMonth = $request->get('month', null); // Jika null, tampilkan per bulan
        $cabang = Auth::user()->admin?->cabang;
        
        // Stats
        $totalPendaftaran = Pendaftaran::count();
        $totalSertifikat = Sertifikat::whereHas('pendaftaran', function($q) use ($cabang) {
            if ($cabang) $q->where('cabang', $cabang);
        })->count();
        
        $passingRatio = $totalPendaftaran > 0 
            ? round(($totalSertifikat / $totalPendaftaran) * 100, 1) 
            : 0;

        // Chart Data
        if ($selectedMonth) {
            // Statistik Harian dalam satu bulan
            $daysInMonth = Carbon::createFromDate($selectedYear, $selectedMonth)->daysInMonth;
            $chartLabels = range(1, $daysInMonth);
            
            $chartData = Pendaftaran::whereYear('tanggal_daftar', $selectedYear)
                ->whereMonth('tanggal_daftar', $selectedMonth)
                ->select(DB::raw('DAY(tanggal_daftar) as label'), DB::raw('count(*) as count'))
                ->groupBy('label')
                ->pluck('count', 'label')
                ->toArray();
                
            $chartCounts = array_fill(1, $daysInMonth, 0);
        } else {
            // Statistik Bulanan dalam satu tahun
            $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $chartData = Pendaftaran::whereYear('tanggal_daftar', $selectedYear)
                ->select(DB::raw('MONTH(tanggal_daftar) as label'), DB::raw('count(*) as count'))
                ->groupBy('label')
                ->pluck('count', 'label')
                ->toArray();
                
            $chartCounts = array_fill(1, 12, 0);
        }

        foreach ($chartData as $key => $count) {
            $chartCounts[$key] = $count;
        }
        $chartCounts = array_values($chartCounts);

        // Latest registrations (Limited to 3 fields in view: Nama, Layanan, Status)
        $latestPendaftarans = Pendaftaran::with(['user', 'layanan'])
            ->latest()
            ->take(6)
            ->get();

        return view('subadmin.dashboard', compact(
            'totalPendaftaran',
            'totalSertifikat',
            'passingRatio',
            'chartCounts',
            'chartLabels',
            'latestPendaftarans',
            'selectedYear',
            'selectedMonth'
        ));
    }
}
