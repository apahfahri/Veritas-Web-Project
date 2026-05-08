@extends('layouts.admin')
@section('page-title', 'Tambah Pemateri')
@section('page-subtitle', 'Tambahkan data pemateri / instruktur baru')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.petugas.index') }}" class="text-gray-500 hover:text-[#7d2ae7] text-sm">← Kembali ke Daftar Pemateri</a>
    </div>

    <div class="bg-white p-8 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-[#7d2ae7] mb-6">Form Tambah Pemateri</h2>

        <form method="POST" action="{{ route('admin.petugas.store') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap *</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none @error('nama_lengkap') border-red-400 @enderror">
                @error('nama_lengkap')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none @error('email') border-red-400 @enderror">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">No. HP</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kompetensi</label>
                <textarea name="kompetensi" rows="3" placeholder="Sebutkan kompetensi / keahlian..."
                          class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">{{ old('kompetensi') }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.petugas.index') }}" class="border px-6 py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="flex-1 bg-[#7d2ae7] text-white py-2.5 rounded-lg hover:opacity-90 transition">
                    Simpan Pemateri
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
