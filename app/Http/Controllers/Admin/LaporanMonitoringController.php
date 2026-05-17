<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class LaporanMonitoringController extends Controller
{
    /**
     * Tampilkan halaman Laporan & Monitoring.
     */
    public function index(Request $request)
    {
        $type = $request->input('type', 'finance'); // 'finance', 'participants', 'products'
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Base query pendaftaran
        $query = Pendaftaran::with(['user', 'layanan.kategori', 'perusahaan']);

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Ambil data filtered untuk tabel (5 per halaman)
        $registrations = $query->latest('id_pendaftaran')->paginate(5)->withQueryString();

        $data = [];

        if ($type === 'finance') {
            // A. LAPORAN KEUANGAN & PENDAPATAN
            // 1. Total Omset Masuk: SUM pendaftaran selesai
            $omsetQuery = Pendaftaran::where('status_progres', 'selesai')
                ->join('layanan', 'pendaftaran.id_layanan', '=', 'layanan.id_layanan');
            if ($startDate) $omsetQuery->whereDate('pendaftaran.created_at', '>=', $startDate);
            if ($endDate) $omsetQuery->whereDate('pendaftaran.created_at', '<=', $endDate);
            $data['total_omset'] = $omsetQuery->sum('layanan.harga');

            // 2. Total Piutang Berjalan: SUM pendaftaran menunggu pembayaran / diproses dan belum lunas
            $piutangQuery = Pendaftaran::whereIn('status_progres', ['menunggu_pembayaran', 'diproses'])
                ->where('status_bayar', 'belum_lunas')
                ->join('layanan', 'pendaftaran.id_layanan', '=', 'layanan.id_layanan');
            if ($startDate) $piutangQuery->whereDate('pendaftaran.created_at', '>=', $startDate);
            if ($endDate) $piutangQuery->whereDate('pendaftaran.created_at', '<=', $endDate);
            $data['total_piutang'] = $piutangQuery->sum('layanan.harga');

            // 3. Grafik Bar Bulanan tren uang masuk (Tahun ini)
            $monthlyOmset = [];
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            for ($m = 1; $m <= 12; $m++) {
                $monthlyQuery = Pendaftaran::where('status_progres', 'selesai')
                    ->whereMonth('pendaftaran.created_at', $m)
                    ->whereYear('pendaftaran.created_at', date('Y'))
                    ->join('layanan', 'pendaftaran.id_layanan', '=', 'layanan.id_layanan');
                $monthlyOmset[] = (int)$monthlyQuery->sum('layanan.harga');
            }
            $data['chart_labels'] = $months;
            $data['chart_series'] = $monthlyOmset;

        } elseif ($type === 'participants') {
            // B. LAPORAN DETAIL PESERTA (B2B vs B2C)
            $b2bQuery = Pendaftaran::where('is_utusan_perusahaan', true);
            $b2cQuery = Pendaftaran::where('is_utusan_perusahaan', false);
            if ($startDate) {
                $b2bQuery->whereDate('created_at', '>=', $startDate);
                $b2cQuery->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $b2bQuery->whereDate('created_at', '<=', $endDate);
                $b2cQuery->whereDate('created_at', '<=', $endDate);
            }
            $data['b2b_count'] = $b2bQuery->count();
            $data['b2c_count'] = $b2cQuery->count();

        } elseif ($type === 'products') {
            // C. LAPORAN EVALUASI PRODUK (Produk Terlaris)
            $productQuery = Pendaftaran::join('layanan', 'pendaftaran.id_layanan', '=', 'layanan.id_layanan')
                ->join('kategori_layanan', 'layanan.id_kategori', '=', 'kategori_layanan.id_kategori')
                ->selectRaw('layanan.nama as nama_layanan, kategori_layanan.nama as nama_kategori, count(pendaftaran.id_pendaftaran) as qty, sum(layanan.harga) as revenue')
                ->groupBy('layanan.nama', 'kategori_layanan.nama')
                ->orderBy('qty', 'desc');

            if ($startDate) $productQuery->whereDate('pendaftaran.created_at', '>=', $startDate);
            if ($endDate) $productQuery->whereDate('pendaftaran.created_at', '<=', $endDate);

            $data['products'] = $productQuery->paginate(5)->withQueryString();

            // Horizontal bar chart top 5 products
            $topProducts = (clone $productQuery)->limit(5)->get();
            $data['chart_labels'] = $topProducts->pluck('nama_layanan')->toArray();
            $data['chart_series'] = $topProducts->pluck('qty')->toArray();
        }

        return view('admin.laporan.index', compact('type', 'registrations', 'data'));
    }
}
