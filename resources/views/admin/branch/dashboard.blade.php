@extends('layouts\branch')

@section('title', 'Dashboard Cabang')
@section('page-title', 'Dashboard Cabang ' . strtoupper($stats['cabang']))

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 select-none">
    
    <!-- STAT CARD -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between h-44 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-gradient-to-tr from-cyan-400/20 to-teal-400/20 rounded-full blur-2xl group-hover:scale-110 transition duration-500"></div>
        <div class="flex justify-between items-start">
            <div>
                <span class="text-xs uppercase font-extrabold text-cyan-600/90 tracking-wider">Layanan Cabang</span>
                <h3 class="text-3xl font-black text-slate-900 mt-1 tracking-tight">{{ $stats['total_layanan'] }}</h3>
            </div>
            <span class="text-3xl bg-cyan-50 p-3.5 rounded-2xl shadow-sm">🛠️</span>
        </div>
        <a href="{{ route('branch-admin.layanan.index') }}" class="text-xs font-semibold text-cyan-600 hover:text-cyan-700 mt-2 flex items-center gap-1">Lihat Detail ➔</a>
    </div>

    <!-- STAT CARD -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between h-44 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-gradient-to-tr from-orange-400/20 to-amber-400/20 rounded-full blur-2xl group-hover:scale-110 transition duration-500"></div>
        <div class="flex justify-between items-start">
            <div>
                <span class="text-xs uppercase font-extrabold text-orange-600/90 tracking-wider">Klien & Mitra</span>
                <h3 class="text-3xl font-black text-slate-900 mt-1 tracking-tight">{{ $stats['total_klien'] }}</h3>
            </div>
            <span class="text-3xl bg-orange-50 p-3.5 rounded-2xl shadow-sm">🏢</span>
        </div>
        <a href="{{ route('branch-admin.klien.index') }}" class="text-xs font-semibold text-orange-600 hover:text-orange-700 mt-2 flex items-center gap-1">Lihat Detail ➔</a>
    </div>

    <!-- STAT CARD -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between h-44 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-gradient-to-tr from-pink-400/20 to-purple-400/20 rounded-full blur-2xl group-hover:scale-110 transition duration-500"></div>
        <div class="flex justify-between items-start">
            <div>
                <span class="text-xs uppercase font-extrabold text-pink-600/90 tracking-wider">Peserta & Riwayat</span>
                <h3 class="text-3xl font-black text-slate-900 mt-1 tracking-tight">{{ $stats['total_peserta'] }}</h3>
            </div>
            <span class="text-3xl bg-pink-50 p-3.5 rounded-2xl shadow-sm">📋</span>
        </div>
        <a href="{{ route('branch-admin.peserta.index') }}" class="text-xs font-semibold text-pink-600 hover:text-pink-700 mt-2 flex items-center gap-1">Lihat Detail ➔</a>
    </div>

    <!-- STAT CARD -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between h-44 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-gradient-to-tr from-emerald-400/20 to-teal-400/20 rounded-full blur-2xl group-hover:scale-110 transition duration-500"></div>
        <div class="flex justify-between items-start">
            <div>
                <span class="text-xs uppercase font-extrabold text-emerald-600/90 tracking-wider">Jadwal Cabang</span>
                <h3 class="text-3xl font-black text-slate-900 mt-1 tracking-tight">{{ $stats['total_jadwal'] }}</h3>
            </div>
            <span class="text-3xl bg-emerald-50 p-3.5 rounded-2xl shadow-sm">📅</span>
        </div>
        <a href="{{ route('branch-admin.jadwal.index') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 mt-2 flex items-center gap-1">Lihat Detail ➔</a>
    </div>

    <!-- STAT CARD -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between h-44 relative overflow-hidden group">
        <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-gradient-to-tr from-blue-400/20 to-indigo-400/20 rounded-full blur-2xl group-hover:scale-110 transition duration-500"></div>
        <div class="flex justify-between items-start">
            <div>
                <span class="text-xs uppercase font-extrabold text-blue-600/90 tracking-wider">Sertifikat Diterbitkan</span>
                <h3 class="text-3xl font-black text-slate-900 mt-1 tracking-tight">{{ $stats['total_sertifikat'] }}</h3>
            </div>
            <span class="text-3xl bg-blue-50 p-3.5 rounded-2xl shadow-sm">🏆</span>
        </div>
        <a href="{{ route('branch-admin.sertifikat.index') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 mt-2 flex items-center gap-1">Lihat Detail ➔</a>
    </div>

</div>

<!-- QUICK LINKS -->
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
    <h3 class="text-lg font-black text-slate-900 tracking-tight">Selamat Datang di Portal Admin Cabang</h3>
    <p class="text-sm text-slate-500 mt-1 mb-6">Kelola data operasional khusus untuk regional {{ strtoupper($stats['cabang']) }} secara mandiri.</p>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-5 border border-slate-100 rounded-2xl hover:bg-slate-50/50 transition duration-300">
            <span class="text-2xl">🛠️</span>
            <h4 class="font-bold text-slate-800 text-sm mt-3">Konten Layanan Cabang</h4>
            <p class="text-xs text-slate-500 mt-1 mb-3">Atur layanan perusahaan khusus di cabang {{ strtoupper($stats['cabang']) }}.</p>
            <a href="{{ route('branch-admin.layanan.index') }}" class="text-xs font-bold text-cyan-600 hover:underline">Akses Menu ➔</a>
        </div>
        <div class="p-5 border border-slate-100 rounded-2xl hover:bg-slate-50/50 transition duration-300">
            <span class="text-2xl">📈</span>
            <h4 class="font-bold text-slate-800 text-sm mt-3">Laporan Statistik</h4>
            <p class="text-xs text-slate-500 mt-1 mb-3">Buat laporan berkala untuk memantau data perkembangan cabang.</p>
            <a href="{{ route('branch-admin.laporan.index') }}" class="text-xs font-bold text-cyan-600 hover:underline">Akses Menu ➔</a>
        </div>
        <div class="p-5 border border-slate-100 rounded-2xl hover:bg-slate-50/50 transition duration-300">
            <span class="text-2xl">📅</span>
            <h4 class="font-bold text-slate-800 text-sm mt-3">Jadwal Pelatihan & Audit</h4>
            <p class="text-xs text-slate-500 mt-1 mb-3">Lihat dan atur jadwal operasional pelatihan bagi peserta.</p>
            <a href="{{ route('branch-admin.jadwal.index') }}" class="text-xs font-bold text-cyan-600 hover:underline">Akses Menu ➔</a>
        </div>
    </div>
</div>
@endsection
