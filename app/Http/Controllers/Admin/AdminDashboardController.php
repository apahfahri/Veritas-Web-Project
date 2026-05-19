<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Sertifikat;
use App\Models\Jadwal;
use App\Models\Pemateri;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear  = $request->get('year', date('Y'));
        $selectedMonth = $request->get('month', null);

        $stats = [
            'pendaftaran' => Pendaftaran::count(),
            'jadwal'      => Jadwal::count(),
            'petugas'     => Pemateri::count(),
            'sertifikat'  => Sertifikat::count(),
            'user'        => User::count(),
            'menunggu'    => Pendaftaran::where('status_progres', 'menunggu')->count(),
            'diproses'    => Pendaftaran::where('status_progres', 'terkonfirmasi')->count(),
            'selesai'     => Pendaftaran::where('status_progres', 'selesai')->count(),
            'pelatihan'   => Jadwal::where('id_kategori', 1)->count(),
        ];

        $pendaftaranTerbaru = Pendaftaran::with(['user', 'jadwal.jenis', 'jadwal.kategori'])
            ->latest()
            ->take(5)
            ->get();

        // Multi-Series Chart Data per kategori layanan
        $categories = [
            1 => 'Pelatihan',
            2 => 'Konsultasi',
            3 => 'Audit',
        ];
        $series = [];

        if ($selectedMonth) {
            $daysInMonth = Carbon::createFromDate($selectedYear, $selectedMonth)->daysInMonth;
            $chartLabels = range(1, $daysInMonth);
        } else {
            $chartLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        }

        foreach ($categories as $catId => $catName) {
            if ($selectedMonth) {
                $data = Pendaftaran::whereYear('tanggal_daftar', $selectedYear)
                    ->whereMonth('tanggal_daftar', $selectedMonth)
                    ->whereHas('jadwal', function ($q) use ($catId) {
                        $q->where('id_kategori', $catId);
                    })
                    ->select(DB::raw('DAY(tanggal_daftar) as label'), DB::raw('count(*) as count'))
                    ->groupBy('label')
                    ->pluck('count', 'label')
                    ->toArray();

                $counts = array_fill(1, $daysInMonth, 0);
            } else {
                $data = Pendaftaran::whereYear('tanggal_daftar', $selectedYear)
                    ->whereHas('jadwal', function ($q) use ($catId) {
                        $q->where('id_kategori', $catId);
                    })
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
                'data' => array_values($counts),
            ];
        }

        return view('admin.dashboard', compact(
            'stats',
            'pendaftaranTerbaru',
            'series',
            'chartLabels',
            'selectedYear',
            'selectedMonth'
        ));
    }
}
