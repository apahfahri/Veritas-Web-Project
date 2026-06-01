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
        $selectedMonth = $request->get('month', null); 
        $cabang = Auth::user()->cabang;
        
        // Stats by Category (Pelatihan: 1, Konsultasi: 2, Audit: 3)
        $stats = Pendaftaran::join('jadwal', 'pendaftaran.id_jadwal', '=', 'jadwal.id_jadwal')
            ->select('jadwal.id_kategori', DB::raw('count(*) as total'))
            ->groupBy('jadwal.id_kategori')
            ->pluck('total', 'id_kategori');

        $totalPelatihan = $stats[1] ?? 0;
        $totalKonsultasi = $stats[2] ?? 0;
        $totalAudit = $stats[3] ?? 0;

        $totalSertifikat = Sertifikat::count();

        // Multi-Series Chart Data
        $categories = [1 => 'Pelatihan', 2 => 'Konsultasi', 3 => 'Audit'];
        $series = [];

        foreach ($categories as $catId => $catName) {
            if ($selectedMonth) {
                $daysInMonth = Carbon::createFromDate($selectedYear, $selectedMonth)->daysInMonth;
                $chartLabels = range(1, $daysInMonth);
                
                $data = Pendaftaran::whereYear('tanggal_daftar', $selectedYear)
                    ->whereMonth('tanggal_daftar', $selectedMonth)
                    ->whereHas('jadwal', function($q) use ($catId) { $q->where('id_kategori', $catId); })
                    ->select(DB::raw('DAY(tanggal_daftar) as label'), DB::raw('count(*) as count'))
                    ->groupBy('label')
                    ->pluck('count', 'label')
                    ->toArray();
                
                $counts = array_fill(1, $daysInMonth, 0);
            } else {
                $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                $data = Pendaftaran::whereYear('tanggal_daftar', $selectedYear)
                    ->whereHas('jadwal', function($q) use ($catId) { $q->where('id_kategori', $catId); })
                    ->select(DB::raw('MONTH(tanggal_daftar) as label'), DB::raw('count(*) as count'))
                    ->groupBy('label')
                    ->pluck('count', 'label')
                    ->toArray();
                
                $counts = array_fill(1, 12, 0);
            }

            foreach ($data as $key => $count) {
                $counts[$key] = $count;
            }
            $series[] = [
                'name' => $catName,
                'data' => array_values($counts)
            ];
        }

        $latestPendaftarans = Pendaftaran::with(['user', 'jadwal.jenis'])
            ->latest()
            ->take(6)
            ->get();

        return view('subadmin.dashboard', compact(
            'totalPelatihan',
            'totalKonsultasi',
            'totalAudit',
            'totalSertifikat',
            'series',
            'chartLabels',
            'latestPendaftarans',
            'selectedYear',
            'selectedMonth'
        ));
    }
}
