@extends('layouts\branch')

@section('title', 'Edit Peserta & Riwayat')
@section('page-title', 'Edit Peserta / Riwayat Layanan')

@section('content')
<div class="max-w-3xl bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
    <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2 mb-6">
        <span>✏️</span> Edit Informasi Peserta & Riwayat
    </h3>

    <form action="{{ route('branch-admin.peserta.update', $peserta->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="user_id">Nama User / Klien</label>
                <select id="user_id" name="user_id" required 
                        class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $peserta->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="layanan_id">Layanan</label>
                <select id="layanan_id" name="layanan_id" required 
                        class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                    @foreach($layanan as $item)
                        <option value="{{ $item->id }}" {{ $peserta->layanan_id == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="tanggal_daftar">Tanggal Daftar</label>
                <input type="date" id="tanggal_daftar" name="tanggal_daftar" value="{{ $peserta->tanggal_daftar ? $peserta->tanggal_daftar->format('Y-m-d') : '' }}" required 
                       class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="status_progres">Status Progres</label>
                    <select id="status_progres" name="status_progres" required 
                            class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                        <option value="menunggu" {{ $peserta->status_progres == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $peserta->status_progres == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $peserta->status_progres == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $peserta->status_progres == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="status_bayar">Status Pembayaran</label>
                    <select id="status_bayar" name="status_bayar" required 
                            class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                        <option value="belum_bayar" {{ $peserta->status_bayar == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="menunggu_konfirmasi" {{ $peserta->status_bayar == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="lunas" {{ $peserta->status_bayar == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>
            </div>
            
            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition shadow-md flex items-center gap-2">
                    <span>💾</span> Simpan Perubahan
                </button>
                <a href="{{ route('branch-admin.peserta.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-5 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
