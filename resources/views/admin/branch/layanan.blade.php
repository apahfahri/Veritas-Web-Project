@extends('layouts\branch')

@section('title', 'Layanan Cabang')
@section('page-title', 'Manajemen Layanan Cabang')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- FORM INSERT -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm h-fit">
        <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
            <span>✨</span> Tambah Layanan Baru
        </h3>
        <p class="text-xs text-slate-500 font-medium mb-5">Konten khusus untuk cabang Anda</p>

        <form action="{{ route('branch-admin.layanan.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="nama">Nama Layanan</label>
                    <input type="text" id="nama" name="nama" required 
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                           placeholder="Contoh: Pelatihan K3 Jambi">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                              class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                              placeholder="Penjelasan singkat layanan"></textarea>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition shadow-md shadow-cyan-600/10 flex justify-center items-center gap-2">
                    <span>➕</span> Tambahkan
                </button>
            </div>
        </form>
    </div>

    <!-- DATA LIST -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
        <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2 mb-5">
            <span>📋</span> Daftar Layanan Cabang
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase text-xs font-extrabold border-b border-slate-100">
                        <th class="px-5 py-3.5 tracking-wider">Nama Layanan</th>
                        <th class="px-5 py-3.5 tracking-wider">Deskripsi</th>
                        <th class="px-5 py-3.5 tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($layanan as $item)
                        <tr class="hover:bg-slate-50/40 transition duration-150">
                            <td class="px-5 py-4 font-bold text-slate-800">{{ $item->nama }}</td>
                            <td class="px-5 py-4 text-slate-500 max-w-sm truncate">{{ $item->deskripsi ?: '-' }}</td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('branch-admin.layanan.edit', $item->id) }}" 
                                       class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/60 font-bold rounded-xl text-xs transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('branch-admin.layanan.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus layanan ini dari cabang Anda?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200/60 font-bold rounded-xl text-xs transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-12 text-center text-slate-400 font-medium">
                                <span class="text-2xl block mb-2">📁</span>
                                Belum ada data layanan untuk cabang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
