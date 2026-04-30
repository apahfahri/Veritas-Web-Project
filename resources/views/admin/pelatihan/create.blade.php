@extends('layouts.admin')
@section('page-title', 'Tambah Pelatihan')
@section('page-subtitle', 'Buat jadwal pelatihan K3 baru')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.pelatihan.index') }}" class="text-gray-500 hover:text-[#00A8A8] text-sm">← Kembali ke Daftar Pelatihan</a>
    </div>
    <div class="bg-white p-8 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-[#0A2540] mb-6">Form Tambah Pelatihan</h2>

        <form method="POST" action="{{ route('admin.pelatihan.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Layanan *</label>
                <select name="layanan_id" required class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none @error('layanan_id') border-red-400 @enderror">
                    <option value="">-- Pilih Layanan --</option>
                    @foreach($layanans as $l)
                        <option value="{{ $l->id }}" {{ old('layanan_id') == $l->id ? 'selected' : '' }}>{{ $l->nama }}</option>
                    @endforeach
                </select>
                @error('layanan_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Materi / Judul Pelatihan *</label>
                <input type="text" name="materi" value="{{ old('materi') }}" required
                       placeholder="Contoh: K3 Umum & Pengenalan Hazard"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none @error('materi') border-red-400 @enderror">
                @error('materi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jenis Pertemuan *</label>
                <select name="jenis_pertemuan" required class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none">
                    <option value="offline" {{ old('jenis_pertemuan') === 'offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                    <option value="online"  {{ old('jenis_pertemuan') === 'online'  ? 'selected' : '' }}>Online (Zoom / Meet)</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" name="tanggal_pertemuan" value="{{ old('tanggal_pertemuan') }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Jam Mulai</label>
                    <input type="time" name="jam_pertemuan" value="{{ old('jam_pertemuan') }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                           placeholder="Nama gedung / kota (kosongkan jika online)"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Kapasitas Peserta</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" min="1"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4" placeholder="Deskripsi singkat pelatihan..."
                          class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.pelatihan.index') }}" class="border px-6 py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="flex-1 bg-[#00A8A8] text-white py-2.5 rounded-lg hover:opacity-90">Simpan Pelatihan</button>
            </div>
        </form>
    </div>
</div>
@endsection
