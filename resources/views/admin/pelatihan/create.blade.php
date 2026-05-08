@extends('layouts.admin')
@section('page-title', 'Tambah Layanan')
@section('page-subtitle', 'Buat program layanan (Pelatihan, Konsultasi, Audit) baru')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.pelatihan.index') }}" class="text-gray-500 hover:text-[#7d2ae7] text-sm">← Kembali ke Daftar Layanan</a>
    </div>
    <div class="bg-white p-8 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-[#7d2ae7] mb-6">Form Tambah Layanan</h2>

        <form method="POST" action="{{ route('admin.pelatihan.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Kategori Layanan *</label>
                <select name="id_kategori" required class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none @error('id_kategori') border-red-400 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
                @error('id_kategori')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Materi / Judul Layanan *</label>
                <input type="text" name="materi" value="{{ old('materi') }}" required
                       placeholder="Contoh: K3 Umum & Pengenalan Hazard"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none @error('materi') border-red-400 @enderror">
                @error('materi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jenis Pertemuan *</label>
                <select name="jenis_pertemuan" required class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                    <option value="offline" {{ old('jenis_pertemuan') === 'offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                    <option value="online"  {{ old('jenis_pertemuan') === 'online'  ? 'selected' : '' }}>Online (Zoom / Meet)</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" name="tanggal_pertemuan" value="{{ old('tanggal_pertemuan') }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Jam Mulai</label>
                    <input type="time" name="jam_pertemuan" value="{{ old('jam_pertemuan') }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                           placeholder="Nama gedung / kota (kosongkan jika online)"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Kapasitas Peserta</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" min="1"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Pemateri (Bisa pilih lebih dari satu)</label>
                <select name="pemateri_ids[]" multiple class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none h-32">
                    @foreach($pemateris as $p)
                        <option value="{{ $p->id_pemateri }}" {{ is_array(old('pemateri_ids')) && in_array($p->id_pemateri, old('pemateri_ids')) ? 'selected' : '' }}>
                            {{ $p->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
                <p class="text-gray-400 text-[10px] mt-1">Tahan Ctrl/Cmd untuk memilih lebih dari satu.</p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4" placeholder="Deskripsi singkat layanan..."
                          class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.pelatihan.index') }}" class="border px-6 py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="flex-1 bg-[#7d2ae7] text-white py-2.5 rounded-lg hover:opacity-90">Simpan Layanan</button>
            </div>
        </form>
    </div>
</div>
@endsection
