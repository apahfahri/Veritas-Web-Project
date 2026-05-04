@extends('layouts.admin-cabang')

@section('title', 'Pelatihan')
@section('page-title', 'Daftar Pelatihan (Read-only)')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm select-none">
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Pelatihan Veritas</h3>
            <p class="text-xs text-slate-500 mt-0.5">Melihat daftar pelatihan yang aktif tanpa hak akses modifikasi.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100/80">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Materi</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Layanan</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Petugas</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Jenis Pertemuan</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pelatihans as $p)
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="p-4 text-sm font-bold text-slate-900">{{ $p->materi }}</td>
                    <td class="p-4 text-sm font-bold text-slate-800">{{ $p->layanan?->nama }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $p->petugas?->nama ?? '-' }}</td>
                    <td class="p-4 text-sm font-semibold">
                        @if($p->jenis_pertemuan == 'online')
                            <span class="text-xs bg-cyan-100 text-cyan-800 px-2.5 py-1 rounded-full font-bold">Online</span>
                        @else
                            <span class="text-xs bg-slate-100 text-slate-800 px-2.5 py-1 rounded-full font-bold">Offline</span>
                        @endif
                    </td>
                    <td class="p-4 text-sm font-medium text-slate-600">
                        {{ $p->tanggal_pertemuan ? \Carbon\Carbon::parse($p->tanggal_pertemuan)->format('d M Y') : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-sm font-medium text-slate-500">Belum ada pelatihan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $pelatihans->links() }}
    </div>
</div>
@endsection
