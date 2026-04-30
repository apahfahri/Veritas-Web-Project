@extends('layouts.admin')
@section('page-title', 'Manajemen Pelatihan')
@section('page-subtitle', 'Kelola jadwal dan program pelatihan K3')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-[#0A2540]">Daftar Pelatihan ({{ $pelatihans->total() }})</h2>
    <a href="{{ route('admin.pelatihan.create') }}"
       class="bg-[#00A8A8] text-white px-4 py-2 rounded-lg hover:opacity-90 transition text-sm">
        ➕ Tambah Pelatihan
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="text-left p-4">Materi</th>
                <th class="text-left p-4">Layanan</th>
                <th class="text-left p-4">Mode</th>
                <th class="text-left p-4">Tanggal</th>
                <th class="text-left p-4">Lokasi</th>
                <th class="text-left p-4">Kapasitas</th>
                <th class="text-left p-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($pelatihans as $p)
            <tr class="hover:bg-gray-50">
                <td class="p-4 font-medium text-[#0A2540] max-w-xs">{{ $p->materi }}</td>
                <td class="p-4 text-gray-600">{{ $p->layanan?->nama ?? '-' }}</td>
                <td class="p-4">
                    <span class="px-2 py-1 rounded text-xs {{ $p->jenis_pertemuan === 'online' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                        {{ ucfirst($p->jenis_pertemuan) }}
                    </span>
                </td>
                <td class="p-4 text-gray-600">
                    {{ $p->tanggal_pertemuan ? $p->tanggal_pertemuan->format('d M Y') : '-' }}
                </td>
                <td class="p-4 text-gray-600">{{ $p->lokasi ?? 'Online' }}</td>
                <td class="p-4 text-gray-600">{{ $p->kapasitas ?? '∞' }}</td>
                <td class="p-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.pelatihan.edit', $p->id) }}"
                           class="border border-[#00A8A8] text-[#00A8A8] px-3 py-1 rounded text-xs hover:bg-[#00A8A8] hover:text-white transition">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.pelatihan.destroy', $p->id) }}"
                              onsubmit="return confirm('Hapus pelatihan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="border border-red-400 text-red-500 px-3 py-1 rounded text-xs hover:bg-red-500 hover:text-white transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="p-8 text-center text-gray-500">Belum ada pelatihan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">{{ $pelatihans->links() }}</div>
</div>

@endsection
