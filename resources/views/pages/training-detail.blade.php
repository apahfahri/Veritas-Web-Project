@extends('layouts.app')
@section('title', $pelatihan->materi . ' — PT Katiga Veritas Indonesia')
@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- BREADCRUMB -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#1E6B3D]">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('training.list') }}" class="text-gray-500 hover:text-[#1E6B3D]">Pelatihan</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-[#1E6B3D] font-medium">{{ $pelatihan->materi }}</span>
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
                        <span class="bg-[#1E6B3D] text-white text-xs px-3 py-1 rounded">
                            {{ $pelatihan->kategori?->nama ?? 'Pelatihan K3' }}
                        </span>
                        <span class="border text-xs px-3 py-1 rounded {{ $pelatihan->jenis_pertemuan === 'online' ? 'border-[#1E6B3D] text-[#1E6B3D]' : 'border-orange-400 text-orange-500' }}">
                            {{ ucfirst($pelatihan->jenis_pertemuan) }}
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold text-[#1E6B3D] mb-2">{{ $pelatihan->nama }}</h1>
                    <div class="text-2xl font-bold text-gray-800 mb-4">Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}</div>

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
                        @if($pelatihan->tanggal_usul)
                        <div>
                            <div class="text-gray-500">Tanggal</div>
                            <div class="font-semibold">{{ $pelatihan->tanggal_usul->format('d M Y') }}</div>
                        </div>
                        @endif
                    </div>

                    <hr class="my-6">

                    <!-- DESCRIPTION -->
                    @if($pelatihan->deskripsi)
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-[#1E6B3D] mb-3">Deskripsi Pelatihan</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $pelatihan->deskripsi }}</p>
                    </div>
                    @endif

                    <!-- SCHEDULE -->
                    <div>
                        <h2 class="text-xl font-semibold text-[#1E6B3D] mb-4">Jadwal</h2>
                        <div class="border rounded-lg p-4 space-y-2 text-sm">
                            @if($pelatihan->tanggal_usul)
                            <div>📅 {{ $pelatihan->tanggal_usul->format('l, d F Y') }}</div>
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

                    <!-- PEMATERI -->
                    @if($pelatihan->pemateri && $pelatihan->pemateri->count() > 0)
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold text-[#1E6B3D] mb-4">Pemateri</h2>
                        <div class="grid gap-4">
                            @foreach($pelatihan->pemateri as $pemateri)
                            <div class="border border-gray-200 rounded-lg p-4 flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-[#1E6B3D]/10 text-[#1E6B3D] flex items-center justify-center font-bold text-xl shrink-0">
                                    {{ strtoupper(substr($pemateri->nama_lengkap, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $pemateri->nama_lengkap }}</h3>
                                    @if($pemateri->kompetensi)
                                        <p class="text-sm text-gray-500">{{ $pemateri->kompetensi }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

            </div>

            <!-- RIGHT -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow sticky top-4">
                    <div class="mb-4">
                        <div class="text-sm text-gray-500">Layanan</div>
                        <div class="text-xl font-bold text-[#1E6B3D] mb-1">{{ $pelatihan->kategori?->nama }}</div>
                        <div class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}</div>
                    </div>

                    <hr class="my-4">

                    <ul class="space-y-2 text-sm mb-6">
                        <li>✔ Sertifikat resmi terakreditasi</li>
                        <li>✔ Materi lengkap & terstructured</li>
                        <li>✔ Instruktur berpengalaman</li>
                        <li>✔ Berlaku seumur hidup</li>
                    </ul>

                    <a href="{{ route('training.register', $pelatihan->id_layanan) }}"
                       class="block w-full text-center bg-[#1E6B3D] text-white py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        Daftar Sekarang
                    </a>

                    <div class="mt-4 text-center text-sm">
                        <a href="{{ route('consultation') }}" class="text-[#1E6B3D] hover:underline">
                            Butuh konsultasi dulu?
                        </a>
                    </div>
                </div>

                @if(!$related->isEmpty())
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold text-[#1E6B3D] mb-4">Pelatihan Lainnya</h3>
                    <div class="space-y-3">
                        @foreach($related as $rel)
                        <a href="{{ route('training.detail', $rel->id_layanan) }}"
                           class="block p-3 border rounded hover:border-[#1E6B3D] transition text-sm">
                            <div class="font-medium text-[#1E6B3D]">{{ $rel->materi }}</div>
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