@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')
@section('page-subtitle', 'Ringkasan data operasional PT Katiga Veritas Indonesia')

@section('content')

<!-- STATS GRID -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
        </div>
        <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Total Pendaftaran</p>
            <h3 class="text-2xl font-black text-slate-900">{{ number_format($stats['pendaftaran']) }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Menunggu Proses</p>
            <h3 class="text-2xl font-black text-amber-600">{{ number_format($stats['menunggu']) }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
        </div>
        <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Selesai</p>
            <h3 class="text-2xl font-black text-teal-600">{{ number_format($stats['selesai']) }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
        <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Total Pelatihan</p>
            <h3 class="text-2xl font-black text-indigo-600">{{ number_format($stats['pelatihan']) }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Petugas Aktif</p>
            <h3 class="text-2xl font-black text-purple-600">{{ number_format($stats['petugas']) }}</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
        <div class="w-12 h-12 bg-cyan-50 text-cyan-600 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
        </div>
        <div>
            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Sertifikat Terbit</p>
            <h3 class="text-2xl font-black text-slate-900">{{ number_format($stats['sertifikat']) }}</h3>
        </div>
    </div>
</div>

<!-- QUICK LINKS & CHART -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Chart: Pendaftaran -->
    <div class="lg:col-span-2 bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight">Tren Pendaftaran</h3>
                <p class="text-xs text-slate-500 font-medium mt-1">Statistik pendaftaran bulanan tahun {{ date('Y') }}</p>
            </div>
        </div>
        <div id="pendaftaranChart" class="min-h-[300px]"></div>
    </div>

    <!-- Quick Actions -->
    <div class="space-y-4">
        <h3 class="text-sm font-black text-slate-900 tracking-widest uppercase mb-4">Quick Actions</h3>
        <a href="{{ route('admin.pendaftaran.index') }}" class="flex items-center justify-between group bg-slate-900 text-white p-5 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <span class="font-bold text-sm tracking-tight">Kelola Pendaftaran</span>
            </div>
            <svg class="w-5 h-5 text-slate-500 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>

        <a href="{{ route('admin.pelatihan.create') }}" class="flex items-center justify-between group bg-white border border-slate-200 p-5 rounded-2xl hover:bg-slate-50 transition shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-teal-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <span class="font-bold text-sm text-slate-900 tracking-tight">Tambah Pelatihan</span>
            </div>
            <svg class="w-5 h-5 text-slate-300 group-hover:text-slate-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>

        <a href="{{ route('admin.sertifikat.index') }}" class="flex items-center justify-between group bg-white border border-slate-200 p-5 rounded-2xl hover:bg-slate-50 transition shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
                <span class="font-bold text-sm text-slate-900 tracking-tight">Manajemen Sertifikat</span>
            </div>
            <svg class="w-5 h-5 text-slate-300 group-hover:text-slate-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>

        <a href="{{ route('admin.petugas.index') }}" class="flex items-center justify-between group bg-white border border-slate-200 p-5 rounded-2xl hover:bg-slate-50 transition shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="font-bold text-sm text-slate-900 tracking-tight">Manajemen Petugas</span>
            </div>
            <svg class="w-5 h-5 text-slate-300 group-hover:text-slate-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>
</div>

<!-- PENDAFTARAN TERBARU (Table Styled) -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
        <h3 class="text-sm font-black text-slate-900 tracking-tight uppercase">Pendaftaran Terbaru</h3>
        <a href="{{ route('admin.pendaftaran.index') }}" class="text-[10px] font-black uppercase tracking-widest text-cyan-600 hover:text-cyan-700">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500">
                <tr class="text-[11px] font-bold uppercase tracking-wider">
                    <th class="text-left p-4">Pendaftar</th>
                    <th class="text-left p-4">Layanan</th>
                    <th class="text-left p-4 text-center">Status</th>
                    <th class="text-left p-4 text-center">Pembayaran</th>
                    <th class="text-right p-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pendaftaranTerbaru as $p)
                <tr class="hover:bg-slate-50/80 transition group">
                    <td class="p-4">
                        <div class="font-bold text-slate-900">{{ $p->user?->nama ?? '-' }}</div>
                        <div class="text-[10px] text-slate-400 font-medium">{{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d M Y') : '-' }}</div>
                    </td>
                    <td class="p-4">
                        <div class="text-xs font-bold text-slate-700 truncate max-w-[200px]">{{ $p->layanan?->nama ?? ($p->layanan?->materi ?? '-') }}</div>
                    </td>
                    <td class="p-4 text-center">
                        @php $c = match($p->status_progres) { 'selesai' => 'bg-teal-50 text-teal-600', 'diproses' => 'bg-blue-50 text-blue-600', 'dibatalkan' => 'bg-red-50 text-red-600', 'menunggu_pembayaran' => 'bg-amber-50 text-amber-600', default => 'bg-slate-50 text-slate-600' }; @endphp
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-tighter {{ $c }}">{{ str_replace('_', ' ', $p->status_progres) }}</span>
                    </td>
                    <td class="p-4 text-center">
                        @php $cb = match($p->status_bayar) { 'lunas' => 'bg-teal-50 text-teal-600', 'menunggu_konfirmasi' => 'bg-amber-50 text-amber-600', default => 'bg-slate-100 text-slate-500' }; @endphp
                        <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-tighter {{ $cb }}">{{ str_replace('_', ' ', $p->status_bayar) }}</span>
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('admin.pendaftaran.show', $p->id_pendaftaran) }}" class="p-2 bg-slate-50 text-slate-400 hover:bg-cyan-50 hover:text-cyan-600 rounded-xl transition shadow-sm border border-slate-200/50 inline-block">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center">
                        <div class="flex flex-col items-center opacity-30">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <p class="text-sm font-bold uppercase tracking-widest">Belum ada data</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

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
                height: 300,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Outfit, sans-serif'
            },
            colors: ['#0ea5e9'],
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
