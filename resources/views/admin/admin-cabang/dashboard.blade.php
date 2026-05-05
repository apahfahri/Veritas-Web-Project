@extends('layouts.admin-cabang')

@section('title', 'Dashboard Cabang')
@section('page-title', 'Dashboard Cabang ' . strtoupper($cabang))

@section('content')
<!-- FILTERS & ACTIONS -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
    <form action="{{ route('admin-cabang.dashboard') }}" method="GET" class="flex flex-wrap items-center gap-3 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-2 px-3 py-2 border-r border-slate-100">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Filter</span>
        </div>
        <select name="year" onchange="this.form.submit()" class="bg-transparent text-sm font-bold text-slate-700 outline-none px-2 py-1 cursor-pointer">
            @foreach($availableYears as $year)
                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>Tahun {{ $year }}</option>
            @endforeach
        </select>
        <select name="month" onchange="this.form.submit()" class="bg-transparent text-sm font-bold text-slate-700 outline-none px-2 py-1 cursor-pointer">
            <option value="all" {{ $selectedMonth == 'all' || !$selectedMonth ? 'selected' : '' }}>Semua Bulan</option>
            @php
                $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            @endphp
            @foreach($months as $index => $name)
                <option value="{{ $index + 1 }}" {{ $selectedMonth == ($index + 1) ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </form>

    <button onclick="exportDashboard()" class="flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-900 hover:from-slate-800 hover:to-black text-white font-bold text-sm px-5 py-3 rounded-xl shadow-md transition group">
        <svg class="w-4 h-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Laporan PDF
    </button>
</div>

<div id="export-area" class="space-y-8">
    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 select-none">
        <!-- STAT CARD 1 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between h-44 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-gradient-to-tr from-cyan-400/20 to-teal-400/20 rounded-full blur-2xl group-hover:scale-110 transition duration-500"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <span class="text-xs uppercase font-extrabold text-cyan-600/90 tracking-wider">Pendaftaran</span>
                    <h3 class="text-3xl font-black text-slate-900 mt-1 tracking-tight">{{ $totalPendaftaran }}</h3>
                </div>
                <span class="bg-cyan-50 p-3.5 rounded-2xl shadow-sm text-cyan-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </span>
            </div>
            <div class="text-xs font-semibold text-cyan-600 flex items-center gap-1 relative z-10">
                {{ $selectedMonth && $selectedMonth != 'all' ? $months[$selectedMonth-1] : 'Tahun ' . $selectedYear }}
            </div>
        </div>

        <!-- STAT CARD 2 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between h-44 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-gradient-to-tr from-orange-400/20 to-amber-400/20 rounded-full blur-2xl group-hover:scale-110 transition duration-500"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <span class="text-xs uppercase font-extrabold text-orange-600/90 tracking-wider">Klien Baru</span>
                    <h3 class="text-3xl font-black text-slate-900 mt-1 tracking-tight">{{ $totalKlien }}</h3>
                </div>
                <span class="bg-orange-50 p-3.5 rounded-2xl shadow-sm text-orange-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </span>
            </div>
            <div class="text-xs font-semibold text-orange-600 flex items-center gap-1 relative z-10">
                {{ $selectedMonth && $selectedMonth != 'all' ? $months[$selectedMonth-1] : 'Tahun ' . $selectedYear }}
            </div>
        </div>

        <!-- STAT CARD 3 -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between h-44 relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-gradient-to-tr from-blue-400/20 to-indigo-400/20 rounded-full blur-2xl group-hover:scale-110 transition duration-500"></div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <span class="text-xs uppercase font-extrabold text-blue-600/90 tracking-wider">Sertifikat</span>
                    <h3 class="text-3xl font-black text-slate-900 mt-1 tracking-tight">{{ $totalSertifikat }}</h3>
                </div>
                <span class="bg-blue-50 p-3.5 rounded-2xl shadow-sm text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </span>
            </div>
            <div class="text-xs font-semibold text-blue-600 flex items-center gap-1 relative z-10">
                {{ $selectedMonth && $selectedMonth != 'all' ? $months[$selectedMonth-1] : 'Tahun ' . $selectedYear }}
            </div>
        </div>
    </div>

    <!-- GRAPH SECTION -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 select-none">
        <!-- LINE/BAR CHART -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <h4 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                Tren Pendaftaran ({{ $chartType == 'daily' ? 'Harian' : 'Bulanan' }})
            </h4>
            <div id="pendaftaranChart" class="min-h-[300px]"></div>
        </div>

        <!-- DONUT CHART -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
            <h4 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                Proporsi Status Pendaftaran
            </h4>
            <div id="statusDonutChart" class="min-h-[300px]"></div>
        </div>
    </div>

    <!-- LATEST REGISTRATIONS -->
    <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Pendaftaran Terbaru</h3>
                <p class="text-xs text-slate-400 font-medium mt-1">Menampilkan 5 data terakhir sesuai filter aktif.</p>
            </div>
            <a href="{{ route('admin-cabang.pendaftaran.index') }}" class="text-xs font-bold text-cyan-600 bg-cyan-50 px-4 py-2 rounded-xl hover:bg-cyan-100 transition">Lihat Semua &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="p-4 text-xs font-black uppercase text-slate-400 tracking-widest">Layanan</th>
                        <th class="p-4 text-xs font-black uppercase text-slate-400 tracking-widest">Klien</th>
                        <th class="p-4 text-xs font-black uppercase text-slate-400 tracking-widest">Tgl Daftar</th>
                        <th class="p-4 text-xs font-black uppercase text-slate-400 tracking-widest">Status</th>
                        <th class="p-4 text-xs font-black uppercase text-slate-400 tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($latestPendaftarans as $p)
                    <tr class="hover:bg-slate-50/30 transition group">
                        <td class="p-4">
                            <div class="text-sm font-bold text-slate-800 group-hover:text-cyan-600 transition">{{ $p->layanan?->nama }}</div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter mt-0.5">#{{ $p->id }}</div>
                        </td>
                        <td class="p-4">
                            <div class="text-sm font-bold text-slate-700">{{ $p->user?->username }}</div>
                            <div class="text-xs text-slate-400">{{ $p->user?->email }}</div>
                        </td>
                        <td class="p-4 text-sm font-medium text-slate-500">
                            {{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d M Y') : '-' }}
                        </td>
                        <td class="p-4">
                            @php
                                $colors = [
                                    'menunggu' => 'bg-amber-100 text-amber-700',
                                    'diproses' => 'bg-blue-100 text-blue-700',
                                    'selesai' => 'bg-emerald-100 text-emerald-700',
                                    'dibatalkan' => 'bg-red-100 text-red-700'
                                ];
                                $color = $colors[$p->status_progres] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <span class="text-[10px] font-black uppercase px-2.5 py-1 rounded-lg {{ $color }} tracking-tighter">
                                {{ $p->status_progres }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <a href="{{ route('admin-cabang.pendaftaran.show', $p->id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-400 hover:bg-cyan-500 hover:text-white transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center">
                            <div class="text-slate-300 font-bold">Tidak ada data pendaftaran ditemukan.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Main Chart (Bar/Line)
        var chartOptions = {
            series: [{
                name: 'Pendaftaran',
                data: @json(array_values($chartCounts))
            }],
            chart: {
                type: '{{ $chartType == "daily" ? "line" : "bar" }}',
                height: 320,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Outfit, sans-serif'
            },
            colors: ['#06b6d4'],
            plotOptions: {
                bar: { borderRadius: 8, columnWidth: '60%' }
            },
            stroke: { curve: 'smooth', width: 3 },
            dataLabels: { enabled: false },
            xaxis: {
                categories: @json($chartLabels),
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { style: { colors: '#94a3b8', fontWeight: 600 } }
            },
            yaxis: {
                labels: { style: { colors: '#94a3b8', fontWeight: 600 } }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4
            },
            tooltip: { theme: 'light' }
        };

        var mainChart = new ApexCharts(document.querySelector("#pendaftaranChart"), chartOptions);
        mainChart.render();

        // Donut Chart
        var donutOptions = {
            series: @json($statusCounts),
            chart: {
                type: 'donut',
                height: 320,
                fontFamily: 'Outfit, sans-serif'
            },
            labels: ['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'],
            colors: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
            legend: { position: 'bottom', fontWeight: 600 },
            stroke: { width: 0 },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'TOTAL',
                                fontSize: '12px',
                                fontWeight: 800,
                                color: '#94a3b8',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: { enabled: false }
        };

        var donutChart = new ApexCharts(document.querySelector("#statusDonutChart"), donutOptions);
        donutChart.render();
    });

    function exportDashboard() {
        const element = document.getElementById('export-area');
        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Menyiapkan...';
        btn.disabled = true;

        const opt = {
            margin:       [0.5, 0.5],
            filename:     'Laporan_Cabang_{{ strtoupper($cabang) }}_{{ $selectedYear }}_{{ $selectedMonth ?? "All" }}.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { 
                scale: 2, 
                useCORS: true, 
                letterRendering: true,
                backgroundColor: '#f8fafc' 
            },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
        };

        // Delay sedikit agar charts dirender sempurna sebelum capture
        setTimeout(() => {
            html2pdf().set(opt).from(element).save().then(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }).catch(err => {
                console.error(err);
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert('Gagal mengekspor PDF. Pastikan library html2pdf terpasang.');
            });
        }, 500);
    }
</script>
@endpush
