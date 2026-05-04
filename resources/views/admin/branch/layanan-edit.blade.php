@extends('layouts\branch')

@section('title', 'Edit Layanan')
@section('page-title', 'Edit Layanan Cabang')

@section('content')
<div class="max-w-2xl bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
    <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2 mb-6">
        <span>✏️</span> Edit Informasi Layanan
    </h3>

    <form action="{{ route('branch-admin.layanan.update', $layanan->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="nama">Nama Layanan</label>
                <input type="text" id="nama" name="nama" value="{{ $layanan->nama }}" required 
                       class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                          class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">{{ $layanan->deskripsi }}</textarea>
            </div>
            
            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition shadow-md flex items-center gap-2">
                    <span>💾</span> Simpan Perubahan
                </button>
                <a href="{{ route('branch-admin.layanan.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-5 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
