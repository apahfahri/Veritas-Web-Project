@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Ringkasan data operasional PT Katiga Veritas Indonesia')

@section('content')

<!-- STATS GRID -->
<div class="grid grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
        <div><p class="text-sm text-gray-500">Total Pendaftaran</p><p class="text-3xl font-bold text-[#0A2540]">{{ $stats['pendaftaran'] }}</p></div>
        <div class="text-3xl">📋</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
        <div><p class="text-sm text-gray-500">Menunggu Proses</p><p class="text-3xl font-bold text-orange-500">{{ $stats['menunggu'] }}</p></div>
        <div class="text-3xl">⏳</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
        <div><p class="text-sm text-gray-500">Selesai</p><p class="text-3xl font-bold text-green-600">{{ $stats['selesai'] }}</p></div>
        <div class="text-3xl">✅</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
        <div><p class="text-sm text-gray-500">Total Pelatihan</p><p class="text-3xl font-bold text-[#00A8A8]">{{ $stats['pelatihan'] }}</p></div>
        <div class="text-3xl">🎓</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
        <div><p class="text-sm text-gray-500">Petugas Aktif</p><p class="text-3xl font-bold text-blue-600">{{ $stats['petugas'] }}</p></div>
        <div class="text-3xl">👥</div>
    </div>
    <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
        <div><p class="text-sm text-gray-500">Sertifikat Terbit</p><p class="text-3xl font-bold text-[#FF7A00]">{{ $stats['sertifikat'] }}</p></div>
        <div class="text-3xl">🏆</div>
    </div>
</div>

<!-- QUICK LINKS -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <a href="{{ route('admin.pendaftaran.index') }}" class="bg-[#0A2540] text-white p-4 rounded-xl text-center hover:opacity-90 transition">
        <div class="text-2xl mb-2">📋</div><div class="text-sm font-medium">Kelola Pendaftaran</div>
    </a>
    <a href="{{ route('admin.pelatihan.create') }}" class="bg-[#00A8A8] text-white p-4 rounded-xl text-center hover:opacity-90 transition">
        <div class="text-2xl mb-2">➕</div><div class="text-sm font-medium">Tambah Pelatihan</div>
    </a>
    <a href="{{ route('admin.sertifikat.index') }}" class="bg-[#FF7A00] text-white p-4 rounded-xl text-center hover:opacity-90 transition">
        <div class="text-2xl mb-2">🏆</div><div class="text-sm font-medium">Manajemen Sertifikat</div>
    </a>
    <a href="{{ route('admin.petugas.index') }}" class="bg-blue-600 text-white p-4 rounded-xl text-center hover:opacity-90 transition">
        <div class="text-2xl mb-2">👥</div><div class="text-sm font-medium">Manajemen Petugas</div>
    </a>
</div>

<!-- PENDAFTARAN TERBARU -->
<div class="bg-white rounded-xl shadow">
    <div class="p-6 border-b flex justify-between items-center">
        <h2 class="text-lg font-semibold text-[#0A2540]">Pendaftaran Terbaru</h2>
        <a href="{{ route('admin.pendaftaran.index') }}" class="text-sm text-[#00A8A8] hover:underline">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left p-4">Pendaftar</th>
                    <th class="text-left p-4">Layanan</th>
                    <th class="text-left p-4">Tanggal</th>
                    <th class="text-left p-4">Progres</th>
                    <th class="text-left p-4">Bayar</th>
                    <th class="text-left p-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($pendaftaranTerbaru as $p)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 font-medium">{{ $p->user?->name ?? '-' }}</td>
                    <td class="p-4 text-gray-600">{{ $p->layanan?->nama ?? '-' }}</td>
                    <td class="p-4 text-gray-500">{{ $p->tanggal_daftar->format('d M Y') }}</td>
                    <td class="p-4">
                        @php $c = match($p->status_progres) { 'selesai' => 'bg-green-100 text-green-700', 'diproses' => 'bg-blue-100 text-blue-700', 'dibatalkan' => 'bg-red-100 text-red-700', default => 'bg-orange-100 text-orange-700' }; @endphp
                        <span class="px-2 py-1 rounded text-xs {{ $c }}">{{ ucfirst($p->status_progres) }}</span>
                    </td>
                    <td class="p-4">
                        @php $cb = match($p->status_bayar) { 'lunas' => 'bg-green-100 text-green-700', 'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-700', default => 'bg-gray-100 text-gray-600' }; @endphp
                        <span class="px-2 py-1 rounded text-xs {{ $cb }}">{{ str_replace('_', ' ', $p->status_bayar) }}</span>
                    </td>
                    <td class="p-4">
                        <a href="{{ route('admin.pendaftaran.show', $p->id) }}" class="text-[#00A8A8] hover:underline text-xs">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="p-8 text-center text-gray-500">Belum ada pendaftaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
