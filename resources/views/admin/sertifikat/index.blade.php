@extends('layouts.admin')
@section('page-title', 'Manajemen Sertifikat')
@section('page-subtitle', 'Daftar sertifikat yang telah diterbitkan')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-[#0A2540]">Sertifikat Terbit ({{ $sertifikats->total() }})</h2>
    <a href="{{ route('admin.pendaftaran.index') }}?status=selesai"
       class="border border-[#00A8A8] text-[#00A8A8] px-4 py-2 rounded-lg text-sm hover:bg-[#00A8A8] hover:text-white transition">
        + Terbitkan dari Pendaftaran Selesai
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="text-left p-4">No. Sertifikat</th>
                <th class="text-left p-4">Nama Pemegang</th>
                <th class="text-left p-4">Layanan</th>
                <th class="text-left p-4">Tanggal Terbit</th>
                <th class="text-left p-4">Verifikasi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($sertifikats as $s)
            <tr class="hover:bg-gray-50">
                <td class="p-4">
                    <span class="font-mono font-semibold text-[#0A2540]">{{ $s->no_sertifikat }}</span>
                </td>
                <td class="p-4 font-medium">{{ $s->nama_lengkap }}</td>
                <td class="p-4 text-gray-600">{{ $s->pendaftaran?->layanan?->nama ?? '-' }}</td>
                <td class="p-4 text-gray-500">{{ $s->tanggal_terbit->format('d M Y') }}</td>
                <td class="p-4">
                    <a href="{{ route('verification') }}"
                       class="text-[#00A8A8] text-xs hover:underline">
                        🔍 Verifikasi
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-8 text-center text-gray-500">Belum ada sertifikat diterbitkan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">{{ $sertifikats->links() }}</div>
</div>

@endsection
