@extends('layouts.admin')
@section('title', 'Laporan & Monitoring')
@section('page-title', 'Laporan & Monitoring')
@section('page-subtitle', 'Analitik bisnis, performa program, dan visualisasi data Veritas')

@section('content')

<!-- PRINT STYLESHEET (High Fidelity Print Engine) -->
<style>
    @media print {
        body {
            background: white !important;
            color: black !important;
            font-size: 12px !important;
        }
        /* Sembunyikan elemen non-cetak */
        aside, header, footer, .no-print, .filter-box, .btn-actions, nav, #header-actions, .header-container {
            display: none !important;
        }
        /* Hapus margin dashboard */
        .ml-72, .p-8, .p-6, .px-8, .py-6 {
            margin: 0 !important;
            padding: 0 !important;
        }
        /* Atur container cetak */
        .print-container {
            width: 100% !important;
            display: block !important;
        }
        .print-header {
            display: block !important;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 24px;
        }
        .bg-white {
            border: none !important;
            box-shadow: none !important;
        }
        .rounded-\[32px\], .rounded-\[2rem\] {
            border-radius: 0 !important;
        }
        /* Tabel Cetak */
        table {
            width: 100% !important;
            border-collapse: collapse !important;
        }
        th, td {
            border: 1px solid #ddd !important;
            padding: 8px !important;
            font-size: 10px !important;
        }
        tr {
            page-break-inside: avoid !important;
        }
        /* Sembunyikan tombol aksi */
        .actions-col {
            display: none !important;
        }
    }
</style>

<!-- KOP SURAT / HEADER CETAK (Hanya Muncul saat Print/PDF) -->
<div class="hidden print-header">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">PT KATIGA VERITAS INDONESIA</h1>
            <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-0.5">Laporan Resmi Analitik & Monitoring Sistem</p>
        </div>
        <div class="text-right text-[9px] font-black text-slate-400 uppercase">
            Tanggal Cetak: {{ now()->format('d F Y H:i') }}<br>
            Akses: Superadmin Dashboard
        </div>
    </div>
</div>

<!-- GLOBAL FILTER BAR -->
<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 p-8 mb-8 no-print filter-box">
    <form method="GET" action="{{ route('admin.laporan.index') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 items-end" id="laporanFilterForm">
        
        <!-- Dropdown Jenis Laporan -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Jenis Laporan</label>
            <select name="type" onchange="this.form.submit()" class="w-full bg-slate-50 border border-slate-100 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
                <option value="finance" {{ $type === 'finance' ? 'selected' : '' }}>Laporan Keuangan & Pendapatan</option>
                <option value="participants" {{ $type === 'participants' ? 'selected' : '' }}>Laporan Detail Peserta</option>
                <option value="products" {{ $type === 'products' ? 'selected' : '' }}>Laporan Evaluasi Produk</option>
            </select>
        </div>

        <!-- Text Search -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Pencarian</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data..."
                   class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-medium text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
        </div>

        <!-- Date Picker: Dari Tanggal -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Mulai Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}"
                   class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
        </div>

        <!-- Date Picker: Sampai Tanggal -->
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}"
                   class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
        </div>

        <!-- Action Buttons -->
        <div>
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-slate-900 text-white py-3.5 rounded-2xl text-sm font-black hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center justify-center gap-2">
                    <i class="fi fi-rr-filter"></i>
                    Filter
                </button>
                
                @if(request()->anyFilled(['start_date', 'end_date']))
                    <a href="{{ route('admin.laporan.index', ['type' => $type]) }}" class="px-5 bg-slate-100 text-slate-500 hover:bg-slate-200 transition rounded-2xl flex items-center justify-center" title="Reset Rentang Tanggal">
                        <i class="fi fi-rr-refresh"></i>
                    </a>
                @endif

                <!-- Excel Export -->
                <button type="button" onclick="exportTableToExcel('laporan-datatable')" class="px-5 bg-emerald-50 text-emerald-600 border border-emerald-100 hover:bg-emerald-100/60 rounded-2xl flex items-center justify-center transition" title="Export Excel (.csv)">
                    <i class="fi fi-rr-download"></i>
                </button>

                <!-- PDF/Print Export -->
                <button type="button" onclick="window.print()" class="px-5 bg-indigo-50 text-indigo-600 border border-indigo-100 hover:bg-indigo-100/60 rounded-2xl flex items-center justify-center transition" title="Cetak / Ekspor PDF">
                    <i class="fi fi-rr-database"></i>
                </button>
            </div>
        </div>

    </form>
</div>

<!-- ==============================================================
     SECTION A: LAPORAN KEUANGAN & PENDAPATAN
     ============================================================== -->
