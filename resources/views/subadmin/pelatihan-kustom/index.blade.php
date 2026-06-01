@extends('layouts.subadmin')

@section('title', 'Pelatihan Kustom B2B')
@section('page-title', 'Manajemen Pelatihan Kustom')

@section('content')
<div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm select-none">
    
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h3 class="text-xl font-black text-slate-900 tracking-tight">Daftar Pelatihan Kustom B2B</h3>
            <p class="text-xs text-slate-500 mt-1">Kelola permohonan, progres, penjadwalan, penugasan pemateri, dan tagihan pelatihan kustom B2B.</p>
        </div>
        
        <!-- Filter Status & Search Form -->
        <form method="GET" action="{{ route('subadmin.pelatihan-kustom.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <div>
                <select name="status" onchange="this.form.submit()" class="border border-slate-200 rounded-xl px-4 py-2.5 text-xs bg-slate-50 font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-cyan-500/10 cursor-pointer">
                    <option value="">-- Semua Status --</option>
                    <option value="meninjau" {{ request('status') === 'meninjau' ? 'selected' : '' }}>⏳ Meninjau</option>
                    <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>👍 Disetujui</option>
                    <option value="dijadwalkan" {{ request('status') === 'dijadwalkan' ? 'selected' : '' }}>📅 Penjadwalan</option>
                    <option value="menunggu_pelaksanaan" {{ request('status') === 'menunggu_pelaksanaan' ? 'selected' : '' }}>⏳ Menunggu Pelaksanaan</option>
                    <option value="menunggu_pembayaran" {{ request('status') === 'menunggu_pembayaran' ? 'selected' : '' }}>💳 Menunggu Pembayaran</option>
                    <option value="pembayaran_ditinjau" {{ request('status') === 'pembayaran_ditinjau' ? 'selected' : '' }}>👀 Pembayaran Ditinjau</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                    <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                </select>
            </div>
            <div class="relative flex-1 md:flex-initial">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="border border-slate-200 rounded-xl pl-9 pr-4 py-2.5 text-xs bg-slate-50 font-medium text-slate-700 focus:outline-none focus:ring-4 focus:ring-cyan-500/10 w-full md:w-60">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
            </div>
            @if(request()->filled('status') || request()->filled('search'))
                <a href="{{ route('subadmin.pelatihan-kustom.index') }}" class="text-xs font-bold text-red-500 hover:text-red-700 transition">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Perusahaan & PIC</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Topik Pelatihan</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Tanggal Rencana</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider text-center">Status</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pendaftarans as $p)
                <tr class="hover:bg-slate-50/60 transition group">
                    <td class="p-4">
                        <div class="text-sm font-black text-slate-900">{{ $p->perusahaan?->nama ?? '—' }}</div>
                        <div class="text-xs text-slate-500 font-medium">PIC: {{ $p->user?->nama }} ({{ $p->user?->no_telp }})</div>
                        <div class="text-[9px] font-bold text-slate-400 tracking-wider uppercase mt-1">No: {{ $p->nomor_pendaftaran }}</div>
                    </td>
                    <td class="p-4 text-sm font-semibold text-slate-700">
                        {{ $p->jadwal?->jenis?->nama ?? 'Pelatihan Kustom' }}
                    </td>
                    <td class="p-4 text-sm font-bold text-slate-600">
                        {{ $p->rencana_tanggal_mulai ? $p->rencana_tanggal_mulai->format('d M Y') : '-' }}
                    </td>
                    <td class="p-4 text-center">
                        @php
                            $statusMap = [
                                'meninjau' => ['bg-slate-100 text-slate-600 border-slate-200', 'Meninjau'],
                                'disetujui' => ['bg-amber-50 text-amber-700 border-amber-200', 'Disetujui'],
                                'dijadwalkan' => ['bg-indigo-50 text-indigo-700 border-indigo-200', 'Penjadwalan'],
                                'menunggu_pelaksanaan' => ['bg-blue-50 text-blue-700 border-blue-200', 'Menunggu Pelaksanaan'],
                                'menunggu_pembayaran' => ['bg-orange-50 text-orange-700 border-orange-200', 'Menunggu Bayar'],
                                'pembayaran_ditinjau' => ['bg-purple-50 text-purple-700 border-purple-200', 'Bukti Diunggah'],
                                'selesai' => ['bg-emerald-50 text-emerald-700 border-emerald-200', 'Selesai'],
                                'dibatalkan' => ['bg-rose-50 text-rose-700 border-rose-200', 'Dibatalkan'],
                            ];
                            $status = $statusMap[strtolower($p->status_progres)] ?? ['bg-gray-100 text-gray-600 border-gray-200', ucfirst($p->status_progres)];
                        @endphp
                        <span class="inline-block px-3 py-1 rounded-full border text-[10px] font-black uppercase tracking-widest {{ $status[0] }}">
                            {{ $status[1] }}
                        </span>
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('subadmin.pelatihan-kustom.show', $p->id_pendaftaran) }}" class="inline-block bg-slate-900 hover:bg-slate-800 text-white text-[10px] font-black uppercase tracking-wider px-4 py-2.5 rounded-xl shadow-sm transition">
                            Kelola Proses
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-sm font-medium text-slate-400">Belum ada data pelatihan kustom B2B.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $pendaftarans->links() }}
    </div>
</div>
@endsection
