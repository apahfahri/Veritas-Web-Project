@extends('layouts.admin')
@section('title', 'Tambah Layanan')
@section('page-title', 'Tambah Layanan')
@section('page-subtitle', 'Buat program layanan (Pelatihan, Konsultasi, Audit) baru untuk klien')

@section('content')

<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.pelatihan.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-900 tracking-tight">Form Tambah Layanan</h2>
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest">Lengkapi detail program layanan di bawah ini</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.pelatihan.store') }}" class="p-8 space-y-8">
            @csrf

            <!-- SECTION 1: KATEGORI & NAMA -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M11 7h.01M11 11h.01M11 15h.01M15 7h.01M15 11h.01M15 15h.01"></path></svg>
                        Kategori Layanan *
                    </label>
                    <select name="id_kategori" id="selectKategori" required onchange="handleKategoriChange()" 
                            class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition @error('id_kategori') border-red-400 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id_kategori }}" data-jenis="{{ $k->jenis }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                    @error('id_kategori')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Nama Layanan *
                    </label>
                    
                    <div id="containerJenis" class="hidden mb-2">
                        <select id="selectJenis" onchange="handleJenisChange(this.value)" disabled
                                class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none disabled:opacity-50 transition">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="lainnya">Lainnya (Input Manual)</option>
                        </select>
                    </div>

                    <input type="text" name="nama" id="inputNama" value="{{ old('nama') }}" required disabled
                           placeholder="Pilih kategori terlebih dahulu..."
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none disabled:opacity-50 transition @error('nama') border-red-400 @enderror">
                    
                    @error('nama')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- SECTION 2: MATERI & HARGA -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Materi / Detail Layanan *
                    </label>
                    <input type="text" name="materi" value="{{ old('materi') }}" required
                           placeholder="Contoh: Ahli K3 Umum & Pengenalan Hazard"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition @error('materi') border-red-400 @enderror">
                    @error('materi')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Harga (IDR) *
                    </label>
                    <input type="number" name="harga" value="{{ old('harga') }}" required min="0"
                           placeholder="Contoh: 1500000"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-black text-slate-900 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition @error('harga') border-red-400 @enderror">
                    @error('harga')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- SECTION 3: TANGGAL & WAKTU -->
            <div class="bg-slate-50/50 p-6 rounded-3xl border border-slate-100 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                            Tgl Mulai *
                        </label>
                        <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai') }}" required
                               class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                            Tgl Selesai *
                        </label>
                        <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai') }}" required
                               class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jam Pertemuan
                        </label>
                        <input type="time" name="jam_pertemuan" value="{{ old('jam_pertemuan') }}"
                               class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                    </div>
                </div>
            </div>

            <!-- SECTION 4: MODE & LOKASI -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Jenis Pertemuan *
                    </label>
                    <select name="jenis_pertemuan" required class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                        <option value="offline" {{ old('jenis_pertemuan') === 'offline' ? 'selected' : '' }}>Offline (Tatap Muka)</option>
                        <option value="online"  {{ old('jenis_pertemuan') === 'online'  ? 'selected' : '' }}>Online (Zoom / Meet)</option>
                    </select>
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Lokasi / Venue
                    </label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                           placeholder="Nama gedung / kota (kosongkan jika online)"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                </div>
            </div>

            <!-- SECTION 5: PEMATERI & KAPASITAS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Pilih Pemateri <span class="text-[9px] font-bold text-slate-300 normal-case ml-2">(bisa pilih lebih dari satu)</span>
                    </label>

                    <div class="bg-white border border-slate-200 rounded-2xl p-4 space-y-3">
                        <input type="text" id="searchPemateri" placeholder="🔍 Cari nama pemateri..."
                               oninput="filterPemateri(this.value)"
                               class="w-full bg-slate-50 border border-slate-100 px-4 py-2 text-xs rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:outline-none">

                        <div id="pemateriList" class="max-h-40 overflow-y-auto space-y-1 pr-2 custom-scrollbar">
                            @forelse($pemateris as $p)
                            @php $checked = is_array(old('pemateri_ids')) && in_array($p->id_pemateri, old('pemateri_ids')); @endphp
                            <label class="pemateri-item flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 transition cursor-pointer group"
                                   data-name="{{ strtolower($p->nama_lengkap) }}">
                                <input type="checkbox" name="pemateri_ids[]" value="{{ $p->id_pemateri }}"
                                       {{ $checked ? 'checked' : '' }}
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
                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Kapasitas Peserta
                            </label>
                            <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" min="1"
                                   placeholder="Contoh: 30"
                                   class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                        </div>

                        <div>
                            <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                Deskripsi Tambahan
                            </label>
                            <textarea name="deskripsi" rows="3" placeholder="Deskripsi singkat layanan..."
                                      class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 pt-8 border-t border-slate-50">
                <a href="{{ route('admin.pelatihan.index') }}" class="px-8 py-4 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl text-sm font-black hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center justify-center gap-2 group">
                    <svg class="w-5 h-5 text-cyan-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Program Layanan
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
            inputNama.placeholder = "Pilih kategori terlebih dahulu...";
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
            
            if (!inputNama.value) {
                inputNama.classList.add('hidden');
            } else {
                const exists = jenisData.some(j => j.nama === inputNama.value);
                if (exists) {
                    selectJenis.value = inputNama.value;
                    inputNama.classList.add('hidden');
                } else {
                    selectJenis.value = 'lainnya';
                    inputNama.classList.remove('hidden');
                }
            }
        } else {
            containerJenis.classList.add('hidden');
            inputNama.classList.remove('hidden');
            inputNama.placeholder = `Nama ${selectedOption.text}...`;
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
