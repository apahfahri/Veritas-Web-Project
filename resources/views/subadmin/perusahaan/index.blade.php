@extends('layouts.subadmin')

@section('title', 'Daftar Perusahaan')
@section('page-title', 'Manajemen Klien Korporat')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm select-none">
    <div class="mb-8">
        <h3 class="text-lg font-black text-slate-900 tracking-tight">Perusahaan & Mitra</h3>
        <p class="text-xs text-slate-500 mt-0.5">Daftar perusahaan yang memiliki peserta terdaftar.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($perusahaans as $p)
        <div class="bg-slate-50/50 border border-slate-100 rounded-3xl p-6 hover:shadow-md transition group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-slate-400 shadow-sm group-hover:scale-110 transition duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-[10px] font-black uppercase tracking-widest rounded-lg">
                    {{ $p->pendaftarans_count }} Peserta
                </span>
            </div>
            
            <h4 class="text-sm font-black text-slate-900 mb-1 truncate">{{ $p->nama }}</h4>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-4 truncate">{{ $p->sektor_industri ?? 'Umum' }}</p>
            
            <div class="space-y-2 mb-6">
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m16-10a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span>{{ $p->jumlah_karyawan ?? '0' }} Karyawan</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-slate-500 font-medium">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span class="truncate">{{ $p->alamat ?? 'No Address' }}</span>
                </div>
            </div>

            <a href="{{ route('subadmin.perusahaan.show', $p->id_perusahaan) }}" class="block w-full py-3 bg-white hover:bg-slate-900 hover:text-white border border-slate-200 rounded-2xl text-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-600 transition shadow-sm hover:shadow-lg">
                Detail Peserta
            </a>
        </div>
        @empty
        <div class="col-span-full py-20 text-center opacity-30">
            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            <p class="text-sm font-bold uppercase tracking-widest">Tidak ada mitra korporat untuk saat ini</p>
        </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $perusahaans->links() }}
    </div>
</div>
@endsection
