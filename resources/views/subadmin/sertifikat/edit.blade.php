@extends('layouts.subadmin')
@section('title', 'Edit Sertifikat')
@section('page-title', 'Edit Sertifikat')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('subadmin.sertifikat.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Repository
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- INFO PANEL -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-slate-900 p-6 rounded-3xl shadow-xl shadow-slate-200 text-white">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Status Dokumen</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] font-black text-cyan-400 uppercase tracking-tighter">Status File</p>
                        @if($sertifikat->file_pdf)
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                            <span class="text-[10px] font-black uppercase text-emerald-400 tracking-widest">File Ready</span>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('subadmin.sertifikat.show', $sertifikat->no_sertifikat) }}" target="_blank" 
                               class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition border border-white/10">
                                <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Lihat File Saat Ini
                            </a>
                        </div>
                        @else
                        <div class="flex items-center gap-2 mt-1">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                            <span class="text-[10px] font-black uppercase text-red-400 tracking-widest">Belum Ada File</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="bg-cyan-50 p-6 rounded-3xl border border-cyan-100">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-cyan-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-[10px] text-cyan-700 font-bold uppercase tracking-widest leading-relaxed">
                        Anda dapat mengubah <span class="underline">Nomor Sertifikat</span> jika terjadi kesalahan input. Sistem akan memperbarui data terkait secara otomatis.
                    </p>
                </div>
            </div>
        </div>

        <!-- FORM PANEL -->
        <div class="lg:col-span-2">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
                <form method="POST" action="{{ route('subadmin.sertifikat.update', $sertifikat->no_sertifikat) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nomor Sertifikat *</label>
                        <input type="text" name="no_sertifikat"
                               value="{{ old('no_sertifikat', $sertifikat->no_sertifikat) }}" required
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 focus:outline-none transition @error('no_sertifikat') border-red-400 @enderror">
                        @error('no_sertifikat')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nama Lengkap di Sertifikat *</label>
                        <input type="text" name="nama_lengkap"
                               value="{{ old('nama_lengkap', $sertifikat->nama_lengkap) }}" required
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 focus:outline-none transition @error('nama_lengkap') border-red-400 @enderror">
                        @error('nama_lengkap')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Lembaga Penerbit *</label>
                            <input type="text" name="penerbit" value="{{ old('penerbit', $sertifikat->penerbit) }}" required
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 focus:outline-none transition @error('penerbit') border-red-400 @enderror">
                            @error('penerbit')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Tanggal Terbit *</label>
                            <input type="date" name="tanggal_terbit"
                                   value="{{ old('tanggal_terbit', $sertifikat->tanggal_terbit ? $sertifikat->tanggal_terbit->format('Y-m-d') : '') }}" required
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 focus:outline-none transition @error('tanggal_terbit') border-red-400 @enderror">
                            @error('tanggal_terbit')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Masa Berlaku (Opsional)</label>
                            <input type="date" name="masa_berlaku"
                                   value="{{ old('masa_berlaku', $sertifikat->masa_berlaku ? $sertifikat->masa_berlaku->format('Y-m-d') : '') }}"
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-cyan-500/10 focus:border-cyan-500 focus:outline-none transition @error('masa_berlaku') border-red-400 @enderror">
                            @error('masa_berlaku')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                            {{ $sertifikat->file_pdf ? 'Ganti File PDF (Opsional)' : 'Upload File PDF *' }}
                        </label>
                        <div class="relative group" id="dropzone">
                            <input type="file" name="file_pdf" id="file_pdf" accept="application/pdf"
                                   onchange="handleFileSelect(this)"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" {{ $sertifikat->file_pdf ? '' : 'required' }}>
                            
                            @if($sertifikat->file_pdf)
                            <div id="file-display" class="w-full bg-emerald-50 border-2 border-emerald-200 p-8 rounded-3xl text-center group-hover:border-emerald-400 transition group-hover:bg-emerald-100/30">
                                <div id="file-icon" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-emerald-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138z"></path></svg>
                                </div>
                                <p id="file-text" class="text-[10px] font-black text-emerald-600 uppercase tracking-widest">Dokumen Sudah Terunggah</p>
                                <p id="file-subtext" class="text-[9px] text-emerald-500 font-bold mt-1 italic">Klik untuk mengganti dengan file baru</p>
                            </div>
                            @else
                            <div id="file-display" class="w-full bg-slate-50 border-2 border-dashed border-slate-200 p-8 rounded-3xl text-center group-hover:border-cyan-300 transition group-hover:bg-cyan-50/30">
                                <div id="file-icon" class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm text-slate-400 group-hover:text-red-500 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <p id="file-text" class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Klik atau seret file PDF ke sini</p>
                                <p id="file-subtext" class="text-[9px] text-slate-400 font-bold mt-1 italic">Maksimal ukuran file: 5MB</p>
                            </div>
                            @endif
                        </div>
                        @error('file_pdf')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('subadmin.sertifikat.index') }}" class="px-8 py-3.5 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                        <button type="submit" id="submitBtn"
                                class="flex-1 bg-gradient-to-r from-cyan-600 to-teal-600 text-white py-3.5 rounded-2xl text-sm font-black hover:from-cyan-700 hover:to-teal-700 transition shadow-lg shadow-cyan-100 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span id="submitBtnText">Simpan Perubahan</span>
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
            display.classList.remove('border-dashed', 'border-slate-200', 'bg-slate-50', 'bg-emerald-50', 'border-emerald-200');
            display.classList.add('border-solid', 'border-emerald-500', 'bg-emerald-50/50');
            icon.classList.remove('text-slate-400', 'text-emerald-500');
            icon.classList.add('text-emerald-600');
            icon.innerHTML = '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
            text.innerHTML = "File Siap Diperbarui";
            text.classList.remove('text-slate-500', 'text-emerald-600');
            text.classList.add('text-emerald-700');
            subtext.innerHTML = fileName;
            subtext.classList.remove('text-slate-400', 'text-emerald-500', 'italic');
            subtext.classList.add('text-emerald-600', 'font-black');
        }
    }

    document.querySelector('form').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        const btnText = document.getElementById('submitBtnText');
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        btnText.innerHTML = '<svg class="w-4 h-4 animate-spin inline mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
    });
</script>
@endpush
