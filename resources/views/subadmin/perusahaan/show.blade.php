@extends('layouts.subadmin')

@section('title', 'Detail Perusahaan')
@section('page-title', 'Detail Peserta: ' . $perusahaan->nama)

@section('content')
<div class="mb-8 flex items-center justify-between">
    <a href="{{ route('subadmin.perusahaan.index') }}" class="flex items-center gap-2 text-xs font-black text-slate-400 hover:text-slate-600 transition uppercase tracking-widest">
        <i class="fi fi-rr-arrow-left"></i> KEMBALI
    </a>
</div>

<div class="grid grid-cols-1 gap-8">
    <!-- List Peserta dari Perusahaan ini -->
    <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden select-none">
        <div class="p-6 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <h3 class="font-black text-slate-800 flex items-center gap-2">
                <i class="fi fi-rr-users text-indigo-600"></i>
                Daftar Peserta Perusahaan
            </h3>
            <span class="px-3 py-1 bg-white border border-slate-200 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-lg">
                {{ $pesertas->count() }} Orang
            </span>
        </div>

        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Peserta</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Layanan / Pelatihan</th>
                    <th class="px-5 py-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">Status</th>
                    <th class="px-5 py-4 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
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
                            <i class="fi fi-rr-angle-right"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-20 text-center">
                        <div class="opacity-30">
                            <i class="fi fi-rr-building w-16 h-16 mx-auto mb-4"></i>
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
