@extends('layouts.subadmin')

@section('title', 'Pelatihan')
@section('page-title', 'Daftar Pelatihan')

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
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Nama Pelatihan</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Materi</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Pemateri</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Jenis</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pelatihans as $p)
                <tr class="hover:bg-slate-50/60 transition group">
                    <td class="p-4">
                        <div class="text-sm font-bold text-slate-900">{{ $p->nama }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $p->kategori?->nama }}</div>
                    </td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $p->materi }}</td>
                    <td class="p-4">
                        @forelse($p->pemateri as $pemateri)
                            <span class="inline-block bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-md font-bold mr-1">{{ $pemateri->nama_lengkap }}</span>
                        @empty
                            <span class="text-xs text-slate-400">-</span>
                        @endforelse
                    </td>
                    <td class="p-4">
                        @if($p->jenis_pertemuan == 'online')
                            <span class="text-[10px] bg-cyan-50 text-cyan-600 border border-cyan-100 px-2.5 py-1 rounded-full font-black uppercase tracking-wider">Online</span>
                        @else
                            <span class="text-[10px] bg-indigo-50 text-indigo-600 border border-indigo-100 px-2.5 py-1 rounded-full font-black uppercase tracking-wider">Offline</span>
                        @endif
                    </td>
                    <td class="p-4 text-right">
                        <a href="{{ route('subadmin.pelatihan.show', $p->id_layanan) }}" class="bg-slate-900 hover:bg-slate-800 text-white text-[10px] font-black uppercase tracking-[0.1em] px-4 py-2 rounded-lg shadow-sm transition">
                            Kelola Peserta
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-sm font-medium text-slate-400">Belum ada data pelatihan tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $pelatihans->links() }}
    </div>
</div>
@endsection
