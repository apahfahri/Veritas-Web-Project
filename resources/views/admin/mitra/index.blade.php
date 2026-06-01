@extends('layouts.admin')
@section('title', 'Manajemen Daftar Perusahaan')
@section('page-title', 'Manajemen Daftar Perusahaan')
@section('page-subtitle', 'Kelola data kemitraan B2B (Perusahaan)')

@section('content')
<div class="flex flex-wrap justify-between items-end gap-4 mb-8">
    <!-- FILTER & SEARCH -->
    <form method="GET" action="{{ route('admin.mitra.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
        <div class="relative min-w-[280px]">
            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Mitra atau CP..." 
                   class="w-full pl-11 pr-4 py-3 rounded-2xl bg-white border border-slate-200 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
        </div>

        <select name="sektor" onchange="this.form.submit()" 
                class="px-4 py-3 rounded-2xl bg-white border border-slate-200 text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
            <option value="">Semua Sektor Industri</option>
            @foreach($sektors as $sektor)
                <option value="{{ $sektor }}" {{ request('sektor') == $sektor ? 'selected' : '' }}>{{ $sektor }}</option>
            @endforeach
        </select>

        @if(request()->filled('search') || request()->filled('sektor'))
            <a href="{{ route('admin.mitra.index') }}" class="px-5 py-3 rounded-2xl bg-slate-200 text-slate-700 hover:bg-slate-300 text-sm font-black transition">Reset</a>
        @endif
    </form>

    <div class="flex items-center gap-3">
        <button onclick="openImportModal()"
                class="bg-white border border-slate-200 text-slate-700 px-6 py-3 rounded-2xl hover:bg-slate-50 transition shadow-sm flex items-center gap-2 text-sm font-black group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Import CSV
        </button>
        <a href="{{ route('admin.mitra.create') }}" 
           class="bg-slate-900 text-white px-6 py-3 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center gap-2 text-sm font-black group">
            <svg class="w-5 h-5 text-emerald-400 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Klien/Mitra
        </a>
    </div>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Nama Perusahaan</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Sektor Industri</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Alamat</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Contact Person</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Jabatan</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Jml Karyawan</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($mitras as $mitra)
                @php
                    $cp = $mitra->klienPerusahaan->first();
                @endphp
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="p-6">
                        <span class="text-[12px] font-black text-slate-950">{{ $mitra->nama }}</span>
                    </td>
                    <td class="p-6">
                        <span class="text-[12px] font-medium text-slate-700">{{ $mitra->sektor_industri ?? '—' }}</span>
                    </td>
                    <td class="p-6 max-w-xs truncate">
                        <span class="text-[12px] font-medium text-slate-500" title="{{ $mitra->alamat }}">{{ $mitra->alamat ?? '—' }}</span>
                    </td>
                    <td class="p-6">
                        @if($cp)
                            <div class="flex flex-col">
                                <span class="text-[12px] font-black text-slate-900">{{ $cp->nama_cp_aktif }}</span>
                                <span class="text-[11px] font-medium text-slate-500">
                                    {{ $cp->id_user ? ($cp->user?->no_telp ?? '—') : ($cp->no_hp_cp ?? '—') }}
                                </span>
                            </div>
                        @else
                            <span class="text-[12px] font-medium text-slate-400">Belum Ada CP</span>
                        @endif
                    </td>
                    <td class="p-6">
                        <span class="text-[12px] font-medium text-slate-700">{{ $cp->jabatan ?? '—' }}</span>
                    </td>
                    <td class="p-6 text-center">
                        <span class="text-[12px] font-bold text-slate-800">{{ $mitra->jumlah_karyawan ?? '0' }}</span>
                    </td>
                    <td class="p-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="openShowModal({{ json_encode($mitra) }}, {{ json_encode($cp) }})" 
                                    class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-indigo-500 hover:text-indigo-500 hover:shadow-lg hover:shadow-indigo-50 transition shadow-sm" title="Lihat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                            <a href="{{ route('admin.mitra.edit', $mitra->id_perusahaan) }}" 
                               class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-amber-500 hover:text-amber-500 hover:shadow-lg hover:shadow-amber-50 transition shadow-sm" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            </a>
                            <form action="{{ route('admin.mitra.destroy', $mitra->id_perusahaan) }}" method="POST" class="delete-form inline" data-name="Mitra {{ $mitra->nama }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-red-500 hover:text-red-500 hover:shadow-lg hover:shadow-red-50 transition shadow-sm" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v1m3 5V4"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-24 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Belum ada data klien / mitra</p>
                            <a href="{{ route('admin.mitra.create') }}" class="mt-4 text-xs font-bold text-indigo-600 hover:underline">Tambah Mitra Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($mitras->count())
    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/40 flex items-center justify-between gap-4">
        {{-- Info halaman --}}
        <p class="text-[13px] font-bold text-slate-900 tracking-widest whitespace-nowrap">
            Menampilkan
            <span class="text-slate-900">{{ $mitras->firstItem() }}–{{ $mitras->lastItem() }}</span>
            dari
            <span class="text-slate-900">{{ $mitras->total() }}</span>
            data
        </p>

        {{-- Navigasi halaman (hanya jika ada lebih dari 1 halaman) --}}
        @if($mitras->hasPages())
        <div class="flex items-center gap-1">
            {{-- Prev --}}
            @if($mitras->onFirstPage())
                <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-100 text-slate-300 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </span>
            @else
                <a href="{{ $mitras->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:border-indigo-500 hover:text-indigo-600 hover:shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
            @endif

            {{-- Nomor halaman --}}
            @foreach($mitras->getUrlRange(1, $mitras->lastPage()) as $page => $url)
                @if($page == $mitras->currentPage())
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
            @if($mitras->hasMorePages())
                <a href="{{ $mitras->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:border-indigo-500 hover:text-indigo-600 hover:shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-100 text-slate-300 cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </span>
            @endif
        </div>
        @endif
    </div>
    @endif
