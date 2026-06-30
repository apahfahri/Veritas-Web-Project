@extends('layouts.admin')
@section('title', 'Kelola Materi')
@section('page-title', 'Daftar Materi Pelatihan')

@section('content')
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl px-6 py-4 flex items-center gap-3 text-sm font-bold">
            <i class="fi fi-rr-check text-emerald-500"></i>
            {{ session('success') }}
        </div>
    @endif

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="p-6 md:p-8 bg-slate-50/30 border-b border-slate-100 select-none">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <form method="GET" action="{{ route('admin.materi.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto flex-1">
                <div class="relative flex-1 min-w-[200px] max-w-md">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fi fi-rr-search"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari materi..."
                           class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
                </div>
                <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                    <i class="fi fi-rr-search"></i> Cari Data
                </button>
                @if(request()->has('search'))
                    <a href="{{ route('admin.materi.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-4 py-2.5 rounded-xl transition">Reset</a>
                @endif
            </form>

            <div class="flex items-center gap-3 shrink-0">
                <button onclick="openImportModal()"
                        class="bg-white border border-slate-200 text-slate-700 font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-sm hover:bg-slate-50 transition uppercase tracking-wider flex items-center gap-2">
                    <i class="fi fi-rr-upload"></i> Import CSV
                </button>
                <a href="{{ route('admin.materi.create') }}"
                   class="bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-md transition uppercase tracking-wider flex items-center gap-2">
                    <i class="fi fi-rr-plus"></i> Tambah Materi Baru
                </a>
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">
                <tr>
                    <th class="px-5 py-4">No</th>
                    <th class="px-5 py-4">Judul Materi</th>
                    <th class="px-5 py-4">Deskripsi</th>
                    <th class="px-5 py-4">File</th>
                    <th class="px-5 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-sm font-medium text-slate-600">
                @forelse($materis as $m)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="p-5">{{ $materis->firstItem() + $loop->index }}</td>
                    <td class="p-5 font-bold text-slate-800">{{ $m->judul }}</td>
                    <td class="p-5 text-xs text-slate-500">{{ Str::limit($m->deskripsi, 50) }}</td>
                    <td class="p-5">
                        <a href="{{ Storage::url($m->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 text-[11px] font-black tracking-widest uppercase flex items-center gap-1">
                            <i class="fi fi-rr-file-pdf"></i> Lihat
                        </a>
                    </td>
                    <td class="p-5">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.materi.edit', $m->id_materi) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-cyan-50 text-cyan-600 hover:text-cyan-800 hover:bg-cyan-100 transition" title="Edit">
                                <i class="fi fi-rr-edit"></i>
                            </a>
                            <form action="{{ route('admin.materi.destroy', $m->id_materi) }}" method="POST" class="delete-form" data-name="{{ $m->judul }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-50 text-rose-500 hover:text-rose-700 hover:bg-rose-100 transition" title="Hapus">
                                    <i class="fi fi-rr-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-16 text-center text-slate-400 text-sm font-bold tracking-widest uppercase">Belum ada data materi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

        {{-- Pagination --}}
    @if($materis->hasPages())
    <div class="p-6 border-t border-slate-100 flex justify-center">
        {{ $materis->links() }}
    </div>
    @endif
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
