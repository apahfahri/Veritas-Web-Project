@extends('layouts.subadmin')

@section('title', 'Manajemen Pendaftaran')
@section('page-title', 'Daftar Pendaftaran')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6 select-none">
        <form method="GET" action="{{ route('subadmin.pendaftaran.index') }}" class="flex flex-wrap items-center gap-3 w-full">
            <div class="relative flex-1 min-w-[200px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, layanan..." class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
            </div>
            <select name="status" class="bg-slate-50 border border-slate-200/80 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
                <option value="">Semua Status</option>
                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Terkonfirmasi</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition">
                Cari Data
            </button>
            @if(request()->has('search') || request()->has('status'))
                <a href="{{ route('subadmin.pendaftaran.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-4 py-2.5 rounded-xl transition">
                    Reset
                </a>
            @endif
            <div class="flex items-center gap-2 ml-auto">
                <a href="{{ route('subadmin.pendaftaran.export-pdf', request()->all()) }}" target="_blank" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs px-4 py-2.5 rounded-xl transition flex items-center gap-2 border border-rose-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export PDF
                </a>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto select-none">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100/80">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">ID</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Layanan</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Klien</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Tanggal Daftar</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Status Progres</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Status Bayar</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pendaftarans as $p)
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="p-4 text-[11px] font-black tracking-widest text-slate-900">{{ $p->nomor_pendaftaran ?? 'ID-'.$p->id_pendaftaran }}</td>
                    <td class="p-4 text-sm font-bold text-slate-800">{{ $p->jadwal?->jenis?->nama ?? '—' }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">
                        {{ $p->user?->nama }}<br>
                        <span class="text-xs text-slate-400">{{ $p->user?->email }}</span>
                    </td>
                    <td class="p-4 text-sm font-medium text-slate-600">
                        {{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d M Y') : '-' }}
                    </td>
                    <td class="p-4 text-sm font-semibold">
                        @if($p->status_progres == 'menunggu')
                            <span class="text-[10px] bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">Menunggu Konfirmasi</span>
                        @elseif($p->status_progres == 'diproses')
                            <span class="text-[10px] bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">Terkonfirmasi</span>
                        @elseif($p->status_progres == 'selesai')
                            <span class="text-[10px] bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">Selesai</span>
                        @else
                            <span class="text-[10px] bg-red-100 text-red-800 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">{{ strtoupper($p->status_progres) }}</span>
                        @endif
                    </td>
                    <td class="p-4 text-sm font-semibold">
                        @if($p->status_bayar == 'belum_bayar')
                            <span class="text-[10px] bg-rose-100 text-rose-800 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">Belum Bayar</span>
                        @elseif($p->status_bayar == 'dp')
                            <span class="text-[10px] bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">DP</span>
                        @elseif($p->status_bayar == 'lunas')
                            <span class="text-[10px] bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">Lunas</span>
                        @else
                            <span class="text-[10px] bg-slate-100 text-slate-600 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">{{ strtoupper($p->status_bayar) }}</span>
                        @endif
                    </td>
                    <td class="p-4 text-sm font-medium flex items-center gap-2">
                        @if($p->status_progres == 'menunggu')
                            <a href="{{ route('subadmin.pendaftaran.show', $p->id_pendaftaran) }}" class="bg-amber-50 hover:bg-amber-100 text-amber-700 px-3.5 py-1.5 rounded-xl text-xs font-black transition">
                                Konfirmasi
                            </a>
                        @elseif($p->status_bayar == 'menunggu_konfirmasi')
                            <a href="{{ route('subadmin.pendaftaran.show', $p->id_pendaftaran) }}" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-700 px-3.5 py-1.5 rounded-xl text-xs font-black transition">
                                Cek Bukti
                            </a>
                        @else
                            <a href="{{ route('subadmin.pendaftaran.show', $p->id_pendaftaran) }}" class="bg-cyan-50 hover:bg-cyan-100 text-cyan-600 px-3.5 py-1.5 rounded-xl text-xs font-black transition">
                                Detail
                            </a>
                        @endif
                        <form action="{{ route('subadmin.pendaftaran.destroy', $p->id_pendaftaran) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3.5 py-1.5 rounded-xl text-xs font-black transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-4 text-center text-sm font-medium text-slate-500">Tidak ada data pendaftaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $pendaftarans->links() }}
    </div>
</div>
@endsection


