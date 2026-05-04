@extends('layouts\branch')

@section('title', 'Klien / Mitra')
@section('page-title', 'Manajemen Klien & Mitra')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- FORM INSERT -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm h-fit">
        <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
            <span>🏢</span> Tambah Klien/Mitra Baru
        </h3>
        <p class="text-xs text-slate-500 font-medium mb-5">Daftar mitra khusus regional cabang Anda</p>

        <form action="{{ route('branch-admin.klien.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="nama">Nama Perusahaan/Mitra</label>
                    <input type="text" id="nama" name="nama" required 
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                           placeholder="Contoh: PT Bangun Mandiri Jambi">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="alamat">Alamat Lengkap</label>
                    <textarea id="alamat" name="alamat" required rows="2"
                              class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                              placeholder="Alamat operasional klien"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="nib_oss">NIB OSS</label>
                        <input type="text" id="nib_oss" name="nib_oss"
                               class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                               placeholder="Nomor NIB">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="npwp_perusahaan">NPWP</label>
                        <input type="text" id="npwp_perusahaan" name="npwp_perusahaan"
                               class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                               placeholder="Nomor NPWP">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="sektor_industri">Sektor Industri</label>
                        <input type="text" id="sektor_industri" name="sektor_industri"
                               class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                               placeholder="Contoh: Pertambangan">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="jumlah_karyawan">Jml Karyawan</label>
                        <input type="number" id="jumlah_karyawan" name="jumlah_karyawan"
                               class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                               placeholder="Jumlah staff">
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition shadow-md shadow-cyan-600/10 flex justify-center items-center gap-2 mt-2">
                    <span>➕</span> Tambahkan Klien
                </button>
            </div>
        </form>
    </div>

    <!-- DATA LIST -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
        <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2 mb-5">
            <span>📋</span> Daftar Klien & Mitra Cabang
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase text-xs font-extrabold border-b border-slate-100">
                        <th class="px-5 py-3.5 tracking-wider">Nama Klien</th>
                        <th class="px-5 py-3.5 tracking-wider">Alamat</th>
                        <th class="px-5 py-3.5 tracking-wider">NIB / Sektor</th>
                        <th class="px-5 py-3.5 tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($klien as $item)
                        <tr class="hover:bg-slate-50/40 transition duration-150">
                            <td class="px-5 py-4 font-bold text-slate-800">{{ $item->nama }}</td>
                            <td class="px-5 py-4 text-slate-500 max-w-sm truncate">{{ $item->alamat }}</td>
                            <td class="px-5 py-4 text-slate-500">
                                <span class="block text-slate-700 font-medium text-xs">{{ $item->nib_oss ?: '-' }}</span>
                                <span class="block text-slate-400 text-xs">{{ $item->sektor_industri ?: '-' }}</span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('branch-admin.klien.edit', $item->id) }}" 
                                       class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/60 font-bold rounded-xl text-xs transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('branch-admin.klien.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus klien/mitra ini dari cabang Anda?');">
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
                                Belum ada data klien untuk cabang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
