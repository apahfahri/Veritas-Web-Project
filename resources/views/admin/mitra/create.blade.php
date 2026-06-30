@extends('layouts.admin')
@section('title', 'Tambah Perusahaan Baru')
@section('page-title', 'Tambah Perusahaan Baru')
@section('page-subtitle', 'Daftarkan Perusahaan B2B beserta Contact Person')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.mitra.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-slate-900 transition">
            <i class="fi fi-rr-arrow-left"></i>
            Kembali ke Daftar Perusahaan
        </a>
    </div>

        <div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
        <div class="bg-slate-50 p-6 lg:p-8 border-b border-slate-100">
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Formulir Perusahaan Baru</h3>
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Lengkapi data perusahaan dan contact person di bawah ini</p>
        </div>
        
        <form method="POST" action="{{ route('admin.mitra.store') }}" class="p-6 lg:p-8 space-y-8">
            @csrf
            
            <!-- Bagian 1: DATA PERUSAHAAN -->
            <div>
                <div class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-black">1</span>
                    DATA PERUSAHAAN
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nama Perusahaan *</label>
                        <input type="text" name="nama" required value="{{ old('nama') }}" placeholder="Contoh: PT Veritas Utama Mandiri"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('nama') border-red-400 @enderror">
                        @error('nama')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Sektor Industri</label>
                        <input type="text" name="sektor_industri" value="{{ old('sektor_industri') }}" placeholder="Contoh: Konstruksi / Migas"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('sektor_industri') border-red-400 @enderror">
                        @error('sektor_industri')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Jumlah Karyawan</label>
                        <input type="number" name="jumlah_karyawan" min="0" value="{{ old('jumlah_karyawan') }}" placeholder="100"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('jumlah_karyawan') border-red-400 @enderror">
                        @error('jumlah_karyawan')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Alamat Perusahaan</label>
                        <textarea name="alamat" placeholder="Jl. Raya Utama No. 12, Jakarta" rows="3"
                                  class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition resize-none @error('alamat') border-red-400 @enderror">{{ old('alamat') }}</textarea>
                        @error('alamat')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Bagian 2: CONTACT PERSON -->
            <div>
                <div class="text-[10px] font-black text-indigo-600 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-black">2</span>
                    CONTACT PERSON (CP)
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nama Lengkap CP</label>
                        <input type="text" name="nama_cp" value="{{ old('nama_cp') }}" placeholder="Contoh: Budi Santoso"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('nama_cp') border-red-400 @enderror">
                        @error('nama_cp')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">No. HP / WA CP</label>
                        <input type="text" name="no_hp_cp" value="{{ old('no_hp_cp') }}" placeholder="Contoh: 08123456789"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('no_hp_cp') border-red-400 @enderror">
                        @error('no_hp_cp')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Jabatan di Perusahaan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: HRD Manager / HSE Officer"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('jabatan') border-red-400 @enderror">
                        @error('jabatan')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.mitra.index') }}" class="px-6 py-3 rounded-2xl bg-slate-100 text-slate-600 hover:bg-slate-200 text-sm font-black transition">Batal</a>
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl text-sm font-black uppercase tracking-wider hover:bg-indigo-700 shadow-md transition">Simpan Perusahaan</button>
            </div>
        </form>
    </div>
</div>
@endsection
