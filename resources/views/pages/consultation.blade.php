@extends('layouts.app')
@section('title', 'Konsultasi K3 — PT Katiga Veritas Indonesia')
@section('content')

<div class="min-h-screen bg-[#F5F7FA]">
    <div class="bg-gradient-to-r from-[#0A2540] to-[#00A8A8] text-white py-12">
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
                <h2 class="text-2xl font-semibold text-[#0A2540] mb-2">Form Pengajuan Konsultasi</h2>
                <p class="text-gray-600 mb-6">Lengkapi form di bawah ini</p>

                @auth
                <form method="POST" action="{{ route('pendaftaran.store') }}" class="space-y-6">
                    @csrf
                    {{-- Layanan ID untuk Konsultasi K3 --}}
                    @php $layananKonsultasi = \App\Models\Layanan::where('nama', 'like', '%Konsultasi%')->first(); @endphp
                    <input type="hidden" name="layanan_id" value="{{ $layananKonsultasi?->id }}">

                    <div>
                        <label class="font-medium text-sm">Nama Lengkap</label>
                        <input type="text" value="{{ Auth::user()->name }}" readonly
                               class="w-full border p-2 rounded mt-1 bg-gray-50 text-gray-600">
                    </div>

                    <div>
                        <label class="font-medium text-sm">Email</label>
                        <input type="email" value="{{ Auth::user()->email }}" readonly
                               class="w-full border p-2 rounded mt-1 bg-gray-50 text-gray-600">
                    </div>

                    <div>
                        <label class="font-medium text-sm">Tanggal yang Diinginkan *</label>
                        <input type="date" name="tanggal_daftar" required
                               min="{{ date('Y-m-d') }}"
                               class="w-full border p-2 rounded mt-1 focus:ring-2 focus:ring-[#00A8A8] focus:outline-none @error('tanggal_daftar') border-red-400 @enderror">
                        @error('tanggal_daftar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('home') }}" class="border px-4 py-2 rounded hover:bg-gray-50">Batal</a>
                        <button type="submit" class="flex-1 bg-[#00A8A8] text-white py-2 rounded hover:opacity-90">
                            Ajukan Konsultasi
                        </button>
                    </div>
                </form>
                @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-4">🔒</div>
                    <p class="text-gray-600 mb-4">Silakan login terlebih dahulu untuk mengajukan konsultasi</p>
                    <a href="{{ route('login') }}" class="bg-[#00A8A8] text-white px-6 py-2 rounded">Login Sekarang</a>
                </div>
                @endauth
            </div>

            <!-- SIDEBAR -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#0A2540]">Tentang Konsultasi</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>✔ Konsultan K3 berpengalaman</li>
                        <li>✔ Solusi sesuai kebutuhan</li>
                        <li>✔ Dokumentasi lengkap</li>
                        <li>✔ Untuk individu &amp; perusahaan</li>
                    </ul>
                </div>
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#0A2540]">Alur Proses</h3>
                    <ol class="text-sm space-y-2 text-gray-600">
                        <li>1. Submit Form</li>
                        <li>2. Review oleh Tim</li>
                        <li>3. Penugasan Konsultan</li>
                        <li>4. Sesi Konsultasi</li>
                    </ol>
                </div>
                <div class="bg-gradient-to-br from-[#0A2540] to-[#00A8A8] text-white p-6 rounded-xl">
                    <h3 class="font-semibold mb-2">Butuh Bantuan?</h3>
                    <a href="#" class="bg-white text-black px-4 py-2 rounded block text-center text-sm">WhatsApp Kami</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection