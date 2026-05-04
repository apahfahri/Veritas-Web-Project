@extends('layouts\branch')

@section('title', 'Sertifikat Cabang')
@section('page-title', 'Manajemen Sertifikat Peserta')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- FORM INSERT -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm h-fit">
        <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
            <span>🏆</span> Terbitkan Sertifikat Baru
        </h3>
        <p class="text-xs text-slate-500 font-medium mb-5">Dokumen penghargaan khusus cabang Anda</p>

        <form action="{{ route('branch-admin.sertifikat.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="no_sertifikat">Nomor Sertifikat</label>
                    <input type="text" id="no_sertifikat" name="no_sertifikat" required 
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                           placeholder="Contoh: SERT-JAMBI/001/V/2026">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="pendaftaran_id">Pendaftaran Peserta</label>
                    <select id="pendaftaran_id" name="pendaftaran_id" required 
                            class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                        <option value="">Pilih Riwayat Pendaftaran</option>
                        @foreach($pendaftaran as $p)
                            <option value="{{ $p->id }}">{{ $p->user?->name ?: 'No Name' }} - {{ $p->layanan?->nama ?: 'No Layanan' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="nama_lengkap">Nama Lengkap Penerima</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" required 
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                           placeholder="Contoh: Ahmad Budiman">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="tanggal_terbit">Tanggal Terbit</label>
                    <input type="date" id="tanggal_terbit" name="tanggal_terbit" required 
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition shadow-md shadow-cyan-600/10 flex justify-center items-center gap-2 mt-2">
                    <span>➕</span> Terbitkan Sertifikat
                </button>
            </div>
        </form>
    </div>

    <!-- DATA LIST -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
        <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2 mb-5">
            <span>📋</span> Daftar Sertifikat Terbit Cabang
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase text-xs font-extrabold border-b border-slate-100">
                        <th class="px-5 py-3.5 tracking-wider">No Sertifikat</th>
                        <th class="px-5 py-3.5 tracking-wider">Nama & Tgl Terbit</th>
                        <th class="px-5 py-3.5 tracking-wider">Layanan</th>
                        <th class="px-5 py-3.5 tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($sertifikat as $item)
                        <tr class="hover:bg-slate-50/40 transition duration-150">
                            <td class="px-5 py-4 font-bold text-slate-800">{{ $item->no_sertifikat }}</td>
                            <td class="px-5 py-4 text-slate-500">
                                <span class="block text-slate-700 font-bold text-xs">{{ $item->nama_lengkap }}</span>
                                <span class="block text-slate-400 text-xs font-medium mt-0.5">{{ $item->tanggal_terbit ? $item->tanggal_terbit->format('d/m/Y') : '-' }}</span>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $item->pendaftaran?->layanan?->nama ?: 'Layanan' }}</td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('branch-admin.sertifikat.edit', $item->id) }}" 
                                       class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/60 font-bold rounded-xl text-xs transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('branch-admin.sertifikat.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus sertifikat ini?');">
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
                            <td colspan="4" class="px-5 py-12 text-center text-slate-400 font-medium">
                                <span class="text-2xl block mb-2">📁</span>
                                Belum ada data sertifikat untuk cabang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
