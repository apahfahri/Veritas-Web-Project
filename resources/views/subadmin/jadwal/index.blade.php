@extends('layouts.subadmin')
@section('title', 'Jadwal Pelatihan')
@section('page-title', 'Jadwal Pelatihan')
@section('page-subtitle', 'Pantau jadwal program Pelatihan')

@section('content')

@if(session('success'))
<div class="mb-5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-5 py-3.5 flex items-center gap-3 text-sm font-bold">
    <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<form method="GET" class="flex flex-wrap gap-3 mb-6 items-end">
    <input type="hidden" name="filter" value="{{ request('filter', 'akan_datang') }}">
    <div class="flex-1 min-w-[200px]">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama program..."
               class="w-full bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
    </div>

    <select name="jenis_pertemuan" class="bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-sm font-bold focus:outline-none focus:border-indigo-500">
        <option value="">Semua Mode</option>
        <option value="online"  {{ request('jenis_pertemuan') == 'online'  ? 'selected' : '' }}>Online</option>
        <option value="offline" {{ request('jenis_pertemuan') == 'offline' ? 'selected' : '' }}>Offline</option>
        <option value="hybrid"  {{ request('jenis_pertemuan') == 'hybrid'  ? 'selected' : '' }}>Hybrid</option>
    </select>
    <button type="submit" class="px-5 py-2.5 bg-slate-900 text-white rounded-xl text-sm font-black hover:bg-slate-800 transition">Filter</button>
    <a href="{{ route('subadmin.jadwal.index') }}" class="px-4 py-2.5 text-slate-400 hover:text-slate-700 text-sm font-bold transition">Reset</a>
</form>

<div class="mb-4 bg-white p-1.5 rounded-2xl shadow-sm border border-slate-100 inline-flex gap-1">
    <a href="{{ route('subadmin.jadwal.index', array_merge(request()->except(['page', 'filter']), ['filter' => 'akan_datang'])) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ (!isset($filter) || $filter === 'akan_datang') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">Akan Datang</a>
    <a href="{{ route('subadmin.jadwal.index', array_merge(request()->except(['page', 'filter']), ['filter' => 'riwayat'])) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ (isset($filter) && $filter === 'riwayat') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">Riwayat</a>
    <a href="{{ route('subadmin.jadwal.index', array_merge(request()->except(['page', 'filter']), ['filter' => 'semua'])) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ (isset($filter) && $filter === 'semua') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">Semua</a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
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
                <tr class="hover:bg-slate-50/50 transition">
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
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('subadmin.jadwal.show', $j->id_jadwal) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-xl border border-slate-200 text-slate-400 hover:border-indigo-500 hover:text-indigo-600 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>

                            @if(!str_contains(strtolower($j->kategori?->nama ?? ''), 'pelatihan'))
                            <a href="{{ route('subadmin.jadwal.edit', $j->id_jadwal) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-xl border border-slate-200 text-slate-400 hover:border-amber-500 hover:text-amber-600 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('subadmin.jadwal.destroy', $j->id_jadwal) }}" class="delete-form" data-name="{{ $j->jenis?->nama }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-xl border border-slate-200 text-slate-400 hover:border-red-500 hover:text-red-500 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
    @if($jadwals->hasPages())
    <div class="p-4 border-t border-slate-50">{{ $jadwals->links() }}</div>
    @endif
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
