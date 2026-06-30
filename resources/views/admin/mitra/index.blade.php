@extends('layouts.admin')
@section('title', 'Manajemen Daftar Perusahaan')
@section('page-title', 'Manajemen Daftar Perusahaan')
@section('page-subtitle', 'Kelola data kemitraan B2B (Perusahaan)')

@section('content')
<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 md:p-8 bg-slate-50/30 border-b border-slate-100 select-none">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <form method="GET" action="{{ route('admin.mitra.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto flex-1">
                <div>
                    <select name="sektor" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200/80 rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition cursor-pointer">
                        <option value="">Semua Sektor</option>
                        @foreach($sektors as $sektor)
                            <option value="{{ $sektor }}" {{ request('sektor') == $sektor ? 'selected' : '' }}>{{ $sektor }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="relative flex-1 min-w-[200px] max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fi fi-rr-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Mitra/CP..."
                           class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
                </div>
                <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fi fi-rr-search"></i> Cari Data
                </button>
                @if(request()->hasAny(['search', 'sektor']))
                    <a href="{{ route('admin.mitra.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-4 py-2.5 rounded-xl transition">Reset</a>
                @endif
            </form>

            <div class="flex items-center gap-3 shrink-0">
                <button onclick="openImportModal()"
                        class="bg-white border border-slate-200 text-slate-700 font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-sm hover:bg-slate-50 transition uppercase tracking-wider flex items-center gap-2">
                    <i class="fi fi-rr-upload"></i> Import CSV
                </button>
                <a href="{{ route('admin.mitra.create') }}" 
                   class="bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-md transition uppercase tracking-wider flex items-center gap-2">
                    <i class="fi fi-rr-plus"></i> Tambah Klien/Mitra
                </a>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">
                <tr>
                    <th class="px-5 py-4">Nama Perusahaan</th>
                    <th class="px-5 py-4">Sektor Industri</th>
                    <th class="px-5 py-4">Alamat</th>
                    <th class="px-5 py-4">Contact Person</th>
                    <th class="px-5 py-4">Jabatan</th>
                    <th class="px-5 py-4 text-center">Jml Karyawan</th>
                    <th class="px-5 py-4 text-center">Aksi</th>
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
                    <td class="p-5 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <button onclick="openShowModal({{ json_encode($mitra) }}, {{ json_encode($cp) }})" 
                                    class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-100 transition" title="Lihat">
                                <i class="fi fi-rr-eye"></i>
                            </button>
                            <a href="{{ route('admin.mitra.edit', $mitra->id_perusahaan) }}" 
                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-cyan-50 text-cyan-600 hover:text-cyan-800 hover:bg-cyan-100 transition" title="Edit">
                                <i class="fi fi-rr-edit"></i>
                            </a>
                            <form action="{{ route('admin.mitra.destroy', $mitra->id_perusahaan) }}" method="POST" class="delete-form inline" data-name="Mitra {{ $mitra->nama }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:text-rose-700 hover:bg-rose-100 transition" title="Hapus">
                                    <i class="fi fi-rr-trash"></i>
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
                                <i class="fi fi-rr-building w-10 h-10"></i>
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
    @if($mitras->hasPages())
    <div class="p-6 border-t border-slate-100 flex justify-center">
        {{ $mitras->links() }}
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
                    <i class="fi fi-rr-cross"></i>
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
