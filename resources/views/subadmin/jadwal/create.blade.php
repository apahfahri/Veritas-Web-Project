@extends('layouts.subadmin')

@section('title', 'Buat Jadwal Baru')
@section('page-title', 'Tambah Jadwal Pelatihan')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm select-none">
        <h3 class="text-lg font-black text-slate-900 tracking-tight mb-6 flex items-center gap-2">
            <span class="w-8 h-8 bg-cyan-50 text-cyan-600 rounded-lg flex items-center justify-center text-sm">🗓️</span>
            Formulir Penjadwalan
        </h3>

        <form action="{{ route('subadmin.jadwal.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Layanan -->
                <div class="md:col-span-2">
                    <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">Pilih Layanan Pelatihan</label>
                    <select name="id_layanan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none appearance-none" required>
                        <option value="" disabled selected>Pilih Layanan...</option>
                        @foreach($layanans as $l)
                            <option value="{{ $l->id_layanan }}">{{ $l->nama }} - {{ $l->materi }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">Tanggal Pelaksanaan</label>
                    <input type="date" name="tanggal" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none" required>
                </div>

                <!-- Kuota -->
                <div>
                    <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">Kuota Peserta</label>
                    <input type="number" name="kuota" min="1" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none" placeholder="Contoh: 30" required>
                </div>

                <!-- Jam Mulai -->
                <div>
                    <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">Jam Mulai</label>
                    <input type="time" name="jam_mulai" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none" required>
                </div>

                <!-- Jam Selesai -->
                <div>
                    <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">Jam Selesai</label>
                    <input type="time" name="jam_selesai" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none" required>
                </div>

                <!-- Lokasi -->
                <div class="md:col-span-2">
                    <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">Lokasi / Ruangan</label>
                    <input type="text" name="lokasi" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none" placeholder="Contoh: Hotel Aston Pasteur / Zoom Link" required>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-50 flex items-center gap-4">
                <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-black text-sm px-8 py-4 rounded-xl shadow-lg transition">
                    Simpan Jadwal
                </button>
                <a href="{{ route('subadmin.jadwal.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

