@extends('layouts.admin')
@section('page-title', 'Manajemen Pendaftaran')
@section('page-subtitle', 'Kelola dan pantau semua pendaftaran layanan')

@section('content')

<!-- FILTER -->
<form method="GET" class="bg-white p-4 rounded-xl shadow mb-6 flex gap-4 items-end">
    <div>
        <label class="block text-xs font-medium mb-1 text-gray-600">Status Progres</label>
        <select name="status" class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
            <option value="">Semua Status</option>
            <option value="menunggu"    {{ request('status') === 'menunggu'    ? 'selected' : '' }}>Menunggu</option>
            <option value="diproses"    {{ request('status') === 'diproses'    ? 'selected' : '' }}>Diproses</option>
            <option value="selesai"     {{ request('status') === 'selesai'     ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan"  {{ request('status') === 'dibatalkan'  ? 'selected' : '' }}>Dibatalkan</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-medium mb-1 text-gray-600">Status Bayar</label>
        <select name="bayar" class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
            <option value="">Semua Bayar</option>
            <option value="belum_bayar"          {{ request('bayar') === 'belum_bayar'          ? 'selected' : '' }}>Belum Bayar</option>
            <option value="menunggu_konfirmasi"  {{ request('bayar') === 'menunggu_konfirmasi'  ? 'selected' : '' }}>Menunggu Konfirmasi</option>
            <option value="lunas"                {{ request('bayar') === 'lunas'                ? 'selected' : '' }}>Lunas</option>
        </select>
    </div>
    <button type="submit" class="bg-[#7d2ae7] text-white px-4 py-2 rounded-lg text-sm hover:opacity-90">Filter</button>
    <a href="{{ route('admin.pendaftaran.index') }}" class="border px-4 py-2 rounded-lg text-sm hover:bg-gray-50">Reset</a>
</form>

<!-- TABLE -->
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="p-4 border-b">
        <span class="text-sm text-gray-600">Total: <strong>{{ $pendaftarans->total() }}</strong> pendaftaran</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600">
                <tr>
                    <th class="text-left p-4">Pendaftar</th>
                    <th class="text-left p-4">Layanan</th>
                    <th class="text-left p-4">Tgl Daftar</th>
                    <th class="text-left p-4">Petugas</th>
                    <th class="text-left p-4">Progres</th>
                    <th class="text-left p-4">Bayar</th>
                    <th class="text-left p-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($pendaftarans as $p)
                <tr class="hover:bg-gray-50">
                    <td class="p-4">
                        <div class="font-medium text-[#7d2ae7]">{{ $p->user?->name }}</div>
                        <div class="text-xs text-gray-500">{{ $p->user?->email }}</div>
                    </td>
                    <td class="p-4 text-gray-600">{{ $p->layanan?->nama ?? '-' }}</td>
                    <td class="p-4 text-gray-500 whitespace-nowrap">{{ $p->tanggal_daftar->format('d M Y') }}</td>
                    <td class="p-4 text-gray-600">{{ $p->petugas?->nama_lengkap ?? '—' }}</td>
                    <td class="p-4">
                        @php $c = match($p->status_progres) { 'selesai' => 'bg-green-100 text-green-700', 'diproses' => 'bg-blue-100 text-blue-700', 'dibatalkan' => 'bg-red-100 text-red-700', default => 'bg-orange-100 text-orange-700' }; @endphp
                        <span class="px-2 py-1 rounded-full text-xs {{ $c }}">{{ ucfirst($p->status_progres) }}</span>
                    </td>
                    <td class="p-4">
                        @php $cb = match($p->status_bayar) { 'lunas' => 'bg-green-100 text-green-700', 'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-700', default => 'bg-gray-100 text-gray-600' }; @endphp
                        <span class="px-2 py-1 rounded-full text-xs {{ $cb }}">{{ str_replace('_', ' ', ucfirst($p->status_bayar)) }}</span>
                    </td>
                    <td class="p-4">
                        <div class="flex gap-2 flex-wrap">
                            <a href="{{ route('admin.pendaftaran.show', $p->id) }}"
                               class="border border-[#7d2ae7] text-[#7d2ae7] px-3 py-1 rounded text-xs hover:bg-[#7d2ae7] hover:text-white transition">
                                Detail
                            </a>
                            @if($p->status_progres === 'selesai' && !$p->sertifikat)
                            <a href="{{ route('admin.sertifikat.create', $p->id) }}"
                               class="border border-[#7d2ae7] text-[#7d2ae7] px-3 py-1 rounded text-xs hover:bg-[#7d2ae7] hover:text-white transition">
                                🏆 Sertifikat
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="p-8 text-center text-gray-500">Tidak ada pendaftaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t">{{ $pendaftarans->links() }}</div>
</div>

@endsection
