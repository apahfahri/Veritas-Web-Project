@extends('layouts.admin')
@section('title', 'Kelola Materi')
@section('page-title', 'Daftar Materi Pelatihan')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-7 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
        <h2 class="text-xl font-black text-slate-900">Data Materi</h2>
        <a href="{{ route('admin.materi.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 hover:shadow-indigo-600/40 transition-all duration-300">
            + Tambah Materi Baru
        </a>
    </div>

    @if(session('success'))
        <div class="m-7 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-7">
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <th class="px-6 py-4 border-b border-slate-100">No</th>
                        <th class="px-6 py-4 border-b border-slate-100">Judul Materi</th>
                        <th class="px-6 py-4 border-b border-slate-100">Deskripsi</th>
                        <th class="px-6 py-4 border-b border-slate-100">File</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-medium text-slate-600">
                    @forelse($materis as $m)
                    <tr class="hover:bg-slate-50 transition border-b border-slate-50 last:border-none">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $m->judul }}</td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ Str::limit($m->deskripsi, 50) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ Storage::url($m->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-xs font-bold underline">Lihat PDF</a>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.materi.edit', $m->id_materi) }}" class="inline-flex items-center justify-center bg-amber-100 text-amber-700 hover:bg-amber-200 px-4 py-2 rounded-lg text-xs font-bold transition">Edit</a>
                            <form action="{{ route('admin.materi.destroy', $m->id_materi) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus materi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center bg-red-100 text-red-700 hover:bg-red-200 px-4 py-2 rounded-lg text-xs font-bold transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada data materi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
