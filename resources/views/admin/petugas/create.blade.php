@extends('layouts.admin')
@section('title', 'Tambah Pemateri')
@section('page-title', 'Tambah Pemateri')
@section('page-subtitle', 'Tambahkan data instruktur baru ke dalam sistem')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.petugas.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white p-8 lg:p-10 rounded-[2.5rem] shadow-sm border border-slate-100">
        <form method="POST" action="{{ route('admin.petugas.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- PHOTO UPLOAD -->
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 text-center">Foto Profil</label>
                    <div class="relative group mx-auto w-40 h-40">
                        <input type="file" name="foto" id="foto" accept="image/*"
                               onchange="previewImage(this)"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div id="image-preview-container" class="w-full h-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-[2.5rem] flex flex-col items-center justify-center overflow-hidden transition group-hover:border-indigo-400 group-hover:bg-indigo-50/30">
                            <div id="preview-placeholder" class="text-center">
                                <svg class="w-10 h-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-tight">Pilih Foto<br>(2MB Max)</p>
                            </div>
                            <img id="image-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                        </div>
                    </div>
                    @error('foto')<p class="text-red-500 text-[10px] font-bold mt-2 text-center uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>

                <!-- MAIN INFO -->
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('nama_lengkap') border-red-400 @enderror">
                        @error('nama_lengkap')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Email Pemateri</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('email') border-red-400 @enderror">
                            @error('email')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nomor HP / WhatsApp</label>
                            <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Kompetensi Utama</label>
                        <textarea name="kompetensi" rows="3" 
                                  class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition"
                                  placeholder="Contoh: Ahli K3 Umum, Auditor SMK3, Pengawas Perancah...">{{ old('kompetensi') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Portofolio</label>
                        <textarea name="bio" rows="4" 
                                  class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition"
                                  placeholder="Contoh: Pengalaman mengajar K3 Umum, sertifikasi K3, dsb...">{{ old('bio') }}</textarea>
                        @error('bio')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>

                    <div class="bg-blue-50/60 border border-blue-100 rounded-2xl p-4">
                        <p class="text-[10px] font-black uppercase tracking-widest text-blue-600 mb-1">💡 Info</p>
                        <p class="text-xs text-blue-700 leading-relaxed">Riwayat layanan pemateri (Audit, Pelatihan, Konsultasi) ditampilkan otomatis dari layanan yang di-assign ke pemateri ini. Atur di menu <strong>Manajemen Layanan</strong>.</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 pt-4">
                <a href="{{ route('admin.petugas.index') }}" class="px-8 py-3.5 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                <button type="submit"
                        style="background-color: #7d2ae7;"
                        class="flex-1 text-white py-3.5 rounded-2xl text-sm font-black hover:opacity-90 transition shadow-lg shadow-indigo-100 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Simpan Data Pemateri
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const placeholder = document.getElementById('preview-placeholder');
        const container = document.getElementById('image-preview-container');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
                container.classList.remove('border-dashed', 'border-slate-200');
                container.classList.add('border-solid', 'border-indigo-400');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
