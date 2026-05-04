@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA] py-10">
    <div class="max-w-3xl mx-auto px-6">

        {{-- ── HEADER ──────────────────────────────────────────────── --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm mb-8 border border-gray-100">
            <a href="{{ route('training.detail', $pelatihan->id) }}"
               class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#7d2ae7] mb-4 transition">
                ← Kembali ke Detail Pelatihan
            </a>
            <h1 class="text-2xl font-bold text-[#7d2ae7]">Form Pendaftaran Pelatihan</h1>
            <p class="text-gray-500 mt-1 text-sm">{{ $pelatihan->layanan->nama ?? $pelatihan->materi }}</p>
            <p class="text-gray-400 text-xs mt-1">
                📅 {{ \Carbon\Carbon::parse($pelatihan->tanggal_pertemuan)->translatedFormat('d F Y') }}
                @if($pelatihan->lokasi) &nbsp;|&nbsp; 📍 {{ $pelatihan->lokasi }} @endif
            </p>
        </div>

        {{-- ── ALERT ERRORS ─────────────────────────────────────────── --}}
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-5 py-4 mb-6">
            <p class="font-semibold mb-1">Terdapat kesalahan pada form:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ── FORM ────────────────────────────────────────────────── --}}
        <form method="POST" action="{{ route('pendaftaran.store') }}" id="form-pendaftaran">
            @csrf

            {{-- hidden fields --}}
            <input type="hidden" name="layanan_id"     value="{{ $pelatihan->layanan_id }}">
            <input type="hidden" name="tanggal_daftar" value="{{ $pelatihan->tanggal_pertemuan->format('Y-m-d') }}">

            @php
                $user = Auth::user();
                $profilIndividu = $user->klienIndividu;
                $profilPerusahaan = $user->klienPerusahaan;
                $perusahaan = $profilPerusahaan ? $profilPerusahaan->perusahaan : null;

                $isIndividu = $profilIndividu !== null;
                $isPerusahaan = $profilPerusahaan !== null;
                $sudahPunyaProfil = $isIndividu || $isPerusahaan;

                $defaultJenis = 'individu';
                if ($isPerusahaan) $defaultJenis = 'perusahaan';
                if ($isIndividu) $defaultJenis = 'individu';
                $jenisKlien = old('jenis_klien', $defaultJenis);
            @endphp
            <input type="hidden" name="jenis_klien" id="hidden_jenis_klien" value="{{ $jenisKlien }}">

            @if(!$sudahPunyaProfil)
            {{-- ── STEP 1 · Jenis Pendaftar ──────────────────────── --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-semibold text-[#7d2ae7] mb-5">1. Jenis Pendaftar</h2>

                <div class="grid md:grid-cols-2 gap-4">
                    <label id="card-individu"
                           class="relative flex flex-col gap-2 border-2 p-5 rounded-xl cursor-pointer transition-all
                                  {{ $jenisKlien === 'individu' ? 'border-[#7d2ae7] bg-[#F0FAFA]' : 'border-gray-200 hover:border-[#7d2ae7]' }}">
                        <input type="radio" name="_jenis_klien_radio" value="individu" class="sr-only"
                               {{ $jenisKlien === 'individu' ? 'checked' : '' }}>
                        <span class="text-2xl">👤</span>
                        <span class="font-semibold text-[#7d2ae7]">Individu</span>
                        <span class="text-xs text-gray-500">Pendaftaran perorangan / pribadi</span>
                        <span id="check-individu"
                              class="absolute top-3 right-3 w-5 h-5 bg-[#7d2ae7] rounded-full flex items-center justify-center
                                     {{ $jenisKlien === 'individu' ? '' : 'hidden' }}">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                    </label>

                    <label id="card-perusahaan"
                           class="relative flex flex-col gap-2 border-2 p-5 rounded-xl cursor-pointer transition-all
                                  {{ $jenisKlien === 'perusahaan' ? 'border-[#7d2ae7] bg-[#F0FAFA]' : 'border-gray-200 hover:border-[#7d2ae7]' }}">
                        <input type="radio" name="_jenis_klien_radio" value="perusahaan" class="sr-only"
                               {{ $jenisKlien === 'perusahaan' ? 'checked' : '' }}>
                        <span class="text-2xl">🏢</span>
                        <span class="font-semibold text-[#7d2ae7]">Perusahaan</span>
                        <span class="text-xs text-gray-500">Mewakili instansi / perusahaan</span>
                        <span id="check-perusahaan"
                              class="absolute top-3 right-3 w-5 h-5 bg-[#7d2ae7] rounded-full flex items-center justify-center
                                     {{ $jenisKlien === 'perusahaan' ? '' : 'hidden' }}">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                    </label>
                </div>
            </div>
            @endif

            {{-- ── STEP 2A · Data Individu ────────────────────────── --}}
            <div id="section-individu"
                 class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-6
                        {{ $jenisKlien === 'perusahaan' ? 'hidden' : '' }}">
                <h2 class="text-lg font-semibold text-[#7d2ae7] mb-5">2. Data Peserta</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap"
                               value="{{ old('nama_lengkap', $profilIndividu->nama_lengkap ?? $user->username) }}"
                               placeholder="Masukkan nama lengkap sesuai KTP"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nomor HP / WhatsApp <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="no_hp"
                               value="{{ old('no_hp', $profilIndividu->no_hp ?? '') }}"
                               placeholder="Contoh: 08123456789"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            NIK (Opsional)
                        </label>
                        <input type="text" name="nik"
                               value="{{ old('nik', $profilIndividu->nik ?? '') }}"
                               placeholder="16 digit nomor KTP"
                               maxlength="16"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                    </div>
                </div>
            </div>

            {{-- ── STEP 2B · Data Perusahaan ─────────────────────── --}}
            <div id="section-perusahaan"
                 class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-6
                        {{ $jenisKlien === 'perusahaan' ? '' : 'hidden' }}">
                <h2 class="text-lg font-semibold text-[#7d2ae7] mb-5">2. Data Peserta & Perusahaan</h2>

                <div class="space-y-4">
                    {{-- Peserta --}}
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Data Peserta</p>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap"
                               value="{{ old('nama_lengkap', $profilPerusahaan->nama_lengkap ?? $user->username) }}"
                               placeholder="Nama perwakilan dari perusahaan"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan (Opsional)</label>
                        <input type="text" name="jabatan"
                               value="{{ old('jabatan', $profilPerusahaan->jabatan ?? '') }}"
                               placeholder="Contoh: HRD Manager, Training Officer"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                    </div>

                    {{-- Perusahaan --}}
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 pt-2">Data Perusahaan</p>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_perusahaan"
                               value="{{ old('nama_perusahaan', $perusahaan->nama ?? '') }}"
                               placeholder="PT / CV / Instansi"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat_perusahaan" rows="2"
                                  placeholder="Alamat lengkap kantor / perusahaan"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition resize-none">{{ old('alamat_perusahaan', $perusahaan->alamat ?? '') }}</textarea>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NPWP Perusahaan (Opsional)</label>
                            <input type="text" name="npwp_perusahaan"
                                   value="{{ old('npwp_perusahaan', $perusahaan->npwp_perusahaan ?? '') }}"
                                   placeholder="XX.XXX.XXX.X-XXX.XXX"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIB / OSS (Opsional)</label>
                            <input type="text" name="nib_oss"
                                   value="{{ old('nib_oss', $perusahaan->nib_oss ?? '') }}"
                                   placeholder="Nomor Induk Berusaha"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sektor Industri (Opsional)</label>
                            <input type="text" name="sektor_industri"
                                   value="{{ old('sektor_industri', $perusahaan->sektor_industri ?? '') }}"
                                   placeholder="Contoh: Manufaktur, Jasa, dll."
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Karyawan (Opsional)</label>
                            <input type="number" name="jumlah_karyawan" min="1"
                                   value="{{ old('jumlah_karyawan', $perusahaan->jumlah_karyawan ?? '') }}"
                                   placeholder="Contoh: 50"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── STEP 3 · Ringkasan & Submit ────────────────────── --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-semibold text-[#7d2ae7] mb-5">3. Ringkasan Pendaftaran</h2>

                <div class="bg-[#F5F7FA] rounded-xl p-5 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Pelatihan</span>
                        <span class="font-medium text-[#7d2ae7] text-right max-w-[60%]">
                            {{ $pelatihan->layanan->nama ?? $pelatihan->materi }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal</span>
                        <span class="font-medium text-[#7d2ae7]">
                            {{ \Carbon\Carbon::parse($pelatihan->tanggal_pertemuan)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    @if($pelatihan->lokasi)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Lokasi</span>
                        <span class="font-medium text-[#7d2ae7]">{{ $pelatihan->lokasi }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-500">Jenis Pertemuan</span>
                        <span class="font-medium text-[#7d2ae7] capitalize">{{ $pelatihan->jenis_pertemuan }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between">
                        <span class="text-gray-500">Status Bayar</span>
                        <span class="text-yellow-600 font-medium">Belum Bayar</span>
                    </div>
                </div>

                <p class="text-xs text-gray-400 mt-3">
                    Setelah mendaftar, tim kami akan menghubungi Anda untuk konfirmasi dan informasi pembayaran.
                </p>
            </div>

            {{-- ── TOMBOL SUBMIT ───────────────────────────────────── --}}
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('training.detail', $pelatihan->id) }}"
                   class="text-sm text-gray-500 hover:text-[#7d2ae7] transition">
                    ← Batalkan
                </a>
                <button type="submit"
                        class="bg-[#7d2ae7] hover:bg-[#008f8f] text-white font-semibold px-8 py-3 rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95">
                    Kirim Pendaftaran →
                </button>
            </div>

        </form>

    </div>
</div>

{{-- ── SCRIPT: Toggle Individu / Perusahaan ─────────────────────────── --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const radios       = document.querySelectorAll('input[name="_jenis_klien_radio"]');
    const sectionInd   = document.getElementById('section-individu');
    const sectionPerus = document.getElementById('section-perusahaan');
    const hiddenJenis  = document.getElementById('hidden_jenis_klien');
    const cardInd      = document.getElementById('card-individu');
    const cardPerus    = document.getElementById('card-perusahaan');
    const checkInd     = document.getElementById('check-individu');
    const checkPerus   = document.getElementById('check-perusahaan');
    const form         = document.getElementById('form-pendaftaran');

    /** Enable / disable semua input dalam sebuah section */
    function disableSection(section, shouldDisable) {
        if (!section) return;
        section.querySelectorAll('input, textarea, select').forEach(el => {
            el.disabled = shouldDisable;
        });
    }

    function switchJenis(val) {
        hiddenJenis.value = val;

        if (val === 'individu') {
            if(sectionInd) sectionInd.classList.remove('hidden');
            if(sectionPerus) sectionPerus.classList.add('hidden');

            if(cardInd) {
                cardInd.classList.add('border-[#7d2ae7]', 'bg-[#F0FAFA]');
                cardInd.classList.remove('border-gray-200');
                if(checkInd) checkInd.classList.remove('hidden');
            }
            if(cardPerus) {
                cardPerus.classList.remove('border-[#7d2ae7]', 'bg-[#F0FAFA]');
                cardPerus.classList.add('border-gray-200');
                if(checkPerus) checkPerus.classList.add('hidden');
            }
        } else {
            if(sectionInd) sectionInd.classList.add('hidden');
            if(sectionPerus) sectionPerus.classList.remove('hidden');

            if(cardPerus) {
                cardPerus.classList.add('border-[#7d2ae7]', 'bg-[#F0FAFA]');
                cardPerus.classList.remove('border-gray-200');
                if(checkPerus) checkPerus.classList.remove('hidden');
            }
            if(cardInd) {
                cardInd.classList.remove('border-[#7d2ae7]', 'bg-[#F0FAFA]');
                cardInd.classList.add('border-gray-200');
                if(checkInd) checkInd.classList.add('hidden');
            }
        }

        disableSection(sectionInd,   val !== 'individu');
        disableSection(sectionPerus, val !== 'perusahaan');
    }

    // Event klik kartu jenis pendaftar
    if (radios.length > 0) {
        radios.forEach(radio => {
            radio.closest('label').addEventListener('click', function () {
                switchJenis(radio.value);
            });
        });
    }

    // Terapkan kondisi awal berdasarkan nilai old() yang diset di hidden input
    switchJenis(hiddenJenis.value || 'individu');

    // Lapisan pengaman: disable section non-aktif tepat sebelum form disubmit
    if (form) {
        form.addEventListener('submit', function () {
            const val = hiddenJenis.value;
            disableSection(sectionInd,   val !== 'individu');
            disableSection(sectionPerus, val !== 'perusahaan');
        });
    }
});
</script>


@endsection