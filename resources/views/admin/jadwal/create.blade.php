@extends('layouts.admin')
@section('title', 'Tambah Jadwal Layanan')
@section('page-title', 'Tambah Jadwal')
@section('page-subtitle', 'Buat jadwal program layanan baru (Pelatihan, Konsultasi, Audit)')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.jadwal.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Form Tambah Jadwal</h2>
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Lengkapi detail jadwal pelaksanaan program layanan</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.jadwal.store') }}" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf

            {{-- Kategori, Jenis Program --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Kategori Layanan *</label>
                    <select name="id_kategori" id="selectKategori" required onchange="loadJenis()"
                            class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition @error('id_kategori') border-red-400 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}"
                                data-jenis="{{ $k->jenis->map(fn($j) => ['id' => $j->id_jenis, 'nama' => $j->nama, 'kode' => $j->kode_jenis])->toJson() }}"
                                {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                            [{{ $k->kode_kategori }}] {{ $k->nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_kategori')<p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Program / Jenis Layanan *</label>
                    <select name="id_jenis" id="selectJenis" required
                            class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition disabled:opacity-50 @error('id_jenis') border-red-400 @enderror" disabled>
                        <option value="">-- Pilih Kategori dulu --</option>
                    </select>
                    @error('id_jenis')<p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Harga & Mode --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Biaya Investasi (IDR) *</label>
                    <input type="number" name="harga" value="{{ old('harga', 0) }}" required min="0"
                           placeholder="Contoh: 5000000"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-black text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition @error('harga') border-red-400 @enderror">
                    @error('harga')<p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Mode Pertemuan *</label>
                    <select name="jenis_pertemuan" required
                            class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                        <option value="offline" {{ old('jenis_pertemuan') == 'offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                        <option value="online"  {{ old('jenis_pertemuan') == 'online'  ? 'selected' : '' }}>Online (Zoom / Meet)</option>
                        <option value="hybrid"  {{ old('jenis_pertemuan') == 'hybrid'  ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
            </div>

            {{-- Tanggal & Jam --}}
            <div class="bg-slate-50/50 p-6 rounded-3xl border border-slate-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Jadwal Pelaksanaan</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai') }}"
                               class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai') }}"
                               class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Jam Mulai</label>
                        <input type="time" name="jam_pertemuan" value="{{ old('jam_pertemuan') }}"
                               class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                    </div>
                </div>
            </div>

            {{-- Lokasi, Link Meet & Kapasitas --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Lokasi / Venue</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                           placeholder="Nama gedung / kota (kosongkan jika online)"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Link Meet Online</label>
                    <input type="url" name="link_meet" value="{{ old('link_meet') }}"
                           placeholder="https://zoom.us/j/... (kosongkan jika offline)"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Kapasitas Peserta</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" min="1"
                           placeholder="Contoh: 30"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                </div>
            </div>

            {{-- Pemateri & Deskripsi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Pemateri <span class="normal-case text-slate-300">(multi-pilih)</span></label>
                    <div class="bg-white border border-slate-200 rounded-2xl p-4 space-y-3">
                        <input type="text" id="searchPemateri" placeholder="🔍 Cari pemateri..."
                               oninput="filterPemateri(this.value)"
                               class="w-full bg-slate-50 border border-slate-100 px-4 py-2 text-xs rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">
                        <div id="pemateriList" class="max-h-44 overflow-y-auto space-y-1 pr-1">
                            @forelse($pemateris as $pm)
                            @php $checked = is_array(old('pemateri_ids')) && in_array($pm->id_pemateri, old('pemateri_ids')); @endphp
                            <label class="pemateri-item flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition cursor-pointer group"
                                   data-name="{{ strtolower($pm->nama_lengkap) }}">
                                <input type="checkbox" name="pemateri_ids[]" value="{{ $pm->id_pemateri }}"
                                       {{ $checked ? 'checked' : '' }}
                                       class="w-4 h-4 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-xs font-bold text-slate-600 group-hover:text-slate-900 transition">{{ $pm->nama_lengkap }}</span>
                            </label>
                            @empty
                            <p class="text-[10px] text-slate-400 text-center py-4 font-bold uppercase">Belum ada pemateri</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Pilih Materi Pendukung <span class="normal-case text-slate-300">(multi-pilih)</span></label>
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
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">File Rundown (Opsional, max 10MB PDF)</label>
                        <input type="file" name="file_rundown" accept=".pdf"
                               class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-xl text-sm font-bold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Foto / Banner Pelatihan (Opsional, max 2MB JPG/PNG)</label>
                        <div class="flex items-center gap-6 bg-slate-50 border border-slate-200 rounded-2xl p-4">
                            <div class="relative w-20 h-20 bg-white rounded-xl border border-slate-200 overflow-hidden flex items-center justify-center flex-shrink-0">
                                <img id="foto-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                                <svg id="foto-placeholder" class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex-1">
                                <input type="file" name="foto" accept="image/*" onchange="previewFoto(this)"
                                       class="w-full text-xs font-bold file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <p class="text-[10px] text-slate-400 mt-1">Format: JPG, JPEG, atau PNG. Maksimal 2MB.</p>
                            </div>
                        </div>
                        @error('foto')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="8" placeholder="Deskripsi singkat program..."
                              class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">{{ old('deskripsi') }}</textarea>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 pt-6 border-t border-slate-50">
                <a href="{{ route('admin.jadwal.index') }}" class="px-8 py-4 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl text-sm font-black hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center justify-center gap-2 group">
                    <svg class="w-5 h-5 text-cyan-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Jadwal
                </button>
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
    } else {
        sel.disabled = true;
    }
}

function filterPemateri(q) {
    document.querySelectorAll('.pemateri-item').forEach(item => {
        item.style.display = item.dataset.name.includes(q.toLowerCase()) ? '' : 'none';
    });
}

function previewFoto(input) {
    const preview = document.getElementById('foto-preview');
    const placeholder = document.getElementById('foto-placeholder');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.src = '#';
        preview.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }
}

document.addEventListener('DOMContentLoaded', loadJenis);
</script>
@endpush
