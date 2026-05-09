@extends('layouts.subadmin')

@section('title', 'Detail Konsultasi')
@section('page-title', 'Detail Peserta/Order: ' . $konsultasi->nama)

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ route('subadmin.konsultasi.index') }}" class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-slate-900 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <p class="text-xs text-slate-500 font-extrabold uppercase tracking-widest">{{ $konsultasi->kategori?->nama }}</p>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">{{ $konsultasi->materi }}</h2>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 gap-8">
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden select-none">
        <div class="p-6 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <h3 class="font-black text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                Daftar Pendaftar Konsultasi
            </h3>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Klien / Perusahaan</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pesertas as $p)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 text-xs font-black">
                                {{ strtoupper(substr($p->user?->nama ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $p->user?->nama }}</p>
                                @if($p->id_perusahaan)
                                    <p class="text-[10px] text-indigo-500 font-black uppercase tracking-tighter">{{ $p->perusahaan?->nama }}</p>
                                @else
                                    <p class="text-[10px] text-slate-400 font-medium">Personal / Mandiri</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-center">
                        @php
                            $statusMap = [
                                'menunggu' => ['bg-slate-100 text-slate-500', 'Menunggu'],
                                'diproses' => ['bg-amber-50 text-amber-600', 'Diproses'],
                                'selesai' => ['bg-emerald-50 text-emerald-600', 'Selesai'],
                                'dibatalkan' => ['bg-red-50 text-red-600', 'Dibatalkan'],
                            ];
                            $status = $statusMap[strtolower($p->status_progres)] ?? $statusMap['menunggu'];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $status[0] }}">
                            {{ $status[1] }}
                        </span>
                    </td>
                    <td class="px-6 py-5 text-right">
                        <a href="{{ route('subadmin.pendaftaran.show', $p->id_pendaftaran) }}" class="p-2 text-slate-400 hover:text-cyan-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-20 text-center text-slate-400 text-sm font-medium italic">Belum ada order untuk layanan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
