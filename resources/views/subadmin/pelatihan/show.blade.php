@extends('layouts.subadmin')

@section('title', 'Manajemen Peserta')
@section('page-title', 'Peserta Pelatihan: ' . $pelatihan->nama)

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div class="flex items-center gap-4">
        <a href="{{ route('subadmin.pelatihan.index') }}" class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-slate-900 transition shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <p class="text-xs text-slate-500 font-extrabold uppercase tracking-widest">{{ $pelatihan->kategori?->nama_kategori }}</p>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">{{ $pelatihan->materi }}</h2>
        </div>
    </div>
    <div class="flex gap-2">
        <span class="px-4 py-2 bg-slate-900 text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg">
            Total: {{ $pesertas->count() }} Peserta
        </span>
    </div>
</div>

<div class="grid grid-cols-1 gap-8">
    <!-- List Peserta -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden select-none">
        <div class="p-6 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <h3 class="font-black text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Daftar Peserta Terdaftar
            </h3>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-slate-50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Peserta</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tipe / Scope</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Progres</th>
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
                                <p class="text-[10px] text-slate-400 font-medium lowercase">{{ $p->user?->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-5">
                        @if($p->id_perusahaan)
                            <div class="flex flex-col">
                                <span class="text-[10px] bg-amber-50 text-amber-600 border border-amber-100 px-2 py-0.5 rounded-md font-black uppercase tracking-wider w-fit">Corporate</span>
                                <span class="text-xs font-bold text-slate-700 mt-1">{{ $p->perusahaan?->nama_perusahaan }}</span>
                            </div>
                        @else
                            <span class="text-[10px] bg-cyan-50 text-cyan-600 border border-cyan-100 px-2 py-0.5 rounded-md font-black uppercase tracking-wider">Individu</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
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
                        <a href="{{ route('subadmin.pendaftaran.show', $p->id_pendaftaran) }}" class="p-2 text-slate-400 hover:text-cyan-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-20 text-center">
                        <div class="opacity-30">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <p class="text-sm font-bold">Belum Ada Peserta Terdaftar</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
