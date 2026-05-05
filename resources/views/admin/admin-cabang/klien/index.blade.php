@extends('layouts.admin-cabang')

@section('title', 'Daftar Klien')
@section('page-title', 'Daftar Klien Cabang')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm select-none">
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Klien Terdaftar</h3>
            <p class="text-xs text-slate-500 mt-0.5">Kelola data klien yang berafiliasi dengan cabang Anda.</p>
        </div>
        <a href="{{ route('admin-cabang.klien.create') }}" class="w-fit bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-extrabold text-sm px-6 py-3.5 rounded-xl shadow-lg transition">
            + Tambah Klien
        </a>
    </div>

    <div class="overflow-x-auto select-none">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100/80">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Nama Lengkap</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">NIK</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">No HP</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Cabang</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($kliens as $k)
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="p-4 text-sm font-bold text-slate-900">{{ $k->nama_lengkap }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $k->nik ?? '-' }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $k->no_hp ?? '-' }}</td>
                    <td class="p-4 text-sm font-semibold text-slate-600">{{ strtoupper($k->cabang) }}</td>
                    <td class="p-4 text-sm font-medium flex items-center gap-2">
                        <a href="{{ route('admin-cabang.klien.edit', $k->id) }}" class="bg-cyan-50 hover:bg-cyan-100 text-cyan-600 px-3.5 py-1.5 rounded-xl text-xs font-black transition">
                            Edit
                        </a>
                        <form action="{{ route('admin-cabang.klien.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus klien ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3.5 py-1.5 rounded-xl text-xs font-black transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-sm font-medium text-slate-500">Tidak ada data klien di cabang ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $kliens->links() }}
    </div>
</div>
@endsection
