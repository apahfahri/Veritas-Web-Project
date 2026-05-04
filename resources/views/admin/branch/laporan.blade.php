@extends('layouts\branch')

@section('title', 'Laporan Statistik')
@section('page-title', 'Laporan Statistik Berkala Cabang')

@section('content')
<div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm mb-8 select-none">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
                <span>📈</span> Filter Statistik Laporan
            </h3>
            <p class="text-xs text-slate-500 font-medium">Berdasarkan data operasional pendaftaran cabang Anda</p>
        </div>
        
        <form action="{{ route('branch-admin.laporan.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5">
            <div>
                <select name="tahun" class="text-xs font-bold px-3 py-2 border border-slate-200 rounded-xl bg-slate-50 focus:outline-none cursor-pointer">
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <select name="bulan" class="text-xs font-bold px-3 py-2 border border-slate-200 rounded-xl bg-slate-50 focus:outline-none cursor-pointer">
                    <option value="">Semua Bulan</option>
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-1">
                <span>🔍</span> Filter Data
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 select-none">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between h-36">
        <div>
            <span class="text-xs font-black text-slate-500 uppercase tracking-wide">Pendaftaran Cabang</span>
            <h4 class="text-2xl font-black text-slate-900 mt-1">{{ $pendaftaran->count() }}</h4>
        </div>
        <p class="text-xs text-slate-400">Total peserta terdaftar</p>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between h-36">
        <div>
            <span class="text-xs font-black text-slate-500 uppercase tracking-wide">Pendaftaran Selesai</span>
            <h4 class="text-2xl font-black text-emerald-600 mt-1">{{ $pendaftaran->where('status_progres', 'selesai')->count() }}</h4>
        </div>
        <p class="text-xs text-slate-400">Status progres selesai</p>
    </div>
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between h-36">
        <div>
            <span class="text-xs font-black text-slate-500 uppercase tracking-wide">Total Terbayar</span>
            <h4 class="text-2xl font-black text-cyan-600 mt-1">{{ $pendaftaran->where('status_bayar', 'lunas')->count() }}</h4>
        </div>
        <p class="text-xs text-slate-400">Sudah berstatus lunas</p>
    </div>
</div>

<div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
    <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2 mb-5">
        <span>📋</span> Detail Pendaftaran Terdata
    </h3>
    
    <div class="overflow-x-auto">
        <table class="w-full border-collapse text-left text-sm">
            <thead>
                <tr class="bg-slate-50/80 text-slate-500 uppercase text-xs font-extrabold border-b border-slate-100">
                    <th class="px-5 py-3.5 tracking-wider">Nama & Email</th>
                    <th class="px-5 py-3.5 tracking-wider">Layanan</th>
                    <th class="px-5 py-3.5 tracking-wider">Tgl Daftar</th>
                    <th class="px-5 py-3.5 tracking-wider">Progres</th>
                    <th class="px-5 py-3.5 tracking-wider">Pembayaran</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pendaftaran as $item)
                    <tr class="hover:bg-slate-50/40 transition">
                        <td class="px-5 py-4 font-bold text-slate-800">
                            <div>{{ $item->user?->name ?: 'N/A' }}</div>
                            <div class="text-xs text-slate-400 font-normal mt-0.5">{{ $item->user?->email ?: '-' }}</div>
                        </td>
                        <td class="px-5 py-4 text-slate-600">{{ $item->layanan?->nama ?: 'Layanan Umum' }}</td>
                        <td class="px-5 py-4 text-slate-500">{{ $item->tanggal_daftar ? $item->tanggal_daftar->format('d/m/Y') : '-' }}</td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 text-[10px] font-black uppercase rounded select-none {{ $item->status_progres === 'selesai' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200/50' : ($item->status_progres === 'diproses' ? 'bg-amber-50 text-amber-600 border border-amber-200/50' : 'bg-slate-50 text-slate-600 border border-slate-200/50') }}">
                                {{ $item->status_progres }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 text-[10px] font-black uppercase rounded select-none {{ $item->status_bayar === 'lunas' ? 'bg-teal-50 text-teal-600 border border-teal-200/50' : ($item->status_bayar === 'menunggu_konfirmasi' ? 'bg-amber-50 text-amber-600 border border-amber-200/50' : 'bg-red-50 text-red-600 border border-red-200/50') }}">
                                {{ $item->status_bayar }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-slate-400 font-medium">
                            <span class="text-2xl block mb-2">📁</span>
                            Tidak ada data pendaftaran di periode ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
