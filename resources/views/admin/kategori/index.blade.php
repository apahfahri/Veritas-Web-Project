@extends('layouts.admin')
@section('title', 'Kategori & Jenis Layanan')
@section('page-title', 'Kategori & Jenis Layanan')
@section('page-subtitle', 'Kelola kategori utama, jenis program, dan kode singkatan untuk penomoran pendaftaran')

@section('content')

{{-- Alert --}}
@if(session('success'))
<div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-6 py-4 flex items-center gap-3 text-sm font-bold">
    <i class="fi fi-rr-check text-emerald-500"></i>
    {{ session('success') }}
</div>
@endif

<div class="flex justify-between items-center mb-8">
    <div>
        <p class="text-[11px] text-slate-400 font-black uppercase tracking-widest">{{ $kategoris->count() }} Kategori · {{ $kategoris->sum(fn($k) => $k->jenis->count()) }} Jenis Program</p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="openImportModal()"
                class="bg-white border border-slate-200 text-slate-700 px-5 py-2.5 rounded-2xl hover:bg-slate-50 transition shadow-sm flex items-center gap-2 text-sm font-black group">
            <i class="fi fi-rr-upload text-slate-400 group-hover:text-slate-600 transition"></i>
            Import CSV
        </button>
        <button onclick="openAddKategoriModal()"
                class="bg-slate-900 text-white px-5 py-2.5 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center gap-2 text-sm font-black group">
            <i class="fi fi-rr-plus text-cyan-400 group-hover:rotate-90 transition-transform"></i>
            Tambah Kategori
        </button>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @foreach($kategoris as $k)
    <div class="bg-white rounded-[28px] shadow-sm border border-slate-100 flex flex-col overflow-hidden transition hover:shadow-xl hover:shadow-indigo-50/50 group">

        {{-- Header Kategori --}}
        <div class="p-6 border-b border-slate-50 bg-slate-50/40 group-hover:bg-indigo-50/20 transition-colors">
            <div class="flex justify-between items-start gap-3">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="inline-flex items-center bg-slate-900 text-cyan-400 text-[10px] font-black px-2.5 py-1 rounded-lg tracking-widest">
                            {{ $k->kode_kategori ?? '???' }}
                        </span>
                        <h3 class="text-sm font-black text-slate-900 tracking-tight truncate">{{ $k->nama }}</h3>
                    </div>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.15em]">{{ $k->jenis->count() }} Jenis Program</p>
                </div>
                <div class="flex gap-1 shrink-0">
                    <button onclick="openEditKategoriModal({{ $k->id_kategori }}, '{{ addslashes($k->nama) }}', '{{ $k->kode_kategori }}')"
                            class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition">
                        <i class="fi fi-rr-edit .5 .5"></i>
                    </button>
                    <button onclick="openAddJenisModal({{ $k->id_kategori }}, '{{ addslashes($k->nama) }}')"
                            class="w-8 h-8 flex items-center justify-center bg-slate-900 text-cyan-400 hover:bg-slate-800 rounded-xl transition">
                        <i class="fi fi-rr-plus .5 .5"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- Daftar Jenis --}}
        <div class="p-4 flex-grow max-h-72 overflow-y-auto custom-scrollbar">
            <ul class="space-y-1">
                @forelse($k->jenis as $j)
                <li class="flex justify-between items-center group/item px-3 py-2.5 hover:bg-slate-50 rounded-xl transition border border-transparent hover:border-slate-100">
                    <div class="flex items-center gap-2.5 flex-1 min-w-0">
                        @if($j->kode_jenis)
                        <span class="shrink-0 inline-flex items-center bg-indigo-50 text-indigo-600 text-[9px] font-black px-1.5 py-0.5 rounded-md tracking-wider border border-indigo-100">
                            {{ $j->kode_jenis }}
                        </span>
                        @else
                        <span class="shrink-0 w-4 h-4 bg-slate-100 rounded-md"></span>
                        @endif
                        <span class="text-[11px] font-bold text-slate-700 group-hover/item:text-slate-900 transition leading-tight">{{ $j->nama }}</span>
                    </div>
                    <div class="flex gap-0.5 opacity-0 group-hover/item:opacity-100 transition shrink-0">
                        <button onclick="openEditJenisModal({{ $j->id_jenis }}, '{{ addslashes($j->nama) }}', '{{ $j->kode_jenis }}')"
                                class="w-7 h-7 flex items-center justify-center text-slate-300 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                            <i class="fi fi-rr-pencil"></i>
                        </button>
                        <form action="{{ route('admin.kategori.jenis.destroy', $j->id_jenis) }}" method="POST" class="delete-jenis-form" data-name="{{ $j->nama }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-7 h-7 flex items-center justify-center text-slate-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                <i class="fi fi-rr-trash"></i>
                            </button>
                        </form>
                    </div>
                </li>
                @empty
                <li class="flex flex-col items-center py-8 text-center">
                    <div class="w-10 h-10 bg-slate-50 text-slate-200 rounded-2xl flex items-center justify-center mb-2">
                        <i class="fi fi-rr-plus"></i>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">Belum ada jenis program</p>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
    @endforeach
