@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')
@section('page-subtitle', 'Ringkasan data operasional PT Katiga Veritas Indonesia')

@section('header-actions')
<button onclick="exportDashboardAsPNG(this)" class="bg-slate-900 text-white text-[11px] font-black uppercase tracking-wider px-6 py-3.5 rounded-2xl hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 flex items-center gap-2.5 group">
    <i class="fi fi-rr-picture text-cyan-400 group-hover:rotate-12 transition-transform"></i>
    Export PNG
</button>
@endsection

@section('content')

<!-- EXPORT AREA (This section will be captured in PNG) -->
<div id="export-area" class="space-y-6">
    <!-- Header info for Export (Hidden on screen, shown in export) -->
    <div id="export-header" class="hidden">
        <div class="flex justify-between items-end border-b-2 border-slate-900 pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-black text-slate-900">VERITAS ANALYTICS REPORT</h1>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Laporan Data Operasional Digital — {{ now()->format('d F Y') }}</p>
            </div>
            <div class="text-right text-[10px] font-black text-slate-400 uppercase tracking-tighter">
                Superadmin Dashboard Access
            </div>
        </div>
    </div>

    <!-- STATS GRID (Reduced Gap & Uniform Height) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-5">
        
        <!-- Card 1: Total Pendaftar (Indigo) -->
        <div class="bg-white p-5 lg:p-6 rounded-[1.5rem] shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition duration-300 group h-full">
            <div class="w-12 h-12 lg:w-14 lg:h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                <i class="fi fi-rr-users lg: lg:"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest truncate">Total Pendaftar</p>
                <h3 class="text-xl lg:text-2xl font-black text-slate-900 tracking-tight mt-0.5">{{ number_format($stats['pendaftaran']) }}</h3>
            </div>
        </div>

        <!-- Card 2: Menunggu Proses (Amber) -->
        <div class="bg-white p-5 lg:p-6 rounded-[1.5rem] shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition duration-300 group h-full">
            <div class="w-12 h-12 lg:w-14 lg:h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                <i class="fi fi-rr-time-past lg:w-7 lg:h-7"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest truncate">Menunggu Proses</p>
                <h3 class="text-xl lg:text-2xl font-black text-amber-600 tracking-tight mt-0.5">{{ number_format($stats['menunggu']) }}</h3>
            </div>
        </div>

        <!-- Card 3: Selesai (Emerald) -->
        <div class="bg-white p-5 lg:p-6 rounded-[1.5rem] shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition duration-300 group h-full">
            <div class="w-12 h-12 lg:w-14 lg:h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                <i class="fi fi-rr-check-circle lg: lg:"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest truncate">Selesai</p>
                <h3 class="text-xl lg:text-2xl font-black text-emerald-600 tracking-tight mt-0.5">{{ number_format($stats['selesai']) }}</h3>
            </div>
        </div>

        <!-- Card 4: Total Pelatihan (Cyan) -->
        <div class="bg-white p-5 lg:p-6 rounded-[1.5rem] shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition duration-300 group h-full">
            <div class="w-12 h-12 lg:w-14 lg:h-14 bg-cyan-50 text-cyan-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                <i class="fi fi-rr-book-open-cover lg: lg:"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest truncate">Total Pelatihan</p>
                <h3 class="text-xl lg:text-2xl font-black text-cyan-600 tracking-tight mt-0.5">{{ number_format($stats['pelatihan']) }}</h3>
            </div>
        </div>

        <!-- Card 5: Petugas Aktif (Blue) -->
        <div class="bg-white p-5 lg:p-6 rounded-[1.5rem] shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition duration-300 group h-full">
            <div class="w-12 h-12 lg:w-14 lg:h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                <i class="fi fi-rr-user lg: lg:"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest truncate">Pemateri Aktif</p>
                <h3 class="text-xl lg:text-2xl font-black text-blue-600 tracking-tight mt-0.5">{{ number_format($stats['petugas']) }}</h3>
            </div>
        </div>

        <!-- Card 6: Sertifikat Terbit (Purple) -->
        <div class="bg-white p-5 lg:p-6 rounded-[1.5rem] shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition duration-300 group h-full">
            <div class="w-12 h-12 lg:w-14 lg:h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center shadow-sm shrink-0">
                <i class="fi fi-rr-diploma lg: lg:"></i>
            </div>
            <div class="min-w-0">
                <p class="text-[9px] text-slate-400 font-black uppercase tracking-widest truncate">Sertifikat Terbit</p>
                <h3 class="text-xl lg:text-2xl font-black text-purple-600 tracking-tight mt-0.5">{{ number_format($stats['sertifikat']) }}</h3>
            </div>
        </div>
    </div>

    <!-- CHART: Pendaftaran (Unified Section for Export) -->
    <div class="bg-white p-8 lg:p-10 rounded-[2rem] shadow-sm border border-slate-100 relative overflow-hidden">
        <div class="flex flex-wrap justify-between items-center gap-6 mb-8 relative z-10">
            <div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Tren Pendaftaran Layanan</h3>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">
                    {{ $selectedMonth ? 'Laporan harian bulan ' . \Carbon\Carbon::create()->month($selectedMonth)->format('F') : 'Statistik bulanan tahun ' . $selectedYear }}
                </p>
            </div>
            <!-- Filter buttons (Should be hidden during PNG export) -->
            <div class="flex items-center gap-3 no-export">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-2" id="filterForm">
                    <select name="month" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-xl text-[9px] font-black uppercase tracking-widest text-slate-500 px-4 py-2.5 focus:ring-4 focus:ring-indigo-500/10 transition cursor-pointer">
                        <option value="">Semua Bulan</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                        @endfor
                    </select>
                    <select name="year" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-xl text-[9px] font-black uppercase tracking-widest text-slate-500 px-4 py-2.5 focus:ring-4 focus:ring-indigo-500/10 transition cursor-pointer">
                        @for($i = date('Y'); $i >= 2024; $i--)
                            <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>
        <div id="pendaftaranChart" class="w-full min-h-[400px]"></div>
    </div>
