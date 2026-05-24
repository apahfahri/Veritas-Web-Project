@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="relative overflow-hidden bg-gradient-to-r from-[#1E6B3D] via-[#24824A] to-[#3CDA7D] text-white py-12 shadow-sm">
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -left-10 -bottom-10 w-72 h-72 bg-[#3CDA7D]/20 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex items-center gap-4 mb-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white shadow-inner text-2xl">
                    💡
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">Konsultasi K3 Veritas</h1>
            </div>
            <p class="text-base md:text-lg text-emerald-50 max-w-2xl font-light">Temukan solusi terbaik untuk kebutuhan sistem manajemen keselamatan dan kesehatan kerja bersama konsultan ahli kami.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- FORM -->
            <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-2xl border border-slate-100 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.03)]">

                <h2 class="text-2xl font-semibold text-[#1E6B3D] mb-2">
                    Form Pendaftaran Konsultasi
                </h2>

                <p class="text-gray-600 mb-6">
                    Isi data di bawah ini dan tim kami akan segera menghubungi Anda
                </p>

                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-300 text-green-700 p-4 rounded-lg">✅ {{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-300 text-red-700 p-4 rounded-lg">
                        <ul class="list-disc ml-5 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('pendaftaran.store') }}" id="form-pendaftaran" class="space-y-6">
                    @csrf
                    @php 
                        $kategoriKonsultasi = \App\Models\KategoriLayanan::where('nama', 'like', '%Konsultasi%')->first();
                        $jenisKlien = old('jenis_klien', 'individu');
                    @endphp
                    
                    <input type="hidden" name="kategori_id" value="{{ $kategoriKonsultasi?->id_kategori }}">
                    <input type="hidden" name="jenis_klien" id="hidden_jenis_klien" value="{{ $jenisKlien }}">


                    <!-- ── STEP 1 · Jenis Pendaftar ──────────────────────── -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#1E6B3D]">1. Jenis Pendaftar</h3>
                        <div class="flex gap-4">
                            <button type="button" id="btn-individu" class="flex-1 border border-gray-200 py-3 rounded-xl font-medium transition flex items-center justify-center gap-2
                                {{ $jenisKlien === 'individu' ? 'bg-[#1E6B3D] text-white border-[#1E6B3D]' : 'bg-white text-gray-700 hover:border-[#1E6B3D]' }}"
                                onclick="switchJenis('individu')">
                                👤 Individu
                            </button>
                            <button type="button" id="btn-perusahaan" class="flex-1 border border-gray-200 py-3 rounded-xl font-medium transition flex items-center justify-center gap-2
                                {{ $jenisKlien === 'perusahaan' ? 'bg-[#1E6B3D] text-white border-[#1E6B3D]' : 'bg-white text-gray-700 hover:border-[#1E6B3D]' }}"
                                onclick="switchJenis('perusahaan')">
                                🏢 Perusahaan
                            </button>
                        </div>
                    </div>

                    <hr>

                    <!-- ── STEP 2 · Jenis Konsultasi ─────────────────────── -->
                    @php
                        $jenisLayanan = \App\Models\JenisLayanan::where('id_kategori', $kategoriKonsultasi?->id_kategori)->get();
                    @endphp
                    <div>
                        <h3 class="font-bold text-base mb-3 text-[#1E6B3D]">2. Jenis Konsultasi</h3>
                        <select name="topik_layanan" id="topik_layanan" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all text-slate-700 cursor-pointer"
                                onchange="toggleCatatan(this.value)">
                            <option value="">-- Pilih Jenis Konsultasi --</option>
                            @foreach($jenisLayanan as $jenis)
                                <option value="{{ $jenis->nama }}" {{ old('topik_layanan') == $jenis->nama ? 'selected' : '' }}>{{ $jenis->nama }}</option>
                            @endforeach
                            <option value="Lainnya" {{ old('topik_layanan') == 'Lainnya' ? 'selected' : '' }}>Lainnya (sebutkan di catatan)</option>
                        </select>

                        {{-- Kolom catatan muncul hanya jika "Lainnya" dipilih --}}
                        <div id="catatan-box" class="{{ old('topik_layanan') == 'Lainnya' ? '' : 'hidden' }} mt-4">
                            <label class="block text-xs font-semibold text-slate-600 mb-1">
                                Catatan / Keterangan Konsultasi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="catatan" id="catatan" rows="3"
                                      placeholder="Tuliskan jenis konsultasi atau kebutuhan spesifik Anda di sini..."
                                      class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400 resize-none">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <!-- ── STEP 3 · Data Perusahaan (hanya jika Perusahaan) ── -->
                    <div id="section-perusahaan" class="{{ $jenisKlien === 'perusahaan' ? '' : 'hidden' }}">
                        <hr class="border-slate-100 my-5">
                        <h3 class="font-bold text-base mb-3 text-[#1E6B3D]">3. Data Perusahaan</h3>
                        <div class="space-y-4">
                            <div>
                                <input type="text" name="nama_perusahaan"
                                       value="{{ old('nama_perusahaan') }}"
                                       placeholder="Nama PT / CV / Instansi *"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400">
                            </div>
                            <div>
                                <input type="text" name="jabatan"
                                       value="{{ old('jabatan') }}"
                                       placeholder="Jabatan di Perusahaan (Opsional)"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400">
                            </div>
                            <div>
                                <textarea name="alamat_perusahaan" rows="2"
                                          placeholder="Alamat Lengkap Perusahaan *"
                                          class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400 resize-none">{{ old('alamat_perusahaan') }}</textarea>
                            </div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <input type="text" name="sektor_industri"
                                           value="{{ old('sektor_industri') }}"
                                           placeholder="Sektor Industri (Opsional)"
                                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400">
                                </div>
                                <div>
                                    <input type="number" name="jumlah_karyawan" min="1"
                                           value="{{ old('jumlah_karyawan') }}"
                                           placeholder="Jumlah Karyawan (Opsional)"
                                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <!-- ── STEP 4 · Data Diri & Kontak ───────────────────── -->
                    <div>
                        <h3 class="font-bold text-base mb-3 text-[#1E6B3D]">4. Data Diri & Kontak</h3>
                        <div class="space-y-4">
                            <div>
                                <input type="text" name="nama_lengkap" required
                                       value="{{ old('nama_lengkap') }}"
                                       placeholder="Nama Lengkap *"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400">
                            </div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <input type="email" name="email" required
                                           value="{{ old('email') }}"
                                           placeholder="Email PIC / Diri Aktif *"
                                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400">
                                </div>
                                <div>
                                    <input type="text" name="no_telp" required
                                           value="{{ old('no_telp') }}"
                                           placeholder="Nomor HP / WhatsApp *"
                                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400">
                                </div>
                            </div>
                            <div>
                                <input type="text" name="pendidikan"
                                       value="{{ old('pendidikan') }}"
                                       placeholder="Pendidikan Terakhir *"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-5 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400" required>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <!-- ── STEP 5 · Jadwal & Mode ─────────────────────────── -->
                    <div>
                        <h3 class="font-bold text-base mb-3 text-[#1E6B3D]">5. Jadwal & Mode Konsultasi</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Usulan *</label>
                                <input type="date" name="tanggal_usul" required
                                       value="{{ old('tanggal_usul') }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all text-slate-700">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Mode Pertemuan *</label>
                                <select name="mode_pertemuan" id="mode_pertemuan" required
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all text-slate-700 cursor-pointer"
                                        onchange="toggleLokasi(this.value)">
                                    <option value="online" {{ old('mode_pertemuan') === 'online' ? 'selected' : '' }}>🌐 Online (Zoom/Meet)</option>
                                    <option value="offline" {{ old('mode_pertemuan') === 'offline' ? 'selected' : '' }}>🏢 Offline (Tatap Muka)</option>
                                </select>
                            </div>
                            <div id="lokasi-box" class="{{ old('mode_pertemuan') === 'offline' ? '' : 'hidden' }}">
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Lokasi Pertemuan *</label>
                                <textarea name="lokasi" id="lokasi" rows="2"
                                          placeholder="Tuliskan lokasi pertemuan..."
                                          class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400 resize-none">{{ old('lokasi') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <!-- ── TOMBOL SUBMIT ───────────────────────────────────── -->
                    <div class="flex items-center gap-4 mt-8 pt-4 border-t border-slate-100">
                        <a href="/" class="border border-slate-200 px-6 py-3 rounded-xl flex items-center justify-center font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition active:scale-[0.98]">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 bg-[#1E6B3D] text-white py-3 px-6 rounded-xl hover:bg-[#24824A] font-bold transition-all shadow-[0_4px_12px_-3px_rgba(30,107,61,0.2)] hover:shadow-[0_6px_20px_-3px_rgba(30,107,61,0.3)] active:scale-[0.98]">
                            Kirim Permintaan Konsultasi
                        </button>
                    </div>

                </form>

            </div>

            <!-- SIDEBAR -->
            <div class="space-y-6">

                <!-- INFO -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.03)]">
                    <h3 class="font-bold text-slate-800 mb-4 text-base">Mengapa Konsultasi Bersama Kami?</h3>
                    <ul class="space-y-3.5 text-xs text-slate-600">
                        <li class="flex items-start gap-2.5">
                            <span class="text-emerald-500 font-bold shrink-0">✓</span>
                            <span>Solusi disesuaikan dengan skala dan jenis industri Anda.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-emerald-500 font-bold shrink-0">✓</span>
                            <span>Konsultan berpengalaman lebih dari 10 tahun.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-emerald-500 font-bold shrink-0">✓</span>
                            <span>Panduan komprehensif mulai dari perencanaan hingga implementasi.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-emerald-500 font-bold shrink-0">✓</span>
                            <span>Membantu persiapan audit sertifikasi (ISO, SMK3).</span>
                        </li>
                    </ul>
                </div>

                <!-- ALUR -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.03)]">
                    <h3 class="font-bold text-slate-800 mb-5 text-base">Alur Konsultasi</h3>
                    <ol class="space-y-6 text-xs text-slate-700 relative border-l-2 border-slate-100 ml-3 pl-5">
                        <li class="relative">
                            <span class="absolute -left-[27px] top-0.5 bg-[#1E6B3D] text-white flex items-center justify-center w-3 h-3 rounded-full border border-white shadow-sm ring-4 ring-emerald-500/10"></span>
                            <strong class="text-slate-800 font-semibold block mb-0.5">1. Pendaftaran</strong>
                            <span class="text-slate-500">Isi formulir pengajuan di samping secara lengkap.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[27px] top-0.5 bg-[#1E6B3D] text-white flex items-center justify-center w-3 h-3 rounded-full border border-white shadow-sm ring-4 ring-emerald-500/10"></span>
                            <strong class="text-slate-800 font-semibold block mb-0.5">2. Diskusi Awal (Gratis)</strong>
                            <span class="text-slate-500">Tim kami akan menghubungi Anda untuk memahami kebutuhan.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[27px] top-0.5 bg-[#1E6B3D] text-white flex items-center justify-center w-3 h-3 rounded-full border border-white shadow-sm ring-4 ring-emerald-500/10"></span>
                            <strong class="text-slate-800 font-semibold block mb-0.5">3. Proposal & Perencanaan</strong>
                            <span class="text-slate-500">Kami mengirimkan rincian program dan biaya.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[27px] top-0.5 bg-[#1E6B3D] text-white flex items-center justify-center w-3 h-3 rounded-full border border-white shadow-sm ring-4 ring-emerald-500/10"></span>
                            <strong class="text-slate-800 font-semibold block mb-0.5">4. Pelaksanaan</strong>
                            <span class="text-slate-500">Konsultasi dan pendampingan dimulai sesuai jadwal.</span>
                        </li>
                    </ol>
                </div>

                <!-- CTA -->
                <div class="relative overflow-hidden bg-gradient-to-br from-[#1E6B3D] via-[#24824A] to-[#3CDA7D] text-white p-6 rounded-2xl shadow-[0_8px_30px_-6px_rgba(30,107,61,0.2)]">
                    <div class="absolute -right-10 -bottom-10 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                    <h3 class="font-bold text-base mb-2 relative z-10">Butuh Bantuan Langsung?</h3>
                    <p class="text-xs text-emerald-50 mb-5 relative z-10 leading-relaxed">Hubungi customer service kami jika Anda memerlukan bantuan dalam pengisian form ini.</p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="relative z-10 w-full bg-white text-[#1E6B3D] font-bold px-4 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-slate-50 active:scale-[0.98] transition-all shadow-sm">
                        <span>💬</span> Chat WhatsApp
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- ── SCRIPT: Toggle Individu / Perusahaan ─────────────────────────── --}}
<script>
    const sectionPerus = document.getElementById('section-perusahaan');
    const hiddenJenis  = document.getElementById('hidden_jenis_klien');
    const btnInd       = document.getElementById('btn-individu');
    const btnPerus     = document.getElementById('btn-perusahaan');
    const form         = document.getElementById('form-pendaftaran');

    function disableSection(section, shouldDisable) {
        if (!section) return;
        section.querySelectorAll('input, textarea, select').forEach(el => {
            el.disabled = shouldDisable;
        });
    }

    window.toggleCatatan = function(val) {
        const box     = document.getElementById('catatan-box');
        const catatan = document.getElementById('catatan');
        if (!box || !catatan) return;

        if (val === 'Lainnya') {
            box.classList.remove('hidden');
            catatan.required = true;
        } else {
            box.classList.add('hidden');
            catatan.required = false;
            catatan.value = '';
        }
    }

    window.toggleLokasi = function(val) {
        const box    = document.getElementById('lokasi-box');
        const lokasi = document.getElementById('lokasi');
        if (!box || !lokasi) return;

        if (val === 'offline') {
            box.classList.remove('hidden');
            lokasi.required = true;
        } else {
            box.classList.add('hidden');
            lokasi.required = false;
            lokasi.value = '';
        }
    }

    window.switchJenis = function(val) {
        hiddenJenis.value = val;
        
        if (val === 'individu') {
            if(sectionPerus) sectionPerus.classList.add('hidden');
            
            if(btnInd) {
                btnInd.classList.add('bg-[#1E6B3D]', 'text-white', 'border-[#1E6B3D]');
                btnInd.classList.remove('bg-white', 'text-gray-700');
            }
            if(btnPerus) {
                btnPerus.classList.add('bg-white', 'text-gray-700');
                btnPerus.classList.remove('bg-[#1E6B3D]', 'text-white', 'border-[#1E6B3D]');
            }
        } else {
            if(sectionPerus) sectionPerus.classList.remove('hidden');
            
            if(btnPerus) {
                btnPerus.classList.add('bg-[#1E6B3D]', 'text-white', 'border-[#1E6B3D]');
                btnPerus.classList.remove('bg-white', 'text-gray-700');
            }
            if(btnInd) {
                btnInd.classList.add('bg-white', 'text-gray-700');
                btnInd.classList.remove('bg-[#1E6B3D]', 'text-white', 'border-[#1E6B3D]');
            }
        }

        disableSection(sectionPerus, val !== 'perusahaan');
    }

    document.addEventListener('DOMContentLoaded', function () {
        switchJenis(hiddenJenis.value || 'individu');
        
        const modePertemuan = document.getElementById('mode_pertemuan');
        if (modePertemuan) {
            toggleLokasi(modePertemuan.value);
        }

        if (form) {
            form.addEventListener('submit', function () {
                const val = hiddenJenis.value;
                disableSection(sectionPerus, val !== 'perusahaan');
            });
        }
    });
</script>

@endsection