@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA] py-10">
    <div class="max-w-3xl mx-auto px-6">

        {{-- ── HEADER ──────────────────────────────────────────────── --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm mb-8 border border-gray-100">
            <a href="{{ route('training.detail', $pelatihan->id_layanan) }}"
               class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#1E6B3D] mb-4 transition">
                ← Kembali ke Detail Pelatihan
            </a>
            <h1 class="text-2xl font-bold text-[#1E6B3D]">Form Pendaftaran Pelatihan</h1>
            <p class="text-gray-500 mt-1 text-sm">{{ $pelatihan->kategori->nama ?? $pelatihan->materi }}</p>
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
            <input type="hidden" name="layanan_id"     value="{{ $pelatihan->id_layanan }}">

            <input type="hidden" name="jenis_klien" value="individu">



            {{-- ── STEP 1 · Data Diri & Kontak ────────────────────────── --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-semibold text-[#1E6B3D] mb-5">1. Data Diri & Kontak</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" required
                               value="{{ old('nama_lengkap') }}"
                               placeholder="Masukkan nama lengkap"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D] focus:border-transparent transition">
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" required
                                   value="{{ old('email') }}"
                                   placeholder="Email aktif"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D] focus:border-transparent transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nomor HP / WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="no_telp" required
                                   value="{{ old('no_telp') }}"
                                   placeholder="Contoh: 08123456789"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D] focus:border-transparent transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Pendidikan (Opsional)
                        </label>
                        <input type="text" name="pendidikan"
                               value="{{ old('pendidikan') }}"
                               placeholder="Contoh: S1 Teknik Industri"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1E6B3D] focus:border-transparent transition">
                    </div>
                </div>
            </div>



            {{-- ── STEP 2 · Ringkasan & Submit ────────────────────── --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-semibold text-[#1E6B3D] mb-5">2. Ringkasan Pendaftaran</h2>

                <div class="bg-[#F5F7FA] rounded-xl p-5 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Pelatihan</span>
                        <span class="font-medium text-[#1E6B3D] text-right max-w-[60%]">
                            {{ $pelatihan->kategori->nama ?? $pelatihan->materi }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal</span>
                        <span class="font-medium text-[#1E6B3D]">
                            {{ \Carbon\Carbon::parse($pelatihan->tanggal_pertemuan)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    @if($pelatihan->lokasi)
                    <div class="flex justify-between">
                        <span class="text-gray-500">Lokasi</span>
                        <span class="font-medium text-[#1E6B3D]">{{ $pelatihan->lokasi }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-500">Jenis Pertemuan</span>
                        <span class="font-medium text-[#1E6B3D] capitalize">{{ $pelatihan->jenis_pertemuan }}</span>
                    </div>
                    <div class="border-t border-gray-200 pt-3 flex justify-between">
                        <span class="text-gray-500">Status Bayar</span>
                        <span class="text-yellow-600 font-medium">Belum Bayar</span>
                    </div>
                </div>

                <p class="text-xs text-gray-400 mt-3">
                    Setelah mendaftar, tim kami akan menghubungi Anda melalui Email atau WhatsApp untuk konfirmasi pembayaran.
                    Anda juga dapat memantau status pendaftaran secara mandiri melalui halaman <a href="{{ route('training.status') }}" class="text-[#1E6B3D] hover:underline font-semibold">Cek Status Pendaftaran</a>.
                </p>
            </div>

            {{-- ── TOMBOL SUBMIT ───────────────────────────────────── --}}
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('training.detail', $pelatihan->id_layanan) }}"
                   class="text-sm text-gray-500 hover:text-[#1E6B3D] transition">
                    ← Batalkan
                </a>
                <button type="submit"
                        class="bg-[#1E6B3D] hover:bg-[#3CDA7D] text-white font-semibold px-8 py-3 rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95">
                    Kirim Pendaftaran →
                </button>
            </div>

        </form>

    </div>
</div>


@endsection