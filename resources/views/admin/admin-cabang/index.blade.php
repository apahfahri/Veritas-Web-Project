@extends('layouts.admin')
@section('page-title', 'Manajemen Admin Cabang')
@section('page-subtitle', 'Kelola data admin cabang PT Katiga Veritas Indonesia')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-semibold text-[#0A2540]">Daftar Admin Cabang ({{ $admins->total() }})</h2>
    <a href="{{ route('admin.admin-cabang.create') }}"
       class="bg-[#00A8A8] text-white px-4 py-2 rounded-lg hover:opacity-90 transition text-sm">
        ➕ Tambah Admin
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600">
            <tr>
                <th class="text-left p-4">#</th>
                <th class="text-left p-4">Nama Lengkap</th>
                <th class="text-left p-4">Email</th>
                <th class="text-left p-4">Cabang</th>
                <th class="text-left p-4">Status</th>
                <th class="text-left p-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($admins as $a)
            <tr class="hover:bg-gray-50">
                <td class="p-4 text-gray-400">{{ $loop->iteration }}</td>
                <td class="p-4 font-medium text-[#0A2540]">{{ $a->user->name }}</td>
                <td class="p-4 text-gray-600">{{ $a->user->email }}</td>
                <td class="p-4 text-gray-600 capitalize">{{ $a->cabang }}</td>
                <td class="p-4">
                    @if($a->status === 'aktif')
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Aktif</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Nonaktif</span>
                    @endif
                </td>
                <td class="p-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.admin-cabang.edit', $a->id) }}"
                           class="border border-[#00A8A8] text-[#00A8A8] px-3 py-1 rounded text-xs hover:bg-[#00A8A8] hover:text-white transition">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.admin-cabang.destroy', $a->id) }}"
                              onsubmit="return confirm('Hapus admin {{ $a->user->name }}?')">
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
                <td colspan="6" class="p-8 text-center text-gray-500">Belum ada admin cabang terdaftar</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t">{{ $admins->links() }}</div>
</div>

@endsection
