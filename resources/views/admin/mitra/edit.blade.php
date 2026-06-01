@extends('layouts.admin')
@section('title', 'Edit Perusahaan')
@section('page-title', 'Edit Perusahaan')
@section('page-subtitle', 'Perbarui data Perusahaan B2B dan Contact Person')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.mitra.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar Perusahaan
        </a>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-slate-50 p-6 lg:p-8 border-b border-slate-100">
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Formulir Edit Perusahaan</h3>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Perbarui data perusahaan dan contact person di bawah ini</p>
        </div>
        
        <form method="POST" action="{{ route('admin.mitra.update', $perusahaan->id_perusahaan) }}" class="p-6 lg:p-8 space-y-8">
            @csrf
            @method('PUT')
            
            <!-- SEKSI 1: DATA PERUSAHAAN -->
            <div>
                <div class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-black">1</span>
                    SEKSI 1: DATA PERUSAHAAN
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nama Perusahaan *</label>
                        <input type="text" name="nama" required value="{{ old('nama', $perusahaan->nama) }}"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('nama') border-red-400 @enderror">
                        @error('nama')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Sektor Industri</label>
                        <input type="text" name="sektor_industri" value="{{ old('sektor_industri', $perusahaan->sektor_industri) }}"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('sektor_industri') border-red-400 @enderror">
                        @error('sektor_industri')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Jumlah Karyawan</label>
                        <input type="number" name="jumlah_karyawan" min="0" value="{{ old('jumlah_karyawan', $perusahaan->jumlah_karyawan) }}"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('jumlah_karyawan') border-red-400 @enderror">
                        @error('jumlah_karyawan')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Alamat Perusahaan</label>
                        <textarea name="alamat" rows="3"
                                  class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition resize-none @error('alamat') border-red-400 @enderror">{{ old('alamat', $perusahaan->alamat) }}</textarea>
                        @error('alamat')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- SEKSI 2: CONTACT PERSON -->
            <div>
                <div class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-black">2</span>
                    SEKSI 2: CONTACT PERSON (CP)
                </div>

                @if($cp && $cp->id_user)
                <!-- Alert if CP has registered User Account -->
                <div class="mb-5 bg-amber-50 border border-amber-100 rounded-2xl p-4 flex gap-3">
                    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <p class="text-[11px] font-bold text-amber-700 uppercase tracking-wider leading-relaxed">
                        CP ini terdaftar sebagai Akun User di sistem. Nama asli terhubung langsung ke profil user dan tidak dapat diubah manual di sini untuk menjaga validitas akun.
                    </p>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nama Lengkap CP</label>
                        <input type="text" name="nama_cp" 
                               value="{{ old('nama_cp', $cp ? ($cp->id_user ? ($cp->user?->nama) : $cp->nama_cp) : '') }}" 
                               {{ $cp && $cp->id_user ? 'disabled' : '' }}
                               placeholder="Contoh: Budi Santoso"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition {{ $cp && $cp->id_user ? 'opacity-60 cursor-not-allowed' : '' }} @error('nama_cp') border-red-400 @enderror">
                        @error('nama_cp')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">No. HP / WA CP</label>
                        <input type="text" name="no_hp_cp" 
                               value="{{ old('no_hp_cp', $cp ? ($cp->id_user ? ($cp->user?->no_telp) : $cp->no_hp_cp) : '') }}" 
                               {{ $cp && $cp->id_user ? 'disabled' : '' }}
                               placeholder="Contoh: 08123456789"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition {{ $cp && $cp->id_user ? 'opacity-60 cursor-not-allowed' : '' }} @error('no_hp_cp') border-red-400 @enderror">
                        @error('no_hp_cp')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Jabatan di Perusahaan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan', $cp->jabatan ?? '') }}" placeholder="Contoh: HRD Manager / HSE Officer"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('jabatan') border-red-400 @enderror">
                        @error('jabatan')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.mitra.index') }}" class="px-6 py-3 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-sm font-black transition">Batal</a>
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl text-sm font-black uppercase tracking-wider hover:bg-indigo-700 shadow-md transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
