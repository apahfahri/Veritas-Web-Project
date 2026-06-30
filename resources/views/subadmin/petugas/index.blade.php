@extends('layouts.subadmin')

@section('title', 'Pemateri')
@section('page-title', 'Daftar Pemateri (Read-only)')

@section('content')
<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden select-none">
    <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between gap-4 bg-slate-50/30 border-b border-slate-100">
        <form method="GET" action="{{ route('subadmin.petugas.index') }}" class="flex flex-wrap items-center gap-3 w-full">
            <div class="relative flex-1 min-w-[200px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fi fi-rr-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pemateri..." class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
            </div>
            <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                <i class="fi fi-rr-search"></i> Cari Data
            </button>
            @if(request()->filled('search'))
                <a href="{{ route('subadmin.petugas.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-4 py-2.5 rounded-xl transition">Reset</a>
            @endif
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Lengkap</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Email</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">No HP</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Kompetensi</th>
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

    <div class="p-6 border-t border-slate-100 flex justify-center">
        {{ $pemateris->links() }}
    </div>
</div>
@endsection
