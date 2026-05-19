@extends('layouts.admin')
@section('title', 'Unggah Sertifikat')
@section('page-title', 'Unggah Sertifikat')
@section('page-subtitle', 'Simpan dokumen sertifikasi eksternal ke dalam sistem')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.sertifikat.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Repository
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- INFO PANEL -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Referensi Pendaftaran</h3>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-indigo-500 uppercase tracking-tighter">Nama Peserta</p>
                        <p class="text-sm font-black text-slate-900">{{ $pendaftaran->user?->nama }}</p>
                    </div>
                    
                    <div>
                        <p class="text-[10px] font-black text-indigo-500 uppercase tracking-tighter">Program Pelatihan</p>
                        <p class="text-sm font-black text-slate-900 leading-tight">{{ $pendaftaran->jadwal?->jenis?->nama ?? ($pendaftaran->jadwal?->kategori?->nama ?? '—') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-[10px] font-black text-indigo-500 uppercase tracking-tighter">Status Pendaftaran</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[8px] font-black uppercase rounded-md border border-emerald-100">Selesai</span>
                            <span class="px-2 py-0.5 bg-cyan-50 text-cyan-600 text-[8px] font-black uppercase rounded-md border border-cyan-100">Lunas</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 p-6 rounded-3xl shadow-xl shadow-slate-200">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-[10px] text-slate-300 font-bold leading-relaxed uppercase tracking-widest">
                        Input nomor sertifikat sesuai fisik dokumen BNSP/Lembaga terkait untuk validasi publik.
                    </p>
                </div>
            </div>
        </div>

        <!-- FORM PANEL -->
        <div class="lg:col-span-2">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <form method="POST" action="{{ route('admin.sertifikat.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="id_pendaftaran" value="{{ $pendaftaran->id_pendaftaran }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nomor Sertifikat (Manual) *</label>
                            <input type="text" name="no_sertifikat" value="{{ old('no_sertifikat') }}" required
                                   placeholder="Contoh: KV/BNSP/2026/001"
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('no_sertifikat') border-red-400 @enderror">
                            @error('no_sertifikat')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nama Lengkap (Sesuai Dokumen) *</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $pendaftaran->user?->nama) }}" required
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('nama_lengkap') border-red-400 @enderror">
                            @error('nama_lengkap')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Lembaga Penerbit *</label>
                            <input type="text" name="penerbit" value="{{ old('penerbit', 'BNSP') }}" required
                                   placeholder="Contoh: BNSP / Katiga Veritas"
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('penerbit') border-red-400 @enderror">
                            @error('penerbit')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Tanggal Terbit *</label>
                            <input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', date('Y-m-d')) }}" required
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('tanggal_terbit') border-red-400 @enderror">
                            @error('tanggal_terbit')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Masa Berlaku (Opsional)</label>
                            <input type="date" name="masa_berlaku" value="{{ old('masa_berlaku') }}"
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('masa_berlaku') border-red-400 @enderror">
                            @error('masa_berlaku')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Upload Dokumen PDF *</label>
                            <div class="relative group" id="dropzone">
                                <input type="file" name="file_pdf" id="file_pdf" required accept="application/pdf"
                                       onchange="handleFileSelect(this)"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div id="file-display" class="w-full bg-slate-50 border-2 border-dashed border-slate-200 p-8 rounded-3xl text-center group-hover:border-indigo-300 transition group-hover:bg-indigo-50/30">
                                    <div id="file-icon" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-slate-400 group-hover:text-red-500 transition">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p id="file-text" class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Klik atau seret file PDF ke sini</p>
                                    <p id="file-subtext" class="text-[9px] text-slate-400 font-bold mt-1 italic">Maksimal ukuran file: 5MB</p>
                                </div>
                            </div>
                            @error('file_pdf')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('admin.sertifikat.index') }}" class="px-8 py-3.5 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                        <button type="submit"
                                style="background-color: #7d2ae7;"
                                class="flex-1 text-white py-3.5 rounded-2xl text-sm font-black hover:opacity-90 transition shadow-lg shadow-indigo-100 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Simpan Sertifikat
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
    function handleFileSelect(input) {
        const display = document.getElementById('file-display');
        const text = document.getElementById('file-text');
        const subtext = document.getElementById('file-subtext');
        const icon = document.getElementById('file-icon');

        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            
            // UI Update: Success State
            display.classList.remove('border-dashed', 'border-slate-200', 'bg-slate-50');
            display.classList.add('border-solid', 'border-emerald-500', 'bg-emerald-50/50');
            
            icon.classList.remove('text-slate-400');
            icon.classList.add('text-emerald-600');
            icon.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
            
            text.innerHTML = "File Siap Diunggah";
            text.classList.remove('text-slate-500');
            text.classList.add('text-emerald-700');
            
            subtext.innerHTML = fileName;
            subtext.classList.remove('text-slate-400', 'italic');
            subtext.classList.add('text-emerald-600', 'font-black');
        }
    }
</script>
@endpush
