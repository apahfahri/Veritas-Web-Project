@extends('layouts.admin')
@section('title', 'Manajemen Pemateri')
@section('page-title', 'Manajemen Pemateri')
@section('page-subtitle', 'Kelola data pemateri / instruktur PT Katiga Veritas Indonesia')

@section('content')

<div class="flex flex-wrap justify-between items-end gap-4 mb-8">
    <div>
        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Pemateri</h2>
        <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Total: {{ $pemateris->total() }} Instruktur Terdaftar</p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="openImportModal()"
                class="bg-white border border-slate-200 text-slate-700 px-6 py-3 rounded-2xl hover:bg-slate-50 transition shadow-sm flex items-center gap-2 text-sm font-black group">
            <svg class="w-5 h-5 text-slate-400 group-hover:text-slate-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
            Import CSV
        </button>
        <a href="{{ route('admin.petugas.create') }}"
           class="bg-slate-900 text-white px-6 py-3 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center gap-2 text-sm font-black group">
            <svg class="w-5 h-5 text-cyan-400 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Pemateri Baru
        </a>
    </div>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100/50 border-b-2 border-slate-100">
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Nama & Identitas</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Kontak Detail</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50">Kompetensi & Portofolio (Bio)</th>
                    <th class="p-6 text-[13px] font-black text-slate-900 border-b border-slate-50 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pemateris as $p)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="p-6">
                        <div class="flex items-center gap-4">
                            @if($p->foto)
                                <div class="w-12 h-12 rounded-2xl overflow-hidden shadow-sm border border-slate-100 group-hover:scale-110 transition duration-300">
                                    <img src="{{ asset('storage/' . $p->foto) }}" alt="{{ $p->nama_lengkap }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center shadow-sm group-hover:scale-110 transition duration-300 border border-slate-100">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex flex-col">
                                <span class="text-[12px] font-medium text-slate-900 group-hover:text-indigo-600 transition">{{ $p->nama_lengkap }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-6">
                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v10a2 2 0 002 2z"></path></svg>
                                <span class="text-[12px] font-medium text-slate-900">{{ $p->email ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span class="text-[12px] font-medium text-slate-900">{{ $p->no_telp ?? '-' }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="p-6 max-w-xs">
                        {{-- Kompetensi --}}
                        @if($p->kompetensi)
                            <p class="text-[11px] font-black text-slate-500 uppercase tracking-widest mb-1">{{ $p->kompetensi }}</p>
                        @endif

                        {{-- Portofolio (Bio) --}}
                        @if($p->bio)
                            <p class="text-[12px] font-bold text-slate-700 leading-relaxed line-clamp-3 mt-1" style="white-space: pre-line;">{!! nl2br(e(str_replace('\n', "\n", $p->bio))) !!}</p>
                        @else
                            <span class="inline-block text-[10px] font-bold text-slate-400 bg-slate-50 px-2 py-0.5 rounded border border-slate-100 mt-1">
                                Belum ada portofolio terdaftar
                            </span>
                        @endif
                    </td>
                    <td class="p-6 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.petugas.edit', $p->id_pemateri) }}"
                               class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-50 transition shadow-sm" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            </a>
                            <form action="{{ route('admin.petugas.destroy', $p->id_pemateri) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pemateri ini?')">
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
                    <td colspan="4" class="p-24 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-3xl flex items-center justify-center mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Belum ada pemateri terdaftar</p>
                            <a href="{{ route('admin.petugas.create') }}" class="mt-4 text-xs font-bold text-indigo-600 hover:underline">Tambah Pemateri Pertama</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pemateris->hasPages())
    <div class="p-8 border-t border-slate-50 bg-slate-50/30">
        {{ $pemateris->links() }}
    </div>
    @endif
</div>

{{-- MODAL: Import Data --}}
<div id="importModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-md p-8 border border-slate-100">
        <h3 class="text-xl font-black text-slate-900 mb-1">Import Pemateri</h3>
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-7">Unggah file CSV untuk mengimport data pemateri</p>
        <form action="{{ route('admin.petugas.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Pilih File CSV *</label>
                <input type="file" name="csv_file" required accept=".csv,text/csv"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl text-xs text-slate-500 space-y-2 border border-slate-100">
                <p class="font-bold text-slate-700">Format Kolom CSV:</p>
                <code class="block bg-white p-2 rounded-xl border border-slate-200/60 text-[10px] text-indigo-600 font-black">nama_lengkap, email, no_telp, kompetensi, bio</code>
                <a href="{{ route('admin.petugas.import-template') }}" class="inline-flex items-center gap-1.5 text-indigo-600 hover:underline font-bold mt-1">
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
