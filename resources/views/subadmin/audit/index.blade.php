@extends('layouts.subadmin')

@section('title', 'Layanan Audit')
@section('page-title', 'Manajemen Layanan Audit')

@section('content')
<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden select-none">
    
    <!-- Header Section -->
    <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between gap-4 bg-slate-50/30 border-b border-slate-100">
        <!-- Filter Status & Search Form -->
        <form method="GET" action="{{ route('subadmin.audit.index') }}" class="flex flex-wrap items-center gap-3 w-full">
            <div>
                <select name="status" onchange="this.form.submit()" class="border border-slate-200/80 rounded-xl px-4 py-2.5 text-xs bg-slate-50 font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-cyan-500/10 cursor-pointer">
                    <option value="">-- Semua Status --</option>
                    <option value="meninjau" {{ request('status') === 'meninjau' ? 'selected' : '' }}>Meninjau</option>
                    <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="dijadwalkan" {{ request('status') === 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                    <option value="menunggu_pelaksanaan" {{ request('status') === 'menunggu_pelaksanaan' ? 'selected' : '' }}>Menunggu Pelaksanaan</option>
                    <option value="menunggu_pembayaran" {{ request('status') === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="pembayaran_ditinjau" {{ request('status') === 'pembayaran_ditinjau' ? 'selected' : '' }}>Pembayaran Ditinjau</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="relative flex-1 min-w-[200px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fi fi-rr-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari perusahaan / PIC..." class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
            </div>
            <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                <i class="fi fi-rr-search"></i> Cari Data
            </button>
            @if(request()->filled('status') || request()->filled('search'))
                <a href="{{ route('subadmin.audit.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-4 py-2.5 rounded-xl transition">Reset</a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Perusahaan & PIC</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Jenis Audit</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Tanggal Usulan</th>
                    <th class="px-5 py-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pendaftarans as $p)
                <tr class="hover:bg-slate-50/80 transition cursor-pointer group" onclick="window.location='{{ route('subadmin.audit.show', $p->id_pendaftaran) }}'">
                    <td class="p-4">
                        <div class="text-sm font-black text-slate-900">{{ $p->perusahaan?->nama ?? '—' }}</div>
                        <div class="text-xs text-slate-500 font-medium">PIC: {{ $p->user?->nama }} ({{ $p->user?->no_telp }})</div>
                        <div class="text-[9px] font-bold text-slate-400 tracking-wider uppercase mt-1">No: {{ $p->nomor_pendaftaran }}</div>
                    </td>
                    <td class="p-4 text-sm font-medium text-slate-700">
                        {{ $p->jadwal?->jenis?->nama ?? 'Audit Sistem Manajemen K3' }}
                    </td>
                    <td class="p-4 text-sm font-bold text-slate-600">
                        {{ $p->rencana_tanggal_mulai ? $p->rencana_tanggal_mulai->format('d M Y') : '-' }}
                    </td>
                    <td class="p-4 text-center">
                        @php
                            $statusMap = [
                                'meninjau' => ['bg-slate-100 text-slate-600 border-slate-200', 'Meninjau'],
                                'disetujui' => ['bg-amber-50 text-amber-700 border-amber-200', 'Disetujui'],
                                'dijadwalkan' => ['bg-indigo-50 text-indigo-700 border-indigo-200', 'Dijadwalkan'],
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
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-sm font-medium text-slate-400">Belum ada data pendaftaran audit yang sesuai filter.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-6 border-t border-slate-100 flex justify-center">
        {{ $pendaftarans->links() }}
    </div>
</div>
@endsection
