@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#1E6B3D] to-[#3CDA7D] text-white py-8">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex items-center gap-3 mb-4">
                <div class="text-2xl">💡</div>
                <h1 class="text-3xl font-bold">Konsultasi K3</h1>
            </div>

            <p class="text-gray-200 max-w-2xl">
                Temukan solusi terbaik untuk kebutuhan sistem manajemen keselamatan dan kesehatan kerja bersama konsultan ahli kami.
            </p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 py-8">

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- FORM -->
            <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow">

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
                        $layananKonsultasi = \App\Models\Layanan::where('id_kategori', $kategoriKonsultasi?->id_kategori)->first()
                                            ?? \App\Models\Layanan::whereHas('kategori', function($q) {
                                                $q->where('nama', 'like', '%Konsultasi%');
                                            })->first()
                                            ?? null
;
                        
                        $layananId = $layananKonsultasi ? $layananKonsultasi->id_layanan : null;
                        $jenisKlien = old('jenis_klien', 'individu');
                    @endphp
                    
                    <input type="hidden" name="layanan_id" value="{{ $layananId }}">
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
                        <h3 class="font-semibold text-lg mb-4 text-[#1E6B3D]">2. Jenis Konsultasi</h3>
                        <select name="topik_layanan" id="topik_layanan" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]"
                                onchange="toggleCatatan(this.value)">
                            <option value="">-- Pilih Jenis Konsultasi --</option>
                            @foreach($jenisLayanan as $jenis)
                                <option value="{{ $jenis->nama }}" {{ old('topik_layanan') == $jenis->nama ? 'selected' : '' }}>{{ $jenis->nama }}</option>
                            @endforeach
                            <option value="Lainnya" {{ old('topik_layanan') == 'Lainnya' ? 'selected' : '' }}>Lainnya (sebutkan di catatan)</option>
                        </select>

                        {{-- Kolom catatan muncul hanya jika "Lainnya" dipilih --}}
                        <div id="catatan-box" class="{{ old('topik_layanan') == 'Lainnya' ? '' : 'hidden' }} mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Catatan / Keterangan Konsultasi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="catatan" id="catatan" rows="3"
                                      placeholder="Tuliskan jenis konsultasi atau kebutuhan spesifik Anda di sini..."
                                      class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D] resize-none">{{ old('catatan') }}</textarea>
                        </div>
                    </div>

                    <!-- ── STEP 3 · Data Perusahaan (hanya jika Perusahaan) ── -->
                    <div id="section-perusahaan" class="{{ $jenisKlien === 'perusahaan' ? '' : 'hidden' }}">
                        <hr class="mb-5">
                        <h3 class="font-semibold text-lg mb-4 text-[#1E6B3D]">3. Data Perusahaan</h3>
                        <div class="space-y-4">
                            <div>
                                <input type="text" name="nama_perusahaan"
                                       value="{{ old('nama_perusahaan') }}"
                                       placeholder="Nama PT / CV / Instansi *"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                            </div>
                            <div>
                                <input type="text" name="jabatan"
                                       value="{{ old('jabatan') }}"
                                       placeholder="Jabatan di Perusahaan (Opsional)"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                            </div>
                            <div>
                                <textarea name="alamat_perusahaan" rows="2"
                                          placeholder="Alamat Lengkap Perusahaan *"
                                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D] resize-none">{{ old('alamat_perusahaan') }}</textarea>
                            </div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <input type="text" name="sektor_industri"
                                           value="{{ old('sektor_industri') }}"
                                           placeholder="Sektor Industri (Opsional)"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                                </div>
                                <div>
                                    <input type="number" name="jumlah_karyawan" min="1"
                                           value="{{ old('jumlah_karyawan') }}"
                                           placeholder="Jumlah Karyawan (Opsional)"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- ── STEP 4 · Data Diri & Kontak ───────────────────── -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#1E6B3D]">4. Data Diri & Kontak</h3>
                        <div class="space-y-4">
                            <div>
                                <input type="text" name="nama_lengkap" required
                                       value="{{ old('nama_lengkap') }}"
                                       placeholder="Nama Lengkap *"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                            </div>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <input type="email" name="email" required
                                           value="{{ old('email') }}"
                                           placeholder="Email Aktif *"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                                </div>
                                <div>
                                    <input type="text" name="no_telp" required
                                           value="{{ old('no_telp') }}"
                                           placeholder="Nomor HP / WhatsApp *"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                                </div>
                            </div>
                            <div>
                                <input type="text" name="pendidikan"
                                       value="{{ old('pendidikan') }}"
                                       placeholder="Pendidikan Terakhir (Opsional)"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- ── STEP 5 · Jadwal & Mode ─────────────────────────── -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#1E6B3D]">5. Jadwal & Mode Konsultasi</h3>
                        <div class="space-y-4">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rencana Tanggal Mulai *</label>
                                    <input type="date" name="rencana_tanggal_mulai" required
                                           value="{{ old('rencana_tanggal_mulai') }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rencana Tanggal Selesai *</label>
                                    <input type="date" name="rencana_tanggal_selesai" required
                                           value="{{ old('rencana_tanggal_selesai') }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mode Pertemuan *</label>
                                <select name="mode_pertemuan" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                                    <option value="online" {{ old('mode_pertemuan') === 'online' ? 'selected' : '' }}>🌐 Online (Zoom/Meet)</option>
                                    <option value="offline" {{ old('mode_pertemuan') === 'offline' ? 'selected' : '' }}>🏢 Offline (Tatap Muka)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- ── TOMBOL SUBMIT ───────────────────────────────────── -->
                    <div class="flex gap-3">
                        <a href="/" class="border px-4 py-2 rounded flex items-center justify-center hover:bg-gray-50">Batal</a>
                        <button type="submit" class="flex-1 bg-[#1E6B3D] text-white py-3 rounded-xl hover:bg-[#3CDA7D] font-semibold transition-all shadow-sm">
                            Kirim Permintaan Konsultasi
                        </button>
                    </div>

                </form>

            </div>

            <!-- SIDEBAR -->
            <div class="space-y-6">

                <!-- INFO -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#1E6B3D]">Mengapa Konsultasi Bersama Kami?</h3>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex gap-2"><span>✅</span> <span>Solusi disesuaikan dengan skala dan jenis industri Anda.</span></li>
                        <li class="flex gap-2"><span>✅</span> <span>Konsultan berpengalaman lebih dari 10 tahun.</span></li>
                        <li class="flex gap-2"><span>✅</span> <span>Panduan komprehensif mulai dari perencanaan hingga implementasi.</span></li>
                        <li class="flex gap-2"><span>✅</span> <span>Membantu persiapan audit sertifikasi (ISO, SMK3).</span></li>
                    </ul>
                </div>

                <!-- ALUR -->
                <div class="bg-[#F5F7FA] p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#1E6B3D]">Alur Konsultasi</h3>
                    <ol class="space-y-4 text-sm text-gray-700 relative border-l-2 border-[#1E6B3D] ml-2 pl-4">
                        <li class="relative">
                            <span class="absolute -left-[23px] top-0 bg-[#1E6B3D] w-3 h-3 rounded-full"></span>
                            <strong>1. Pendaftaran</strong><br>
                            <span class="text-gray-500">Isi formulir pengajuan di samping.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[23px] top-0 bg-[#1E6B3D] w-3 h-3 rounded-full"></span>
                            <strong>2. Diskusi Awal (Gratis)</strong><br>
                            <span class="text-gray-500">Tim kami akan menghubungi Anda untuk memahami kebutuhan.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[23px] top-0 bg-[#1E6B3D] w-3 h-3 rounded-full"></span>
                            <strong>3. Proposal & Perencanaan</strong><br>
                            <span class="text-gray-500">Kami mengirimkan rincian program dan biaya.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[23px] top-0 bg-[#1E6B3D] w-3 h-3 rounded-full"></span>
                            <strong>4. Pelaksanaan</strong><br>
                            <span class="text-gray-500">Konsultasi dan pendampingan dimulai.</span>
                        </li>
                    </ol>
                </div>

                <!-- CTA -->
                <div class="bg-gradient-to-br from-[#1E6B3D] to-[#3CDA7D] text-white p-6 rounded-xl">
                    <h3 class="font-semibold mb-2">Butuh Bantuan Langsung?</h3>
                    <p class="text-sm mb-4">Chat dengan tim layanan pelanggan kami via WhatsApp</p>
                    <a href="https://wa.me/6281234567890" target="_blank" class="bg-white text-[#25D366] font-medium px-4 py-2 rounded flex items-center justify-center gap-2 hover:bg-gray-50 transition">
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

        if (form) {
            form.addEventListener('submit', function () {
                const val = hiddenJenis.value;
                disableSection(sectionPerus, val !== 'perusahaan');
            });
        }
    });
</script>

@endsection