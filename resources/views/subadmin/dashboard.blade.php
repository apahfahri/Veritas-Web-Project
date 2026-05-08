@extends('layouts.subadmin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card: Pendaftaran -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        </div>
        <div>
            <p class="text-sm text-slate-500 font-medium">Total Pendaftaran</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $totalPendaftaran }}</h3>
        </div>
    </div>

    <!-- Stat Card: User -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-slate-500 font-medium">Total User</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $totalUser }}</h3>
        </div>
    </div>

    <!-- Stat Card: Sertifikat -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-slate-500 font-medium">Sertifikat Terbit</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $totalSertifikat }}</h3>
        </div>
    </div>

    <!-- Stat Card: Layanan -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-slate-500 font-medium">Total Layanan</p>
            <h3 class="text-2xl font-bold text-slate-900">{{ $totalLayanan }}</h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Chart: Pendaftaran -->
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-slate-900">Grafik Pendaftaran {{ $selectedYear }}</h3>
            <form action="{{ route('subadmin.dashboard') }}" method="GET" id="yearForm">
                <select name="year" onchange="this.form.submit()" class="text-sm border-slate-200 rounded-lg focus:ring-cyan-500 focus:border-cyan-500">
                    @for($i = date('Y'); $i >= 2024; $i--)
                        <option value="{{ $i }}" {{ $selectedYear == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </form>
        </div>
        <div id="pendaftaranChart" class="min-h-[300px]"></div>
    </div>

    <!-- Table: Pendaftaran Terbaru -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <h3 class="font-bold text-slate-900 mb-6">Pendaftaran Terbaru</h3>
        <div class="space-y-4">
            @forelse($latestPendaftarans as $p)
                <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs">
                        {{ strtoupper(substr($p->user?->nama ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-slate-900 truncate">{{ $p->user?->nama ?? 'User Unknown' }}</p>
                        <p class="text-[10px] text-slate-500 truncate">{{ $p->layanan?->materi ?? 'Layanan' }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-[10px] px-2 py-0.5 rounded-full {{ $p->status_progres === 'selesai' ? 'bg-teal-50 text-teal-600' : 'bg-amber-50 text-amber-600' }}">
                            {{ ucfirst(str_replace('_', ' ', $p->status_progres)) }}
                        </span>
                        <p class="text-[9px] text-slate-400 mt-1">{{ $p->tanggal_daftar->format('d/m/y') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-500 text-sm py-8">Belum ada pendaftaran</p>
            @endforelse
        </div>
        @if($latestPendaftarans->isNotEmpty())
            <a href="{{ route('subadmin.pendaftaran.index') }}" class="block text-center text-cyan-600 font-bold text-xs mt-6 hover:text-cyan-700">Lihat Semua</a>
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
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100, 100, 100]
                }
            },
            xaxis: {
                categories: {!! json_encode($chartLabels) !!},
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function(val) { return Math.floor(val); }
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4
            },
            tooltip: {
                theme: 'light',
                x: { show: true },
                y: { title: { formatter: () => 'Total:' } }
            }
        };

        var chart = new ApexCharts(document.querySelector("#pendaftaranChart"), options);
        chart.render();
    });
</script>
@endpush
@endsection