</div>

{{-- ═══ MODAL: Tambah Kategori ═══ --}}
<div id="addKategoriModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-md p-8 border border-slate-100">
        <h3 class="text-xl font-black text-slate-900 mb-1">Tambah Kategori</h3>
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-7">Kategori baru untuk pengelompokan layanan</p>
        <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Nama Kategori *</label>
                <input type="text" name="nama" required placeholder="Contoh: Pelatihan K3"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Kode Kategori * <span class="normal-case text-slate-300">(maks 10 karakter)</span></label>
                <input type="text" name="kode_kategori" required maxlength="10" placeholder="Contoh: PLT"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-black uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="2" placeholder="Deskripsi singkat..."
                          class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition"></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeAllModals()" class="flex-1 px-5 py-3 text-xs font-black text-slate-400 hover:text-slate-600 transition uppercase tracking-widest">Batal</button>
                <button type="submit" class="flex-1 bg-slate-900 text-white px-5 py-3 rounded-2xl text-xs font-black hover:bg-slate-800 transition uppercase tracking-widest">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══ MODAL: Edit Kategori ═══ --}}
<div id="editKategoriModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-md p-8 border border-slate-100">
        <h3 class="text-xl font-black text-slate-900 mb-7">Edit Kategori</h3>
        <form id="editKategoriForm" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Nama Kategori *</label>
                <input type="text" name="nama" id="editKategoriNama" required
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Kode Kategori *</label>
                <input type="text" name="kode_kategori" id="editKategoriKode" required maxlength="10"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-black uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeAllModals()" class="flex-1 px-5 py-3 text-xs font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest transition">Batal</button>
                <button type="submit" class="flex-1 bg-slate-900 text-white px-5 py-3 rounded-2xl text-xs font-black hover:bg-slate-800 uppercase tracking-widest transition">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══ MODAL: Tambah Jenis ═══ --}}
<div id="addJenisModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-md p-8 border border-slate-100">
        <h3 class="text-xl font-black text-slate-900 mb-1">Tambah Jenis Program</h3>
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-7">Kategori: <span id="addJenisKategoriName" class="text-indigo-600"></span></p>
        <form action="{{ route('admin.kategori.jenis.store') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="id_kategori" id="addJenisKategoriId">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Nama Program *</label>
                <input type="text" name="nama" required placeholder="Contoh: Ahli K3 Umum"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Kode Singkatan <span class="normal-case text-slate-300">(maks 15 karakter, untuk nomor pendaftaran)</span></label>
                <input type="text" name="kode_jenis" maxlength="15" placeholder="Contoh: AK3U"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-black uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeAllModals()" class="flex-1 px-5 py-3 text-xs font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest transition">Batal</button>
                <button type="submit" class="flex-1 bg-slate-900 text-white px-5 py-3 rounded-2xl text-xs font-black hover:bg-slate-800 uppercase tracking-widest transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ═══ MODAL: Edit Jenis ═══ --}}
<div id="editJenisModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-md p-8 border border-slate-100">
        <h3 class="text-xl font-black text-slate-900 mb-7">Edit Jenis Program</h3>
        <form id="editJenisForm" method="POST" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Nama Program *</label>
                <input type="text" name="nama" id="editJenisNama" required
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Kode Singkatan</label>
                <input type="text" name="kode_jenis" id="editJenisKode" maxlength="15"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-black uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeAllModals()" class="flex-1 px-5 py-3 text-xs font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest transition">Batal</button>
                <button type="submit" class="flex-1 bg-slate-900 text-white px-5 py-3 rounded-2xl text-xs font-black hover:bg-slate-800 uppercase tracking-widest transition">Update</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL: Import Data --}}
<div id="importModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-md p-8 border border-slate-100">
        <h3 class="text-xl font-black text-slate-900 mb-1">Import Kategori & Jenis</h3>
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-7">Unggah file CSV untuk mengimport data kategori dan jenis program</p>
        <form action="{{ route('admin.kategori.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Pilih File CSV *</label>
                <input type="file" name="csv_file" required accept=".csv,text/csv"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl text-xs text-slate-500 space-y-2 border border-slate-100">
                <p class="font-bold text-slate-700">Format Kolom CSV:</p>
                <code class="block bg-white p-2 rounded-xl border border-slate-200/60 text-[10px] text-indigo-600 font-black leading-relaxed">kode_kategori, nama_kategori, deskripsi_kategori, kode_jenis, nama_jenis</code>
                <p class="text-[10px]">*) Program jenis baru akan otomatis ditambahkan ke dalam kategori terkait.</p>
                <a href="{{ route('admin.kategori.import-template') }}" class="inline-flex items-center gap-1.5 text-indigo-600 hover:underline font-bold mt-1">
                    <i class="fi fi-rr-download"></i>
                    Unduh Template CSV
                </a>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeAllModals()" class="flex-1 px-5 py-3 text-xs font-black text-slate-400 hover:text-slate-600 transition uppercase tracking-widest">Batal</button>
                <button type="submit" class="flex-1 bg-slate-900 text-white px-5 py-3 rounded-2xl text-xs font-black hover:bg-slate-800 transition uppercase tracking-widest">Import</button>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 3px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
</style>

@endsection

@push('scripts')
<script>
    function closeAllModals() {
        ['addKategoriModal','editKategoriModal','addJenisModal','editJenisModal','importModal'].forEach(id => {
            document.getElementById(id)?.classList.add('hidden');
        });
        document.body.classList.remove('overflow-hidden');
    }

    function openModal(id) {
        closeAllModals();
        document.getElementById(id)?.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function openImportModal() { openModal('importModal'); }

    function openAddKategoriModal() { openModal('addKategoriModal'); }

    function openEditKategoriModal(id, nama, kode) {
        document.getElementById('editKategoriNama').value = nama;
        document.getElementById('editKategoriKode').value = kode ?? '';
        document.getElementById('editKategoriForm').action = `/admin/kategori/${id}`;
        openModal('editKategoriModal');
    }

    function openAddJenisModal(kategoriId, kategoriNama) {
        document.getElementById('addJenisKategoriId').value = kategoriId;
        document.getElementById('addJenisKategoriName').textContent = kategoriNama;
        openModal('addJenisModal');
    }

    function openEditJenisModal(id, nama, kode) {
        document.getElementById('editJenisNama').value = nama;
        document.getElementById('editJenisKode').value = kode ?? '';
        document.getElementById('editJenisForm').action = `/admin/kategori/jenis/${id}`;
        openModal('editJenisModal');
    }

    window.addEventListener('keydown', e => { if (e.key === 'Escape') closeAllModals(); });

    // Confirm delete jenis
    document.querySelectorAll('.delete-jenis-form').forEach(form => {
        form.addEventListener('submit', e => {
            const name = form.dataset.name;
            if (!confirm(`Hapus jenis program "${name}"? Jadwal terkait juga akan terhapus.`)) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
