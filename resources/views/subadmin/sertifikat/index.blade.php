@extends('layouts.subadmin')

@section('title', 'Sertifikat Cabang')
@section('page-title', 'Manajemen Sertifikat')

@section('content')
<!-- Alert status -->
@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl">
        {{ session('success') }}
    </div>
@endif
@if(session('warning'))
    <div class="mb-6 p-4 bg-amber-50 border border-amber-200 text-amber-800 text-sm font-semibold rounded-2xl leading-relaxed">
        {{ session('warning') }}
    </div>
@endif
@if(session('error'))
    <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold rounded-2xl">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden select-none">
    <!-- Header Section -->
    <div class="p-6 md:p-8 bg-slate-50/30 border-b border-slate-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <!-- Tabs Navigasi -->
            <div class="flex border-b border-slate-200/50 gap-6 w-full md:w-auto">
                <a href="?tab=terbit" class="pb-3 text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2 {{ $activeTab === 'terbit' ? 'border-b-2 border-cyan-600 text-cyan-600' : 'text-slate-400 hover:text-slate-600' }}">
                    Sertifikat Terbit
                </a>
                <a href="?tab=belum" class="pb-3 text-xs font-black uppercase tracking-wider transition-all flex items-center gap-2 {{ $activeTab === 'belum' ? 'border-b-2 border-cyan-600 text-cyan-600' : 'text-slate-400 hover:text-slate-600' }}">
                    Belum Memiliki Sertifikat
                </a>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto shrink-0">
                <a href="{{ route('subadmin.sertifikat.create-general') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-md transition uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah
                </a>
                <button onclick="document.getElementById('modal-import-sertifikat').classList.remove('hidden')" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-md transition uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Import
                </button>
            </div>
        </div>

        <form method="GET" action="{{ route('subadmin.sertifikat.index') }}" class="flex flex-wrap items-center gap-3 w-full">
            <input type="hidden" name="tab" value="{{ $activeTab }}">
            <div class="relative flex-1 min-w-[200px]">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <i class="fi fi-rr-search"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $activeTab === 'belum' ? 'Cari nama, email, nomor registrasi...' : 'Cari nomor sertifikat, nama...' }}" class="w-full bg-slate-50 border border-slate-200/80 rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium text-slate-700 outline-none focus:ring-2 focus:ring-cyan-500 transition">
            </div>
            <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-2">
                <i class="fi fi-rr-search"></i> Cari Data
            </button>
            @if(request()->filled('search'))
                <a href="?tab={{ $activeTab }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-4 py-2.5 rounded-xl transition">Reset</a>
            @endif
        </form>
    </div>

    @if($activeTab === 'belum')
        <!-- Tab Belum Memiliki Sertifikat -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">No Registrasi</th>
                        <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Lengkap</th>
                        <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Layanan</th>
                        <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Tanggal Selesai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pendaftaranBelum as $p)
                    <tr class="hover:bg-slate-50/80 transition cursor-pointer group" onclick="window.location='{{ route('subadmin.sertifikat.create', $p->id_pendaftaran) }}'">
                        <td class="p-4 text-xs font-black tracking-widest text-slate-900">
                            {{ $p->nomor_pendaftaran }}
                        </td>
                        <td class="p-4">
                            <div class="text-sm font-bold text-slate-800">{{ $p->user?->nama }}</div>
                            <div class="text-xs text-slate-400 font-medium">{{ $p->user?->email }}</div>
                        </td>
                        <td class="p-4 text-sm font-semibold text-slate-700">
                            {{ $p->jadwal?->jenis?->nama ?? ($p->jadwal?->kategori?->nama ?? '—') }}
                        </td>
                        <td class="p-4 text-sm font-bold text-slate-600">
                            {{ $p->rencana_tanggal_selesai ? $p->rencana_tanggal_selesai->format('d M Y') : ($p->jadwal?->tgl_selesai ? \Carbon\Carbon::parse($p->jadwal->tgl_selesai)->format('d M Y') : '-') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-sm font-medium text-slate-400">Tidak ada data pendaftaran selesai yang memerlukan penerbitan sertifikat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 border-t border-slate-100 flex justify-center">
            {{ $pendaftaranBelum->links() }}
        </div>
    @else
        <!-- Tab Sertifikat Terbit -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">No Sertifikat</th>
                        <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Lengkap</th>
                        <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Layanan</th>
                        <th class="px-5 py-4 text-left text-[10px] font-black uppercase tracking-widest text-slate-400">Tanggal Terbit</th>
                        <th class="px-5 py-4 text-right text-[10px] font-black uppercase tracking-widest text-slate-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($sertifikats as $s)
                    <tr class="hover:bg-slate-50/60 transition group">
                        <td class="p-4 text-sm font-bold text-slate-900">{{ $s->no_sertifikat }}</td>
                        <td class="p-4 text-sm font-bold text-slate-800">{{ $s->nama_lengkap }}</td>
                        <td class="p-4 text-sm font-medium text-slate-600">{{ $s->pendaftaran?->jadwal?->jenis?->nama ?? ($s->pendaftaran?->jadwal?->kategori?->nama ?? '-') }}</td>
                        <td class="p-4 text-sm font-medium text-slate-600">
                            {{ $s->tanggal_terbit ? $s->tanggal_terbit->format('d M Y') : '-' }}
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('subadmin.sertifikat.edit', $s->no_sertifikat) }}" class="text-cyan-600 hover:text-cyan-800 bg-cyan-50 hover:bg-cyan-100 w-8 h-8 rounded-lg flex items-center justify-center transition" title="Edit">
                                    <i class="fi fi-rr-edit"></i>
                                </a>
                                <form action="{{ route('subadmin.sertifikat.destroy', $s->no_sertifikat) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 w-8 h-8 rounded-lg flex items-center justify-center transition" title="Hapus">
                                        <i class="fi fi-rr-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-sm font-medium text-slate-400">Belum ada sertifikat yang diterbitkan di cabang ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-slate-100 flex justify-center">
            {{ $sertifikats->links() }}
        </div>
    @endif
