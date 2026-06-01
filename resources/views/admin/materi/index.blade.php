@extends('layouts.admin')
@section('title', 'Kelola Materi')
@section('page-title', 'Daftar Materi Pelatihan')

@section('content')
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-7 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
        <h2 class="text-xl font-black text-slate-900">Data Materi</h2>
        <div class="flex items-center gap-3">
            <button onclick="openImportModal()"
                    class="bg-white border border-slate-200 text-slate-700 px-5 py-2.5 rounded-xl hover:bg-slate-50 transition text-sm font-bold flex items-center gap-1.5 shadow-sm">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Import CSV / ZIP
            </button>
            <a href="{{ route('admin.materi.create') }}" class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 hover:shadow-indigo-600/40 transition-all duration-300">
                + Tambah Materi Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="m-7 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-7">
        <div class="overflow-x-auto rounded-xl border border-slate-100">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <th class="px-6 py-4 border-b border-slate-100">No</th>
                        <th class="px-6 py-4 border-b border-slate-100">Judul Materi</th>
                        <th class="px-6 py-4 border-b border-slate-100">Deskripsi</th>
                        <th class="px-6 py-4 border-b border-slate-100">File</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm font-medium text-slate-600">
                    @forelse($materis as $m)
                    <tr class="hover:bg-slate-50 transition border-b border-slate-50 last:border-none">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $m->judul }}</td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ Str::limit($m->deskripsi, 50) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ Storage::url($m->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-xs font-bold underline">Lihat PDF</a>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.materi.edit', $m->id_materi) }}" class="inline-flex items-center justify-center bg-amber-100 text-amber-700 hover:bg-amber-200 px-4 py-2 rounded-lg text-xs font-bold transition">Edit</a>
                            <form action="{{ route('admin.materi.destroy', $m->id_materi) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus materi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center bg-red-100 text-red-700 hover:bg-red-200 px-4 py-2 rounded-lg text-xs font-bold transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada data materi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL: Import Data --}}
<div id="importModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-md p-8 border border-slate-100">
        <h3 class="text-xl font-black text-slate-900 mb-1">Import Materi (CSV + ZIP)</h3>
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-7">Unggah berkas CSV dan ZIP untuk mengimport materi beserta file PDF</p>
        <form action="{{ route('admin.materi.import') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Berkas CSV (Metadata) *</label>
                <input type="file" name="csv_file" required accept=".csv,text/csv"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1.5">Berkas ZIP (Berisi Kumpulan PDF) *</label>
                <input type="file" name="zip_file" required accept=".zip"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition">
            </div>
            <div class="bg-slate-50 p-4 rounded-2xl text-xs text-slate-500 space-y-2 border border-slate-100">
                <p class="font-bold text-slate-700">Format Kolom CSV:</p>
                <code class="block bg-white p-2 rounded-xl border border-slate-200/60 text-[10px] text-indigo-600 font-black">judul, deskripsi, file_name</code>
                <p class="text-[10px]">*) Berkas PDF harus di-zip dan nama file di ZIP harus sama persis dengan kolom <span class="font-bold text-slate-700">file_name</span>.</p>
                <a href="{{ route('admin.materi.import-template') }}" class="inline-flex items-center gap-1.5 text-indigo-600 hover:underline font-bold mt-1">
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
