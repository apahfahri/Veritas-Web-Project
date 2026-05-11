@extends('layouts.subadmin')

@section('title', 'Layanan Konsultasi')
@section('page-title', 'Manajemen Layanan Konsultasi')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm select-none">
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Konsultasi SMK3</h3>
            <p class="text-xs text-slate-500 mt-0.5">Daftar layanan konsultasi aktif.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100/80">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Nama Layanan</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Materi</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Jenis</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($konsultasis as $k)
                <tr class="hover:bg-slate-50/60 transition group">
                    <td class="p-4">
                        <div class="text-sm font-bold text-slate-900">{{ $k->nama }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $k->kategori?->nama }}</div>
                    </td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $k->materi }}</td>
                    <td class="p-4">
                        @if($k->jenis_pertemuan == 'online')
                            <span class="text-[10px] bg-cyan-50 text-cyan-600 border border-cyan-100 px-2.5 py-1 rounded-full font-black uppercase tracking-wider">Online</span>
                        @else
                            <span class="text-[10px] bg-indigo-50 text-indigo-600 border border-indigo-100 px-2.5 py-1 rounded-full font-black uppercase tracking-wider">Offline</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            @if($k->pending_count > 0)
                                <span class="bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full animate-pulse shadow-sm shadow-red-500/40">{{ $k->pending_count }}</span>
                            @endif
                            <a href="{{ route('subadmin.konsultasi.show', $k->id_layanan) }}" class="bg-slate-900 hover:bg-slate-800 text-white text-[10px] font-black uppercase tracking-[0.1em] px-4 py-2 rounded-lg shadow-sm transition">
                                Kelola Order
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-12 text-center text-sm font-medium text-slate-400">Belum ada data konsultasi tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $konsultasis->links() }}
    </div>
</div>
@endsection
