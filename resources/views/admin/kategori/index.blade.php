@extends('layouts.admin')
@section('page-title', 'Kategori & Jenis Layanan')
@section('page-subtitle', 'Kelola sub-kategori (jenis) untuk setiap kategori layanan')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($kategoris as $k)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col">
        <div class="p-5 border-b border-gray-50 flex justify-between items-center bg-gray-50/50 rounded-t-xl">
            <div>
                <h3 class="font-bold text-gray-800">{{ $k->nama }}</h3>
                <p class="text-xs text-gray-500">{{ $k->jenis->count() }} Jenis Terdaftar</p>
            </div>
            <button onclick="openAddModal({{ $k->id_kategori }}, '{{ $k->nama }}')" 
                    class="bg-[#7d2ae7] text-white p-2 rounded-lg hover:opacity-90 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </button>
        </div>
        
        <div class="p-4 flex-grow">
            <ul class="space-y-2">
                @forelse($k->jenis as $j)
                <li class="flex justify-between items-center group p-2 hover:bg-gray-50 rounded-lg transition">
                    <span class="text-sm text-gray-700">{{ $j->nama }}</span>
                    <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition">
                        <button onclick="openEditModal({{ $j->id_jenis }}, '{{ $j->nama }}')" class="p-1 text-blue-500 hover:bg-blue-50 rounded">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        <form action="{{ route('admin.kategori.jenis.destroy', $j->id_jenis) }}" method="POST" onsubmit="return confirm('Hapus jenis ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1 text-red-500 hover:bg-red-50 rounded">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </li>
                @empty
                <li class="text-xs text-gray-400 text-center py-4 italic">Belum ada jenis ditambahkan</li>
                @endforelse
            </ul>
        </div>
    </div>
    @endforeach
</div>

{{-- Add Modal --}}
<div id="addModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 animate-in fade-in zoom-in duration-200">
        <h3 class="text-lg font-bold text-gray-800 mb-1">Tambah Jenis Layanan</h3>
        <p class="text-sm text-gray-500 mb-4">Menambahkan ke kategori: <span id="addKategoriName" class="font-semibold text-[#7d2ae7]"></span></p>
        
        <form action="{{ route('admin.kategori.jenis.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_kategori" id="addKategoriId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jenis Layanan</label>
                <input type="text" name="nama" required placeholder="Misal: Ahli K3 Umum"
                       class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none transition">
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeModals()" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                <button type="submit" class="bg-[#7d2ae7] text-white px-6 py-2 rounded-lg text-sm font-bold hover:opacity-90">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 animate-in fade-in zoom-in duration-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Edit Nama Jenis</h3>
        
        <form id="editForm" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Jenis Layanan</label>
                <input type="text" name="nama" id="editNama" required
                       class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none transition">
            </div>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeModals()" class="px-4 py-2 text-sm text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                <button type="submit" class="bg-[#7d2ae7] text-white px-6 py-2 rounded-lg text-sm font-bold hover:opacity-90">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openAddModal(id, name) {
        document.getElementById('addKategoriId').value = id;
        document.getElementById('addKategoriName').textContent = name;
        document.getElementById('addModal').classList.remove('hidden');
    }

    function openEditModal(id, name) {
        document.getElementById('editNama').value = name;
        document.getElementById('editForm').action = `/admin/kategori/jenis/${id}`;
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModals() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('editModal').classList.add('hidden');
    }

    // Close on escape
    window.addEventListener('keydown', (e) => {
        if(e.key === 'Escape') closeModals();
    });
</script>
@endpush
