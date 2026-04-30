@extends('layouts.app')
@section('title', 'Verifikasi Sertifikat — PT Katiga Veritas Indonesia')
@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#0A2540] to-[#00A8A8] text-white py-12">
        <div class="max-w-4xl mx-auto px-6">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-4 hover:bg-white/10 px-3 py-2 rounded">
                ← Kembali
            </a>
            <div class="flex items-center gap-3 mb-4">
                <div class="text-3xl">🛡️</div>
                <h1 class="text-4xl font-bold">Verifikasi Sertifikat</h1>
            </div>
            <p class="text-gray-200 max-w-2xl">
                Cek keaslian sertifikat pelatihan K3 yang dikeluarkan oleh PT Katiga Veritas Indonesia
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-8">

        <div class="mb-8 border border-[#00A8A8] bg-blue-50 p-4 rounded text-sm text-[#0A2540]">
            🔒 Verifikasi sertifikat untuk memastikan keaslian dan mencegah pemalsuan dokumen.
        </div>

        <!-- FORM CARD -->
        <div class="bg-white p-8 rounded-xl shadow">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-[#0A2540] rounded-full flex items-center justify-center mx-auto mb-4 text-white text-3xl">
                    🛡️
                </div>
                <h2 class="text-2xl font-semibold text-[#0A2540] mb-2">Verifikasi Sertifikat</h2>
                <p class="text-gray-600">Masukkan nomor sertifikat untuk memeriksa keasliannya</p>
            </div>

            <form method="POST" action="{{ route('verification.cek') }}" class="space-y-4">
                @csrf
                <input type="text" name="no_sertifikat"
                       value="{{ old('no_sertifikat') }}"
                       placeholder="Contoh: KV-K3-2026-000001"
                       class="w-full border p-3 rounded text-center text-lg uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-[#00A8A8] @error('no_sertifikat') border-red-400 @enderror">
                @error('no_sertifikat')
                    <p class="text-red-500 text-sm text-center">{{ $message }}</p>
                @enderror
                <button type="submit" class="w-full bg-[#00A8A8] text-white py-3 rounded font-semibold hover:opacity-90 transition">
                    🔍 Verifikasi Sertifikat
                </button>
            </form>
        </div>


        {{-- HASIL VERIFIKASI --}}
        @isset($status)
        <div class="mt-8 space-y-6">

            @if($status === 'valid' && $sertifikat)

                <!-- VALID -->
                <div class="border-2 border-green-500 bg-green-50 p-8 rounded-xl text-center">
                    <div class="text-5xl mb-4">✅</div>
                    <h2 class="text-3xl font-bold text-green-700">Sertifikat Valid</h2>
                    <p class="text-gray-600 mt-2">Sertifikat ini terdaftar dan diakui resmi oleh PT Katiga Veritas Indonesia</p>
                </div>

                <!-- DETAIL -->
                <div class="bg-white p-8 rounded-xl shadow">
                    <div class="flex justify-between mb-6">
                        <h3 class="text-xl font-semibold text-[#0A2540]">Detail Sertifikat</h3>
                        <span class="bg-green-600 text-white px-3 py-1 rounded text-sm">✓ Terverifikasi</span>
                    </div>

                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="space-y-4">
                            <div>
                                <div class="text-sm text-gray-500">Nomor Sertifikat</div>
                                <div class="font-bold text-lg">{{ $sertifikat->no_sertifikat }}</div>
                            </div>
                            <hr>
                            <div>
                                <div class="text-sm text-gray-500">Nama Pemegang</div>
                                <div class="font-bold">{{ $sertifikat->nama_lengkap }}</div>
                            </div>
                            <hr>
                            <div>
                                <div class="text-sm text-gray-500">Layanan / Pelatihan</div>
                                <div>{{ $sertifikat->pendaftaran?->layanan?->nama ?? '-' }}</div>
                            </div>
                            <hr>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm text-gray-500">Tanggal Terbit</div>
                                    <div>{{ $sertifikat->tanggal_terbit->format('d M Y') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-center justify-center">
                            <div class="w-32 h-32 bg-[#0A2540] rounded-xl flex items-center justify-center text-white text-4xl shadow">
                                🏆
                            </div>
                            <p class="text-sm text-gray-500 mt-4 text-center">
                                Sertifikat Resmi<br>PT Katiga Veritas Indonesia
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 bg-[#F5F7FA] p-4 rounded text-sm text-gray-600">
                        🛡️ Sertifikat ini memiliki sistem verifikasi digital. Jika ada keraguan, hubungi kami.
                    </div>
                </div>

            @else

                <!-- TIDAK DITEMUKAN -->
                <div class="border-2 border-red-400 bg-red-50 p-8 rounded-xl text-center">
                    <div class="text-5xl mb-4">❌</div>
                    <h2 class="text-3xl font-bold text-red-700">Sertifikat Tidak Ditemukan</h2>
                    <p class="text-gray-600 mt-2">
                        Nomor <strong>{{ old('no_sertifikat') }}</strong> tidak terdaftar dalam sistem kami.
                        Pastikan penulisan sudah benar.
                    </p>
                </div>

            @endif

            <!-- ACTION -->
            <div class="flex gap-3">
                <a href="{{ route('verification') }}" class="flex-1 bg-[#00A8A8] text-white py-2 rounded text-center hover:opacity-90">
                    Verifikasi Lagi
                </a>
                <a href="{{ route('home') }}" class="border px-6 py-2 rounded hover:bg-gray-50">Beranda</a>
            </div>

        </div>
        @endisset


        <!-- HELP -->
        <div class="mt-8 bg-gradient-to-br from-[#0A2540] to-[#00A8A8] text-white p-6 rounded-xl">
            <h3 class="font-semibold mb-2">Butuh Bantuan?</h3>
            <p class="text-sm mb-4">Hubungi tim kami jika ada kendala dalam verifikasi sertifikat.</p>
            <div class="flex gap-3">
                <a href="#" class="bg-white text-black px-4 py-2 rounded text-sm">WhatsApp</a>
                <a href="#" class="border border-white px-4 py-2 rounded text-sm">Email</a>
            </div>
        </div>

    </div>
</div>

@endsection