@extends('layouts.admin-cabang')

@section('title', 'Sertifikat Cabang')
@section('page-title', 'Daftar Sertifikat Terbit')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm select-none">
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Data Sertifikat</h3>
            <p class="text-xs text-slate-500 mt-0.5">Daftar semua sertifikat yang diterbitkan khusus di cabang Anda.</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100/80">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">No Sertifikat</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Nama Lengkap</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Layanan</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Tanggal Terbit</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($sertifikats as $s)
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="p-4 text-sm font-bold text-slate-900">{{ $s->no_sertifikat }}</td>
                    <td class="p-4 text-sm font-bold text-slate-800">{{ $s->nama_lengkap }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">{{ $s->pendaftaran?->layanan?->nama ?? '-' }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">
                        {{ $s->tanggal_terbit ? $s->tanggal_terbit->format('d M Y') : '-' }}
                    </td>
                    <td class="p-4 text-sm font-medium flex items-center gap-2">
                        <a href="{{ route('admin-cabang.sertifikat.edit', $s->no_sertifikat) }}" class="bg-cyan-50 hover:bg-cyan-100 text-cyan-600 px-3.5 py-1.5 rounded-xl text-xs font-black transition">
                            Edit
                        </a>
                        <form action="{{ route('admin-cabang.sertifikat.destroy', $s->no_sertifikat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3.5 py-1.5 rounded-xl text-xs font-black transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-4 text-center text-sm font-medium text-slate-500">Belum ada sertifikat yang diterbitkan di cabang ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $sertifikats->links() }}
    </div>
</div>
@endsection
