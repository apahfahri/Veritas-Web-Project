@extends('layouts.admin')
@section('page-title', 'Edit Layanan')
@section('page-subtitle', 'Perbarui data program layanan')

@section('content')
<div class="max-w-2xl">
    <div class="mb-4">
        <a href="{{ route('admin.pelatihan.index') }}" class="text-gray-500 hover:text-[#7d2ae7] text-sm">← Kembali ke Daftar Layanan</a>
    </div>
    <div class="bg-white p-8 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-[#7d2ae7] mb-6">Edit Layanan</h2>

        <form method="POST" action="{{ route('admin.pelatihan.update', $layanan->id_layanan) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium mb-1">Kategori Layanan *</label>
                <select name="id_kategori" id="selectKategori" required onchange="handleKategoriChange()"
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}" data-jenis="{{ $k->jenis }}" {{ old('id_kategori', $layanan->id_kategori) == $k->id_kategori ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nama Layanan *</label>
                
                {{-- Dropdown Jenis (Hidden initially) --}}
                <div id="containerJenis" class="hidden mb-2">
                    <select id="selectJenis" onchange="handleJenisChange(this.value)" disabled
                            class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none disabled:bg-gray-100 disabled:cursor-not-allowed transition-colors">
                        <option value="">-- Pilih Jenis --</option>
                        {{-- Options populated via JS --}}
                        <option value="lainnya">Lainnya (Input Manual)</option>
                    </select>
                </div>

                <input type="text" name="nama" id="inputNama" value="{{ old('nama', $layanan->nama) }}" required disabled
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none disabled:bg-gray-100 disabled:cursor-not-allowed transition-colors @error('nama') border-red-400 @enderror">
                @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Materi / Detail *</label>
                <input type="text" name="materi" value="{{ old('materi', $layanan->materi) }}" required
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none @error('materi') border-red-400 @enderror">
                @error('materi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Jenis Pertemuan *</label>
                <select name="jenis_pertemuan" required class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                    <option value="offline" {{ old('jenis_pertemuan', $layanan->jenis_pertemuan) === 'offline' ? 'selected' : '' }}>Offline</option>
                    <option value="online"  {{ old('jenis_pertemuan', $layanan->jenis_pertemuan) === 'online'  ? 'selected' : '' }}>Online</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Tanggal</label>
                    <input type="date" name="tanggal_pertemuan"
                           value="{{ old('tanggal_pertemuan', $layanan->tanggal_pertemuan?->format('Y-m-d')) }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Jam Mulai</label>
                    <input type="time" name="jam_pertemuan"
                           value="{{ old('jam_pertemuan', substr($layanan->jam_pertemuan ?? '', 0, 5)) }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $layanan->lokasi) }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Kapasitas</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas', $layanan->kapasitas) }}" min="1"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2">Pemateri <span class="text-gray-400 font-normal">(bisa pilih lebih dari satu)</span></label>

                {{-- Search --}}
                <input type="text" id="searchPemateri" placeholder="🔍 Cari nama pemateri..."
                       oninput="filterPemateri(this.value)"
                       class="w-full border rounded-lg px-3 py-2 text-sm mb-2 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">

                {{-- Select All --}}
                <label class="flex items-center gap-2 text-xs text-gray-500 mb-2 cursor-pointer select-none">
                    <input type="checkbox" id="selectAllPemateri" onchange="toggleSelectAll(this)"
                           class="w-4 h-4 accent-[#7d2ae7]">
                    Pilih semua pemateri
                </label>

                {{-- Checkbox List --}}
                <div id="pemateriList" class="border rounded-lg divide-y max-h-48 overflow-y-auto">
                    @php
                        $selectedIds = collect(old('pemateri_ids', $layanan->pemateri->pluck('id_pemateri')->toArray()));
                    @endphp
                    @forelse($pemateris as $p)
                    <label class="pemateri-item flex items-center gap-3 px-4 py-2.5 cursor-pointer hover:bg-purple-50 transition-colors"
                           data-name="{{ strtolower($p->nama_lengkap) }}">
                        <input type="checkbox" name="pemateri_ids[]" value="{{ $p->id_pemateri }}"
                               {{ $selectedIds->contains($p->id_pemateri) ? 'checked' : '' }}
                               onchange="updateSelectAll()"
                               class="w-4 h-4 accent-[#7d2ae7] flex-shrink-0">
                        <span class="text-sm text-gray-700">{{ $p->nama_lengkap }}</span>
                    </label>
                    @empty
                    <p class="text-sm text-gray-400 p-4 text-center">Belum ada pemateri terdaftar.</p>
                    @endforelse
                </div>

                <p id="pemateriCount" class="text-xs text-gray-400 mt-1">
                    {{ count($pemateris) }} pemateri tersedia
                </p>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Harga (IDR) *</label>
                <input type="number" name="harga" value="{{ old('harga', $layanan->harga) }}" required min="0"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none @error('harga') border-red-400 @enderror">
                @error('harga')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="4"
                          class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.pelatihan.index') }}" class="border px-6 py-2.5 rounded-lg hover:bg-gray-50">Batal</a>
                <button type="submit" class="flex-1 bg-[#7d2ae7] text-white py-2.5 rounded-lg hover:opacity-90">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterPemateri(query) {
        const items = document.querySelectorAll('.pemateri-item');
        const q = query.toLowerCase().trim();
        let visible = 0;
        items.forEach(item => {
            const name = item.getAttribute('data-name');
            const match = name.includes(q);
            item.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        document.getElementById('pemateriCount').textContent = visible + ' pemateri ditemukan';
        updateSelectAll();
    }

    function toggleSelectAll(master) {
        const items = document.querySelectorAll('.pemateri-item');
        items.forEach(item => {
            if (item.style.display !== 'none') {
                const cb = item.querySelector('input[type=checkbox]');
                if (cb) cb.checked = master.checked;
            }
        });
    }

    function updateSelectAll() {
        const all  = document.querySelectorAll('.pemateri-item:not([style*="display: none"]) input[type=checkbox]');
        const checked = document.querySelectorAll('.pemateri-item:not([style*="display: none"]) input[type=checkbox]:checked');
        const master = document.getElementById('selectAllPemateri');
        if (!master) return;
        master.indeterminate = checked.length > 0 && checked.length < all.length;
        master.checked = all.length > 0 && checked.length === all.length;
    }

    // Init on load
    document.addEventListener('DOMContentLoaded', () => {
        updateSelectAll();
        handleKategoriChange(); // Handle initial state with existing data
    });

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
        
        // Enable inputs
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
            
            // Check if current value exists in types
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
</script>
@endpush