</div>

<!-- MODAL IMPORT CERTIFICATES (CSV/Excel) -->
<div id="modal-import-sertifikat" class="fixed inset-0 z-50 overflow-y-auto hidden">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="document.getElementById('modal-import-sertifikat').classList.add('hidden')"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Import Data Sertifikat</h3>
                        <p class="text-xs text-slate-500 mt-1">Unggah berkas CSV untuk menerbitkan sertifikat peserta dalam jumlah banyak sekaligus.</p>
                    </div>
                    <button type="button" onclick="document.getElementById('modal-import-sertifikat').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('subadmin.sertifikat.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="relative group mb-6">
                        <input type="file" name="csv_file" id="csv_file_input" accept=".csv" required class="hidden" onchange="updateFileName(this)">
                        <label for="csv_file_input" class="flex flex-col items-center justify-center w-full h-44 border-2 border-dashed border-slate-200 rounded-[2rem] cursor-pointer hover:bg-slate-50 hover:border-cyan-300 transition-all group-active:scale-95">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-slate-400 group-hover:text-cyan-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p id="file-label" class="text-xs text-slate-500 font-black uppercase tracking-widest group-hover:text-cyan-600 transition">Pilih Berkas CSV (.csv)</p>
                                <p class="text-[9px] text-slate-400 mt-2 uppercase tracking-[0.2em]">Format CSV Ekspor Excel (Max 5MB)</p>
                            </div>
                        </label>
                    </div>

                    <div class="bg-cyan-50/50 border border-cyan-100 rounded-2xl p-5 mb-6">
                        <p class="text-[11px] text-cyan-800 font-bold uppercase tracking-wider mb-2">Panduan Kolom File:</p>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Pastikan berkas CSV menggunakan baris pertama sebagai nama header berikut:
                        </p>
                        <div class="bg-white border border-slate-100 rounded-xl p-3 mt-3">
                            <code class="text-[11px] text-cyan-700 font-mono font-bold">nomor_pendaftaran, no_sertifikat, nama_lengkap, tanggal_terbit, masa_berlaku, penerbit</code>
                        </div>
                        <ul class="text-[11px] text-slate-500 mt-3 list-disc list-inside space-y-1.5 leading-relaxed">
                            <li><span class="font-bold text-slate-700">nomor_pendaftaran</span> (Wajib): Nomor pendaftaran (e.g. <code class="font-mono text-cyan-700">UP4S3-...</code>) atau ID pendaftaran atau email peserta.</li>
                            <li><span class="font-bold text-slate-700">no_sertifikat</span> (Opsional): Nomor sertifikat. Jika kosong akan dibuatkan otomatis.</li>
                            <li><span class="font-bold text-slate-700">nama_lengkap</span> (Opsional): Jika kosong, menggunakan nama peserta terdaftar di database.</li>
                            <li><span class="font-bold text-slate-700">tanggal_terbit</span> (Opsional): Format YYYY-MM-DD. Default hari ini.</li>
                            <li><span class="font-bold text-slate-700">masa_berlaku</span> (Opsional): Format YYYY-MM-DD.</li>
                            <li><span class="font-bold text-slate-700">penerbit</span> (Opsional): Default <code class="font-mono text-cyan-700">PT Katiga Veritas Indonesia</code>.</li>
                        </ul>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-extrabold text-xs px-6 py-4 rounded-xl shadow-lg shadow-emerald-700/10 transition uppercase tracking-wider">
                            Mulai Impor
                        </button>
                        <button type="button" onclick="document.getElementById('modal-import-sertifikat').classList.add('hidden')"
                                class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs px-5 py-4 rounded-xl transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateFileName(input) {
        const label = document.getElementById('file-label');
        if (input.files && input.files[0]) {
            label.innerText = input.files[0].name;
            label.classList.add('text-cyan-700');
        } else {
            label.innerText = 'Pilih Berkas CSV (.csv)';
            label.classList.remove('text-cyan-700');
        }
    }
</script>
@endpush
