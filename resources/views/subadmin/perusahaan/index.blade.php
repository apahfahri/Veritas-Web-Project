@extends('layouts.subadmin')

@section('title', 'Daftar Perusahaan')
@section('page-title', 'Manajemen Klien Korporat')

@section('content')
<div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm select-none">
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Perusahaan & Mitra</h3>
            <p class="text-xs text-slate-500 mt-0.5">Daftar perusahaan yang memiliki peserta terdaftar.</p>
        </div>
        
        <!-- Search & Filter -->
        <div class="flex items-center gap-3">
            <form action="{{ route('subadmin.perusahaan.index') }}" method="GET" class="flex flex-1 md:w-80 bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden focus-within:border-cyan-500 focus-within:ring-2 focus-within:ring-cyan-500/20 transition-all shadow-sm">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau industri..."
                       class="w-full bg-transparent border-none text-sm px-4 py-2.5 focus:ring-0 text-slate-700 placeholder-slate-400 font-medium">
                <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 flex items-center justify-center transition">
                    <i class="fi fi-rr-search mt-1"></i>
                </button>
            </form>
            @if(request()->hasAny(['search']))
                <a href="{{ route('subadmin.perusahaan.index') }}" class="w-10 h-10 flex items-center justify-center bg-red-50 text-red-600 hover:bg-red-100 border border-red-100 rounded-2xl transition tooltip-trigger" title="Reset Filter">
                    <i class="fi fi-rr-cross"></i>
                </a>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($perusahaans as $p)
        <div class="bg-slate-50/50 border border-slate-100 rounded-[2rem] p-6 hover:shadow-md hover:bg-white hover:border-slate-200 transition group cursor-pointer relative" onclick="window.location.href='{{ route('subadmin.perusahaan.show', $p->id_perusahaan) }}'">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-white border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 shadow-sm group-hover:scale-110 group-hover:text-cyan-600 group-hover:border-cyan-100 transition duration-300">
                    <i class="fi fi-rr-building text-lg"></i>
                </div>
                <span class="px-3 py-1 bg-cyan-50 border border-cyan-100 text-cyan-700 text-[10px] font-black uppercase tracking-widest rounded-lg">
                    {{ $p->pendaftarans_count }} Peserta
                </span>
            </div>
            
            <h4 class="text-sm font-black text-slate-900 mb-1 truncate group-hover:text-cyan-700 transition">{{ $p->nama }}</h4>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-4 truncate">{{ $p->sektor_industri ?? 'Umum' }}</p>
            
            <div class="space-y-2 mb-4">
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                    <i class="fi fi-rr-users text-slate-400"></i>
                    <span>{{ $p->jumlah_karyawan ?? '0' }} Karyawan</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                    <i class="fi fi-rr-marker text-slate-400"></i>
                    <span class="truncate">{{ $p->alamat ?? 'No Address' }}</span>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-slate-100 flex justify-end">
                <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center group-hover:bg-cyan-600 group-hover:text-white transition">
                    <i class="fi fi-rr-angle-small-right text-lg mt-0.5"></i>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center opacity-30">
            <i class="fi fi-rr-building w-16 h-16 mx-auto mb-4"></i>
            <p class="text-sm font-bold uppercase tracking-widest">Tidak ada mitra korporat untuk saat ini</p>
        </div>
        @endforelse
    </div>

    @if($perusahaans->hasPages())
    <div class="mt-8 pt-8 border-t border-slate-100">
        {{ $perusahaans->links('vendor.pagination.tailwind') }}
    </div>
    @endif
</div>
@endsection
