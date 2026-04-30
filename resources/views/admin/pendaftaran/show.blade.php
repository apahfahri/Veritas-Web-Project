@extends('layouts.admin')
@section('page-title', 'Detail Pendaftaran #' . $pendaftaran->id)
@section('page-subtitle', 'Kelola status dan penugasan petugas')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.pendaftaran.index') }}" class="text-gray-500 hover:text-[#00A8A8] text-sm">← Kembali ke Daftar Pendaftaran</a>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    <!-- DETAIL INFO -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold text-[#0A2540] mb-4">Informasi Pendaftaran</h2>
            <dl class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-gray-500">ID Pendaftaran</dt>
                    <dd class="font-semibold">#{{ $pendaftaran->id }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Tanggal Daftar</dt>
                    <dd class="font-semibold">{{ $pendaftaran->tanggal_daftar->format('d M Y') }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Nama Pendaftar</dt>
                    <dd class="font-semibold">{{ $pendaftaran->user?->name }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Email</dt>
                    <dd class="font-semibold">{{ $pendaftaran->user?->email }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Layanan</dt>
                    <dd class="font-semibold">{{ $pendaftaran->layanan?->nama ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Petugas</dt>
                    <dd class="font-semibold">{{ $pendaftaran->petugas?->nama_lengkap ?? '— Belum ditugaskan —' }}</dd>
                </div>
            </dl>
        </div>

        @if($pendaftaran->sertifikat)
        <div class="bg-green-50 border border-green-200 p-6 rounded-xl">
            <h3 class="font-semibold text-green-700 mb-2">🏆 Sertifikat Telah Diterbitkan</h3>
            <p class="text-sm text-green-600">No. Sertifikat: <strong>{{ $pendaftaran->sertifikat->no_sertifikat }}</strong></p>
            <p class="text-sm text-green-600">Nama: <strong>{{ $pendaftaran->sertifikat->nama_lengkap }}</strong></p>
            <p class="text-sm text-green-600">Terbit: <strong>{{ $pendaftaran->sertifikat->tanggal_terbit->format('d M Y') }}</strong></p>
        </div>
        @endif
    </div>

    <!-- UPDATE FORM -->
    <div class="bg-white p-6 rounded-xl shadow">
        <h3 class="font-semibold text-[#0A2540] mb-4">Update Status</h3>

        <form method="POST" action="{{ route('admin.pendaftaran.update', $pendaftaran->id) }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-xs font-medium mb-1 text-gray-600">Status Progres *</label>
                <select name="status_progres" required class="w-full border rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#00A8A8] focus:outline-none">
                    <option value="menunggu"    {{ $pendaftaran->status_progres === 'menunggu'    ? 'selected' : '' }}>⏳ Menunggu</option>
                    <option value="diproses"    {{ $pendaftaran->status_progres === 'diproses'    ? 'selected' : '' }}>🔄 Diproses</option>
                    <option value="selesai"     {{ $pendaftaran->status_progres === 'selesai'     ? 'selected' : '' }}>✅ Selesai</option>
                    <option value="dibatalkan"  {{ $pendaftaran->status_progres === 'dibatalkan'  ? 'selected' : '' }}>❌ Dibatalkan</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium mb-1 text-gray-600">Status Pembayaran *</label>
                <select name="status_bayar" required class="w-full border rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#00A8A8] focus:outline-none">
                    <option value="belum_bayar"          {{ $pendaftaran->status_bayar === 'belum_bayar'          ? 'selected' : '' }}>💳 Belum Bayar</option>
                    <option value="menunggu_konfirmasi"  {{ $pendaftaran->status_bayar === 'menunggu_konfirmasi'  ? 'selected' : '' }}>⏳ Menunggu Konfirmasi</option>
                    <option value="lunas"                {{ $pendaftaran->status_bayar === 'lunas'                ? 'selected' : '' }}>💰 Lunas</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-medium mb-1 text-gray-600">Tugaskan Petugas</label>
                <select name="petugas_id" class="w-full border rounded-lg p-2.5 text-sm focus:ring-2 focus:ring-[#00A8A8] focus:outline-none">
                    <option value="">— Belum ditugaskan —</option>
                    @foreach($petugas as $pt)
                        <option value="{{ $pt->id }}" {{ $pendaftaran->petugas_id == $pt->id ? 'selected' : '' }}>
                            {{ $pt->nama_lengkap }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full bg-[#0A2540] text-white py-2.5 rounded-lg hover:opacity-90 text-sm">
                Simpan Perubahan
            </button>
        </form>

        @if($pendaftaran->status_progres === 'selesai' && !$pendaftaran->sertifikat)
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('admin.sertifikat.create', $pendaftaran->id) }}"
               class="block w-full text-center bg-[#FF7A00] text-white py-2.5 rounded-lg hover:opacity-90 text-sm">
                🏆 Terbitkan Sertifikat
            </a>
        </div>
        @endif
    </div>

</div>

@endsection
