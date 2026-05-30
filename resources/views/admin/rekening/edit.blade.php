@extends('layouts.admin')
@section('title', 'Ubah Rekening')
@section('page-title', 'Ubah Rekening')
@section('page-subtitle', 'Ubah detail data rekening bank resmi sistem')

@section('content')

<div class="max-w-3xl mx-auto select-none">
    <div class="mb-6">
        <a href="{{ route('admin.rekening.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30 text-center">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-3xl flex items-center justify-center shadow-sm mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
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
                    <svg class="w-5 h-5 text-cyan-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
