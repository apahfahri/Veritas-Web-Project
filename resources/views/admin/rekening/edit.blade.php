@extends('layouts.admin')
@section('title', 'Ubah Rekening')
@section('page-title', 'Ubah Rekening')
@section('page-subtitle', 'Ubah detail data rekening bank resmi sistem')

@section('content')

<div class="max-w-3xl mx-auto select-none">
    <div class="mb-6">
        <a href="{{ route('admin.rekening.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <i class="fi fi-rr-arrow-left"></i>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30 text-center">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-3xl flex items-center justify-center shadow-sm mx-auto mb-4">
                <i class="fi fi-rr-edit w-8 h-8"></i>
            </div>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Ubah Data Rekening</h2>
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Perubahan data akan langsung ter-update di seluruh invoice pelanggan</p>
        </div>

        <form method="POST" action="{{ route('admin.rekening.update', $rekening->id_rekening) }}" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                    Nama Bank *
                </label>
                <input type="text" name="nama_bank" value="{{ old('nama_bank', $rekening->nama_bank) }}" required
                       placeholder="Contoh: Bank Mandiri, BCA, BRI, BNI"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-slate-900/5 focus:border-slate-800 focus:outline-none transition @error('nama_bank') border-red-400 @enderror">
                @error('nama_bank')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                    Nomor Rekening *
                </label>
                <input type="text" name="nomor_rekening" value="{{ old('nomor_rekening', $rekening->nomor_rekening) }}" required
                       placeholder="Contoh: 131-00-1886111-1"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-slate-900/5 focus:border-slate-800 focus:outline-none transition @error('nomor_rekening') border-red-400 @enderror">
                @error('nomor_rekening')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                    Atas Nama Pemilik *
                </label>
                <input type="text" name="atas_nama" value="{{ old('atas_nama', $rekening->atas_nama) }}" required
                       placeholder="Contoh: PT Katiga Veritas Indonesia"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-slate-900/5 focus:border-slate-800 focus:outline-none transition @error('atas_nama') border-red-400 @enderror">
                @error('atas_nama')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-wrap gap-4 pt-8 border-t border-slate-50">
                <a href="{{ route('admin.rekening.index') }}" class="px-8 py-4 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl text-sm font-black hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center justify-center gap-2 group">
                    <i class="fi fi-rr-check text-cyan-400 group-hover:scale-110 transition"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