</div>

<!-- ==============================================
     MODAL DETAIL MITRA (SHOW)
     ============================================== -->
<div id="showModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity" onclick="closeShowModal()"></div>
        <div class="relative bg-white w-full max-w-xl rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
            <div class="bg-slate-50 p-6 lg:p-8 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight" id="show_title">Profil Mitra Perusahaan</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Detail Informasi dan perwakilan B2B</p>
                </div>
                <button onclick="closeShowModal()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-slate-900 transition shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 lg:p-8 space-y-6">
                <!-- DATA PERUSAHAAN -->
                <div>
                    <div class="text-[10px] font-black text-indigo-600 uppercase tracking-wider mb-4 border-b pb-1">Detail Perusahaan</div>
                    <div class="space-y-3">
                        <div class="flex justify-between items-start gap-4">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Nama Mitra</span>
                            <span class="text-sm font-black text-slate-900 text-right" id="show_nama">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Sektor Industri</span>
                            <span class="text-xs font-bold text-slate-700" id="show_sektor_industri">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Jumlah Karyawan</span>
                            <span class="text-xs font-bold text-slate-700" id="show_jumlah_karyawan">—</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Alamat Perusahaan</span>
                            <span class="text-xs font-bold text-slate-700 bg-slate-50 p-3.5 rounded-2xl leading-relaxed" id="show_alamat">—</span>
                        </div>
                    </div>
                </div>

                <!-- CONTACT PERSON -->
                <div>
                    <div class="text-[10px] font-black text-indigo-600 uppercase tracking-wider mb-4 border-b pb-1">Contact Person (CP)</div>
                    <div class="space-y-3" id="show_cp_container">
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Nama Lengkap</span>
                            <span class="text-xs font-black text-slate-900" id="show_nama_cp">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Jabatan</span>
                            <span class="text-xs font-bold text-slate-700" id="show_jabatan">—</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider">No. Kontak</span>
                            <span class="text-xs font-bold text-slate-700" id="show_no_hp_cp">—</span>
                        </div>
                        <div class="flex justify-between items-center" id="show_status_akun_container">
                            <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider">Status Hubungan</span>
                            <span class="px-2 py-0.5 text-[8px] font-black uppercase rounded-md border" id="show_status_akun">—</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button onclick="closeShowModal()" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-wider hover:bg-slate-800 transition">Tutup Detail</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL: Import Data --}}
<div id="importModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-md p-8 border border-slate-100">
        <h3 class="text-xl font-black text-slate-900 mb-1">Import Mitra Perusahaan</h3>
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-7">Unggah file CSV untuk mengimport data mitra & perwakilan B2B</p>
        <form action="{{ route('admin.mitra.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Pilih File CSV *</label>
                <input type="file" name="csv_file" required accept=".csv,text/csv"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl text-xs text-slate-500 space-y-2 border border-slate-100">
                <p class="font-bold text-slate-700">Format Kolom CSV:</p>
                <code class="block bg-white p-2 rounded-xl border border-slate-200/60 text-[10px] text-indigo-600 font-black leading-relaxed">nama_perusahaan, alamat, sektor_industri, jumlah_karyawan, nama_cp, no_hp_cp, jabatan</code>
                <p class="text-[10px]">*) Contact Person (CP) yang diimport akan ditambahkan secara manual ke kemitraan B2B.</p>
                <a href="{{ route('admin.mitra.import-template') }}" class="inline-flex items-center gap-1.5 text-indigo-600 hover:underline font-bold mt-1">
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
    // SHOW MODAL
    function openShowModal(mitra, cp) {
        document.getElementById('show_nama').textContent = mitra.nama || '—';
        document.getElementById('show_sektor_industri').textContent = mitra.sektor_industri || '—';
        document.getElementById('show_jumlah_karyawan').textContent = mitra.jumlah_karyawan ? `${mitra.jumlah_karyawan} Karyawan` : '—';
        document.getElementById('show_alamat').textContent = mitra.alamat || '—';

        if (cp) {
            document.getElementById('show_nama_cp').textContent = cp.id_user ? (cp.user?.nama || '—') : (cp.nama_cp || '—');
            document.getElementById('show_jabatan').textContent = cp.jabatan || '—';
            document.getElementById('show_no_hp_cp').textContent = cp.id_user ? (cp.user?.no_telp || '—') : (cp.no_hp_cp || '—');

            const statusEl = document.getElementById('show_status_akun');
            const statusContainer = document.getElementById('show_status_akun_container');
            if (cp.id_user) {
                statusContainer.classList.remove('hidden');
                statusEl.textContent = 'Akun Terhubung (B2B)';
                statusEl.className = "px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[8px] font-black uppercase rounded-md border border-indigo-100";
            } else {
                statusContainer.classList.remove('hidden');
                statusEl.textContent = 'Manual Input (Backend)';
                statusEl.className = "px-2 py-0.5 bg-slate-100 text-slate-600 text-[8px] font-black uppercase rounded-md border border-slate-200";
            }
        } else {
            document.getElementById('show_nama_cp').textContent = '—';
            document.getElementById('show_jabatan').textContent = '—';
            document.getElementById('show_no_hp_cp').textContent = '—';
            document.getElementById('show_status_akun_container').classList.add('hidden');
        }

        document.getElementById('showModal').classList.remove('hidden');
    }
    function closeShowModal() {
        document.getElementById('showModal').classList.add('hidden');
    }

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
        if (e.key === 'Escape') {
            closeShowModal();
            closeImportModal();
        }
    });
</script>
@endpush
