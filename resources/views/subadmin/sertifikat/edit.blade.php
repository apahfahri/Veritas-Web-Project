@extends('layouts.subadmin')

@section('title', 'Edit Sertifikat')
@section('page-title', 'Edit Data Sertifikat')

@section('content')
<div class="bg-white rounded-[2rem] border border-slate-100 p-8 shadow-sm max-w-xl select-none">
    <h3 class="text-lg font-black text-slate-900 tracking-tight mb-6">Ubah Data Sertifikat</h3>

    <form method="POST" action="{{ route('subadmin.sertifikat.update', $sertifikat->no_sertifikat) }}">
        @csrf
        @method('PUT')

        <div class="space-y-5">
            <div>
                <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">No Sertifikat</label>
                <input type="text" value="{{ $sertifikat->no_sertifikat }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold outline-none text-slate-500" disabled>
            </div>

            <div>
                <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $sertifikat->nama_lengkap) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-cyan-500 transition font-medium" placeholder="Nama Lengkap Pemegang Sertifikat" required>
            </div>

            <div>
                <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">Tanggal Terbit</label>
                <input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit', $sertifikat->tanggal_terbit ? $sertifikat->tanggal_terbit->format('Y-m-d') : '') }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-cyan-500 transition font-medium" required>
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-extrabold text-sm px-6 py-3.5 rounded-xl shadow-lg transition">
                    Perbarui Sertifikat
                </button>
                <a href="{{ route('subadmin.sertifikat.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-6 py-3.5 rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection


