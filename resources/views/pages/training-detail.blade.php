@extends('layouts.app')
@section('title', $pelatihan->materi . ' — PT Katiga Veritas Indonesia')
@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- BREADCRUMB -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#00A8A8]">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('training.list') }}" class="text-gray-500 hover:text-[#00A8A8]">Pelatihan</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-[#0A2540] font-medium">{{ $pelatihan->materi }}</span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">
        <a href="{{ route('training.list') }}" class="inline-flex items-center gap-2 mb-6 text-gray-600 hover:underline">
            ← Kembali ke Daftar Pelatihan
        </a>

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- LEFT -->
            <div class="lg:col-span-2 space-y-6">

                <!-- HEADER CARD -->
                <div class="bg-white p-8 rounded-xl shadow">
                    <div class="flex gap-3 mb-4">
                        <span class="bg-[#0A2540] text-white text-xs px-3 py-1 rounded">
                            {{ $pelatihan->layanan?->nama ?? 'Pelatihan K3' }}
                        </span>
                        <span class="border text-xs px-3 py-1 rounded {{ $pelatihan->jenis_pertemuan === 'online' ? 'border-[#00A8A8] text-[#00A8A8]' : 'border-orange-400 text-orange-500' }}">
                            {{ ucfirst($pelatihan->jenis_pertemuan) }}
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold text-[#0A2540] mb-4">{{ $pelatihan->materi }}</h1>

                    <!-- INFO GRID -->
                    <div class="grid sm:grid-cols-3 gap-4 mb-6 text-sm bg-[#F5F7FA] p-4 rounded-lg">
                        @if($pelatihan->kapasitas)
                        <div>
                            <div class="text-gray-500">Kapasitas</div>
                            <div class="font-semibold">{{ $sisaKursi }} kursi</div>
                        </div>
                        @endif
                        <div>
                            <div class="text-gray-500">Mode</div>
                            <div class="font-semibold">{{ ucfirst($pelatihan->jenis_pertemuan) }}</div>
                        </div>
                        @if($pelatihan->tanggal_pertemuan)
                        <div>
                            <div class="text-gray-500">Tanggal</div>
                            <div class="font-semibold">{{ $pelatihan->tanggal_pertemuan->format('d M Y') }}</div>
                        </div>
                        @endif
                    </div>

                    <hr class="my-6">

                    <!-- DESCRIPTION -->
                    @if($pelatihan->deskripsi)
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-[#0A2540] mb-3">Deskripsi Pelatihan</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $pelatihan->deskripsi }}</p>
                    </div>
                    @endif

                    <!-- SCHEDULE -->
                    <div>
                        <h2 class="text-xl font-semibold text-[#0A2540] mb-4">Jadwal</h2>
                        <div class="border rounded-lg p-4 space-y-2 text-sm">
                            @if($pelatihan->tanggal_pertemuan)
                            <div>📅 {{ $pelatihan->tanggal_pertemuan->format('l, d F Y') }}</div>
                            @endif
                            @if($pelatihan->jam_pertemuan)
                            <div>⏰ {{ substr($pelatihan->jam_pertemuan, 0, 5) }} WIB</div>
                            @endif
                            @if($pelatihan->lokasi)
                            <div>📍 {{ $pelatihan->lokasi }}</div>
                            @else
                            <div>📍 Online (Zoom / Google Meet)</div>
                            @endif
                            @if($pelatihan->kapasitas)
                            <div class="{{ $sisaKursi > 5 ? 'text-green-600' : 'text-orange-500' }} font-medium">
                                {{ $sisaKursi }} kursi tersedia
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow sticky top-4">
                    <div class="mb-4">
                        <div class="text-sm text-gray-500">Layanan</div>
                        <div class="text-xl font-bold text-[#0A2540]">{{ $pelatihan->layanan?->nama }}</div>
                    </div>

                    <hr class="my-4">

                    <ul class="space-y-2 text-sm mb-6">
                        <li>✔ Sertifikat resmi terakreditasi</li>
                        <li>✔ Materi lengkap & terstruktur</li>
                        <li>✔ Instruktur berpengalaman</li>
                        <li>✔ Berlaku seumur hidup</li>
                    </ul>

                    @auth
                        <a href="{{ route('training.register', $pelatihan->id) }}"
                           class="block w-full text-center bg-[#FF7A00] text-white py-3 rounded-lg font-semibold hover:opacity-90 transition">
                            Daftar Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="block w-full text-center bg-[#0A2540] text-white py-3 rounded-lg hover:opacity-90 transition">
                            Login untuk Mendaftar
                        </a>
                        <p class="text-xs text-center text-gray-500 mt-2">
                            Belum punya akun? <a href="{{ route('register') }}" class="text-[#00A8A8] hover:underline">Daftar</a>
                        </p>
                    @endauth

                    <div class="mt-4 text-center text-sm">
                        <a href="{{ route('consultation') }}" class="text-[#00A8A8] hover:underline">
                            Butuh konsultasi dulu?
                        </a>
                    </div>
                </div>

                @if(!$related->isEmpty())
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold text-[#0A2540] mb-4">Pelatihan Lainnya</h3>
                    <div class="space-y-3">
                        @foreach($related as $rel)
                        <a href="{{ route('training.detail', $rel->id) }}"
                           class="block p-3 border rounded hover:border-[#00A8A8] transition text-sm">
                            <div class="font-medium text-[#0A2540]">{{ $rel->materi }}</div>
                            <div class="text-gray-500 text-xs">{{ ucfirst($rel->jenis_pertemuan) }}</div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

@endsection