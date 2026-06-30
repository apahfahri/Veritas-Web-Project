@extends('layouts.subadmin')
@section('title', 'Jadwal Pelatihan')
@section('page-title', 'Jadwal Pelatihan')
@section('page-subtitle', 'Pantau jadwal program Pelatihan')

@section('content')

@if(session('success'))
<div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-5 py-3.5 flex items-center gap-3 text-sm font-bold">
    <i class="fi fi-rr-check text-emerald-500"></i>
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 md:p-8 bg-slate-50/30 border-b border-slate-100 select-none">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
            <div class="flex border-b border-slate-200/50 gap-6 w-full md:w-auto">
                <a href="{{ route('subadmin.jadwal.index', array_merge(request()->except(['page', 'filter']), ['filter' => 'akan_datang'])) }}" class="pb-3 text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2 {{ (!isset($filter) || $filter === 'akan_datang') ? 'border-b-2 border-cyan-600 text-cyan-600' : 'text-slate-400 hover:text-slate-600' }}">
                    Akan Datang
                </a>
                <a href="{{ route('subadmin.jadwal.index', array_merge(request()->except(['page', 'filter']), ['filter' => 'riwayat'])) }}" class="pb-3 text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2 {{ (isset($filter) && $filter === 'riwayat') ? 'border-b-2 border-cyan-600 text-cyan-600' : 'text-slate-400 hover:text-slate-600' }}">
                    Riwayat
                </a>
                <a href="{{ route('subadmin.jadwal.index', array_merge(request()->except(['page', 'filter']), ['filter' => 'semua'])) }}" class="pb-3 text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2 {{ (isset($filter) && $filter === 'semua') ? 'border-b-2 border-cyan-600 text-cyan-600' : 'text-slate-400 hover:text-slate-600' }}">
                    Semua
                </a>
            </div>
            
            <a href="{{ route('subadmin.jadwal.create') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-md transition uppercase tracking-wider flex items-center gap-2">
                <i class="fi fi-rr-plus"></i> Tambah Jadwal
            </a>
        </div>

        <form method="GET" class="flex flex-wrap items-center gap-3 w-full">
            <input type="hidden" name="filter" value="{{ request('filter', 'akan_datang') }}">
            <div>
                <select name="jenis_pertemuan" class="bg-slate-50 border border-slate-200/80 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition cursor-pointer">
                    <option value="">Semua Mode</option>
                    <option value="online"  {{ request('jenis_pertemuan') == 'online'  ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ request('jenis_pertemuan') == 'offline' ? 'selected' : '' }}>Offline</option>
                    <option value="hybrid"  {{ request('jenis_pertemuan') == 'hybrid'  ? 'selected' : '' }}>Hybrid</option>
                </select>
            </div>
            <div class="relative flex-1 min-w-[200px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fi fi-rr-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama program..."
                       class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
            </div>
            <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                <i class="fi fi-rr-search"></i> Cari Data
            </button>
            <a href="{{ route('subadmin.jadwal.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-4 py-2.5 rounded-xl transition">Reset</a>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Program</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Mode</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Tanggal</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Kapasitas</th>
                    <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Pemateri</th>
                    <th class="px-5 py-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">Menunggu</th>
                    <th class="px-5 py-4 text-center text-[10px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($jadwals as $j)
                <tr class="hover:bg-slate-50/80 transition cursor-pointer group" onclick="window.location='{{ route('subadmin.jadwal.show', $j->id_jadwal) }}'">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="text-[9px] font-black bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded tracking-wider">{{ $j->kategori?->kode_kategori }}</span>
                            @if($j->jenis?->kode_jenis)
                            <span class="text-[9px] font-black bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded border border-indigo-100 tracking-wider">{{ $j->jenis->kode_jenis }}</span>
                            @endif
                        </div>
                        <p class="text-sm font-black text-slate-900">{{ $j->jenis?->nama ?? '—' }}</p>
                        @if($j->lokasi)<p class="text-[10px] text-slate-400 mt-0.5">{{ $j->lokasi }}</p>@endif
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex px-2 py-1 rounded-full text-[9px] font-black uppercase tracking-widest
                            {{ $j->jenis_pertemuan === 'online' ? 'bg-cyan-50 text-cyan-700' : ($j->jenis_pertemuan === 'hybrid' ? 'bg-purple-50 text-purple-700' : 'bg-amber-50 text-amber-700') }}">
                            {{ $j->jenis_pertemuan }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <p class="text-sm font-bold text-slate-700">{{ $j->tgl_mulai?->format('d M Y') ?? '—' }}</p>
                        @if($j->tgl_selesai && $j->tgl_selesai->ne($j->tgl_mulai))
                        <p class="text-[10px] text-slate-400">s.d. {{ $j->tgl_selesai->format('d M Y') }}</p>
                        @endif

                        @php
                            $isPast = false;
                            $isOngoing = false;
                            $now = now()->startOfDay();
                            $mulai = $j->tgl_mulai ? $j->tgl_mulai->startOfDay() : null;
                            $selesai = $j->tgl_selesai ? $j->tgl_selesai->startOfDay() : null;

                            if ($mulai) {
                                if ($selesai) {
                                    if ($selesai < $now) $isPast = true;
                                    elseif ($mulai <= $now && $selesai >= $now) $isOngoing = true;
                                } else {
                                    if ($mulai < $now) $isPast = true;
                                    elseif ($mulai == $now) $isOngoing = true;
                                }
                            }
                        @endphp
                        <div class="mt-2">
                            @if($isPast)
                                <span class="inline-flex bg-slate-100 text-slate-500 text-[8px] font-black px-1.5 py-0.5 rounded tracking-widest">SELESAI</span>
                            @elseif($isOngoing)
                                <span class="inline-flex bg-emerald-100 text-emerald-700 text-[8px] font-black px-1.5 py-0.5 rounded tracking-widest">BERJALAN</span>
                            @else
                                <span class="inline-flex bg-indigo-100 text-indigo-700 text-[8px] font-black px-1.5 py-0.5 rounded tracking-widest">AKAN DATANG</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-5 py-4">
                        @if($j->kapasitas)
                        <p class="text-sm font-black text-slate-900">{{ $j->sisa_kursi }}/{{ $j->kapasitas }}</p>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">sisa kursi</p>
                        @else
                        <span class="text-slate-300 font-bold">∞</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        @forelse($j->pemateri as $pm)
                        <span class="inline-block text-[10px] font-bold bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded mr-1 mb-1">{{ $pm->nama_lengkap }}</span>
                        @empty
                        <span class="text-[10px] text-slate-300 font-bold">—</span>
                        @endforelse
                    </td>
                    <td class="px-5 py-4 text-center">
                        @if($j->pending_count > 0)
                        <span class="inline-flex items-center justify-center bg-amber-100 text-amber-700 text-xs font-black w-7 h-7 rounded-lg">{{ $j->pending_count }}</span>
                        @else
                        <span class="text-slate-300 font-bold">0</span>
                        @endif
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('subadmin.jadwal.edit', $j->id_jadwal) }}" onclick="event.stopPropagation()" class="text-cyan-600 hover:text-cyan-800 bg-cyan-50 hover:bg-cyan-100 w-8 h-8 rounded-lg flex items-center justify-center transition" title="Edit">
                                <i class="fi fi-rr-edit"></i>
                            </a>
                            @if(!str_contains(strtolower($j->kategori?->nama ?? ''), 'pelatihan'))
                            <form action="{{ route('subadmin.jadwal.destroy', $j->id_jadwal) }}" method="POST" class="inline" onsubmit="event.stopPropagation(); return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="event.stopPropagation()" class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 w-8 h-8 rounded-lg flex items-center justify-center transition" title="Hapus">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-16 text-center">
                    <p class="text-sm font-black text-slate-300 uppercase tracking-widest">Belum ada jadwal tersedia</p>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-6 border-t border-slate-100 flex justify-center">
        {{ $jadwals->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', e => {
        if (!confirm(`Hapus jadwal "${form.dataset.name}"?`)) e.preventDefault();
    });
});
</script>
@endpush
