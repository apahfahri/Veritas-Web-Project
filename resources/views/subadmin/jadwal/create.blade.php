@extends('layouts.subadmin')
@section('title', 'Tambah Jadwal')
@section('page-title', 'Tambah Jadwal Layanan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('subadmin.jadwal.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-7 py-6 border-b border-slate-100 bg-slate-50/30">
            <h2 class="text-xl font-black text-slate-900">Form Tambah Jadwal</h2>
        </div>

        <form method="POST" action="{{ route('subadmin.jadwal.store') }}" enctype="multipart/form-data" class="p-7 space-y-7">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Kategori *</label>
                    <select name="id_kategori" id="selectKategori" required onchange="loadJenis()"
                            class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}"
                                data-jenis="{{ $k->jenis->map(fn($j) => ['id' => $j->id_jenis, 'nama' => $j->nama, 'kode' => $j->kode_jenis])->toJson() }}"
                                {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                            [{{ $k->kode_kategori }}] {{ $k->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Program *</label>
                    <select name="id_jenis" id="selectJenis" required disabled
                            class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 disabled:opacity-50">
                        <option value="">-- Pilih Kategori dulu --</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Mode Pertemuan *</label>
                    <select name="jenis_pertemuan" required
                            class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="offline">Offline</option>
                        <option value="online">Online</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Harga (IDR) *</label>
                    <input type="number" name="harga" value="{{ old('harga', 0) }}" min="0" required
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Kapasitas</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" min="1"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai') }}"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai') }}"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Jam Mulai</label>
                    <input type="time" name="jam_pertemuan" value="{{ old('jam_pertemuan') }}"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Lokasi / Venue</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="Nama gedung atau kota"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Link Meet Online</label>
                    <input type="url" name="link_meet" value="{{ old('link_meet') }}" placeholder="https://zoom.us/j/... (opsional)"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Pemateri</label>
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 max-h-48 overflow-y-auto space-y-2">
                    @foreach($pemateris as $pm)
                    <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition">
                        <input type="checkbox" name="pemateri_ids[]" value="{{ $pm->id_pemateri }}"
                               {{ is_array(old('pemateri_ids')) && in_array($pm->id_pemateri, old('pemateri_ids')) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-bold text-slate-700">{{ $pm->nama_lengkap }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Pilih Materi Pendukung</label>
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 max-h-48 overflow-y-auto space-y-2">
                    @forelse($materis as $m)
                    <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition">
                        <input type="checkbox" name="materi_ids[]" value="{{ $m->id_materi }}"
                               {{ is_array(old('materi_ids')) && in_array($m->id_materi, old('materi_ids')) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm font-bold text-slate-700">{{ $m->judul }} <span class="text-xs font-normal text-slate-500">({{ Str::limit($m->deskripsi, 30) }})</span></span>
                    </label>
                    @empty
                    <p class="text-sm text-slate-400 p-2">Belum ada master materi. Silakan tambahkan di Kelola Materi.</p>
                    @endforelse
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">File Rundown (Opsional, max 10MB PDF)</label>
                <input type="file" name="file_rundown" accept=".pdf"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder="Deskripsi program..."
                          class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="flex gap-4 pt-4 border-t border-slate-100">
                <a href="{{ route('subadmin.jadwal.index') }}" class="px-6 py-3 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                <button type="submit" class="flex-1 bg-slate-900 text-white py-3 rounded-xl text-sm font-black hover:bg-slate-800 transition">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const jenisData = {};
@foreach($kategoris as $k)
jenisData[{{ $k->id_kategori }}] = {!! $k->jenis->map(fn($j) => ['id' => $j->id_jenis, 'nama' => $j->nama, 'kode' => $j->kode_jenis])->toJson() !!};
@endforeach

function loadJenis() {
    const katId = document.getElementById('selectKategori').value;
    const sel   = document.getElementById('selectJenis');
    sel.innerHTML = '<option value="">-- Pilih Program --</option>';
    if (katId && jenisData[katId]) {
        jenisData[katId].forEach(j => {
            const opt = document.createElement('option');
            opt.value = j.id;
            opt.textContent = j.kode ? `[${j.kode}] ${j.nama}` : j.nama;
            if ('{{ old('id_jenis') }}' == j.id) opt.selected = true;
            sel.appendChild(opt);
        });
        sel.disabled = false;
    } else { sel.disabled = true; }
}
document.addEventListener('DOMContentLoaded', loadJenis);
</script>
@endpush
