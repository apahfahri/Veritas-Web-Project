@extends('layouts.admin')
@section('title', 'Manajemen Jadwal Pelatihan')
@section('page-title', 'Manajemen Jadwal Pelatihan')
@section('page-subtitle', 'Kelola semua jadwal program Pelatihan, Konsultasi, dan Audit')

@section('content')

@if(session('success'))
<div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-6 py-4 flex items-center gap-3 text-sm font-bold">
    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="flex flex-wrap justify-between items-end gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Jadwal</h2>
        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Total: {{ $jadwals->total() }} Jadwal Terdaftar</p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="openImportModal()"
                class="bg-white border border-slate-200 text-slate-700 px-6 py-3 rounded-2xl hover:bg-slate-50 transition shadow-sm flex items-center gap-2 text-sm font-black group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Import CSV
        </button>
        <a href="{{ route('admin.jadwal.create') }}"
           class="bg-slate-900 text-white px-6 py-3 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center gap-2 text-sm font-black group">
            <svg class="w-5 h-5 text-cyan-400 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Tambah Jadwal Baru
        </a>
    </div>
</div>

<div class="mb-5 bg-white p-1.5 rounded-2xl shadow-sm border border-slate-100 inline-flex gap-1">
    <a href="{{ route('admin.jadwal.index', ['filter' => 'akan_datang']) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ (!isset($filter) || $filter === 'akan_datang') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">Akan Datang</a>
    <a href="{{ route('admin.jadwal.index', ['filter' => 'riwayat']) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ (isset($filter) && $filter === 'riwayat') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">Riwayat</a>
    <a href="{{ route('admin.jadwal.index', ['filter' => 'semua']) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ (isset($filter) && $filter === 'semua') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">Semua</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse" style="min-width:860px">
            <thead>
                <tr class="bg-slate-50/60 border-b border-slate-100">
                    <th class="px-4 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest w-32">Kategori</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest">Program Layanan</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest w-36">Pemateri</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center w-24">Mode</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest w-36">Tanggal</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest w-28">Harga</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center w-24">Kapasitas</th>
                    <th class="px-4 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest text-center w-28">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($jadwals as $j)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex bg-slate-900 text-cyan-400 text-[9px] font-black px-2 py-1 rounded-lg tracking-widest shrink-0">
                                {{ $j->kategori?->kode_kategori ?? '???' }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-600 hidden xl:block truncate max-w-[80px]">{{ $j->kategori?->nama }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            @if($j->foto)
                                <div class="w-9 h-9 rounded-xl overflow-hidden shadow-sm border border-slate-100 shrink-0">
                                    <img src="{{ asset('storage/' . $j->foto) }}" alt="{{ $j->jenis?->nama }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-9 h-9 rounded-xl bg-slate-50 text-slate-300 flex items-center justify-center border border-slate-100 shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <span class="text-[12px] font-black text-slate-900 leading-tight block truncate max-w-[200px]">{{ $j->jenis?->nama ?? '—' }}</span>
                                @if($j->jenis?->kode_jenis)
                                <span class="block text-[9px] text-indigo-500 font-black tracking-widest mt-0.5">{{ $j->jenis->kode_jenis }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-col gap-0.5">
                            @forelse($j->pemateri as $pm)
                            <span class="text-[11px] font-medium text-slate-600 whitespace-nowrap">{{ $pm->nama_lengkap }}</span>
                            @empty
                            <span class="text-[11px] text-slate-300 font-bold">—</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="px-4 py-3 text-center whitespace-nowrap">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $j->jenis_pertemuan === 'online' ? 'bg-cyan-50 text-cyan-700 border border-cyan-100' : ($j->jenis_pertemuan === 'hybrid' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 'bg-amber-50 text-amber-700 border border-amber-100') }}">
                            {{ $j->jenis_pertemuan }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="text-[11px] font-bold text-slate-700">
                            {{ $j->tgl_mulai?->format('d M Y') ?? '—' }}
                        </div>
                        @if($j->tgl_selesai && $j->tgl_selesai != $j->tgl_mulai)
                        <div class="text-[10px] text-slate-400 font-bold">s.d. {{ $j->tgl_selesai->format('d M Y') }}</div>
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
                        <div class="mt-1.5">
                            @if($isPast)
                                <span class="inline-flex bg-slate-100 text-slate-500 text-[9px] font-black px-2 py-0.5 rounded tracking-widest">SELESAI</span>
                            @elseif($isOngoing)
                                <span class="inline-flex bg-emerald-100 text-emerald-700 text-[9px] font-black px-2 py-0.5 rounded tracking-widest">BERJALAN</span>
                            @else
                                <span class="inline-flex bg-indigo-100 text-indigo-700 text-[9px] font-black px-2 py-0.5 rounded tracking-widest">AKAN DATANG</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span class="text-[12px] font-black text-slate-900">
                            {{ $j->harga > 0 ? 'Rp ' . number_format($j->harga, 0, ',', '.') : 'Gratis' }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center whitespace-nowrap">
                        @if($j->kapasitas)
                        <div class="flex flex-col items-center">
                            <span class="text-[12px] font-black text-slate-900">{{ $j->sisa_kursi }}/{{ $j->kapasitas }}</span>
                            <span class="text-[9px] text-slate-400 font-bold">sisa kursi</span>
                        </div>
                        @else
                        <span class="text-[11px] text-slate-300 font-bold">∞</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('admin.jadwal.show', $j->id_jadwal) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:border-cyan-500 hover:text-cyan-600 hover:shadow-lg hover:shadow-cyan-50 transition shadow-sm" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('admin.jadwal.edit', $j->id_jadwal) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:border-indigo-500 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition shadow-sm" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.jadwal.destroy', $j->id_jadwal) }}" class="delete-form" data-name="{{ $j->jenis?->nama }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white border border-slate-200 text-slate-400 hover:border-red-500 hover:text-red-500 hover:shadow-lg hover:shadow-red-50 transition shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="py-14 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-14 h-14 bg-slate-50 text-slate-200 rounded-2xl flex items-center justify-center mb-3">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Belum ada jadwal</p>
                        <a href="{{ route('admin.jadwal.create') }}" class="mt-3 text-xs font-bold text-indigo-600 hover:underline">Tambah Jadwal Pertama</a>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jadwals->count())
    <div class="px-5 py-3.5 border-t border-slate-100 bg-slate-50/30 flex flex-col sm:flex-row items-center justify-between gap-3">
        <p class="text-[11px] font-medium text-slate-500 whitespace-nowrap">
            Menampilkan
            <span class="font-black text-slate-800">{{ $jadwals->firstItem() }}–{{ $jadwals->lastItem() }}</span>
            dari
            <span class="font-black text-slate-800">{{ $jadwals->total() }}</span>
            jadwal
        </p>

        {{-- Navigasi halaman (hanya jika ada lebih dari 1 halaman) --}}
        @if($jadwals->hasPages())
        <div class="flex items-center gap-1">
            @if($jadwals->onFirstPage())
                <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-lg cursor-not-allowed bg-white select-none">‹</span>
            @else
                <a href="{{ $jadwals->previousPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-lg hover:border-indigo-400 hover:text-indigo-600 transition bg-white">‹</a>
            @endif
            @php $cur = $jadwals->currentPage(); $last = $jadwals->lastPage(); $prev = null; @endphp
            @for($i = 1; $i <= $last; $i++)
                @if($i === 1 || $i === $last || ($i >= $cur - 2 && $i <= $cur + 2))
                    @if($prev !== null && $i - $prev > 1)
                        <span class="px-1.5 py-1.5 text-[11px] font-black text-slate-400 select-none">…</span>
                    @endif
                    @if($i === $cur)
                        <span class="px-3 py-1.5 text-[11px] font-black text-white bg-slate-900 rounded-lg select-none">{{ $i }}</span>
                    @else
                        <a href="{{ $jadwals->url($i) }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-lg hover:border-indigo-400 hover:text-indigo-600 transition bg-white">{{ $i }}</a>
                    @endif
                    @php $prev = $i; @endphp
                @endif
            @endfor
            @if($jadwals->hasMorePages())
                <a href="{{ $jadwals->nextPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-lg hover:border-indigo-400 hover:text-indigo-600 transition bg-white">›</a>
            @else
                <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-lg cursor-not-allowed bg-white select-none">›</span>
            @endif
        </div>
        @endif
    </div>
    @endif
</div>

{{-- MODAL: Import Data --}}
<div id="importModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-md p-8 border border-slate-100">
        <h3 class="text-xl font-black text-slate-900 mb-1">Import Jadwal Pelatihan</h3>
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-7">Unggah file CSV untuk mengimport data jadwal pelatihan</p>
        <form action="{{ route('admin.jadwal.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Pilih File CSV *</label>
                <input type="file" name="csv_file" required accept=".csv,text/csv"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl text-xs text-slate-500 space-y-2 border border-slate-100 overflow-x-auto">
                <p class="font-bold text-slate-700">Format Kolom CSV:</p>
                <code class="block bg-white p-2 rounded-xl border border-slate-200/60 text-[9px] text-indigo-600 font-black leading-relaxed whitespace-nowrap">kode_kategori, kode_jenis, jenis_pertemuan, tgl_mulai, tgl_selesai, jam_pertemuan, lokasi, kapasitas, harga, deskripsi, link_meet</code>
                <p class="text-[10px]">*) Kolom jenis_pertemuan diisi dengan: <span class="font-bold text-slate-700">online</span>, <span class="font-bold text-slate-700">offline</span>, atau <span class="font-bold text-slate-700">hybrid</span>.</p>
                <a href="{{ route('admin.jadwal.import-template') }}" class="inline-flex items-center gap-1.5 text-indigo-600 hover:underline font-bold mt-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Unduh Template CSV
                </a>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeImportModal()" class="flex-1 px-5 py-3 text-xs font-black text-slate-400 hover:text-slate-600 transition uppercase tracking-widest">Batal</button>
                <button type="submit" class="flex-1 bg-slate-900 text-white px-5 py-3 rounded-2xl text-xs font-black hover:bg-slate-800 transition uppercase tracking-widest">Import</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.delete-form').forEach(form => {
    form.addEventListener('submit', e => {
        if (!confirm(`Hapus jadwal "${form.dataset.name}"? Semua pendaftaran terkait juga akan terhapus.`)) {
            e.preventDefault();
        }
    });
});

// IMPORT CSV
function openImportModal() {
    document.getElementById('importModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}
function closeImportModal() {
    document.getElementById('importModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}
window.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeImportModal();
});
</script>
@endpush
