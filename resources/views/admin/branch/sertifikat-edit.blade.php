@extends('layouts\branch')

@section('title', 'Edit Sertifikat Cabang')
@section('page-title', 'Edit Informasi Sertifikat')

@section('content')
<div class="max-w-3xl bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
    <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2 mb-6">
        <span>✏️</span> Edit Detail Sertifikat
    </h3>

    <form action="{{ route('branch-admin.sertifikat.update', $sertifikat->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="no_sertifikat">Nomor Sertifikat</label>
                <input type="text" id="no_sertifikat" name="no_sertifikat" value="{{ $sertifikat->no_sertifikat }}" required 
                       class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="pendaftaran_id">Pendaftaran Peserta</label>
                <select id="pendaftaran_id" name="pendaftaran_id" required 
                        class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                    @foreach($pendaftaran as $p)
                        <option value="{{ $p->id }}" {{ $sertifikat->pendaftaran_id == $p->id ? 'selected' : '' }}>{{ $p->user?->name ?: 'N/A' }} - {{ $p->layanan?->nama ?: 'No Layanan' }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="nama_lengkap">Nama Lengkap Penerima</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ $sertifikat->nama_lengkap }}" required 
                       class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="tanggal_terbit">Tanggal Terbit</label>
                <input type="date" id="tanggal_terbit" name="tanggal_terbit" value="{{ $sertifikat->tanggal_terbit ? $sertifikat->tanggal_terbit->format('Y-m-d') : '' }}" required 
                       class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
            </div>
            
            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition shadow-md flex items-center gap-2">
                    <span>💾</span> Simpan Perubahan
                </button>
                <a href="{{ route('branch-admin.sertifikat.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-5 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
