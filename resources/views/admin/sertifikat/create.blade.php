@extends('layouts.admin')
@section('page-title', 'Terbitkan Sertifikat')
@section('page-subtitle', 'Buat sertifikat untuk pendaftaran yang telah selesai')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.sertifikat.index') }}" class="text-gray-500 hover:text-[#7d2ae7] text-sm">← Kembali ke Daftar Sertifikat</a>
    </div>

    <!-- INFO PENDAFTARAN -->
    <div class="bg-[#F5F7FA] border rounded-xl p-4 mb-6 text-sm">
        <h3 class="font-semibold text-[#7d2ae7] mb-2">Data Pendaftaran</h3>
        <div class="grid grid-cols-2 gap-2 text-gray-700">
            <div><span class="text-gray-500">Pendaftar:</span> <strong>{{ $pendaftaran->user?->name }}</strong></div>
            <div><span class="text-gray-500">Email:</span> {{ $pendaftaran->user?->email }}</div>
            <div><span class="text-gray-500">Layanan:</span> <strong>{{ $pendaftaran->layanan?->nama }}</strong></div>
            <div><span class="text-gray-500">Tgl Daftar:</span> {{ $pendaftaran->tanggal_daftar->format('d M Y') }}</div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-xl shadow">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-[#7d2ae7] rounded-xl flex items-center justify-center text-white text-xl">🏆</div>
            <div>
                <h2 class="text-xl font-semibold text-[#7d2ae7]">Form Penerbitan Sertifikat</h2>
                <p class="text-xs text-gray-500">Nomor sertifikat akan digenerate otomatis (format: KV-K3-YYYY-XXXXXX)</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.sertifikat.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="pendaftaran_id" value="{{ $pendaftaran->id }}">

            <div>
                <label class="block text-sm font-medium mb-1">Nama Lengkap Penerima *</label>
                <input type="text" name="nama_lengkap"
                       value="{{ old('nama_lengkap', $pendaftaran->user?->name) }}" required
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none @error('nama_lengkap') border-red-400 @enderror">
                <p class="text-xs text-gray-500 mt-1">Nama ini akan tercetak di sertifikat (snapshot permanen)</p>
                @error('nama_lengkap')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Terbit *</label>
                <input type="date" name="tanggal_terbit"
                       value="{{ old('tanggal_terbit', date('Y-m-d')) }}" required
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none @error('tanggal_terbit') border-red-400 @enderror">
                @error('tanggal_terbit')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-sm text-orange-700">
                ⚠️ Setelah sertifikat diterbitkan, status pendaftaran akan otomatis berubah menjadi <strong>Selesai</strong>.
                Tindakan ini tidak dapat dibatalkan.
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.pendaftaran.show', $pendaftaran->id) }}" class="border px-6 py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit"
                        onclick="return confirm('Yakin ingin menerbitkan sertifikat untuk {{ $pendaftaran->user?->name }}?')"
                        class="flex-1 bg-[#7d2ae7] text-white py-2.5 rounded-lg hover:opacity-90 font-semibold">
                    🏆 Terbitkan Sertifikat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
