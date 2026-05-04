@extends('layouts.app')
@section('title', 'Konsultasi K3 — PT Katiga Veritas Indonesia')
@section('content')

<div class="min-h-screen bg-[#F5F7FA]">
    <div class="bg-gradient-to-r from-[#7d2ae7] via-[#3969e7] to-[#07b9ce] text-white py-12">
        <div class="max-w-5xl mx-auto px-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-4 hover:bg-white/10 px-3 py-2 rounded">← Kembali</a>
            <h1 class="text-4xl font-bold mb-4">Konsultasi K3</h1>
            <p class="text-gray-200 max-w-2xl">Dapatkan solusi terbaik untuk kebutuhan K3 perusahaan atau individu Anda</p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 py-8">

        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-300 text-green-700 p-4 rounded-lg">✅ {{ session('success') }}</div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- FORM -->
            <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow">
                <h2 class="text-2xl font-semibold text-[#7d2ae7] mb-2">Form Pengajuan Konsultasi</h2>
                <p class="text-gray-600 mb-6">Lengkapi form di bawah ini</p>

                @auth
                <form method="POST" action="{{ route('pendaftaran.store') }}" class="space-y-6" id="form-pendaftaran">
                    @csrf
                    {{-- Layanan ID untuk Konsultasi K3 --}}
                    @php $layananKonsultasi = \App\Models\Layanan::where('nama', 'like', '%Konsultasi%')->first(); @endphp
                    <input type="hidden" name="layanan_id" value="{{ $layananKonsultasi?->id }}">
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
                    <!-- Jenis Pendaftar -->
                    <div>
                        <label class="font-medium text-sm">Jenis Pendaftar *</label>
                        <div class="grid grid-cols-2 gap-3 mt-1">
                            <label class="border p-3 rounded cursor-pointer text-center transition" id="btn-individu">
                                <input type="radio" name="_jenis_klien_radio" value="individu" class="sr-only" {{ $jenisKlien === 'individu' ? 'checked' : '' }}>
                                👤 Individu
                            </label>
                            <label class="border p-3 rounded cursor-pointer text-center transition" id="btn-perusahaan">
                                <input type="radio" name="_jenis_klien_radio" value="perusahaan" class="sr-only" {{ $jenisKlien === 'perusahaan' ? 'checked' : '' }}>
                                🏢 Perusahaan
                            </label>
                        </div>
                    </div>
                    @endif

                    <!-- Data Individu -->
                    <div id="section-individu" class="space-y-4 {{ $jenisKlien === 'perusahaan' ? 'hidden' : '' }}">
                        <div>
                            <label class="font-medium text-sm">Nama Lengkap *</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profilIndividu->nama_lengkap ?? Auth::user()->name) }}" class="w-full border p-2 rounded mt-1" required>
                        </div>
                        <div>
                            <label class="font-medium text-sm">Nomor HP *</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $profilIndividu->no_hp ?? '') }}" class="w-full border p-2 rounded mt-1" required>
                        </div>
                        <div>
                            <label class="font-medium text-sm">NIK (Opsional)</label>
                            <input type="text" name="nik" value="{{ old('nik', $profilIndividu->nik ?? '') }}" class="w-full border p-2 rounded mt-1" maxlength="16">
                        </div>
                    </div>

                    <!-- Data Perusahaan -->
                    <div id="section-perusahaan" class="space-y-4 {{ $jenisKlien === 'perusahaan' ? '' : 'hidden' }}">
                        <div>
                            <label class="font-medium text-sm">Nama Lengkap PIC *</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profilPerusahaan->nama_lengkap ?? Auth::user()->name) }}" class="w-full border p-2 rounded mt-1" disabled required>
                        </div>
                        <div>
                            <label class="font-medium text-sm">Jabatan (Opsional)</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan', $profilPerusahaan->jabatan ?? '') }}" class="w-full border p-2 rounded mt-1" disabled>
                        </div>
                        <div>
                            <label class="font-medium text-sm">Nama Perusahaan *</label>
                            <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $perusahaan->nama ?? '') }}" class="w-full border p-2 rounded mt-1" disabled required>
                        </div>
                        <div>
                            <label class="font-medium text-sm">Alamat Perusahaan *</label>
                            <textarea name="alamat_perusahaan" class="w-full border p-2 rounded mt-1" disabled required>{{ old('alamat_perusahaan', $perusahaan->alamat ?? '') }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label class="font-medium text-sm">Tanggal yang Diinginkan *</label>
                        <input type="date" name="tanggal_daftar" required
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('tanggal_daftar') }}"
                               class="w-full border p-2 rounded mt-1 focus:ring-2 focus:ring-[#7d2ae7] focus:outline-none @error('tanggal_daftar') border-red-400 @enderror">
                        @error('tanggal_daftar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('home') }}" class="border px-4 py-2 rounded hover:bg-gray-50 flex items-center justify-center">Batal</a>
                        <button type="submit" class="flex-1 bg-[#7d2ae7] text-white py-2 rounded hover:opacity-90">
                            Ajukan Konsultasi
                        </button>
                    </div>
                </form>
                @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-4">🔒</div>
                    <p class="text-gray-600 mb-4">Silakan login terlebih dahulu untuk mengajukan konsultasi</p>
                    <a href="{{ route('login') }}" class="bg-[#7d2ae7] text-white px-6 py-2 rounded">Login Sekarang</a>
                </div>
                @endauth
            </div>

            <!-- SIDEBAR -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#7d2ae7]">Tentang Konsultasi</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>✔ Konsultan K3 berpengalaman</li>
                        <li>✔ Solusi sesuai kebutuhan</li>
                        <li>✔ Dokumentasi lengkap</li>
                        <li>✔ Untuk individu &amp; perusahaan</li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#7d2ae7]">Alur Proses</h3>
                    <ol class="text-sm space-y-2 text-gray-600">
                        <li>1. Submit Form</li>
                        <li>2. Review oleh Tim</li>
                        <li>3. Penugasan Konsultan</li>
                        <li>4. Sesi Konsultasi</li>
                    </ol>
                </div>
                <div class="bg-gradient-to-br from-[#7d2ae7] via-[#3969e7] to-[#07b9ce] text-white p-6 rounded-xl">
                    <h3 class="font-semibold mb-2">Butuh Bantuan?</h3>
                    <a href="#" class="bg-white text-black px-4 py-2 rounded block text-center text-sm">WhatsApp Kami</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="_jenis_klien_radio"]');
    const sectionInd = document.getElementById('section-individu');
    const sectionPerus = document.getElementById('section-perusahaan');
    const hiddenJenis = document.getElementById('hidden_jenis_klien');
    const btnInd = document.getElementById('btn-individu');
    const btnPerus = document.getElementById('btn-perusahaan');
    const form = document.getElementById('form-pendaftaran');

    if (!form) return;

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
            if(btnInd) {
                btnInd.classList.add('bg-[#7d2ae7]', 'text-white', 'border-[#7d2ae7]');
                btnInd.classList.remove('bg-white', 'text-gray-700', 'border-gray-200');
            }
            if(btnPerus) {
                btnPerus.classList.add('bg-white', 'text-gray-700', 'border-gray-200');
                btnPerus.classList.remove('bg-[#7d2ae7]', 'text-white', 'border-[#7d2ae7]');
            }
        } else {
            if(sectionInd) sectionInd.classList.add('hidden');
            if(sectionPerus) sectionPerus.classList.remove('hidden');
            if(btnPerus) {
                btnPerus.classList.add('bg-[#7d2ae7]', 'text-white', 'border-[#7d2ae7]');
                btnPerus.classList.remove('bg-white', 'text-gray-700', 'border-gray-200');
            }
            if(btnInd) {
                btnInd.classList.add('bg-white', 'text-gray-700', 'border-gray-200');
                btnInd.classList.remove('bg-[#7d2ae7]', 'text-white', 'border-[#7d2ae7]');
            }
        }
        disableSection(sectionInd, val !== 'individu');
        disableSection(sectionPerus, val !== 'perusahaan');
    }

    if (radios.length > 0) {
        radios.forEach(radio => {
            radio.closest('label').addEventListener('click', function () {
                switchJenis(radio.value);
            });
        });
    }

    switchJenis(hiddenJenis.value || 'individu');

    form.addEventListener('submit', function () {
        const val = hiddenJenis.value;
        disableSection(sectionInd, val !== 'individu');
        disableSection(sectionPerus, val !== 'perusahaan');
    });
});
</script>
@endpush