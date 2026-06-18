@extends('layouts.admin')
@section('title', 'Manajemen Jadwal Pelatihan')
@section('page-title', 'Manajemen Jadwal Pelatihan')
@section('page-subtitle', 'Kelola semua jadwal program Pelatihan, Konsultasi, dan Audit')

@section('content')

@if(session('success'))
<div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-6 py-4 flex items-center gap-3 text-sm font-bold">
    <i class="fi fi-rr-check text-emerald-500"></i>
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
            <i class="fi fi-rr-upload text-slate-400 group-hover:text-slate-600 transition"></i>
            Import CSV
        </button>
        <a href="{{ route('admin.jadwal.create') }}"
           class="bg-slate-900 text-white px-6 py-3 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center gap-2 text-sm font-black group">
            <i class="fi fi-rr-plus text-cyan-400 group-hover:rotate-90 transition-transform duration-300"></i>
            Tambah Jadwal Baru
        </a>
    </div>
</div>

<div class="mb-6 bg-white p-1.5 rounded-2xl shadow-sm border border-slate-100 inline-flex gap-1">
    <a href="{{ route('admin.jadwal.index', ['filter' => 'akan_datang']) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ (!isset($filter) || $filter === 'akan_datang') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">Akan Datang</a>
    <a href="{{ route('admin.jadwal.index', ['filter' => 'riwayat']) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ (isset($filter) && $filter === 'riwayat') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">Riwayat</a>
    <a href="{{ route('admin.jadwal.index', ['filter' => 'semua']) }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ (isset($filter) && $filter === 'semua') ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">Semua</a>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/60 border-b border-slate-100">
                    <th class="p-5 text-[11px] font-black text-slate-500 uppercase tracking-widest">Kategori</th>
                    <th class="p-5 text-[11px] font-black text-slate-500 uppercase tracking-widest">Program Layanan</th>
                    <th class="p-5 text-[11px] font-black text-slate-500 uppercase tracking-widest">Pemateri</th>
                    <th class="p-5 text-[11px] font-black text-slate-500 uppercase tracking-widest text-center">Mode</th>
                    <th class="p-5 text-[11px] font-black text-slate-500 uppercase tracking-widest">Tanggal</th>
                    <th class="p-5 text-[11px] font-black text-slate-500 uppercase tracking-widest">Harga</th>
                    <th class="p-5 text-[11px] font-black text-slate-500 uppercase tracking-widest text-center">Kapasitas</th>
                    <th class="p-5 text-[11px] font-black text-slate-500 uppercase tracking-widest text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($jadwals as $j)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="p-5">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex bg-slate-900 text-cyan-400 text-[9px] font-black px-2 py-1 rounded-lg tracking-widest">
                                {{ $j->kategori?->kode_kategori ?? '???' }}
                            </span>
                            <span class="text-[11px] font-bold text-slate-600 hidden xl:block">{{ $j->kategori?->nama }}</span>
                        </div>
                    </td>
                    <td class="p-5">
                        <div class="flex items-center gap-3">
                            @if($j->foto)
                                <div class="w-10 h-10 rounded-xl overflow-hidden shadow-sm border border-slate-100 shrink-0">
                                    <img src="{{ asset('storage/' . $j->foto) }}" alt="{{ $j->jenis?->nama }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-300 flex items-center justify-center border border-slate-100 shrink-0">
                                    <i class="fi fi-rr-picture"></i>
                                </div>
                            @endif
                            <div>
                                <span class="text-sm font-black text-slate-900 leading-tight">{{ $j->jenis?->nama ?? '—' }}</span>
                                @if($j->jenis?->kode_jenis)
                                <span class="block text-[9px] text-indigo-500 font-black tracking-widest mt-0.5">{{ $j->jenis->kode_jenis }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="p-5">
                        <div class="flex flex-col gap-0.5">
                            @forelse($j->pemateri as $pm)
                            <span class="text-[11px] font-medium text-slate-600">{{ $pm->nama_lengkap }}</span>
                            @empty
                            <span class="text-[11px] text-slate-300 font-bold">—</span>
                            @endforelse
                        </div>
                    </td>
                    <td class="p-5 text-center">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $j->jenis_pertemuan === 'online' ? 'bg-cyan-50 text-cyan-700 border border-cyan-100' : ($j->jenis_pertemuan === 'hybrid' ? 'bg-purple-50 text-purple-700 border border-purple-100' : 'bg-amber-50 text-amber-700 border border-amber-100') }}">
                            {{ $j->jenis_pertemuan }}
                        </span>
                    </td>
                    <td class="p-5">
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
                        <div class="mt-2">
                            @if($isPast)
                                <span class="inline-flex bg-slate-100 text-slate-500 text-[9px] font-black px-2 py-0.5 rounded tracking-widest">SELESAI</span>
                            @elseif($isOngoing)
                                <span class="inline-flex bg-emerald-100 text-emerald-700 text-[9px] font-black px-2 py-0.5 rounded tracking-widest">BERJALAN</span>
                            @else
                                <span class="inline-flex bg-indigo-100 text-indigo-700 text-[9px] font-black px-2 py-0.5 rounded tracking-widest">AKAN DATANG</span>
                            @endif
                        </div>
                    </td>
                    <td class="p-5">
                        <span class="text-sm font-black text-slate-900">
                            {{ $j->harga > 0 ? 'Rp ' . number_format($j->harga, 0, ',', '.') : 'Gratis' }}
                        </span>
                    </td>
                    <td class="p-5 text-center">
                        @if($j->kapasitas)
                        <div class="flex flex-col items-center">
                            <span class="text-sm font-black text-slate-900">{{ $j->sisa_kursi }}/{{ $j->kapasitas }}</span>
                            <span class="text-[9px] text-slate-400 font-bold">sisa kursi</span>
                        </div>
                        @else
                        <span class="text-[11px] text-slate-300 font-bold">∞</span>
                        @endif
                    </td>
                    <td class="p-5">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.jadwal.show', $j->id_jadwal) }}"
                               class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-cyan-500 hover:text-cyan-600 hover:shadow-lg hover:shadow-cyan-50 transition shadow-sm" title="Detail">
                                <i class="fi fi-rr-eye"></i>
                            </a>
                            <a href="{{ route('admin.jadwal.edit', $j->id_jadwal) }}"
                               class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-indigo-500 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition shadow-sm" title="Edit">
                                <i class="fi fi-rr-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.jadwal.destroy', $j->id_jadwal) }}" class="delete-form" data-name="{{ $j->jenis?->nama }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-red-500 hover:text-red-500 hover:shadow-lg hover:shadow-red-50 transition shadow-sm">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="p-20 text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mb-4">
                            <i class="fi fi-rr-calendar"></i>
                        </div>
                        <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Belum ada jadwal</p>
                        <a href="{{ route('admin.jadwal.create') }}" class="mt-4 text-xs font-bold text-indigo-600 hover:underline">Tambah Jadwal Pertama</a>
                    </div>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jadwals->count())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/40 flex items-center justify-between gap-4">
        {{-- Info halaman --}}
        <p class="text-[13px] font-bold text-slate-900 tracking-widest whitespace-nowrap">
            Menampilkan
            <span class="text-slate-900">{{ $jadwals->firstItem() }}–{{ $jadwals->lastItem() }}</span>
            dari
            <span class="text-slate-900">{{ $jadwals->total() }}</span>
            data
        </p>

        {{-- Navigasi halaman (hanya jika ada lebih dari 1 halaman) --}}
        @if($jadwals->hasPages())
        <div class="flex items-center gap-1">
            {{-- Prev --}}
            @if($jadwals->onFirstPage())
                <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-100 text-slate-300 cursor-not-allowed">
                    <i class="fi fi-rr-angle-left"></i>
                </span>
            @else
                <a href="{{ $jadwals->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:border-indigo-500 hover:text-indigo-600 hover:shadow-sm transition">
                    <i class="fi fi-rr-angle-left"></i>
                </a>
            @endif

            {{-- Nomor halaman --}}
            @foreach($jadwals->getUrlRange(1, $jadwals->lastPage()) as $page => $url)
                @if($page == $jadwals->currentPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl bg-slate-900 text-white text-[12px] font-black shadow-sm">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 text-[12px] font-bold hover:border-indigo-500 hover:text-indigo-600 hover:shadow-sm transition">
                        {{ $page }}
                    </a>
                @endif
            @endforeach

            {{-- Next --}}
            @if($jadwals->hasMorePages())
                <a href="{{ $jadwals->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:border-indigo-500 hover:text-indigo-600 hover:shadow-sm transition">
                    <i class="fi fi-rr-angle-right"></i>
                </a>
            @else
                <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-100 text-slate-300 cursor-not-allowed">
                    <i class="fi fi-rr-angle-right"></i>
                </span>
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
                    <i class="fi fi-rr-download"></i>
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
