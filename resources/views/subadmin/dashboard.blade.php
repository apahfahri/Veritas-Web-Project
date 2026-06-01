@extends('layouts.subadmin')
@section('title', 'Dashboard Analytics')
@section('page-title', 'Overview Subadmin ' . strtoupper(Auth::user()->cabang))

@section('header-actions')
<button onclick="exportDashboardAsPNG()" class="bg-cyan-600 hover:bg-cyan-700 text-white text-[11px] font-black uppercase tracking-wider px-5 py-3 rounded-xl transition-all shadow-lg shadow-cyan-600/20 flex items-center gap-2 group">
    <svg class="w-4 h-4 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
    Export Dashboard (PNG)
</button>
@endsection

@section('content')
<div id="dashboard-capture" class="p-2">
    <!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card: Pelatihan -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition group">
        <div class="w-14 h-14 bg-cyan-50 text-cyan-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] text-slate-500 font-extrabold uppercase tracking-widest truncate">Pelatihan</p>
            <h3 class="text-xl font-black text-slate-900 mt-1">{{ number_format($totalPelatihan) }}</h3>
        </div>
    </div>

    <!-- Stat Card: Konsultasi -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition group">
        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] text-slate-500 font-extrabold uppercase tracking-widest truncate">Konsultasi</p>
            <h3 class="text-xl font-black text-slate-900 mt-1">{{ number_format($totalKonsultasi) }}</h3>
        </div>
    </div>

    <!-- Stat Card: Audit -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition group">
        <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        </div>
        <div class="min-w-0">
            <p class="text-[10px] text-slate-500 font-extrabold uppercase tracking-widest truncate">Audit</p>
            <h3 class="text-xl font-black text-slate-900 mt-1">{{ number_format($totalAudit) }}</h3>
        </div>
    </div>

    <!-- Stat Card: Sertifikat -->
    <div class="bg-slate-900 p-6 rounded-3xl shadow-xl flex items-center gap-4 hover:scale-[1.02] transition duration-300 relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white">
            <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"></path></svg>
        </div>
        <div class="w-14 h-14 bg-white/10 text-white rounded-2xl flex items-center justify-center backdrop-blur-sm shrink-0">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
        </div>
        <div class="relative z-10 min-w-0">
            <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest truncate">Sertifikat</p>
            <h3 class="text-xl font-black text-white mt-1">{{ number_format($totalSertifikat) }}</h3>
        </div>
    </div>
</div>

