@extends('layouts.admin')
@section('title', 'Edit Layanan')
@section('page-title', 'Edit Layanan')
@section('page-subtitle', 'Perbarui detail program layanan (Pelatihan, Konsultasi, Audit)')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.pelatihan.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <i class="fi fi-rr-arrow-left"></i>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-sm">
                    <i class="fi fi-rr-edit"></i>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Edit Layanan</h2>
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">ID LAYANAN: #{{ $layanan->id_layanan }}</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.pelatihan.update', $layanan->id_layanan) }}" class="p-8 space-y-8">
            @csrf @method('PUT')

            <!-- SECTION 1: KATEGORI, KODE & NAMA -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-apps text-indigo-500"></i>
                        Kategori Layanan *
                    </label>
                    <select name="id_kategori" id="selectKategori" required onchange="handleKategoriChange()" 
                            class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id_kategori }}" data-jenis="{{ $k->jenis }}" {{ old('id_kategori', $layanan->id_kategori) == $k->id_kategori ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-info text-indigo-500"></i>
                        Nama Layanan *
                    </label>
                    
                    <div id="containerJenis" class="hidden mb-2">
                        <select id="selectJenis" onchange="handleJenisChange(this.value)" disabled
                                class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="lainnya">Lainnya (Input Manual)</option>
                        </select>
                    </div>

                    <input type="text" name="nama" id="inputNama" value="{{ old('nama', $layanan->nama) }}" required disabled
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none disabled:opacity-50 transition @error('nama') border-red-400 @enderror">
                    @error('nama')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-code text-indigo-500"></i>
                        Kode Singkatan (Opsional)
                    </label>
                    <input type="text" name="kode_layanan" value="{{ old('kode_layanan', $layanan->kode_layanan) }}"
                           placeholder="Contoh: PAK3U" maxlength="10"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition @error('kode_layanan') border-red-400 @enderror">
                    @error('kode_layanan')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- SECTION 2: MATERI & HARGA -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-book-alt .5 .5 text-indigo-500"></i>
                        Materi / Detail *
                    </label>
                    <input type="text" name="materi" value="{{ old('materi', $layanan->materi) }}" required
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition @error('materi') border-red-400 @enderror">
                    @error('materi')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-dollar text-indigo-500"></i>
                        Harga (IDR) *
                    </label>
                    <input type="number" name="harga" value="{{ old('harga', $layanan->harga) }}" required min="0"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-black text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition @error('harga') border-red-400 @enderror">
                    @error('harga')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- SECTION 3: TANGGAL & WAKTU -->
            <div class="bg-slate-50/50 p-6 rounded-3xl border border-slate-100 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                            <i class="fi fi-rr-calendar .5 .5 text-indigo-500"></i>
                            Tgl Mulai *
                        </label>
                        <input type="date" name="tgl_mulai" 
                               value="{{ old('tgl_mulai', $layanan->tgl_mulai?->format('Y-m-d')) }}" required
                               class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                            <i class="fi fi-rr-calendar .5 .5 text-indigo-500"></i>
                            Tgl Selesai *
                        </label>
                        <input type="date" name="tgl_selesai" 
                               value="{{ old('tgl_selesai', $layanan->tgl_selesai?->format('Y-m-d')) }}" required
                               class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                            <i class="fi fi-rr-time-past .5 .5 text-indigo-500"></i>
                            Jam Pertemuan
                        </label>
                        <input type="time" name="jam_pertemuan" 
                               value="{{ old('jam_pertemuan', substr($layanan->jam_pertemuan ?? '', 0, 5)) }}"
                               class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                    </div>
                </div>
            </div>

            <!-- SECTION 4: MODE & LOKASI -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-users text-indigo-500"></i>
                        Jenis Pertemuan *
                    </label>
                    <select name="jenis_pertemuan" required class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                        <option value="offline" {{ old('jenis_pertemuan', $layanan->jenis_pertemuan) === 'offline' ? 'selected' : '' }}>Offline</option>
                        <option value="online"  {{ old('jenis_pertemuan', $layanan->jenis_pertemuan) === 'online'  ? 'selected' : '' }}>Online</option>
                    </select>
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-marker text-indigo-500"></i>
                        Lokasi / Venue
                    </label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $layanan->lokasi) }}"
                           placeholder="Nama gedung / kota (kosongkan jika online)"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                </div>
            </div>

            <!-- SECTION 5: PEMATERI & KAPASITAS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-user text-indigo-500"></i>
                        Pilih Pemateri <span class="text-[9px] font-bold text-slate-300 normal-case ml-2">(bisa pilih lebih dari satu)</span>
                    </label>

                    <div class="bg-white border border-slate-200 rounded-2xl p-4 space-y-3">
                        <input type="text" id="searchPemateri" placeholder="🔍 Cari nama pemateri..."
                               oninput="filterPemateri(this.value)"
                               class="w-full bg-slate-50 border border-slate-100 px-4 py-2 text-xs rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">

                        <div id="pemateriList" class="max-h-40 overflow-y-auto space-y-1 pr-2 custom-scrollbar">
                            @php $selectedIds = collect(old('pemateri_ids', $layanan->pemateri->pluck('id_pemateri')->toArray())); @endphp
                            @forelse($pemateris as $p)
                            <label class="pemateri-item flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition cursor-pointer group"
                                   data-name="{{ strtolower($p->nama_lengkap) }}">
                                <input type="checkbox" name="pemateri_ids[]" value="{{ $p->id_pemateri }}"
                                       {{ $selectedIds->contains($p->id_pemateri) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 transition cursor-pointer">
                                <span class="text-xs font-bold text-slate-600 group-hover:text-slate-900 transition">{{ $p->nama_lengkap }}</span>
                            </label>
                            @empty
                            <p class="text-[10px] text-slate-400 p-4 text-center font-bold uppercase tracking-widest">Belum ada pemateri</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div>
                    <div class="space-y-8">
                        <div>
                            <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                                <i class="fi fi-rr-users text-indigo-500"></i>
                                Kapasitas Peserta
                            </label>
                            <input type="number" name="kapasitas" value="{{ old('kapasitas', $layanan->kapasitas) }}" min="1"
                                   placeholder="Contoh: 30"
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                        </div>

                        <div>
                            <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                                <i class="fi fi-rr-document text-indigo-500"></i>
                                Deskripsi Tambahan
                            </label>
                            <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat layanan..."
                                      class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 pt-8 border-t border-slate-50">
                <a href="{{ route('admin.pelatihan.index') }}" class="px-8 py-4 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl text-sm font-black hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center justify-center gap-2 group">
                    <i class="fi fi-rr-check text-cyan-400 group-hover:scale-110 transition"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>

@endsection

@push('scripts')
<script>
    function filterPemateri(query) {
        const items = document.querySelectorAll('.pemateri-item');
        const q = query.toLowerCase().trim();
        items.forEach(item => {
            const name = item.getAttribute('data-name');
            const match = name.includes(q);
            item.style.display = match ? '' : 'none';
        });
    }

    function handleKategoriChange() {
        const selectKategori = document.getElementById('selectKategori');
        const selectJenis = document.getElementById('selectJenis');
        const containerJenis = document.getElementById('containerJenis');
        const inputNama = document.getElementById('inputNama');
        
        const selectedOption = selectKategori.options[selectKategori.selectedIndex];
        if (!selectedOption || !selectedOption.value) {
            containerJenis.classList.add('hidden');
            inputNama.classList.remove('hidden');
            inputNama.disabled = true;
            selectJenis.disabled = true;
            return;
        }

        const jenisData = JSON.parse(selectedOption.getAttribute('data-jenis') || '[]');
        
        selectJenis.disabled = false;
        inputNama.disabled = false;
        
        if (jenisData.length > 0) {
            selectJenis.innerHTML = '<option value="">-- Pilih Jenis --</option>';
            jenisData.forEach(j => {
                const opt = document.createElement('option');
                opt.value = j.nama;
                opt.textContent = j.nama;
                selectJenis.appendChild(opt);
            });
            const optOther = document.createElement('option');
            optOther.value = 'lainnya';
            optOther.textContent = 'Lainnya (Input Manual)';
            selectJenis.appendChild(optOther);
            
            containerJenis.classList.remove('hidden');
            
            const currentVal = inputNama.value;
            const exists = jenisData.some(j => j.nama === currentVal);
            
            if (exists) {
                selectJenis.value = currentVal;
                inputNama.classList.add('hidden');
            } else if (currentVal !== "") {
                selectJenis.value = 'lainnya';
                inputNama.classList.remove('hidden');
            } else {
                inputNama.classList.add('hidden');
            }
        } else {
            containerJenis.classList.add('hidden');
            inputNama.classList.remove('hidden');
        }
    }

    function handleJenisChange(val) {
        const inputNama = document.getElementById('inputNama');
        if (val === 'lainnya' || val === '') {
            inputNama.classList.remove('hidden');
            if (val === 'lainnya') inputNama.value = '';
            inputNama.focus();
        } else {
            inputNama.classList.add('hidden');
            inputNama.value = val;
        }
    }

    document.addEventListener('DOMContentLoaded', handleKategoriChange);
</script>
@endpush
