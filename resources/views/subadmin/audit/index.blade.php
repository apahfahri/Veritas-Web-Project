@extends('layouts.subadmin')

@section('title', 'Layanan Audit')
@section('page-title', 'Manajemen Audit K3 Korporat')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm select-none">
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Audit Eksternal & Internal</h3>
            <p class="text-xs text-slate-500 mt-0.5">Daftar layanan audit khusus perusahaan.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100/80">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Nama Audit</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Materi / Scope</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($audits as $a)
                <tr class="hover:bg-slate-50/60 transition group">
                    <td class="p-4">
                        <div class="text-sm font-bold text-slate-900">{{ $a->nama }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $a->kategori?->nama }}</div>
                    </td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $a->materi }}</td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            @if($a->pending_count > 0)
                                <span class="bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full animate-pulse shadow-sm shadow-red-500/40">{{ $a->pending_count }}</span>
                            @endif
                            <a href="{{ route('subadmin.audit.show', $a->id_layanan) }}" class="bg-slate-900 hover:bg-slate-800 text-white text-[10px] font-black uppercase tracking-[0.1em] px-4 py-2 rounded-lg shadow-sm transition">
                                Kelola Audit
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="p-12 text-center text-sm font-medium text-slate-400">Belum ada data audit tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $audits->links() }}
    </div>
</div>
@endsection
