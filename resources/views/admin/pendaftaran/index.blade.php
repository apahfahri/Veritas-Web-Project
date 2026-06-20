@extends('layouts.admin')
@section('title', 'Manajemen Pendaftaran')
@section('page-title', 'Manajemen Pendaftaran')
@section('page-subtitle', 'Kelola dan pantau semua pendaftaran program layanan')

@section('content')

<!-- TABLE SECTION -->
<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 md:p-8 bg-slate-50/30 border-b border-slate-100 select-none overflow-x-auto">
        <form method="GET" class="flex flex-nowrap items-end gap-3 w-full min-w-max">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Pencarian</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fi fi-rr-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email..."
                           class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
                </div>
            </div>
            <div class="w-40">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Status Progres</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="meninjau" {{ request('status') === 'meninjau' ? 'selected' : '' }}>Meninjau</option>
                    <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="dijadwalkan" {{ request('status') === 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                    <option value="menunggu_pelaksanaan" {{ request('status') === 'menunggu_pelaksanaan' ? 'selected' : '' }}>M.Pelaksanaan</option>
                    <option value="menunggu_pembayaran" {{ request('status') === 'menunggu_pembayaran' ? 'selected' : '' }}>M.Pembayaran</option>
                    <option value="pembayaran_ditinjau" {{ request('status') === 'pembayaran_ditinjau' ? 'selected' : '' }}>Pemb.Ditinjau</option>
                    <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                </select>
            </div>
            <div class="w-36">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Bulan</label>
                <select name="month" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition cursor-pointer">
                    <option value="">Semua Bulan</option>
                    @for($m=1; $m<=12; $m++)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                    @endfor
                </select>
            </div>
            <div class="w-28">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Tahun</label>
                <select name="year" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition cursor-pointer">
                    <option value="">Semua</option>
                    @for($y=date('Y'); $y>=2024; $y--)
                        <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div class="w-36">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Status Bayar</label>
                <select name="bayar" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition cursor-pointer">
                    <option value="">Semua</option>
                    <option value="belum_lunas"          {{ request('bayar') === 'belum_lunas'          ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="lunas"                {{ request('bayar') === 'lunas'                ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>
            <div class="flex gap-2 shrink-0">
                <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-5 py-2.5 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                    <i class="fi fi-rr-filter"></i>
                </button>
                @if(request()->hasAny(['search', 'status', 'month', 'year', 'bayar']))
                <a href="{{ route('admin.pendaftaran.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-5 py-2.5 rounded-xl transition flex items-center justify-center">
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">
                <tr>
                    <th class="px-5 py-4">ID</th>
                    <th class="px-5 py-4">Nama Pendaftar</th>
                    <th class="px-5 py-4">Kategori Layanan</th>
                    <th class="px-5 py-4">Tgl Daftar</th>
                    <th class="px-5 py-4 text-center">Progres</th>
                    <th class="px-5 py-4 text-center">Pembayaran</th>
                    <th class="px-5 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pendaftarans as $p)
                <tr class="hover:bg-slate-50/50 transition-colors group cursor-pointer" onclick="window.location='{{ route('admin.pendaftaran.show', $p->id_pendaftaran) }}'">
                    <td class="p-6 text-[12px] font-black tracking-widest text-slate-900 group-hover:text-indigo-600 transition-colors">
                        {{ $p->nomor_pendaftaran ? substr($p->nomor_pendaftaran, 0, 5) : 'ID-'.$p->id_pendaftaran }}
                    </td>
                    <td class="p-6">
                        <div class="flex flex-col">
                            <span class="text-[12px] font-medium text-slate-900 group-hover:text-indigo-600 transition">{{ $p->user?->nama }}</span>
                            <span class="text-[11px] font-medium text-slate-400">{{ $p->user?->email }}</span>
                        </div>
                    </td>
                    <td class="p-6">
                        <span class="text-[12px] font-medium text-slate-900 leading-relaxed">{{ $p->jadwal?->jenis?->nama ?? ($p->jadwal?->kategori?->nama ?? '-') }}</span>
                        @if($p->jadwal && $p->jadwal->status_pelaksanaan === 'Berlangsung')
                            <div class="mt-1.5">
                                <span class="inline-flex px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-widest border bg-rose-50 text-rose-600 border-rose-200 items-center gap-1.5 w-max">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span> Berlangsung
                                </span>
                            </div>
                        @endif
                    </td>
                    <td class="p-6 whitespace-nowrap">
                        <span class="text-[12px] font-medium text-slate-900">{{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d M Y') : '-' }}</span>
                    </td>
                    <td class="p-6 text-center">
                        @php 
                            $c = match($p->status_progres) { 
                                'selesai' => 'bg-teal-50 text-teal-600 border-teal-100', 
                                'diproses' => 'bg-blue-50 text-blue-600 border-blue-100', 
                                'dibatalkan' => 'bg-red-50 text-red-600 border-red-100', 
                                'menunggu_pembayaran' => 'bg-amber-50 text-amber-600 border-amber-100', 
                                'meninjau' => 'bg-purple-50 text-purple-600 border-purple-100', 
                                'disetujui' => 'bg-cyan-50 text-cyan-600 border-cyan-100', 
                                'dijadwalkan' => 'bg-indigo-50 text-indigo-600 border-indigo-100', 
                                'menunggu_pelaksanaan' => 'bg-emerald-50 text-emerald-600 border-emerald-100', 
                                'pembayaran_ditinjau' => 'bg-violet-50 text-violet-600 border-violet-100', 
                                default => 'bg-slate-50 text-slate-600 border-slate-100' 
                            }; 
                        @endphp
                        <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $c }}">
                            {{ str_replace('_', ' ', $p->status_progres) }}
                        </span>
                    </td>
                    <td class="p-6 text-center">
                        @php 
                            $cb = match($p->status_bayar) { 
                                'lunas' => 'bg-indigo-50 text-indigo-600 border-indigo-100', 
                                default => 'bg-slate-50 text-slate-400 border-slate-100' 
                            }; 
                        @endphp
                        <span class="inline-flex px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest border {{ $cb }}">
                            {{ $p->status_bayar }}
                        </span>
                    </td>
                    <td class="p-5">
                        <div class="flex items-center justify-center gap-2">
                            <form action="{{ route('admin.pendaftaran.destroy', $p->id_pendaftaran) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="event.stopPropagation()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:text-rose-700 hover:bg-rose-100 transition" title="Hapus">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                            <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center group-hover:bg-cyan-600 group-hover:text-white transition">
                                <i class="fi fi-rr-angle-small-right text-lg mt-0.5"></i>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mb-4">
                                <i class="fi fi-rr-book-alt w-10 h-10"></i>
                            </div>
                            <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Tidak ada data pendaftaran</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($pendaftarans->hasPages())
    <div class="p-6 border-t border-slate-100 flex justify-center">
        {{ $pendaftarans->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection
