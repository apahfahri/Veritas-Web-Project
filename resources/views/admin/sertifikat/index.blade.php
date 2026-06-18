@extends('layouts.admin')
@section('title', 'Manajemen Sertifikat')
@section('page-title', 'Manajemen Sertifikat')
@section('page-subtitle', 'Pusat dokumen sertifikasi eksternal (BNSP/Lembaga Lain)')

@section('content')

<!-- SELECTION MODAL -->
<div id="selectionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity" onclick="toggleSelectionModal()"></div>
        <div class="relative bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden transform transition-all">
            <div class="bg-slate-50 p-6 lg:p-8 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Pilih Pendaftaran (Lunas)</h3>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Hanya pendaftaran berstatus 'Selesai' & 'Lunas' yang belum diunggah sertifikatnya</p>
                </div>
                <button onclick="toggleSelectionModal()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-slate-900 transition shadow-sm">
                    <i class="fi fi-rr-cross"></i>
                </button>
            </div>
            <div class="p-6 lg:p-8">
                <div class="max-h-[60vh] overflow-y-auto rounded-3xl border border-slate-100 bg-white">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50/80 sticky top-0 backdrop-blur-sm z-10">
                            <tr>
                                <th class="p-5 text-[9px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-100">Peserta</th>
                                <th class="p-5 text-[9px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-100">Program Layanan</th>
                                <th class="p-5 text-[9px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-100 text-center">Status</th>
                                <th class="p-5 text-[9px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-100 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($pendaftaranTersedia as $p)
                            <tr class="hover:bg-slate-50/50 transition duration-200 group">
                                <td class="p-6">
                                    <div class="flex flex-col">
                                        <span class="text-[12px] font-medium text-slate-900 group-hover:text-indigo-600 transition">{{ $p->user?->nama }}</span>
                                        <span class="text-[11px] font-medium text-slate-400">ID Daftar: #{{ $p->id_pendaftaran }}</span>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <div class="text-xs font-bold text-slate-500 leading-relaxed max-w-[250px] truncate">{{ $p->jadwal?->jenis?->nama ?? ($p->jadwal?->kategori?->nama ?? '—') }}</div>
                                </td>
                                <td class="p-5 text-center">
                                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase rounded-lg border border-emerald-100">Lunas & Selesai</span>
                                </td>
                                <td class="p-5 text-center">
                                    <a href="{{ route('admin.sertifikat.create', $p->id_pendaftaran) }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 hover:scale-105 active:scale-95 transition-transform">
                                        Pilih Data
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-200 mb-4">
                                            <i class="fi fi-rr-computer"></i>
                                        </div>
                                        <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest leading-relaxed">Tidak ada pendaftaran lunas<br>yang siap diunggah sertifikatnya</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="flex flex-wrap justify-between items-end gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Sertifikat</h2>
        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Total: {{ $sertifikats->total() }} Sertifikat Terbit</p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="openImportModal()"
                class="bg-white border border-slate-200 text-slate-700 px-6 py-3 rounded-2xl hover:bg-slate-50 transition shadow-sm flex items-center gap-2 text-sm font-black group">
            <i class="fi fi-rr-upload text-slate-400 group-hover:text-slate-600 transition"></i>
            Import CSV & ZIP
        </button>
        <button onclick="toggleSelectionModal()" 
                class="bg-slate-900 text-white px-6 py-3 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center gap-2 text-sm font-black group">
            <i class="fi fi-rr-copy text-cyan-400 group-hover:rotate-90 transition-transform duration-300"></i>
            Unggah Dokumen Baru
        </button>
    </div>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">No Sertifikat</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Nama Peserta</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Kategori Layanan</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Penerbit</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Tgl Terbit</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Masa Berlaku</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($sertifikats as $s)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="p-6">
                        <span class="text-[12px] font-medium text-slate-900">{{ $s->no_sertifikat }}</span>
                    </td>
                    <td class="p-6">
                        <span class="text-[12px] font-medium text-slate-900">{{ $s->nama_lengkap }}</span>
                    </td>
                    <td class="p-6">
                        <span class="text-[12px] font-medium text-slate-900">{{ $s->pendaftaran?->jadwal?->kategori?->nama ?? '-' }}</span>
                    </td>
                    <td class="p-6 text-center">
                        <span class="text-[12px] font-medium text-slate-900">{{ $s->penerbit ?? '-' }}</span>
                    </td>
                    <td class="p-6 text-center whitespace-nowrap">
                        <span class="text-[12px] font-medium text-slate-900">{{ $s->tanggal_terbit ? $s->tanggal_terbit->format('d M Y') : '-' }}</span>
                    </td>
                    <td class="p-6 text-center whitespace-nowrap">
                        <span class="text-[12px] font-medium text-slate-900">{{ $s->masa_berlaku ? $s->masa_berlaku->format('d M Y') : '-' }}</span>
                    </td>
                    <td class="p-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.sertifikat.show', $s->no_sertifikat) }}" target="_blank" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-red-500 hover:text-red-500 hover:shadow-lg hover:shadow-red-50 transition shadow-sm" title="Lihat PDF">
                                <i class="fi fi-rr-download"></i>
                            </a>
                            <a href="{{ route('admin.sertifikat.edit', $s->no_sertifikat) }}" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-amber-500 hover:text-amber-500 hover:shadow-lg hover:shadow-amber-50 transition shadow-sm" title="Edit">
                                <i class="fi fi-rr-edit"></i>
                            </a>
                            <form action="{{ route('admin.sertifikat.destroy', $s->no_sertifikat) }}" method="POST" class="delete-form" data-name="Sertifikat {{ $s->no_sertifikat }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="kembalikan_ke_proses" value="0" id="kembalikan_{{ str_replace('-','_',$s->no_sertifikat) }}">
                                <button type="button" onclick="confirmDelete('{{ $s->no_sertifikat }}')" class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-red-500 hover:text-red-500 hover:shadow-lg hover:shadow-red-50 transition shadow-sm" title="Hapus">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-24 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mb-4">
                                <i class="fi fi-rr-computer"></i>
                            </div>
                            <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Belum ada dokumen yang diunggah</p>
                            <button onclick="toggleSelectionModal()" class="mt-4 text-xs font-bold text-indigo-600 hover:underline">Unggah Dokumen Pertama</button>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sertifikats->hasPages())
    <div class="px-8 py-5 border-t border-slate-100 bg-slate-50/30 flex flex-col sm:flex-row items-center justify-between gap-4">
        {{-- Info teks kiri --}}
        <p class="text-[12px] font-medium text-slate-500">
            Menampilkan
            <span class="font-black text-slate-800">{{ $sertifikats->firstItem() }}–{{ $sertifikats->lastItem() }}</span>
            dari
            <span class="font-black text-slate-800">{{ $sertifikats->total() }}</span>
            sertifikat
        </p>

        {{-- Tombol navigasi kanan --}}
        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if($sertifikats->onFirstPage())
                <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">‹</span>
            @else
                <a href="{{ $sertifikats->previousPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">‹</a>
            @endif

            {{-- Nomor halaman --}}
            @for($i = 1; $i <= $sertifikats->lastPage(); $i++)
                @if($i == $sertifikats->currentPage())
                    <span class="px-3 py-1.5 text-[11px] font-black text-white bg-slate-900 rounded-xl">{{ $i }}</span>
                @else
                    <a href="{{ $sertifikats->url($i) }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">{{ $i }}</a>
                @endif
            @endfor

            {{-- Next --}}
            @if($sertifikats->hasMorePages())
                <a href="{{ $sertifikats->nextPageUrl() }}" class="px-3 py-1.5 text-[11px] font-black text-slate-500 border border-slate-200 rounded-xl hover:border-indigo-400 hover:text-indigo-600 transition bg-white">›</a>
            @else
                <span class="px-3 py-1.5 text-[11px] font-black text-slate-300 border border-slate-100 rounded-xl cursor-not-allowed bg-white">›</span>
            @endif
        </div>
    </div>
    @endif

</div>

{{-- MODAL: Import Data --}}
<div id="importModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-md p-8 border border-slate-100">
        <h3 class="text-xl font-black text-slate-900 mb-1">Import Sertifikat (CSV + ZIP)</h3>
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-7">Unggah berkas CSV dan berkas ZIP berisi PDF untuk mengimport data sertifikat</p>
        <form action="{{ route('admin.sertifikat.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Berkas CSV (Metadata) *</label>
                <input type="file" name="csv_file" required accept=".csv,text/csv"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Berkas ZIP (PDF Sertifikat) <span class="normal-case text-slate-300">(opsional)</span></label>
                <input type="file" name="zip_file" accept=".zip"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl text-xs text-slate-500 space-y-2 border border-slate-100 overflow-x-auto">
                <p class="font-bold text-slate-700">Format Kolom CSV:</p>
                <code class="block bg-white p-2 rounded-xl border border-slate-200/60 text-[9px] text-indigo-600 font-black leading-relaxed whitespace-nowrap">nomor_pendaftaran, no_sertifikat, nama_lengkap, tanggal_terbit, penerbit, masa_berlaku, file_name</code>
                <p class="text-[10px]">*) Kolom <span class="font-bold text-slate-700">nomor_pendaftaran</span> dapat berupa nomor pendaftaran, ID pendaftaran, atau email peserta.</p>
                <p class="text-[10px]">*) Berkas PDF di ZIP dicocokkan dengan kolom <span class="font-bold text-slate-700">file_name</span>.</p>
                <a href="{{ route('admin.sertifikat.import-template') }}" class="inline-flex items-center gap-1.5 text-indigo-600 hover:underline font-bold mt-1">
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
    function toggleSelectionModal() {
        const modal = document.getElementById('selectionModal');
        modal.classList.toggle('hidden');
    }

    function confirmDelete(noSertifikat) {
        const formId = 'kembalikan_' + noSertifikat.replace(/-/g, '_');
        const form = document.getElementById(formId).closest('form');
        
        Swal.fire({
            title: 'Hapus Sertifikat?',
            text: "Apakah Anda ingin mengembalikan status pendaftaran ke 'Proses'?",
            icon: 'warning',
            showCancelButton: true,
            showDenyButton: true,
            confirmButtonColor: '#0f172a',
            denyButtonColor: '#475569',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Kembalikan ke Proses',
            denyButtonText: 'Tidak, Biarkan Selesai',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).value = "1";
                form.submit();
            } else if (result.isDenied) {
                document.getElementById(formId).value = "0";
                form.submit();
            }
        });
    }

    // IMPORT CSV/ZIP
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
            closeImportModal();
        }
    });
</script>
@endpush
