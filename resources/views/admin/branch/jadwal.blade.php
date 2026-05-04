@extends('layouts\branch')

@section('title', 'Jadwal Cabang')
@section('page-title', 'Manajemen Jadwal Pelatihan & Audit')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- FORM INSERT -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm h-fit">
        <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
            <span>📅</span> Tambah Jadwal Baru
        </h3>
        <p class="text-xs text-slate-500 font-medium mb-5">Atur jadwal pelatihan & audit khusus cabang Anda</p>

        <form action="{{ route('branch-admin.jadwal.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="layanan_id">Pilih Layanan</label>
                    <select id="layanan_id" name="layanan_id" required 
                            class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                        <option value="">Pilih Layanan Cabang</option>
                        @foreach($layanan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="materi">Nama Materi Pelatihan</label>
                    <input type="text" id="materi" name="materi" required 
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                           placeholder="Contoh: Pembinaan Ahli K3 Umum">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="jenis_pertemuan">Jenis Pertemuan</label>
                        <select id="jenis_pertemuan" name="jenis_pertemuan" required 
                                class="w-full text-sm px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="kapasitas">Kapasitas</label>
                        <input type="number" id="kapasitas" name="kapasitas"
                               class="w-full text-sm px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                               placeholder="Jumlah kuota">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="tanggal_pertemuan">Tanggal</label>
                        <input type="date" id="tanggal_pertemuan" name="tanggal_pertemuan"
                               class="w-full text-sm px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="jam_pertemuan">Jam</label>
                        <input type="time" id="jam_pertemuan" name="jam_pertemuan"
                               class="w-full text-sm px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="lokasi">Lokasi / Tautan Zoom</label>
                    <input type="text" id="lokasi" name="lokasi"
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                           placeholder="Contoh: Hotel Ceria Jambi / Link Zoom">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="deskripsi">Deskripsi Singkat</label>
                    <textarea id="deskripsi" name="deskripsi" rows="2"
                              class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition"
                              placeholder="Deskripsi atau catatan lainnya"></textarea>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition shadow-md shadow-cyan-600/10 flex justify-center items-center gap-2 mt-2">
                    <span>➕</span> Tambahkan Jadwal
                </button>
            </div>
        </form>
    </div>

    <!-- DATA LIST -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
        <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2 mb-5">
            <span>📋</span> Jadwal Pelatihan & Audit Cabang
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase text-xs font-extrabold border-b border-slate-100">
                        <th class="px-5 py-3.5 tracking-wider">Materi & Layanan</th>
                        <th class="px-5 py-3.5 tracking-wider">Tanggal & Jam</th>
                        <th class="px-5 py-3.5 tracking-wider">Jenis / Lokasi</th>
                        <th class="px-5 py-3.5 tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($jadwal as $item)
                        <tr class="hover:bg-slate-50/40 transition duration-150">
                            <td class="px-5 py-4 font-bold text-slate-800">
                                <div>{{ $item->materi }}</div>
                                <div class="text-xs text-slate-400 font-normal mt-0.5">{{ $item->layanan?->nama ?: 'Layanan Umum' }}</div>
                            </td>
                            <td class="px-5 py-4 text-slate-500">
                                <span class="block text-slate-700 font-medium text-xs">{{ $item->tanggal_pertemuan ? $item->tanggal_pertemuan->format('d/m/Y') : '-' }}</span>
                                <span class="block text-slate-400 text-xs font-medium mt-0.5">{{ $item->jam_pertemuan ?: '-' }} WIB</span>
                            </td>
                            <td class="px-5 py-4 text-slate-500">
                                <span class="px-2 py-0.5 text-[10px] bg-slate-50 border border-slate-200 text-slate-600 font-extrabold uppercase rounded select-none">{{ $item->jenis_pertemuan }}</span>
                                <div class="text-xs text-slate-500 max-w-xs truncate mt-1">{{ $item->lokasi ?: '-' }}</div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('branch-admin.jadwal.edit', $item->id) }}" 
                                       class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/60 font-bold rounded-xl text-xs transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('branch-admin.jadwal.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');">
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
                                Belum ada data jadwal pelatihan/audit untuk cabang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
