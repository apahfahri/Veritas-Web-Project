@extends('layouts.admin-cabang')

@section('title', 'Layanan')
@section('page-title', 'Daftar Layanan (Read-only)')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm select-none">
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Layanan Veritas</h3>
            <p class="text-xs text-slate-500 mt-0.5">Daftar semua layanan yang tersedia untuk dipesan oleh klien.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100/80">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Nama Layanan</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Deskripsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($layanans as $l)
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="p-4 text-sm font-bold text-slate-900">{{ $l->nama }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $l->deskripsi ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="p-4 text-center text-sm font-medium text-slate-500">Belum ada data layanan.</td>
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
