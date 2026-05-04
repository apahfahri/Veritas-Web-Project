@extends('layouts\branch')

@section('title', 'Peserta & Riwayat')
@section('page-title', 'Database Peserta & Riwayat Layanan')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- FORM INSERT -->
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm h-fit">
        <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2">
            <span>📋</span> Tambah Peserta / Riwayat
        </h3>
        <p class="text-xs text-slate-500 font-medium mb-5">Input pendaftaran baru khusus di cabang Anda</p>

        <form action="{{ route('branch-admin.peserta.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="user_id">Nama User / Klien</label>
                    <select id="user_id" name="user_id" required 
                            class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                        <option value="">Pilih User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->username }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
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
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="tanggal_daftar">Tanggal Daftar</label>
                    <input type="date" id="tanggal_daftar" name="tanggal_daftar" required 
                           class="w-full text-sm px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="status_progres">Progres</label>
                        <select id="status_progres" name="status_progres" required 
                                class="w-full text-sm px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                            <option value="menunggu">Menunggu</option>
                            <option value="diproses">Diproses</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5" for="status_bayar">Pembayaran</label>
                        <select id="status_bayar" name="status_bayar" required 
                                class="w-full text-sm px-3 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-cyan-500 focus:bg-white transition">
                            <option value="belum_bayar">Belum Bayar</option>
                            <option value="menunggu_konfirmasi">Konfirmasi</option>
                            <option value="lunas">Lunas</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-sm px-5 py-3 rounded-xl transition shadow-md shadow-cyan-600/10 flex justify-center items-center gap-2 mt-2">
                    <span>➕</span> Tambahkan Peserta
                </button>
            </div>
        </form>
    </div>

    <!-- DATA LIST -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
        <h3 class="text-base font-black text-slate-900 tracking-tight flex items-center gap-2 mb-5">
            <span>📋</span> Riwayat Peserta Cabang
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full border-collapse text-left text-sm">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 uppercase text-xs font-extrabold border-b border-slate-100">
                        <th class="px-5 py-3.5 tracking-wider">Nama & Email</th>
                        <th class="px-5 py-3.5 tracking-wider">Layanan</th>
                        <th class="px-5 py-3.5 tracking-wider">Tgl Daftar / Status</th>
                        <th class="px-5 py-3.5 tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($peserta as $item)
                        <tr class="hover:bg-slate-50/40 transition duration-150">
                            <td class="px-5 py-4 font-bold text-slate-800">
                                <div>{{ $item->user?->name ?: 'N/A' }}</div>
                                <div class="text-xs text-slate-400 font-normal mt-0.5">{{ $item->user?->email ?: '-' }}</div>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $item->layanan?->nama ?: 'Layanan Umum' }}</td>
                            <td class="px-5 py-4 text-slate-500">
                                <span class="block text-slate-700 font-medium text-xs">{{ $item->tanggal_daftar ? $item->tanggal_daftar->format('d/m/Y') : '-' }}</span>
                                <div class="mt-1 flex gap-1 select-none">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase {{ $item->status_progres === 'selesai' ? 'bg-emerald-50 text-emerald-600 border border-emerald-200/50' : ($item->status_progres === 'diproses' ? 'bg-amber-50 text-amber-600 border border-amber-200/50' : 'bg-slate-50 text-slate-600 border border-slate-200/50') }}">
                                        {{ $item->status_progres }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-black uppercase {{ $item->status_bayar === 'lunas' ? 'bg-teal-50 text-teal-600 border border-teal-200/50' : ($item->status_bayar === 'menunggu_konfirmasi' ? 'bg-amber-50 text-amber-600 border border-amber-200/50' : 'bg-red-50 text-red-600 border border-red-200/50') }}">
                                        {{ $item->status_bayar }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('branch-admin.peserta.edit', $item->id) }}" 
                                       class="px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200/60 font-bold rounded-xl text-xs transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('branch-admin.peserta.delete', $item->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat peserta ini?');">
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
                                Belum ada data peserta untuk cabang ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
