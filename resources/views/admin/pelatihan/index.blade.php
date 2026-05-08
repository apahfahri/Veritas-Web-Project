@extends('layouts.admin')
@section('page-title', 'Manajemen Layanan')
@section('page-subtitle', 'Kelola semua program layanan (Pelatihan, Konsultasi, Audit)')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-[#7d2ae7]">Daftar Layanan ({{ $layanans->total() }})</h2>
    <a href="{{ route('admin.pelatihan.create') }}"
       class="bg-[#7d2ae7] text-white px-4 py-2 rounded-lg hover:opacity-90 transition text-sm">
        ➕ Tambah Layanan
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="text-left p-4">Materi/Layanan</th>
                <th class="text-left p-4">Kategori</th>
                <th class="text-left p-4">Mode</th>
                <th class="text-left p-4">Tanggal</th>
                <th class="text-left p-4">Lokasi</th>
                <th class="text-left p-4">Pemateri</th>
                <th class="text-left p-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($layanans as $l)
            <tr class="hover:bg-gray-50">
                <td class="p-4 font-medium text-[#7d2ae7] max-w-xs">{{ $l->materi }}</td>
                <td class="p-4 text-gray-600">
                    <span class="bg-gray-100 px-2 py-0.5 rounded text-xs">
                        {{ $l->kategori?->nama ?? '-' }}
                    </span>
                </td>
                <td class="p-4">
                    <span class="px-2 py-1 rounded text-xs {{ $l->jenis_pertemuan === 'online' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700' }}">
                        {{ ucfirst($l->jenis_pertemuan) }}
                    </span>
                </td>
                <td class="p-4 text-gray-600">
                    {{ $l->tanggal_pertemuan ? $l->tanggal_pertemuan->format('d M Y') : '-' }}
                </td>
                <td class="p-4 text-gray-600">{{ $l->lokasi ?? 'Online' }}</td>
                <td class="p-4 text-gray-600">
                    <div class="flex flex-wrap gap-1">
                        @foreach($l->pemateri as $p)
                            <span class="bg-purple-50 text-purple-600 px-1.5 py-0.5 rounded text-[10px]">{{ $p->nama_lengkap }}</span>
                        @endforeach
                        @if($l->pemateri->isEmpty()) - @endif
                    </div>
                </td>
                <td class="p-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.pelatihan.edit', $l->id_layanan) }}"
                           class="border border-[#7d2ae7] text-[#7d2ae7] px-3 py-1 rounded text-xs hover:bg-[#7d2ae7] hover:text-white transition">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.pelatihan.destroy', $l->id_layanan) }}"
                               onsubmit="return confirm('Hapus layanan ini?')">
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
                <td colspan="7" class="p-8 text-center text-gray-500">Belum ada layanan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">{{ $layanans->links() }}</div>
</div>

@endsection
