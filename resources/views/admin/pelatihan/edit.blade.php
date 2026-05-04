@extends('layouts.admin')
@section('page-title', 'Edit Pelatihan')
@section('page-subtitle', 'Perbarui data pelatihan K3')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.pelatihan.index') }}" class="text-gray-500 hover:text-[#7d2ae7] text-sm">← Kembali ke Daftar Pelatihan</a>
    </div>
    <div class="bg-white p-8 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-[#7d2ae7] mb-6">Edit Pelatihan</h2>

        <form method="POST" action="{{ route('admin.pelatihan.update', $pelatihan->id) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Layanan *</label>
                <select name="layanan_id" required class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                    @foreach($layanans as $l)
                        <option value="{{ $l->id }}" {{ old('layanan_id', $pelatihan->layanan_id) == $l->id ? 'selected' : '' }}>{{ $l->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Materi / Judul *</label>
                <input type="text" name="materi" value="{{ old('materi', $pelatihan->materi) }}" required
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none @error('materi') border-red-400 @enderror">
                @error('materi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jenis Pertemuan *</label>
                <select name="jenis_pertemuan" required class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                    <option value="offline" {{ old('jenis_pertemuan', $pelatihan->jenis_pertemuan) === 'offline' ? 'selected' : '' }}>Offline</option>
                    <option value="online"  {{ old('jenis_pertemuan', $pelatihan->jenis_pertemuan) === 'online'  ? 'selected' : '' }}>Online</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" name="tanggal_pertemuan"
                           value="{{ old('tanggal_pertemuan', $pelatihan->tanggal_pertemuan?->format('Y-m-d')) }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Jam Mulai</label>
                    <input type="text" id="jam_pertemuan" name="jam_pertemuan"
                           value="{{ old('jam_pertemuan', substr($pelatihan->jam_pertemuan ?? '', 0, 5)) }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none" readonly>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $pelatihan->lokasi) }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Kapasitas</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas', $pelatihan->kapasitas) }}" min="1"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                          class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">{{ old('deskripsi', $pelatihan->deskripsi) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.pelatihan.index') }}" class="border px-6 py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="flex-1 bg-[#7d2ae7] text-white py-2.5 rounded-lg hover:opacity-90">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/dmuy/MDTimePicker@2.0.1/dist/mdtimepicker.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/gh/dmuy/MDTimePicker@2.0.1/dist/mdtimepicker.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        mdtimepicker('#jam_pertemuan', {
            format: 'hh:mm',
            is24hour: true
        });
    });
</script>
@endpush
