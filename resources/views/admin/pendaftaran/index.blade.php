@extends('layouts.admin')
@section('title', 'Manajemen Pendaftaran')
@section('page-title', 'Manajemen Pendaftaran')
@section('page-subtitle', 'Kelola dan pantau semua pendaftaran program layanan')

@section('content')

<!-- FILTER SECTION -->
<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 p-8 mb-8">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 items-end">
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Status Progres</label>
            <select name="status" class="w-full bg-slate-50 border border-slate-100 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
                <option value="">Semua Status</option>
                <option value="meninjau" {{ request('status') === 'meninjau' ? 'selected' : '' }}>Meninjau</option>
                <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="dijadwalkan" {{ request('status') === 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                <option value="menunggu_pelaksanaan" {{ request('status') === 'menunggu_pelaksanaan' ? 'selected' : '' }}>Menunggu Pelaksanaan</option>
                <option value="menunggu_pembayaran" {{ request('status') === 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="pembayaran_ditinjau" {{ request('status') === 'pembayaran_ditinjau' ? 'selected' : '' }}>Pembayaran Ditinjau</option>
                <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses (Pelatihan)</option>
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Bulan</label>
            <select name="month" class="w-full bg-slate-50 border border-slate-100 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
                <option value="">Semua Bulan</option>
                @for($m=1; $m<=12; $m++)
                    <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Tahun</label>
            <select name="year" class="w-full bg-slate-50 border border-slate-100 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
                @for($y=date('Y'); $y>=2024; $y--)
                    <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Status Bayar</label>
            <select name="bayar" class="w-full bg-slate-50 border border-slate-100 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
                <option value="">Semua</option>
                <option value="belum_lunas"          {{ request('bayar') === 'belum_lunas'          ? 'selected' : '' }}>Belum Lunas</option>
                <option value="lunas"                {{ request('bayar') === 'lunas'                ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-slate-900 text-white px-6 py-3.5 rounded-2xl text-sm font-black hover:bg-slate-800 transition shadow-lg shadow-slate-200">
                Filter
            </button>
            <a href="{{ route('admin.pendaftaran.index') }}" class="px-6 py-3.5 rounded-2xl text-sm font-black text-slate-400 hover:text-slate-600 transition flex items-center justify-center border border-slate-100">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- TABLE SECTION -->
<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-8 border-b border-slate-50 flex justify-between items-center">
        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Daftar Pendaftar</h3>
        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-50 px-4 py-1.5 rounded-full border border-slate-100">Total: {{ $pendaftarans->total() }}</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">ID</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Nama Pendaftar</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Kategori Layanan</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Tgl Daftar</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Progres</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Pembayaran</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Aksi</th>
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
                    <td class="p-6">
                        <div class="flex items-center justify-center gap-2">
                            <form action="{{ route('admin.pendaftaran.destroy', $p->id_pendaftaran) }}" method="POST" onsubmit="event.stopPropagation(); return confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="event.stopPropagation()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-red-600 hover:text-red-600 hover:shadow-lg hover:shadow-red-50 transition shadow-sm group/btn" title="Hapus">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
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
    <div class="px-8 py-5 border-t border-slate-100 bg-slate-50/30 flex flex-col sm:flex-row items-center justify-between gap-4">
        {{-- Info teks kiri --}}
        <p class="text-[12px] font-medium text-slate-500">
            Menampilkan
            <span class="font-black text-slate-800">{{ $pendaftarans->firstItem() }}–{{ $pendaftarans->lastItem() }}</span>
            dari
            <span class="font-black text-slate-800">{{ $pendaftarans->total() }}</span>
            pendaftar
        </p>

        {{-- Tombol navigasi kanan --}}
        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if($pendaftarans->onFirstPage())
                <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">‹</span>
            @else
                <a href="{{ $pendaftarans->previousPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">‹</a>
            @endif

            {{-- Nomor halaman --}}
            @for($i = 1; $i <= $pendaftarans->lastPage(); $i++)
                @if($i == $pendaftarans->currentPage())
                    <span class="px-3 py-1.5 text-[11px] font-black text-white bg-slate-900 rounded-xl">{{ $i }}</span>
                @else
                    <a href="{{ $pendaftarans->url($i) }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">{{ $i }}</a>
                @endif
            @endfor

            {{-- Next --}}
            @if($pendaftarans->hasMorePages())
                <a href="{{ $pendaftarans->nextPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">›</a>
            @else
                <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">›</span>
            @endif
        </div>
    </div>
    @endif
</div>

@endsection
