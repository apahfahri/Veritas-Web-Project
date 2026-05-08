@extends('layouts.admin-cabang')

@section('title', 'Petugas')
@section('page-title', 'Daftar Petugas (Read-only)')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm select-none">
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Petugas Veritas</h3>
            <p class="text-xs text-slate-500 mt-0.5">Daftar semua petugas/instruktur aktif di Katiga Veritas Indonesia.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100/80">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Nama Lengkap</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Spesialisasi</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">No HP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($petugases as $p)
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="p-4 text-sm font-bold text-slate-900">{{ $p->nama_lengkap }}</td>
                    <td class="p-4 text-sm font-bold text-slate-800">{{ $p->spesialisasi ?? '-' }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $p->no_hp ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-sm font-medium text-slate-500">Belum ada data petugas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $petugases->links() }}
    </div>
</div>
@endsection
