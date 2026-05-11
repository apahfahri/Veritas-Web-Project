@extends('layouts.admin')
@section('title', 'Kategori Layanan')
@section('page-title', 'Kategori & Jenis Layanan')
@section('page-subtitle', 'Kelola sub-kategori (jenis) untuk setiap kategori layanan utama')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @foreach($kategoris as $k)
    <div class="bg-white rounded-[32px] shadow-sm border border-slate-100 flex flex-col overflow-hidden transition hover:shadow-xl hover:shadow-indigo-50/50 group">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30 group-hover:bg-indigo-50/20 transition-colors">
            <div>
                <h3 class="text-lg font-black text-slate-900 tracking-tight">{{ $k->nama }}</h3>
                <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.2em] mt-1">{{ $k->jenis->count() }} Jenis Terdaftar</p>
            </div>
            <button onclick="openAddModal({{ $k->id_kategori }}, '{{ $k->nama }}')" 
                    class="w-10 h-10 bg-slate-900 text-cyan-400 rounded-2xl flex items-center justify-center hover:bg-slate-800 transition shadow-lg shadow-slate-200 group/btn transform active:scale-95">
                <svg class="w-5 h-5 group-hover/btn:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </button>
        </div>
        
        <div class="p-6 flex-grow bg-white">
            <ul class="space-y-2">
                @forelse($k->jenis as $j)
                <li class="flex justify-between items-center group/item p-4 hover:bg-indigo-50/30 rounded-2xl transition border border-transparent hover:border-indigo-100/50">
                    <span class="text-xs font-black text-slate-600 group-hover/item:text-indigo-600 transition">{{ $j->nama }}</span>
                    <div class="flex gap-1 opacity-0 group-hover/item:opacity-100 transition">
                        <button onclick="openEditModal({{ $j->id_jenis }}, '{{ $j->nama }}')" class="w-8 h-8 flex items-center justify-center text-slate-300 hover:text-indigo-600 hover:bg-white rounded-xl transition shadow-sm border border-transparent hover:border-slate-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        <form action="{{ route('admin.kategori.jenis.destroy', $j->id_jenis) }}" method="POST" class="delete-form" data-name="{{ $j->nama }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-8 h-8 flex items-center justify-center text-slate-300 hover:text-red-600 hover:bg-white rounded-xl transition shadow-sm border border-transparent hover:border-slate-100">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </li>
                @empty
                <li class="flex flex-col items-center py-10">
                    <div class="w-12 h-12 bg-slate-50 text-slate-200 rounded-2xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-2.586 2.586a1 1 0 01-1.414 0L15 13m-3-3V7m0 10v-3m-3 3h6"></path></svg>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">Belum ada jenis layanan</p>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
    @endforeach
</div>

{{-- Add Modal --}}
<div id="addModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-md flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[40px] shadow-2xl w-full max-w-md p-10 animate-in fade-in zoom-in duration-200 border border-slate-100">
        <div class="w-16 h-16 bg-slate-900 text-cyan-400 rounded-3xl flex items-center justify-center mb-8 shadow-xl transform rotate-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </div>
        <h3 class="text-2xl font-black text-slate-900 mb-1 tracking-tight">Tambah Jenis</h3>
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-8">Kategori: <span id="addKategoriName" class="text-indigo-600"></span></p>
        
        <form action="{{ route('admin.kategori.jenis.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="id_kategori" id="addKategoriId">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Nama Jenis Layanan</label>
                <input type="text" name="nama" required placeholder="Misal: Ahli K3 Umum"
                       class="w-full bg-slate-50 border border-slate-100 px-6 py-4 rounded-2xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all">
            </div>
            <div class="flex gap-4 items-center pt-2">
                <button type="button" onclick="closeModals()" class="flex-1 px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition">Batal</button>
                <button type="submit" class="flex-1 bg-slate-900 text-white px-6 py-4 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 transition shadow-xl shadow-slate-200">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="editModal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-md flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[40px] shadow-2xl w-full max-w-md p-10 animate-in fade-in zoom-in duration-200 border border-slate-100">
        <div class="w-16 h-16 bg-indigo-600 text-white rounded-3xl flex items-center justify-center mb-8 shadow-xl transform -rotate-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
        </div>
        <h3 class="text-2xl font-black text-slate-900 mb-8 tracking-tight">Edit Nama Jenis</h3>
        
        <form id="editForm" method="POST" class="space-y-6">
            @csrf @method('PUT')
            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Nama Jenis Layanan</label>
                <input type="text" name="nama" id="editNama" required
                       class="w-full bg-slate-50 border border-slate-100 px-6 py-4 rounded-2xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all">
            </div>
            <div class="flex gap-4 items-center pt-2">
                <button type="button" onclick="closeModals()" class="flex-1 px-6 py-4 text-xs font-black text-slate-400 uppercase tracking-widest hover:text-slate-600 transition">Batal</button>
                <button type="submit" class="flex-1 bg-slate-900 text-white px-6 py-4 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 transition shadow-xl shadow-slate-200">Update</button>
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
        document.body.classList.add('overflow-hidden');
    }

    function openEditModal(id, name) {
        document.getElementById('editNama').value = name;
        document.getElementById('editForm').action = `/admin/kategori/jenis/${id}`;
        document.getElementById('editModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModals() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('editModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    window.addEventListener('keydown', (e) => {
        if(e.key === 'Escape') closeModals();
    });
</script>
@endpush
