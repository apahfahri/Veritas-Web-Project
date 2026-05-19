@extends('layouts.subadmin')
@section('title', 'Detail Jadwal')
@section('page-title', 'Detail Jadwal')

@section('content')
<div class="mb-6">
    <a href="{{ route('subadmin.jadwal.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Info Jadwal --}}
    <div class="lg:col-span-1 space-y-5">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="bg-slate-50/50 px-6 py-5 border-b border-slate-100">
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-[9px] font-black bg-slate-900 text-cyan-400 px-2 py-1 rounded-lg tracking-widest">{{ $jadwal->kategori?->kode_kategori }}</span>
                    @if($jadwal->jenis?->kode_jenis)
                    <span class="text-[9px] font-black bg-indigo-50 text-indigo-600 px-2 py-1 rounded-lg border border-indigo-100 tracking-widest">{{ $jadwal->jenis->kode_jenis }}</span>
                    @endif
                </div>
                <h2 class="text-xl font-black text-slate-900 leading-tight">{{ $jadwal->jenis?->nama ?? '—' }}</h2>
                <p class="text-[11px] text-slate-400 font-bold mt-1">{{ $jadwal->kategori?->nama }}</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-bold">Mode</span>
                    <span class="inline-flex px-2.5 py-1 rounded-full text-[9px] font-black uppercase
                        {{ $jadwal->jenis_pertemuan === 'online' ? 'bg-cyan-50 text-cyan-700' : ($jadwal->jenis_pertemuan === 'hybrid' ? 'bg-purple-50 text-purple-700' : 'bg-amber-50 text-amber-700') }}">
                        {{ $jadwal->jenis_pertemuan }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-bold">Tanggal</span>
                    <span class="font-black text-slate-900 text-right">
                        {{ $jadwal->tgl_mulai?->format('d M Y') ?? '—' }}
                        @if($jadwal->tgl_selesai && $jadwal->tgl_selesai->ne($jadwal->tgl_mulai))
                        <br><span class="text-slate-400 font-bold text-xs">s.d. {{ $jadwal->tgl_selesai->format('d M Y') }}</span>
                        @endif
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-bold">Jam</span>
                    <span class="font-black text-slate-900">{{ $jadwal->jam_pertemuan ? substr($jadwal->jam_pertemuan, 0, 5).' WIB' : '—' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-bold">Lokasi</span>
                    <span class="font-black text-slate-900 text-right max-w-[160px]">{{ $jadwal->lokasi ?? '—' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-bold">Harga</span>
                    <span class="font-black text-slate-900">{{ $jadwal->harga > 0 ? 'Rp '.number_format($jadwal->harga,0,',','.') : 'Gratis' }}</span>
                </div>
                @if($jadwal->kapasitas)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-bold">Kapasitas</span>
                    <span class="font-black text-slate-900">{{ $jadwal->sisa_kursi }} / {{ $jadwal->kapasitas }} <span class="text-slate-400 font-bold text-xs">sisa</span></span>
                </div>
                @endif
            </div>
            <div class="px-6 pb-5 flex gap-2">
                <a href="{{ route('subadmin.jadwal.edit', $jadwal->id_jadwal) }}"
                   class="flex-1 text-center bg-slate-900 text-white py-2.5 rounded-xl text-xs font-black hover:bg-slate-800 transition">Edit Jadwal</a>
            </div>
        </div>

        {{-- Pemateri --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Pemateri / Instruktur</p>
            @forelse($jadwal->pemateri as $pm)
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-sm font-black">
                    {{ strtoupper(substr($pm->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-black text-slate-900 leading-tight">{{ $pm->nama_lengkap }}</p>
                    <p class="text-[10px] text-slate-400 font-bold">{{ $pm->kompetensi ?? 'Pemateri Veritas' }}</p>
                </div>
            </div>
            @empty
            <p class="text-[11px] text-slate-300 font-bold">Belum ada pemateri ditugaskan</p>
            @endforelse
        </div>
    </div>

    {{-- Daftar Peserta --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-black text-slate-900">Daftar Peserta</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $pesertas->count() }} pendaftar</p>
                </div>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($pesertas as $p)
                <div class="px-6 py-4 flex items-center justify-between gap-4 hover:bg-slate-50/50 transition">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-9 h-9 bg-slate-100 text-slate-500 rounded-xl flex items-center justify-center text-sm font-black shrink-0">
                            {{ strtoupper(substr($p->user?->nama ?? '?', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-black text-slate-900 truncate">{{ $p->user?->nama }}</p>
                            <p class="text-[10px] text-slate-400 font-bold truncate">{{ $p->user?->email }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <span class="text-[9px] font-black px-2 py-1 rounded-full uppercase tracking-wider
                            {{ $p->status_progres === 'terkonfirmasi' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : ($p->status_progres === 'dibatalkan' ? 'bg-red-50 text-red-600 border border-red-100' : 'bg-amber-50 text-amber-700 border border-amber-100') }}">
                            {{ str_replace('_', ' ', $p->status_progres) }}
                        </span>
                        <a href="{{ route('subadmin.pendaftaran.show', $p->id_pendaftaran) }}"
                           class="text-[10px] font-black text-indigo-600 hover:text-indigo-800 transition">Detail →</a>
                    </div>
                </div>
                @empty
                <div class="px-6 py-16 text-center">
                    <p class="text-sm font-black text-slate-300 uppercase tracking-widest">Belum ada peserta</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
