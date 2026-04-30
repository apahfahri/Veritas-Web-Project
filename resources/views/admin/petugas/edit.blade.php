@extends('layouts.admin')
@section('page-title', 'Edit Petugas')
@section('page-subtitle', 'Perbarui data petugas')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.petugas.index') }}" class="text-gray-500 hover:text-[#00A8A8] text-sm">← Kembali ke Daftar Petugas</a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-[#0A2540] mb-6">Edit: {{ $petugas->nama_lengkap }}</h2>

        <form method="POST" action="{{ route('admin.petugas.update', $petugas->id) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $petugas->nama_lengkap) }}" required
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none @error('nama_lengkap') border-red-400 @enderror">
                @error('nama_lengkap')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Email *</label>
                <input type="email" name="email" value="{{ old('email', $petugas->email) }}" required
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none @error('email') border-red-400 @enderror">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp', $petugas->no_hp) }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Spesialisasi</label>
                <input type="text" name="spesialisasi" value="{{ old('spesialisasi', $petugas->spesialisasi) }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none">
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.petugas.index') }}" class="border px-6 py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="flex-1 bg-[#00A8A8] text-white py-2.5 rounded-lg hover:opacity-90 transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
