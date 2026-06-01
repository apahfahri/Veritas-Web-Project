@extends('layouts.subadmin')
@section('title', 'Edit Jadwal')
@section('page-title', 'Edit Jadwal Layanan')

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
            <h2 class="text-xl font-black text-slate-900">Edit: {{ $jadwal->jenis?->nama ?? 'Jadwal #'.$jadwal->id_jadwal }}</h2>
        </div>

        <form method="POST" action="{{ route('subadmin.jadwal.update', $jadwal->id_jadwal) }}" enctype="multipart/form-data" class="p-7 space-y-7">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Kategori *</label>
                    <select name="id_kategori" id="selectKategori" required onchange="loadJenis()" disabled
                            class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}"
                                data-jenis="{{ $k->jenis->map(fn($j) => ['id' => $j->id_jenis, 'nama' => $j->nama, 'kode' => $j->kode_jenis])->toJson() }}"
                                {{ old('id_kategori', $jadwal->id_kategori) == $k->id_kategori ? 'selected' : '' }}>
                            [{{ $k->kode_kategori }}] {{ $k->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Program *</label>
                    <select name="id_jenis" id="selectJenis" required disabled
                            class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="">-- Pilih Jenis --</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Mode Pertemuan *</label>
                    <select name="jenis_pertemuan" required disabled
                            class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="offline" {{ old('jenis_pertemuan', $jadwal->jenis_pertemuan) == 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="online"  {{ old('jenis_pertemuan', $jadwal->jenis_pertemuan) == 'online'  ? 'selected' : '' }}>Online</option>
                        <option value="hybrid"  {{ old('jenis_pertemuan', $jadwal->jenis_pertemuan) == 'hybrid'  ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Harga (IDR) *</label>
                    <input type="number" name="harga" value="{{ old('harga', $jadwal->harga) }}" min="0" required disabled
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Kapasitas</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas', $jadwal->kapasitas) }}" min="1" disabled
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Tanggal Mulai</label>
                    <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai', $jadwal->tgl_mulai?->format('Y-m-d')) }}" disabled
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Tanggal Selesai</label>
                    <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai', $jadwal->tgl_selesai?->format('Y-m-d')) }}" disabled
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Jam Mulai</label>
                    <input type="time" name="jam_pertemuan" value="{{ old('jam_pertemuan', $jadwal->jam_pertemuan) }}" disabled
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Lokasi / Venue</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $jadwal->lokasi) }}" disabled
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Link Meet Online</label>
                    <input type="url" name="link_meet" value="{{ old('link_meet', $jadwal->link_meet) }}" placeholder="https://zoom.us/j/... (opsional)" disabled
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Pemateri</label>
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 max-h-48 overflow-y-auto space-y-2">
                    @foreach($pemateris as $pm)
                    @php $checked = $jadwal->pemateri->contains('id_pemateri', $pm->id_pemateri); @endphp
                    <label class="flex items-center gap-3 cursor-not-allowed hover:bg-white p-2 rounded-lg transition">
                        <input type="checkbox" name="pemateri_ids[]" value="{{ $pm->id_pemateri }}"
                               {{ $checked ? 'checked' : '' }} disabled
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
                    @php $materi_checked = $jadwal->materi->contains('id_materi', $m->id_materi); @endphp
                    <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded-lg transition">
                        <input type="checkbox" name="materi_ids[]" value="{{ $m->id_materi }}"
                               {{ $materi_checked ? 'checked' : '' }}
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
                @if($jadwal->file_rundown)
                <div class="mb-3 text-sm">
                    File saat ini: <a href="{{ Storage::url($jadwal->file_rundown) }}" target="_blank" class="text-indigo-600 font-bold underline">Lihat PDF Rundown</a>
                </div>
                @endif
                <input type="file" name="file_rundown" accept=".pdf"
                       class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="text-xs text-slate-400 mt-2">Biarkan kosong jika tidak ingin mengubah file rundown.</p>
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Deskripsi</label>
                <textarea name="deskripsi" rows="3" disabled
                          class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">{{ old('deskripsi', $jadwal->deskripsi) }}</textarea>
            </div>

            <div class="flex gap-4 pt-4 border-t border-slate-100">
                <a href="{{ route('subadmin.jadwal.index') }}" class="px-6 py-3 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                <button type="submit" class="flex-1 bg-slate-900 text-white py-3 rounded-xl text-sm font-black hover:bg-slate-800 transition">Perbarui Jadwal</button>
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

const currentJenisId = {{ $jadwal->id_jenis ?? 'null' }};

function loadJenis() {
    const katId = document.getElementById('selectKategori').value;
    const sel   = document.getElementById('selectJenis');
    sel.innerHTML = '<option value="">-- Pilih Program --</option>';
    if (katId && jenisData[katId]) {
        jenisData[katId].forEach(j => {
            const opt = document.createElement('option');
            opt.value = j.id;
            opt.textContent = j.kode ? `[${j.kode}] ${j.nama}` : j.nama;
            if (currentJenisId == j.id) opt.selected = true;
            sel.appendChild(opt);
        });
        sel.disabled = true;
    } else { sel.disabled = true; }
}
document.addEventListener('DOMContentLoaded', loadJenis);
</script>
@endpush
