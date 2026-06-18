@extends('layouts.subadmin')
@section('title', 'Kelola Materi')
@section('page-title', 'Daftar Materi Pelatihan')

@section('content')
<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/30 border-b border-slate-100">
        <form method="GET" action="{{ route('subadmin.materi.index') }}" class="flex flex-wrap items-center gap-3 w-full md:flex-1">
            <div class="relative flex-1 min-w-[200px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fi fi-rr-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari materi..." class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
            </div>
            <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                <i class="fi fi-rr-search"></i> Cari Data
            </button>
            @if(request()->filled('search'))
                <a href="{{ route('subadmin.materi.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-4 py-2.5 rounded-xl transition">Reset</a>
            @endif
        </form>

        <a href="{{ route('subadmin.materi.create') }}" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-md transition whitespace-nowrap flex items-center gap-2">
            <i class="fi fi-rr-plus"></i> Tambah Materi
        </a>
    </div>

    @if(session('success'))
        <div class="m-7 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto select-none">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">No</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Judul Materi</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Deskripsi</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">File</th>
                    <th class="px-5 py-4 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($materis as $m)
                <tr class="hover:bg-slate-50/80 transition cursor-pointer group" onclick="window.open('{{ Storage::url($m->file_path) }}', '_blank')">
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $loop->iteration }}</td>
                    <td class="p-4 font-bold text-slate-800 text-sm">{{ $m->judul }}</td>
                    <td class="p-4 text-xs text-slate-500 max-w-xs truncate">{{ Str::limit($m->deskripsi, 50) }}</td>
                    <td class="p-4">
                        <a href="{{ Storage::url($m->file_path) }}" target="_blank" class="text-cyan-600 hover:text-cyan-800 text-xs font-black uppercase tracking-wider transition">Lihat PDF</a>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('subadmin.materi.edit', $m->id_materi) }}" onclick="event.stopPropagation()" class="text-cyan-600 hover:text-cyan-800 bg-cyan-50 hover:bg-cyan-100 w-8 h-8 rounded-lg flex items-center justify-center transition" title="Edit">
                                <i class="fi fi-rr-edit"></i>
                            </a>
                            <form action="{{ route('subadmin.materi.destroy', $m->id_materi) }}" method="POST" class="inline" onsubmit="event.stopPropagation(); return confirm('Yakin ingin menghapus materi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="event.stopPropagation()" class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 w-8 h-8 rounded-lg flex items-center justify-center transition" title="Hapus">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-slate-400 text-sm font-medium">Belum ada data materi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-6 border-t border-slate-100 flex justify-center">
        {{ $materis->links() }}
    </div>
</div>
@endsection