@if($type === 'finance')
<div class="space-y-8 print-container">
    
    <!-- STATS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Widget 1: Total Omset -->
        <div class="bg-white p-6 lg:p-8 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                <i class="fi fi-rr-dollar"></i>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Total Omset Masuk</p>
                <h3 class="text-2xl lg:text-3xl font-black text-emerald-600 tracking-tight mt-0.5">Rp. {{ number_format($data['total_omset'], 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Widget 2: Total Piutang -->
        <div class="bg-white p-6 lg:p-8 rounded-[2rem] shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition">
            <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                <i class="fi fi-rr-time-past w-7 h-7"></i>
            </div>
            <div>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest">Total Piutang Berjalan</p>
                <h3 class="text-2xl lg:text-3xl font-black text-amber-600 tracking-tight mt-0.5">Rp. {{ number_format($data['total_piutang'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- monthly bar chart -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 no-print">
        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Tren Omset Bulanan (Tahun ini)</h3>
        <div id="financeChart" class="w-full min-h-[350px]"></div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Rekapitulasi Keuangan</h3>
            <span class="text-[10px] font-black text-slate-400 bg-slate-50 border px-3 py-1 rounded-full">{{ $registrations->total() }} Data Transaksi</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="laporan-datatable">
            <thead class="bg-slate-50 border-b border-slate-100 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">
                <tr>
                    <th class="px-5 py-4">No.</th>
                    <th class="px-5 py-4">Invoice / TRX ID</th>
                    <th class="px-5 py-4">Tanggal Pembayaran</th>
                    <th class="px-5 py-4">Program / Layanan</th>
                    <th class="px-5 py-4">Pembeli / Klien</th>
                    <th class="px-5 py-4">Nominal TRX</th>
                    <th class="px-5 py-4 text-center">Status</th>
                </tr>
            </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($registrations as $index => $r)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-6 text-[12px] font-bold text-slate-400">{{ $registrations->firstItem() + $index }}</td>
                        <td class="p-6 text-[12px] font-mono font-black text-indigo-600">{{ $r->no_registrasi }}</td>
                        <td class="p-6 text-[12px] text-slate-600">{{ $r->created_at ? $r->created_at->format('d M Y') : '—' }}</td>
                        <td class="p-6">
                            @if($r->is_utusan_perusahaan)
                                <div class="flex flex-col">
                                    <span class="text-[12px] font-black text-slate-900">{{ $r->perusahaan?->nama }}</span>
                                    <span class="text-[9px] font-extrabold text-indigo-500 uppercase tracking-widest mt-0.5">Perusahaan ({{ $r->user?->nama }})</span>
                                </div>
                            @else
                                <div class="flex flex-col">
                                    <span class="text-[12px] font-black text-slate-900">{{ $r->user?->nama }}</span>
                                    <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-widest mt-0.5">Individu / Mandiri</span>
                                </div>
                            @endif
                        </td>
                        <td class="p-6 text-[12px] font-black text-slate-900">Rp. {{ number_format($r->jadwal?->harga ?? 0, 0, ',', '.') }}</td>
                        <td class="p-6 text-center">
                            @if($r->status_bayar === 'lunas')
                                <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">Lunas</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 border border-amber-100">Belum Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-16 text-center text-[12px] font-bold text-slate-400">Tidak ada data transaksi ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        @if($registrations->hasPages())
        <div class="p-6 border-t border-slate-100 no-print">
            {{ $registrations->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>
@endif

<!-- ==============================================================
     SECTION B: LAPORAN DETAIL PESERTA
     ============================================================== -->
@if($type === 'participants')
<div class="space-y-8 print-container">
    
    <!-- pie/donut chart -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 no-print flex flex-col items-center">
        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6 self-start">Rasio Pendaftar (Perusahaan vs Individu)</h3>
        <div id="participantsChart" class="w-full max-w-[450px]"></div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Rekapitulasi Detail Peserta</h3>
            <span class="text-[10px] font-black text-slate-400 bg-slate-50 border px-3 py-1 rounded-full">{{ $registrations->count() }} Pendaftar</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="laporan-datatable">
            <thead class="bg-slate-50 border-b border-slate-100 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">
                <tr>
                    <th class="px-5 py-4">No.</th>
                    <th class="px-5 py-4">Tanggal Daftar</th>
                    <th class="px-5 py-4">Nama Lengkap</th>
                    <th class="px-5 py-4">Kategori / Asal Perusahaan</th>
                    <th class="px-5 py-4">Layanan K3 yang Diambil</th>
                    <th class="px-5 py-4 text-center">Status Progres</th>
                </tr>
            </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($registrations as $index => $r)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-6 text-[12px] font-bold text-slate-400">{{ $registrations->firstItem() + $index }}</td>
                        <td class="p-6 text-[12px] text-slate-600">{{ $r->created_at ? $r->created_at->format('d M Y') : '—' }}</td>
                        <td class="p-6">
                            <div class="flex flex-col">
                                <span class="text-[12px] font-black text-slate-900">{{ $r->user?->nama }}</span>
                                <span class="text-[10px] text-slate-400 font-bold">{{ $r->user?->email }}</span>
                            </div>
                        </td>
                        <td class="p-6">
                            @if($r->is_utusan_perusahaan)
                                <div class="flex flex-col">
                                    <span class="text-[12px] font-black text-slate-900">{{ $r->perusahaan?->nama }}</span>
                                    <span class="text-[9px] font-extrabold text-indigo-500 uppercase tracking-widest mt-0.5">Utusan Perusahaan</span>
                                </div>
                            @else
                                <span class="inline-flex px-2.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-slate-100 text-slate-500 border border-slate-200">Individu / Mandiri</span>
                            @endif
                        </td>
                        <td class="p-6 text-[12px] font-bold text-slate-700 leading-relaxed">{{ $r->jadwal?->jenis?->nama ?? ($r->jadwal?->kategori?->nama ?? '—') }}</td>
                        <td class="p-6 text-center">
                            @php 
                                $c = match($r->status_progres) { 
                                    'selesal', 'selesai' => 'bg-emerald-50 text-emerald-600 border-emerald-100', 
                                    'diproses' => 'bg-blue-50 text-blue-600 border-blue-100', 
                                    'dibatalkan' => 'bg-red-50 text-red-600 border-red-100', 
                                    default => 'bg-amber-50 text-amber-600 border-amber-100' 
                                }; 
                            @endphp
                            <span class="inline-flex px-2.5 py-0.5 rounded text-[9px] font-black uppercase tracking-widest border {{ $c }}">
                                {{ str_replace('_', ' ', $r->status_progres) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="p-16 text-center text-[12px] font-bold text-slate-400">Tidak ada pendaftar ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        @if($registrations->hasPages())
        <div class="p-6 border-t border-slate-100 no-print">
            {{ $registrations->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>
@endif

<!-- ==============================================================
     SECTION C: LAPORAN EVALUASI PRODUK
     ============================================================== -->
@if($type === 'products')
<div class="space-y-8 print-container">
    
    <!-- horizontal bar chart -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 no-print">
        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6">Top 5 Layanan Terlaris</h3>
        <div id="productsChart" class="w-full min-h-[350px]"></div>
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center">
            <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Tingkat Penjualan & Kontribusi Produk</h3>
            <span class="text-[10px] font-black text-slate-400 bg-slate-50 border px-3 py-1 rounded-full">{{ $data['products']->count() }} Layanan Terdaftar</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="laporan-datatable">
            <thead class="bg-slate-50 border-b border-slate-100 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">
                <tr>
                    <th class="px-5 py-4">No.</th>
                    <th class="px-5 py-4">Nama Layanan K3</th>
                    <th class="px-5 py-4">Kategori Layanan</th>
                    <th class="px-5 py-4 text-center">Jumlah Penjualan (Qty)</th>
                    <th class="px-5 py-4">Kontribusi ke Omset</th>
                </tr>
            </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($data['products'] as $index => $p)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="p-6 text-[12px] font-bold text-slate-400">{{ $data['products']->firstItem() + $index }}</td>
                        <td class="p-6 text-[12px] font-black text-slate-900">{{ $p->nama_layanan }}</td>
                        <td class="p-6 text-[12px] font-bold text-slate-500">{{ $p->nama_kategori }}</td>
                        <td class="p-6 text-center text-[12px] font-black text-indigo-600">{{ number_format($p->qty) }} Pendaftar</td>
                        <td class="p-6 text-[12px] font-black text-slate-950">Rp. {{ number_format($p->revenue ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-16 text-center text-[12px] font-bold text-slate-400">Tidak ada data evaluasi produk ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- PAGINATION -->
        @if($data['products']->hasPages())
        <div class="p-6 border-t border-slate-100 no-print">
            {{ $data['products']->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const type = "{{ $type }}";

        if (type === 'finance') {
            // A. Monthly omset bar chart
            const labels = {!! json_encode($data['chart_labels'] ?? []) !!};
            const seriesData = {!! json_encode($data['chart_series'] ?? []) !!};

            const options = {
                series: [{
                    name: 'Total Pendapatan',
                    data: seriesData
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    width: '100%',
                    redrawOnParentResize: true,
                    redrawOnWindowResize: true,
                    toolbar: { show: false },
                    fontFamily: 'Outfit, sans-serif'
                },
                colors: ['#10b981'],
                plotOptions: {
                    bar: {
                        borderRadius: 8,
                        columnWidth: '50%',
                        dataLabels: { position: 'top' }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        if (val >= 1000000) return (val / 1000000).toFixed(1) + 'M';
                        if (val >= 1000) return (val / 1000).toFixed(0) + 'K';
                        return val;
                    },
                    offsetY: -20,
                    style: { fontSize: '10px', fontWeight: 900, colors: ["#334155"] }
                },
                xaxis: {
                    categories: labels,
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: { style: { colors: '#94a3b8', fontWeight: 800, fontSize: '10px' } }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#94a3b8', fontWeight: 800, fontSize: '10px' },
                        formatter: function (val) {
                            return 'Rp ' + (val / 1000000).toFixed(0) + 'jt';
                        }
                    }
                },
                grid: { borderColor: '#f8fafc', strokeDashArray: 5 }
            };

            const chart = new ApexCharts(document.querySelector("#financeChart"), options);
            chart.render();

        } else if (type === 'participants') {
            // B. Rasio B2B vs B2C donut chart
            const b2b = parseInt("{{ $data['b2b_count'] ?? 0 }}");
            const b2c = parseInt("{{ $data['b2c_count'] ?? 0 }}");

            const options = {
                series: [b2b, b2c],
                labels: ['Klien Perusahaan', 'Klien Individu'],
                chart: {
                    type: 'donut',
                    height: 350,
                    width: '100%',
                    redrawOnParentResize: true,
                    redrawOnWindowResize: true,
                    fontFamily: 'Outfit, sans-serif'
                },
                colors: ['#6366f1', '#94a3b8'],
                legend: {
                    position: 'bottom',
                    fontSize: '11px',
                    fontWeight: 900,
                    itemMargin: { horizontal: 15 }
                },
                dataLabels: { enabled: true },
                responsive: [{
                    breakpoint: 480,
                    options: { chart: { width: 200 } }
                }]
            };

            const chart = new ApexCharts(document.querySelector("#participantsChart"), options);
            chart.render();

        } else if (type === 'products') {
            // C. Top 5 popular products horizontal bar chart
            const labels = {!! json_encode($data['chart_labels'] ?? []) !!};
            const seriesData = {!! json_encode($data['chart_series'] ?? []) !!};

            const options = {
                series: [{
                    name: 'Jumlah Terjual',
                    data: seriesData
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    width: '100%',
                    redrawOnParentResize: true,
                    redrawOnWindowResize: true,
                    toolbar: { show: false },
                    fontFamily: 'Outfit, sans-serif'
                },
                colors: ['#6366f1'],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 6,
                        barHeight: '45%'
                    }
                },
                dataLabels: { enabled: true, style: { fontSize: '10px', fontWeight: 900 } },
                xaxis: {
                    categories: labels,
                    axisBorder: { show: false },
                    labels: { style: { colors: '#94a3b8', fontWeight: 800, fontSize: '10px' } }
                },
                yaxis: {
                    labels: { style: { colors: '#334155', fontWeight: 800, fontSize: '10px' } }
                },
                grid: { borderColor: '#f8fafc', strokeDashArray: 5 }
            };

            const chart = new ApexCharts(document.querySelector("#productsChart"), options);
            chart.render();
        }

        // Force chart to recalculate and expand to 100% width on page load / refresh
        setTimeout(function() {
            window.dispatchEvent(new Event('resize'));
        }, 150);
    });

    /**
     * Client-Side Excel / CSV Exporter Engine
     * Mengonversi isi tabel dinamis aktif menjadi format berkas CSV siap pakai.
     */
    function exportTableToExcel(tableID, filename = '') {
        const table = document.getElementById(tableID);
        if (!table) return;

        let csv = [];
        const rows = table.querySelectorAll("tr");

        for (let i = 0; i < rows.length; i++) {
            let row = [], cols = rows[i].querySelectorAll("td, th");

            for (let j = 0; j < cols.length; j++) {
                // Bersihkan teks, hilangkan baris baru dan koma untuk format CSV
                let cleanVal = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
                cleanVal = cleanVal.replace(/"/g, '""'); // Escape double quotes
                row.push('"' + cleanVal + '"');
            }
            csv.push(row.join(","));
        }

        const csvContent = "data:text/csv;charset=utf-8,\uFEFF" + csv.join("\n");
        const encodedUri = encodeURI(csvContent);
        
        const typeStr = "{{ $type }}";
        const dateStr = new Date().toISOString().slice(0, 10);
        filename = `Laporan-${typeStr}-${dateStr}.csv`;

        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", filename);
        document.body.appendChild(link);
        
        link.click();
        document.body.removeChild(link);
    }
</script>
@endpush
