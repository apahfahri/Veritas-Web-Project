<?php

namespace App\Http\Controllers\AdminCabang;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\KlienIndividu;
use App\Models\Sertifikat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminCabangDashboardController extends Controller
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
        $selectedYear = $request->get('year', date('Y'));
        $selectedMonth = $request->get('month'); // null means all months

        // Base query for stats
        $statsQuery = Pendaftaran::where('cabang', $cabang);
        $klienQuery = KlienIndividu::where('cabang', $cabang);
        $sertifikatQuery = Sertifikat::where('cabang', $cabang);

        if ($selectedYear) {
            $statsQuery->whereYear('tanggal_daftar', $selectedYear);
            $klienQuery->whereYear('created_at', $selectedYear);
            $sertifikatQuery->whereYear('created_at', $selectedYear);
        }

        if ($selectedMonth && $selectedMonth != 'all') {
            $statsQuery->whereMonth('tanggal_daftar', $selectedMonth);
            $klienQuery->whereMonth('created_at', $selectedMonth);
            $sertifikatQuery->whereMonth('created_at', $selectedMonth);
        }

        // Fetch scoped stats
        $totalPendaftaran = $statsQuery->count();
        $totalKlien = $klienQuery->count();
        $totalSertifikat = $sertifikatQuery->count();

        // Data for bar chart
        if ($selectedMonth && $selectedMonth != 'all') {
            // If specific month is selected, show daily data for that month? 
            // Or just keep monthly but it will only have 1 bar? 
            // Usually, if month is selected, we show days. 
            $chartData = Pendaftaran::where('cabang', $cabang)
                ->whereYear('tanggal_daftar', $selectedYear)
                ->whereMonth('tanggal_daftar', $selectedMonth)
                ->select(DB::raw('DAY(tanggal_daftar) as label'), DB::raw('count(*) as count'))
                ->groupBy('label')
                ->pluck('count', 'label')
                ->toArray();
            
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
            $chartLabels = range(1, $daysInMonth);
            $chartCounts = array_fill_keys($chartLabels, 0);
            foreach ($chartData as $day => $count) {
                $chartCounts[$day] = $count;
            }
            $chartType = 'daily';
        } else {
            // Show monthly data for the year
            $chartData = Pendaftaran::where('cabang', $cabang)
                ->whereYear('tanggal_daftar', $selectedYear)
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
            $chartType = 'monthly';
        }

        // Data for donut chart: status progres (filtered)
        $statusData = clone $statsQuery;
        $statusData = $statusData->select('status_progres', DB::raw('count(*) as count'))
            ->groupBy('status_progres')
            ->pluck('count', 'status_progres')
            ->toArray();

        $statuses = ['menunggu', 'diproses', 'selesai', 'dibatalkan'];
        $statusCounts = [];
        foreach ($statuses as $st) {
            $statusCounts[] = $statusData[$st] ?? 0;
        }

        // Add latest registrations (filtered)
        $latestPendaftarans = clone $statsQuery;
        $latestPendaftarans = $latestPendaftarans->with(['user', 'layanan'])
            ->latest()
            ->take(5)
            ->get();

        // Get available years for filter
        $availableYears = Pendaftaran::where('cabang', $cabang)
            ->select(DB::raw('YEAR(tanggal_daftar) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();
        
        if (empty($availableYears)) $availableYears = [date('Y')];

        return view('admin.admin-cabang.dashboard', compact(
            'cabang',
            'totalPendaftaran',
            'totalKlien',
            'totalSertifikat',
            'chartCounts',
            'chartLabels',
            'chartType',
            'statusCounts',
            'latestPendaftarans',
            'selectedYear',
            'selectedMonth',
            'availableYears'
        ));
    }
}
