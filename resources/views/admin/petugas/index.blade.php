@extends('layouts.admin')
@section('page-title', 'Manajemen Petugas')
@section('page-subtitle', 'Kelola data petugas / staf PT Katiga Veritas Indonesia')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-[#0A2540]">Daftar Petugas ({{ $petugas->total() }})</h2>
    <a href="{{ route('admin.petugas.create') }}"
       class="bg-[#00A8A8] text-white px-4 py-2 rounded-lg hover:opacity-90 transition text-sm">
        ➕ Tambah Petugas
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="text-left p-4">#</th>
                <th class="text-left p-4">Nama Lengkap</th>
                <th class="text-left p-4">Email</th>
                <th class="text-left p-4">No. HP</th>
                <th class="text-left p-4">Spesialisasi</th>
                <th class="text-left p-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($petugas as $p)
            <tr class="hover:bg-gray-50">
                <td class="p-4 text-gray-400">{{ $loop->iteration }}</td>
                <td class="p-4 font-medium text-[#0A2540]">{{ $p->nama_lengkap }}</td>
                <td class="p-4 text-gray-600">{{ $p->email }}</td>
                <td class="p-4 text-gray-600">{{ $p->no_hp ?? '-' }}</td>
                <td class="p-4 text-gray-600">{{ $p->spesialisasi ?? '-' }}</td>
                <td class="p-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.petugas.edit', $p->id) }}"
                           class="border border-[#00A8A8] text-[#00A8A8] px-3 py-1 rounded text-xs hover:bg-[#00A8A8] hover:text-white transition">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.petugas.destroy', $p->id) }}"
                              onsubmit="return confirm('Hapus petugas {{ $p->nama_lengkap }}?')">
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
                <td colspan="6" class="p-8 text-center text-gray-500">Belum ada petugas terdaftar</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">{{ $petugas->links() }}</div>
</div>

@endsection
