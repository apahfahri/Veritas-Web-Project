@extends('layouts.subadmin')

@section('title', 'Manajemen Pendaftaran')
@section('page-title', 'Daftar Pendaftaran')

@section('content')
<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between gap-4 select-none bg-slate-50/30 border-b border-slate-100">
        <form method="GET" action="{{ route('subadmin.pendaftaran.index') }}" class="flex flex-wrap items-center gap-3 w-full">
            <div>
                <select name="status" onchange="this.form.submit()" class="border border-slate-200/80 rounded-xl px-4 py-2.5 text-xs bg-slate-50 font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-cyan-500/10 cursor-pointer">
                    <option value="">-- Semua Status --</option>
                    <option value="menunggu_pembayaran" {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Terkonfirmasi</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="relative flex-1 min-w-[200px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fi fi-rr-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, layanan..." class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
            </div>
            <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                <i class="fi fi-rr-search"></i> Cari Data
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
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">ID</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Layanan</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Klien</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Tanggal Daftar</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Status Progres</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Status Bayar</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pendaftarans as $p)
                <tr class="hover:bg-slate-50/80 transition cursor-pointer group" onclick="window.location='{{ route('subadmin.pendaftaran.show', $p->id_pendaftaran) }}'">
                    <td class="p-4 text-[11px] font-black tracking-widest text-slate-900 group-hover:text-cyan-600 transition-colors">
                        {{ $p->nomor_pendaftaran ? substr($p->nomor_pendaftaran, 0, 5) : 'ID-'.$p->id_pendaftaran }}
                    </td>
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
                        @elseif($p->status_progres == 'menunggu_pembayaran')
                            <span class="text-[10px] bg-orange-100 text-orange-800 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">Menunggu Pembayaran</span>
                        @elseif($p->status_progres == 'diproses')
                            <span class="text-[10px] bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">Terkonfirmasi</span>
                        @elseif($p->status_progres == 'selesai')
                            <span class="text-[10px] bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">Selesai</span>
                        @else
                            <span class="text-[10px] bg-red-100 text-red-800 px-2.5 py-1 rounded-full font-black uppercase tracking-widest whitespace-nowrap">{{ strtoupper(str_replace('_', ' ', $p->status_progres)) }}</span>
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
                        <form action="{{ route('subadmin.pendaftaran.destroy', $p->id_pendaftaran) }}" method="POST" class="inline" onsubmit="event.stopPropagation(); return confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="event.stopPropagation()" class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 w-8 h-8 rounded-lg flex items-center justify-center transition" title="Hapus">
                                <i class="fi fi-rr-trash"></i>
                            </button>
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

    <div class="p-6 border-t border-slate-100 flex justify-center">
        {{ $pendaftarans->links() }}
    </div>
</div>
@endsection


