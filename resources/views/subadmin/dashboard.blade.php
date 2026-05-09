@extends('layouts.subadmin')
@section('title', 'Dashboard Analytics')
@section('page-title', 'Overview Subadmin — ' . strtoupper(Auth::user()->admin?->cabang ?? 'Pusat'))

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Stat Card: Pendaftaran -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition group">
        <div class="w-14 h-14 bg-cyan-50 text-cyan-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        </div>
        <div>
            <p class="text-xs text-slate-500 font-extrabold uppercase tracking-widest">Total Pendaftaran</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">{{ number_format($totalPendaftaran) }}</h3>
        </div>
    </div>

    <!-- Stat Card: Sertifikat -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition group">
        <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path></svg>
        </div>
        <div>
            <p class="text-xs text-slate-500 font-extrabold uppercase tracking-widest">Sertifikat Terbit</p>
            <h3 class="text-2xl font-black text-slate-900 mt-1">{{ number_format($totalSertifikat) }}</h3>
        </div>
    </div>

    <!-- Stat Card: Passing Ratio -->
    <div class="bg-slate-900 p-6 rounded-3xl shadow-xl flex items-center gap-4 hover:scale-[1.02] transition duration-300 relative overflow-hidden">
        <div class="absolute -right-4 -bottom-4 opacity-10 text-white">
            <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"></path></svg>
        </div>
        <div class="w-14 h-14 bg-white/10 text-white rounded-2xl flex items-center justify-center backdrop-blur-sm">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
        <div class="relative z-10">
            <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em]">Passing Ratio</p>
            <h3 class="text-2xl font-black text-white mt-1">{{ $passingRatio }}%</h3>
        </div>
    </div>
</div>

<!-- Charts & Latest -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Chart: Pendaftaran -->
    <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
        <div class="flex flex-wrap justify-between items-center gap-4 mb-8">
            <div>
                <h3 class="font-black text-slate-900 text-lg">Statistik Pendaftaran</h3>
                <p class="text-xs text-slate-400 font-medium mt-1">
                    {{ $selectedMonth ? 'Data harian bulan ' . \Carbon\Carbon::create()->month($selectedMonth)->format('F') : 'Data bulanan tahun ' . $selectedYear }}
                </p>
            </div>
            <form action="{{ route('subadmin.dashboard') }}" method="GET" class="flex items-center gap-2" id="filterForm">
                <select name="month" onchange="this.form.submit()" class="bg-slate-50 border-none rounded-xl text-xs font-bold text-slate-600 px-4 py-2.5 focus:ring-2 focus:ring-cyan-500/20 transition cursor-pointer">
                    <option value="">Seluruh Bulan</option>
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
        <div id="pendaftaranChart" class="min-h-[350px]"></div>
    </div>

    <!-- Latest Pendaftaran (Simplified: 3 Fields) -->
    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-black text-slate-900">Pendaftaran Terbaru</h3>
            <span class="px-2 py-1 bg-slate-50 text-[9px] font-bold text-slate-400 rounded-lg">Top 6</span>
        </div>
        <div class="space-y-5">
            @forelse($latestPendaftarans as $p)
                <div class="flex items-center justify-between group cursor-default">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-cyan-50 group-hover:text-cyan-600 transition duration-300">
                            <span class="text-xs font-black">{{ strtoupper(substr($p->user?->nama ?? 'U', 0, 1)) }}</span>
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-bold text-slate-900 truncate group-hover:text-cyan-600 transition">{{ $p->user?->nama ?? 'User Unknown' }}</p>
                            <p class="text-[10px] text-slate-400 font-medium truncate uppercase tracking-wider">{{ $p->layanan?->materi ?? 'Layanan' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        @php
                            $statusColors = [
                                'selesai' => 'text-emerald-500',
                                'lulus' => 'text-cyan-500',
                                'diproses' => 'text-amber-500',
                                'menunggu' => 'text-slate-400',
                            ];
                            $statusColor = $statusColors[strtolower($p->status_progres)] ?? 'text-slate-400';
                        @endphp
                        <span class="text-[9px] font-black uppercase tracking-widest {{ $statusColor }}">
                            {{ $p->status_progres ?? 'Pending' }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-400 text-sm py-10 font-medium">Belum ada aktivitas baru.</p>
            @endforelse
        </div>
        @if($latestPendaftarans->isNotEmpty())
            <a href="{{ route('subadmin.pendaftaran.index') }}" class="mt-8 block text-center py-3 bg-slate-50 hover:bg-slate-100 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 transition">Lihat Detail Semua</a>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            series: [{
                name: 'Pendaftaran',
                data: {!! json_encode($chartCounts) !!}
            }],
            chart: {
                type: 'area',
                height: 350,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Outfit, sans-serif'
            },
            colors: ['#0891b2'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 4 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
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
                y: { title: { formatter: () => 'Total Pendaftar:' } }
            },
            markers: {
                size: 4,
                colors: ['#0891b2'],
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: { size: 6 }
            }
        };

        var chart = new ApexCharts(document.querySelector("#pendaftaranChart"), options);
        chart.render();
    });
</script>
@endpush
@endsection