<!-- Main Layout: Chart & Latest Side by Side -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
    <!-- Chart Section -->
    <div class="xl:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 h-full">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
            <div>
                <h3 class="font-black text-slate-900 text-lg">Statistik Pendaftaran</h3>
                <p class="text-xs text-slate-400 font-medium mt-1">
                    {{ $selectedMonth ? 'Data harian bulan ' . \Carbon\Carbon::create()->month($selectedMonth)->format('F') : 'Data bulanan tahun ' . $selectedYear }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <form action="{{ route('subadmin.dashboard') }}" method="GET" class="flex items-center gap-2" id="filterForm">
                    <select name="month" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 px-4 py-2.5 focus:ring-2 focus:ring-cyan-500/20 transition cursor-pointer">
                        <option value="">Semua Bulan</option>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $selectedMonth == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                        @endfor
                    </select>
                    <select name="year" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 px-4 py-2.5 focus:ring-2 focus:ring-cyan-500/20 transition cursor-pointer">
                        @for($i = date('Y'); $i >= 2024; $i--)
                            <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>
        <div id="pendaftaranChart" class="min-h-[400px]"></div>
    </div>

    <!-- Latest Pendaftaran Section -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 h-full flex flex-col">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-black text-slate-900">Pendaftaran Terbaru</h3>
            <span class="px-2 py-1 bg-slate-50 text-[9px] font-bold text-slate-400 rounded-lg">Realtime</span>
        </div>
        <div class="space-y-5 flex-1">
            @forelse($latestPendaftarans as $p)
                <div class="flex items-center gap-4 group cursor-default">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-cyan-50 group-hover:text-cyan-600 transition duration-300 shrink-0">
                            <span class="text-xs font-black">{{ strtoupper(substr($p->user?->nama ?? 'U', 0, 1)) }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-bold text-slate-900 truncate group-hover:text-cyan-600 transition">{{ $p->user?->nama ?? 'User Unknown' }}</p>
                            <p class="text-[10px] text-slate-400 font-medium truncate uppercase tracking-wider">{{ $p->jadwal?->jenis?->nama ?? 'Layanan' }}</p>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        @php
                            $statusColors = [
                                'selesai' => 'text-emerald-500',
                                'lulus' => 'text-cyan-500',
                                'diproses' => 'text-amber-500',
                                'menunggu' => 'text-slate-400',
                                'menunggu_pembayaran' => 'text-amber-500',
                            ];
                            $statusKey = strtolower($p->status_progres);
                            if (str_contains($statusKey, 'pembayaran')) $statusKey = 'menunggu_pembayaran';
                            $statusColor = $statusColors[$statusKey] ?? 'text-slate-400';
                        @endphp
                        <span class="text-[8px] font-black uppercase tracking-widest leading-none {{ $statusColor }} block whitespace-nowrap">
                            {{ str_replace('_', ' ', $p->status_progres ?? 'Pending') }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-400 text-sm py-10 font-medium">Belum ada aktivitas baru.</p>
            @endforelse
        </div>
        @if($latestPendaftarans->isNotEmpty())
            <a href="{{ route('subadmin.pendaftaran.index') }}" class="mt-8 block text-center py-3 bg-slate-50 hover:bg-slate-100 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 transition">Lihat Semua</a>
        @endif
    </div>
</div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            series: {!! json_encode($series) !!},
            chart: {
                type: 'area',
                height: 400,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Outfit, sans-serif'
            },
            colors: ['#0891b2', '#4f46e5', '#e11d48'], // Pelatihan, Konsultasi, Audit
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.2,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: {!! json_encode($chartLabels) !!},
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: { 
                    style: { colors: '#94a3b8', fontWeight: 600 },
                    rotate: {{ $selectedMonth ? '-45' : '0' }}
                }
            },
            yaxis: {
                labels: { 
                    style: { colors: '#94a3b8', fontWeight: 600 },
                    formatter: function(val) { return Math.floor(val); }
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4,
                padding: { left: 20, right: 20 }
            },
            tooltip: {
                theme: 'light',
                x: { show: true },
                y: { title: { formatter: (seriesName) => seriesName + ':' } }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                fontWeight: 700,
                fontSize: '11px',
                markers: { radius: 6 }
            },
            markers: {
                size: 0,
                hover: { size: 6 }
            }
        };

        var chart = new ApexCharts(document.querySelector("#pendaftaranChart"), options);
        chart.render();
    });

    function exportDashboardAsPNG() {
        const element = document.getElementById('dashboard-capture');
        const btn = event.currentTarget;
        const originalText = btn.innerHTML;
        
        btn.disabled = true;
        btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';

        html2canvas(element, {
            scale: 2, // High quality
            useCORS: true,
            backgroundColor: '#f8fafc', // Match dashboard background
            logging: false,
            onclone: (clonedDoc) => {
                // Ensure charts are rendered in clone
                clonedDoc.getElementById('dashboard-capture').style.padding = '20px';
            }
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'Dashboard-Veritas-' + new Date().toISOString().slice(0,10) + '.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
            
            btn.disabled = false;
            btn.innerHTML = originalText;
        }).catch(err => {
            console.error('Export failed:', err);
            btn.disabled = false;
            btn.innerHTML = originalText;
            alert('Gagal mengekspor dashboard. Silakan coba lagi.');
        });
    }
</script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
@endpush
@endsection
