@extends('layouts.subadmin')

@section('title', 'Pemateri')
@section('page-title', 'Daftar Pemateri (Read-only)')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm select-none">
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Pemateri Veritas</h3>
            <p class="text-xs text-slate-500 mt-0.5">Daftar semua pemateri/instruktur aktif.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100/80">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Nama Lengkap</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Email</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">No HP</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Kompetensi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pemateris as $p)
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="p-4 text-sm font-bold text-slate-900">{{ $p->nama_lengkap }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $p->email }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $p->no_hp ?? '-' }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600 max-w-xs truncate">{{ $p->kompetensi ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-sm font-medium text-slate-500">Belum ada data pemateri.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $pemateris->links() }}
    </div>
</div>
@endsection