</div>

<!-- LATEST ACTIVITIES (Excluded from Export) -->
<div class="mt-12 bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden no-export">
    <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center">
        <h3 class="text-[13px] font-black text-slate-900">Aktivitas Terkini</h3>
        <a href="{{ route('admin.pendaftaran.index') }}" class="text-[11px] font-black text-indigo-600 hover:text-indigo-700 transition">Lihat Seluruh Aktivitas →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Nama Peserta</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Kategori Layanan</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Tgl Daftar</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pendaftaranTerbaru as $p)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="p-6">
                        <span class="text-[12px] font-medium text-slate-900 group-hover:text-indigo-600 transition">{{ $p->user?->nama ?? 'Unknown' }}</span>
                    </td>
                    <td class="p-6">
                        <span class="text-[12px] font-medium text-slate-900 truncate max-w-[200px] block">{{ $p->jadwal?->jenis?->nama ?? ($p->jadwal?->kategori?->nama ?? '-') }}</span>
                    </td>
                    <td class="p-6 whitespace-nowrap">
                        <span class="text-[12px] font-medium text-slate-900">{{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d M Y') : '-' }}</span>
                    </td>
                    <td class="p-6 text-center">
                        @php $c = match($p->status_progres) { 'selesai' => 'text-emerald-500', 'diproses' => 'text-blue-500', 'menunggu_pembayaran' => 'text-amber-500', default => 'text-slate-400' }; @endphp
                        <span class="text-[12px] font-medium {{ $c }}">{{ str_replace('_', ' ', $p->status_progres) }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-12 text-center text-[12px] font-medium text-slate-400">Belum ada aktivitas baru</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            series: {!! json_encode($series) !!},
            chart: {
                type: 'area',
                height: 400,
                width: '100%',
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Outfit, sans-serif',
                sparkline: { enabled: false },
                redrawOnParentResize: true,
                redrawOnWindowResize: true
            },
            colors: ['#6366f1', '#0ea5e9', '#f43f5e'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 4 },
            fill: {
                type: 'gradient',
                gradient: { shadeIntensity: 1, opacityFrom: 0.25, opacityTo: 0.05, stops: [0, 90, 100] }
            },
            xaxis: {
                categories: {!! json_encode($chartLabels) !!},
                axisBorder: { show: false }, axisTicks: { show: false },
                labels: { style: { colors: '#94a3b8', fontWeight: 800, fontSize: '10px' }, rotate: {{ $selectedMonth ? '-45' : '0' }} }
            },
            yaxis: {
                labels: { style: { colors: '#94a3b8', fontWeight: 800, fontSize: '10px' }, formatter: function(val) { return Math.floor(val); } }
            },
            grid: { borderColor: '#f1f5f9', strokeDashArray: 5, padding: { left: 20, right: 20, top: 0, bottom: 0 } },
            tooltip: { theme: 'light', x: { show: true }, y: { title: { formatter: (name) => name + ':' } } },
            legend: {
                position: 'top', horizontalAlign: 'right', fontWeight: 900, fontSize: '10px', 
                markers: { radius: 8, width: 12, height: 12 }, itemMargin: { horizontal: 20 }, offsetY: -10
            },
            markers: { size: 0, hover: { size: 6, strokeWidth: 3 } },
            responsive: [{
                breakpoint: 1024,
                options: { chart: { height: 350 }, legend: { position: 'bottom', horizontalAlign: 'center' } }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#pendaftaranChart"), options);
        chart.render().then(() => {
            // Force a resize event to ensure it fits the container perfectly after render
            window.dispatchEvent(new Event('resize'));
        });
    });

    /**
     * Engine Ekspor Dashboard ke PNG (Nuclear Fix Edition)
     * Menghasilkan capture area statistik & grafik pendaftaran
     */
    async function exportDashboardAsPNG(exportBtn) {
        if (!exportBtn) exportBtn = document.querySelector('button[onclick*="exportDashboardAsPNG"]');
        const originalContent = exportBtn.innerHTML;
        
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        if (typeof html2canvas === 'undefined') {
            Swal.fire({ icon: 'error', title: 'Library Missing', text: 'html2canvas tidak ditemukan.' });
            return;
        }

        exportBtn.disabled = true;
        exportBtn.innerHTML = '<i class="fi fi-rr-spinner animate-spin"></i>';

        try {
            const captureArea = document.getElementById('export-area');
            if (!captureArea) throw new Error('Capture area tidak ditemukan.');

            // Beri jeda agar ApexCharts selesai render animasi
            await new Promise(resolve => setTimeout(resolve, 1500));

            const canvas = await html2canvas(captureArea, {
                scale: 2,
                useCORS: true,
                allowTaint: true,
                backgroundColor: '#f8fafc',
                logging: false,
                ignoreElements: (el) => el.classList && el.classList.contains('no-export'),
                onclone: (clonedDoc) => {
                    // NUCLEAR FIX: Strip all oklch from ALL style tags in the clone
                    const styleTags = clonedDoc.getElementsByTagName('style');
                    for (let tag of styleTags) {
                        tag.innerHTML = tag.innerHTML.replace(/oklch\([^)]+\)/g, '#4f46e5');
                    }

                    // Injeksi Style Kompatibilitas Total
                    const forceStyle = clonedDoc.createElement('style');
                    forceStyle.innerHTML = `
                        * { 
                            box-shadow: none !important; 
                            text-shadow: none !important;
                            --tw-shadow: 0 0 #0000 !important;
                            --tw-ring-color: transparent !important;
                        }
                        .bg-white { background: #ffffff !important; }
                        .bg-slate-50 { background: #f8fafc !important; }
                        .bg-slate-900 { background: #0f172a !important; }
                        .bg-indigo-50 { background: #eef2ff !important; }
                        .text-slate-900 { color: #0f172a !important; }
                        .text-slate-400 { color: #94a3b8 !important; }
                        .text-indigo-600 { color: #4f46e5 !important; }
                        #export-header { display: block !important; visibility: visible !important; }
                        #export-area { padding: 40px !important; width: 1200px !important; background: #f8fafc !important; }
                    `;
                    clonedDoc.head.appendChild(forceStyle);

                    const header = clonedDoc.getElementById('export-header');
                    if (header) header.classList.remove('hidden');
                }
            });

            const dataUrl = canvas.toDataURL('image/png', 1.0);
            const downloadLink = document.createElement('a');
            downloadLink.download = `Analytics-Report-${new Date().toISOString().slice(0,10)}.png`;
            downloadLink.href = dataUrl;
            downloadLink.click();

            Toast.fire({ icon: 'success', title: 'Berhasil Diunduh!' });
        } catch (error) {
            console.error('EXPORT_ERROR:', error);
            Swal.fire({ icon: 'error', title: 'Ekspor Gagal', text: 'Error: ' + error.message });
        } finally {
            exportBtn.disabled = false;
            exportBtn.innerHTML = originalContent;
        }
    }
</script>
@endpush
