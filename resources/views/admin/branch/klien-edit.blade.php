@extends('layouts\branch')

@section('title', 'Edit Klien / Mitra')
@section('page-title', 'Edit Klien & Mitra Cabang')

@section('content')
<div class="max-w-3xl bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
    <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2 mb-6">
        <span>✏️</span> Edit Informasi Klien/Mitra
    </h3>

    <form action="{{ route('branch-admin.klien.update', $klien->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="nama">Nama Perusahaan/Mitra</label>
                <input type="text" id="nama" name="nama" value="{{ $klien->nama }}" required 
                       class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="alamat">Alamat Lengkap</label>
                <textarea id="alamat" name="alamat" required rows="3"
                          class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">{{ $klien->alamat }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="nib_oss">NIB OSS</label>
                    <input type="text" id="nib_oss" name="nib_oss" value="{{ $klien->nib_oss }}"
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="npwp_perusahaan">NPWP Perusahaan</label>
                    <input type="text" id="npwp_perusahaan" name="npwp_perusahaan" value="{{ $klien->npwp_perusahaan }}"
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="sektor_industri">Sektor Industri</label>
                    <input type="text" id="sektor_industri" name="sektor_industri" value="{{ $klien->sektor_industri }}"
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="jumlah_karyawan">Jumlah Karyawan</label>
                    <input type="number" id="jumlah_karyawan" name="jumlah_karyawan" value="{{ $klien->jumlah_karyawan }}"
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                </div>
            </div>
            
            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition shadow-md flex items-center gap-2">
                    <span>💾</span> Simpan Perubahan
                </button>
                <a href="{{ route('branch-admin.klien.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-5 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
