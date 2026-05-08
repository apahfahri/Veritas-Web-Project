@extends('layouts.admin-cabang')

@section('title', 'Edit Klien')
@section('page-title', 'Edit Data Klien')

@section('content')
<div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm max-w-xl select-none">
    <h3 class="text-lg font-black text-slate-900 tracking-tight mb-6">Ubah Formulir Klien</h3>

    <form method="POST" action="{{ route('admin-cabang.klien.update', $klien->id) }}">
        @csrf
        @method('PUT')

        <div class="space-y-5">
            <div>
                <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $klien->nama_lengkap) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-cyan-500 transition font-medium" placeholder="Nama lengkap klien" required>
            </div>

            <div>
                <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">NIK</label>
                <input type="text" name="nik" value="{{ old('nik', $klien->nik) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-cyan-500 transition font-medium" placeholder="16 Digit NIK" maxlength="16">
            </div>

            <div>
                <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">No HP / WhatsApp</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $klien->no_hp) }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-cyan-500 transition font-medium" placeholder="Contoh: 0812xxxxxxxx" maxlength="20">
            </div>

            <div class="pt-2 flex items-center gap-3">
                <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-extrabold text-sm px-6 py-3.5 rounded-xl shadow-lg transition">
                    Perbarui Klien
                </button>
                <a href="{{ route('admin-cabang.klien.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-6 py-3.5 rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
