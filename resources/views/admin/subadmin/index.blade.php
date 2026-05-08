@extends('layouts.admin')
@section('page-title', 'Manajemen Subadmin')
@section('page-subtitle', 'Kelola data subadmin PT Katiga Veritas Indonesia')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-[#7d2ae7]">Daftar Subadmin ({{ $admins->total() }})</h2>
    <a href="{{ route('admin.subadmin.create') }}"
       class="bg-[#7d2ae7] text-white px-4 py-2 rounded-lg hover:opacity-90 transition text-sm">
        ➕ Tambah Subadmin
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="text-left p-4">#</th>
                <th class="p-4 text-left">Username</th>
                <th class="p-4 text-left">Email</th>
                <th class="p-4 text-left">No. Telp</th>
                <th class="p-4 text-left">Status</th>
                <th class="p-4 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($admins as $a)
            <tr class="hover:bg-gray-50">
                <td class="p-4 text-gray-400">{{ $loop->iteration }}</td>
                <td class="p-4 font-medium text-[#7d2ae7]">{{ $a->username }}</td>
                <td class="p-4 text-gray-600">{{ $a->email }}</td>
                <td class="p-4 text-gray-600">{{ $a->no_telp ?? '-' }}</td>
                <td class="p-4">
                    @if($a->status === 'aktif')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Aktif</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Nonaktif</span>
                    @endif
                </td>
                <td class="p-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.subadmin.edit', $a->id_admin) }}"
                           class="border border-[#7d2ae7] text-[#7d2ae7] px-3 py-1 rounded text-xs hover:bg-[#7d2ae7] hover:text-white transition">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.subadmin.destroy', $a->id_admin) }}"
                               onsubmit="return confirm('Hapus subadmin {{ $a->username }}?')">
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
                <td colspan="6" class="p-8 text-center text-gray-500">Belum ada subadmin terdaftar</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">{{ $admins->links() }}</div>
</div>

@endsection
