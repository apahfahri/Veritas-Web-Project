@extends('layouts\branch')

@section('title', 'Edit Jadwal Cabang')
@section('page-title', 'Edit Jadwal Pelatihan & Audit')

@section('content')
<div class="max-w-3xl bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
    <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2 mb-6">
        <span>✏️</span> Edit Informasi Jadwal
    </h3>

    <form action="{{ route('branch-admin.jadwal.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="layanan_id">Pilih Layanan</label>
                <select id="layanan_id" name="layanan_id" required 
                        class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                    @foreach($layanan as $item)
                        <option value="{{ $item->id }}" {{ $jadwal->layanan_id == $item->id ? 'selected' : '' }}>{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="materi">Nama Materi Pelatihan</label>
                <input type="text" id="materi" name="materi" value="{{ $jadwal->materi }}" required 
                       class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="jenis_pertemuan">Jenis Pertemuan</label>
                    <select id="jenis_pertemuan" name="jenis_pertemuan" required 
                            class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                        <option value="online" {{ $jadwal->jenis_pertemuan == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ $jadwal->jenis_pertemuan == 'offline' ? 'selected' : '' }}>Offline</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="kapasitas">Kapasitas</label>
                    <input type="number" id="kapasitas" name="kapasitas" value="{{ $jadwal->kapasitas }}"
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="tanggal_pertemuan">Tanggal Pertemuan</label>
                    <input type="date" id="tanggal_pertemuan" name="tanggal_pertemuan" value="{{ $jadwal->tanggal_pertemuan ? $jadwal->tanggal_pertemuan->format('Y-m-d') : '' }}"
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="jam_pertemuan">Jam Pertemuan</label>
                    <input type="time" id="jam_pertemuan" name="jam_pertemuan" value="{{ $jadwal->jam_pertemuan }}"
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="lokasi">Lokasi / Tautan Zoom</label>
                <input type="text" id="lokasi" name="lokasi" value="{{ $jadwal->lokasi }}"
                       class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="3"
                          class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">{{ $jadwal->deskripsi }}</textarea>
            </div>
            
            <div class="pt-4 flex gap-3">
                <button type="submit" class="bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition shadow-md flex items-center gap-2">
                    <span>💾</span> Simpan Perubahan
                </button>
                <a href="{{ route('branch-admin.jadwal.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-5 py-3 rounded-xl transition">
                    Batal
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
