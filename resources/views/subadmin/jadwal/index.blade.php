@extends('layouts.subadmin')

@section('title', 'Jadwal Pelatihan')
@section('page-title', 'Manajemen Jadwal Pelatihan')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <p class="text-sm text-slate-500 font-medium">Kelola waktu dan lokasi pelaksanaan pelatihan di cabang Anda.</p>
    </div>
    <a href="{{ route('subadmin.jadwal.create') }}" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-extrabold text-sm px-6 py-3.5 rounded-xl shadow-lg shadow-cyan-600/20 transition flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Buat Jadwal Baru
    </a>
</div>

<div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden select-none">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100">
                <th class="px-6 py-5 text-xs font-extrabold text-slate-500 uppercase tracking-wider">Layanan / Materi</th>
                <th class="px-6 py-5 text-xs font-extrabold text-slate-500 uppercase tracking-wider">Waktu Pelaksanaan</th>
                <th class="px-6 py-5 text-xs font-extrabold text-slate-500 uppercase tracking-wider">Lokasi</th>
                <th class="px-6 py-5 text-xs font-extrabold text-slate-500 uppercase tracking-wider">Kuota</th>
                <th class="px-6 py-5 text-xs font-extrabold text-slate-500 uppercase tracking-wider text-center">Status</th>
                <th class="px-6 py-5 text-xs font-extrabold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($jadwals as $j)
            <tr class="hover:bg-slate-50/50 transition group">
                <td class="px-6 py-5">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-slate-900">{{ $j->layanan?->nama ?? 'Layanan' }}</span>
                        <span class="text-[11px] text-slate-500 mt-0.5">{{ $j->layanan?->materi }}</span>
                    </div>
                </td>
                <td class="px-6 py-5">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($j->tanggal)->format('d M Y') }}</span>
                        <span class="text-[11px] text-slate-500 mt-0.5">{{ $j->jam_mulai }} - {{ $j->jam_selesai }}</span>
                    </div>
                </td>
                <td class="px-6 py-5">
                    <span class="text-sm font-medium text-slate-700">{{ $j->lokasi }}</span>
                </td>
                <td class="px-6 py-5">
                    <div class="flex items-center gap-2">
                        <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                            @php $percent = ($j->pendaftarans_count ?? 0) / ($j->kuota ?: 1) * 100; @endphp
                            <div class="h-full bg-cyan-500 rounded-full" style="width: {{ $percent }}%"></div>
                        </div>
                        <span class="text-xs font-bold text-slate-600">{{ $j->pendaftarans_count ?? 0 }}/{{ $j->kuota }}</span>
                    </div>
                </td>
                <td class="px-6 py-5 text-center">
                    @php
                        $statusColors = [
                            'aktif' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            'penuh' => 'bg-amber-50 text-amber-600 border-amber-100',
                            'selesai' => 'bg-slate-50 text-slate-600 border-slate-100',
                            'batal' => 'bg-red-50 text-red-600 border-red-100',
                        ];
                        $color = $statusColors[strtolower($j->status)] ?? $statusColors['aktif'];
                    @endphp
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $color }}">
                        {{ $j->status }}
                    </span>
                </td>
                <td class="px-6 py-5 text-right">
                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition">
                        <a href="{{ route('subadmin.jadwal.edit', $j->id_jadwal) }}" class="p-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:text-cyan-600 hover:border-cyan-200 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <form action="{{ route('subadmin.jadwal.destroy', $j->id_jadwal) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-white border border-slate-200 rounded-xl text-slate-600 hover:text-red-600 hover:border-red-200 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-20 text-center">
                    <div class="flex flex-col items-center justify-center opacity-40">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-lg font-bold">Belum Ada Jadwal</p>
                        <p class="text-sm">Silakan buat jadwal pelatihan pertama Anda.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $jadwals->links() }}
</div>
@endsection

