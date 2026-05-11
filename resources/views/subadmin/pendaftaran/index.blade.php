@extends('layouts.subadmin')

@section('title', 'Manajemen Pendaftaran')
@section('page-title', 'Daftar Pendaftaran')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
    <div class="flex flex-col md:flex-row justify-between gap-4 mb-6 select-none">
        <form method="GET" action="{{ route('subadmin.pendaftaran.index') }}" class="flex flex-wrap items-center gap-3">
            <select name="status" class="bg-slate-50 border border-slate-200/80 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
                <option value="">Semua Progres</option>
                <option value="menunggu_pembayaran" {{ request('status') == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition">
                Saring Data
            </button>
        </form>
    </div>

    <div class="overflow-x-auto select-none">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100/80">
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">ID</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Layanan</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Klien</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Tanggal Daftar</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Status Progres</th>
                    <th class="p-4 text-xs font-black uppercase text-slate-500 tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pendaftarans as $p)
                <tr class="hover:bg-slate-50/60 transition">
                    <td class="p-4 text-sm font-bold text-slate-900">#{{ $p->id_pendaftaran }}</td>
                    <td class="p-4 text-sm font-bold text-slate-800">{{ $p->layanan?->materi }}</td>
                    <td class="p-4 text-sm font-medium text-slate-600">
                        {{ $p->user?->nama }}<br>
                        <span class="text-xs text-slate-400">{{ $p->user?->email }}</span>
                    </td>
                    <td class="p-4 text-sm font-medium text-slate-600">
                        {{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d M Y') : '-' }}
                    </td>
                    <td class="p-4 text-sm font-semibold">
                        @if($p->status_progres == 'menunggu_pembayaran')
                            <span class="text-xs bg-amber-100 text-amber-800 px-2.5 py-1 rounded-full font-bold">Menunggu Bayar</span>
                        @elseif($p->status_progres == 'diproses')
                            <span class="text-xs bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full font-bold">Diproses</span>
                        @elseif($p->status_progres == 'selesai')
                            <span class="text-xs bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-full font-bold">Selesai</span>
                        @else
                            <span class="text-xs bg-red-100 text-red-800 px-2.5 py-1 rounded-full font-bold">{{ ucfirst($p->status_progres) }}</span>
                        @endif
                    </td>
                    <td class="p-4 text-sm font-medium flex items-center gap-2">
                        <a href="{{ route('subadmin.pendaftaran.show', $p->id_pendaftaran) }}" class="bg-cyan-50 hover:bg-cyan-100 text-cyan-600 px-3.5 py-1.5 rounded-xl text-xs font-black transition">
                            Detail
                        </a>
                        <form action="{{ route('subadmin.pendaftaran.destroy', $p->id_pendaftaran) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pendaftaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3.5 py-1.5 rounded-xl text-xs font-black transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-sm font-medium text-slate-500">Tidak ada data pendaftaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $pendaftarans->links() }}
    </div>
</div>
@endsection


