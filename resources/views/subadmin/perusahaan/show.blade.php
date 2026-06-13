@extends('layouts.subadmin')

@section('title', 'Detail Perusahaan')
@section('page-title', 'Detail Peserta: ' . $perusahaan->nama)

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ route('subadmin.perusahaan.index') }}" class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-slate-900 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <p class="text-xs text-slate-500 font-extrabold uppercase tracking-widest">{{ $perusahaan->sektor_industri ?? 'Klien Korporat' }}</p>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">{{ $perusahaan->nama }}</h2>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-8">
    <!-- List Peserta dari Perusahaan ini -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden select-none">
        <div class="p-6 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <h3 class="font-black text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Daftar Peserta Perusahaan
            </h3>
            <span class="px-3 py-1 bg-white border border-slate-200 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-lg">
                {{ $pesertas->count() }} Orang
            </span>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Peserta</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Layanan / Pelatihan</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pesertas as $p)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-black">
                                {{ strtoupper(substr($p->user?->nama ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $p->user?->nama }}</p>
                                <p class="text-[10px] text-slate-400 font-medium uppercase tracking-tight">{{ $p->jabatan ?? 'Staf' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-700">{{ $p->layanan?->nama }}</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $p->layanan?->materi ? $p->layanan->materi->pluck('judul')->implode(', ') : '—' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @php
                            $statusMap = [
                                'menunggu' => ['bg-slate-100 text-slate-500', 'Menunggu'],
                                'diproses' => ['bg-amber-50 text-amber-600', 'Diproses'],
                                'selesai' => ['bg-emerald-50 text-emerald-600', 'Selesai'],
                                'lulus' => ['bg-cyan-50 text-cyan-600', 'Lulus'],
                                'dibatalkan' => ['bg-red-50 text-red-600', 'Dibatalkan'],
                            ];
                            $status = $statusMap[strtolower($p->status_progres)] ?? $statusMap['menunggu'];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $status[0] }}">
                            {{ $status[1] }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <a href="{{ route('subadmin.pendaftaran.show', $p->id_pendaftaran) }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition">
                            Lihat Detail
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-20 text-center">
                        <div class="opacity-30">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <p class="text-sm font-bold uppercase tracking-widest">Belum ada peserta dari perusahaan ini</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
