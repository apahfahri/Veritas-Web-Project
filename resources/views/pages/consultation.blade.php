@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#7d2ae7] via-[#3969e7] to-[#07b9ce] text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <a href="/" class="inline-flex items-center gap-2 mb-4 hover:bg-white/10 px-3 py-2 rounded">
                ← Kembali
            </a>

            <div class="flex items-center gap-3 mb-4">
                <div class="text-3xl">💡</div>
                <h1 class="text-4xl font-bold">Konsultasi K3</h1>
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

                <h2 class="text-2xl font-semibold text-[#7d2ae7] mb-2">
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
                                            ?? \App\Models\Layanan::first();
                        
                        $layananId = $layananKonsultasi ? $layananKonsultasi->id_layanan : null;
                        $jenisKlien = old('jenis_klien', 'individu');
                    @endphp
                    
                    <input type="hidden" name="layanan_id" value="{{ $layananId }}">
                    <input type="hidden" name="jenis_klien" id="hidden_jenis_klien" value="{{ $jenisKlien }}">

                    <!-- TYPE SELECTOR -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#7d2ae7]">1. Jenis Pendaftar</h3>
                        <div class="flex gap-4">
                            <button type="button" id="btn-individu" class="flex-1 border border-gray-200 py-3 rounded-xl font-medium transition flex items-center justify-center gap-2
                                {{ $jenisKlien === 'individu' ? 'bg-[#7d2ae7] text-white border-[#7d2ae7]' : 'bg-white text-gray-700 hover:border-[#7d2ae7]' }}"
                                onclick="switchJenis('individu')">
                                👤 Individu
                            </button>
                            <button type="button" id="btn-perusahaan" class="flex-1 border border-gray-200 py-3 rounded-xl font-medium transition flex items-center justify-center gap-2
                                {{ $jenisKlien === 'perusahaan' ? 'bg-[#7d2ae7] text-white border-[#7d2ae7]' : 'bg-white text-gray-700 hover:border-[#7d2ae7]' }}"
                                onclick="switchJenis('perusahaan')">
                                🏢 Perusahaan
                            </button>
                        </div>
                    </div>
                    
                    <hr>

                    <!-- INDIVIDU & PIC DATA -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#7d2ae7]">2. Data Diri & Kontak</h3>
                        <div class="space-y-4">
                            <div>
                                <input type="text" name="nama_lengkap" required
                                       value="{{ old('nama_lengkap') }}"
                                       placeholder="Nama Lengkap *"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <input type="email" name="email" required
                                           value="{{ old('email') }}"
                                           placeholder="Email Aktif *"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                                </div>

                                <div>
                                    <input type="text" name="no_telp" required
                                           value="{{ old('no_telp') }}"
                                           placeholder="Nomor HP / WhatsApp *"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                                </div>
                            </div>

                            <div>
                                <input type="text" name="pendidikan"
                                       value="{{ old('pendidikan') }}"
                                       placeholder="Pendidikan Terakhir (Opsional)"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                            </div>
                        </div>
                    </div>

                    <!-- PERUSAHAAN DATA -->
                    <div id="section-perusahaan" class="{{ $jenisKlien === 'perusahaan' ? '' : 'hidden' }}">
                        <hr class="my-6">
                        <h3 class="font-semibold text-lg mb-4 text-[#7d2ae7]">3. Data Perusahaan</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <input type="text" name="nama_perusahaan"
                                       value="{{ old('nama_perusahaan') }}"
                                       placeholder="Nama PT / CV / Instansi *"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                            </div>

                            <div>
                                <input type="text" name="jabatan"
                                       value="{{ old('jabatan') }}"
                                       placeholder="Jabatan di Perusahaan (Opsional)"
                                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                            </div>

                            <div>
                                <textarea name="alamat_perusahaan" rows="2"
                                          placeholder="Alamat Lengkap Perusahaan *"
                                          class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] resize-none">{{ old('alamat_perusahaan') }}</textarea>
                            </div>

                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <input type="text" name="sektor_industri"
                                           value="{{ old('sektor_industri') }}"
                                           placeholder="Sektor Industri (Opsional)"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                                </div>
                                <div>
                                    <input type="number" name="jumlah_karyawan" min="1"
                                           value="{{ old('jumlah_karyawan') }}"
                                           placeholder="Jumlah Karyawan (Opsional)"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>

                    <!-- JADWAL & MODE -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#7d2ae7]">4. Jadwal & Mode Konsultasi</h3>
                        <div class="space-y-4">
                            <div class="grid md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rencana Tanggal Mulai *</label>
                                    <input type="date" name="rencana_tanggal_mulai" required
                                           value="{{ old('rencana_tanggal_mulai') }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rencana Tanggal Selesai *</label>
                                    <input type="date" name="rencana_tanggal_selesai" required
                                           value="{{ old('rencana_tanggal_selesai') }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mode Pertemuan *</label>
                                <select name="mode_pertemuan" required
                                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                                    <option value="online" {{ old('mode_pertemuan') === 'online' ? 'selected' : '' }}>🌐 Online (Zoom/Meet)</option>
                                    <option value="offline" {{ old('mode_pertemuan') === 'offline' ? 'selected' : '' }}>🏢 Offline (Tatap Muka)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- BUTTON -->
                    <div class="flex gap-3">
                        <a href="/" class="border px-4 py-2 rounded flex items-center justify-center hover:bg-gray-50">Batal</a>
                        <button type="submit" class="flex-1 bg-[#7d2ae7] text-white py-3 rounded-xl hover:bg-[#008f8f] font-semibold transition-all shadow-sm">
                            Kirim Permintaan Konsultasi
                        </button>
                    </div>

                </form>

            </div>

            <!-- SIDEBAR -->
            <div class="space-y-6">

                <!-- INFO -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#7d2ae7]">Mengapa Konsultasi Bersama Kami?</h3>
                    <ul class="space-y-3 text-sm text-gray-600">
                        <li class="flex gap-2"><span>✅</span> <span>Solusi disesuaikan dengan skala dan jenis industri Anda.</span></li>
                        <li class="flex gap-2"><span>✅</span> <span>Konsultan berpengalaman lebih dari 10 tahun.</span></li>
                        <li class="flex gap-2"><span>✅</span> <span>Panduan komprehensif mulai dari perencanaan hingga implementasi.</span></li>
                        <li class="flex gap-2"><span>✅</span> <span>Membantu persiapan audit sertifikasi (ISO, SMK3).</span></li>
                    </ul>
                </div>

                <!-- ALUR -->
                <div class="bg-[#F5F7FA] p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#7d2ae7]">Alur Konsultasi</h3>
                    <ol class="space-y-4 text-sm text-gray-700 relative border-l-2 border-[#7d2ae7] ml-2 pl-4">
                        <li class="relative">
                            <span class="absolute -left-[23px] top-0 bg-[#7d2ae7] w-3 h-3 rounded-full"></span>
                            <strong>1. Pendaftaran</strong><br>
                            <span class="text-gray-500">Isi formulir pengajuan di samping.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[23px] top-0 bg-[#7d2ae7] w-3 h-3 rounded-full"></span>
                            <strong>2. Diskusi Awal (Gratis)</strong><br>
                            <span class="text-gray-500">Tim kami akan menghubungi Anda untuk memahami kebutuhan.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[23px] top-0 bg-[#7d2ae7] w-3 h-3 rounded-full"></span>
                            <strong>3. Proposal & Perencanaan</strong><br>
                            <span class="text-gray-500">Kami mengirimkan rincian program dan biaya.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[23px] top-0 bg-[#7d2ae7] w-3 h-3 rounded-full"></span>
                            <strong>4. Pelaksanaan</strong><br>
                            <span class="text-gray-500">Konsultasi dan pendampingan dimulai.</span>
                        </li>
                    </ol>
                </div>

                <!-- CTA -->
                <div class="bg-gradient-to-br from-[#7d2ae7] via-[#3969e7] to-[#07b9ce] text-white p-6 rounded-xl">
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

    window.switchJenis = function(val) {
        hiddenJenis.value = val;
        
        if (val === 'individu') {
            if(sectionPerus) sectionPerus.classList.add('hidden');
            
            if(btnInd) {
                btnInd.classList.add('bg-[#7d2ae7]', 'text-white', 'border-[#7d2ae7]');
                btnInd.classList.remove('bg-white', 'text-gray-700');
            }
            if(btnPerus) {
                btnPerus.classList.add('bg-white', 'text-gray-700');
                btnPerus.classList.remove('bg-[#7d2ae7]', 'text-white', 'border-[#7d2ae7]');
            }
        } else {
            if(sectionPerus) sectionPerus.classList.remove('hidden');
            
            if(btnPerus) {
                btnPerus.classList.add('bg-[#7d2ae7]', 'text-white', 'border-[#7d2ae7]');
                btnPerus.classList.remove('bg-white', 'text-gray-700');
            }
            if(btnInd) {
                btnInd.classList.add('bg-white', 'text-gray-700');
                btnInd.classList.remove('bg-[#7d2ae7]', 'text-white', 'border-[#7d2ae7]');
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