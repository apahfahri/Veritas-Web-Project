@extends('layouts.subadmin')

@section('title', 'Layanan')
@section('page-title', 'Daftar Layanan (Read-only)')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm select-none">
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Layanan Veritas</h3>
            <p class="text-xs text-slate-500 mt-0.5">Daftar semua layanan yang tersedia.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100/80">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Materi / Layanan</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Kategori</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Mode</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Lokasi</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Pemateri</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($layanans as $l)
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="p-4 text-sm font-bold text-slate-900">{{ $l->materi }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">
                        <span class="bg-slate-100 px-2 py-0.5 rounded text-[10px] font-bold">{{ $l->kategori?->nama }}</span>
                    </td>
                    <td class="p-4 text-sm font-medium text-slate-600">
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $l->jenis_pertemuan === 'online' ? 'bg-blue-50 text-blue-600' : 'bg-orange-50 text-orange-600' }}">
                            {{ ucfirst($l->jenis_pertemuan) }}
                        </span>
                    </td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $l->lokasi ?? '-' }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">
                        <div class="flex flex-wrap gap-1">
                            @foreach($l->pemateri as $p)
                                <span class="bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded text-[10px]">{{ $p->nama_lengkap }}</span>
                            @endforeach
                            @if($l->pemateri->isEmpty()) - @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-sm font-medium text-slate-500">Belum ada data layanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $layanans->links() }}
    </div>
</div>
@endsection
