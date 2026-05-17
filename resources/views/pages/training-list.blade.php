@extends('layouts.app')
@section('title', 'Pelatihan K3 — PT Katiga Veritas Indonesia')
@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#1E6B3D] to-[#3CDA7D] text-white py-8">
        <div class="max-w-7xl mx-auto px-6">
            <h1 class="text-3xl font-bold mb-4">Pelatihan K3</h1>
            <p class="text-base text-gray-200">Pilih program pelatihan K3 yang sesuai dengan kebutuhan Anda</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- SEARCH + FILTER -->
        <form method="GET" action="{{ route('training.list') }}" class="bg-white p-6 rounded-xl shadow mb-8">
            <div class="grid md:grid-cols-3 gap-4">
                <div class="md:col-span-2 relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔍</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari materi pelatihan..."
                           class="w-full border rounded pl-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                </div>
                <select name="jenis" onchange="this.form.submit()"
                        class="border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E6B3D]">
                    <option value="">Semua Mode</option>
                    <option value="online"  {{ request('jenis') == 'online'  ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ request('jenis') == 'offline' ? 'selected' : '' }}>Offline</option>
                </select>
            </div>
        </form>

        <!-- REQUEST COMPANY TRAINING BANNER -->
        <div class="bg-gradient-to-r from-orange-400 to-orange-500 rounded-xl shadow p-6 mb-8 text-white flex flex-col md:flex-row items-center justify-between">
            <div class="mb-4 md:mb-0">
                <h2 class="text-xl font-bold mb-1">🏢 Butuh Pelatihan Khusus Perusahaan?</h2>
                <p class="text-sm opacity-90">Kami menyediakan pelatihan in-house yang disesuaikan dengan kebutuhan perusahaan Anda.</p>
            </div>
            <a href="{{ route('request.training.create') }}" class="bg-white text-orange-500 font-semibold px-6 py-2 rounded-lg hover:bg-gray-100 transition whitespace-nowrap shadow-sm">
                Isi Form Request
            </a>
        </div>
        <!-- RESULT COUNT -->
        <div class="mb-6 text-gray-600">
            Menampilkan <strong>{{ $pelatihans->count() }}</strong> pelatihan
        </div>

        @if($pelatihans->isEmpty())
            <div class="text-center py-20 bg-white rounded-xl shadow">
                <div class="text-5xl mb-4">📭</div>
                <h3 class="text-xl font-bold text-gray-600">Tidak ada pelatihan ditemukan</h3>
                <a href="{{ route('training.list') }}" class="mt-4 inline-block text-[#1E6B3D] hover:underline">Reset filter</a>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pelatihans as $pelatihan)
                <div class="bg-white rounded-xl shadow overflow-hidden group hover:shadow-xl transition">
                    <div class="aspect-video overflow-hidden bg-gradient-to-br from-[#1E6B3D] to-[#3CDA7D] flex items-center justify-center">
                        <span class="text-6xl">🎓</span>
                    </div>
                    <div class="p-6">
                        <!-- BADGE -->
                        <div class="flex justify-between mb-3">
                            <span class="bg-[#1E6B3D] text-white text-xs px-2 py-1 rounded">
                                {{ $pelatihan->kategori?->nama ?? 'Pelatihan K3' }}
                            </span>
                            <span class="border text-xs px-2 py-1 rounded {{ $pelatihan->jenis_pertemuan === 'online' ? 'border-[#1E6B3D] text-[#1E6B3D]' : 'border-orange-400 text-orange-500' }}">
                                {{ ucfirst($pelatihan->jenis_pertemuan) }}
                            </span>
                        </div>

                        <h3 class="text-xl font-semibold text-[#1E6B3D] mb-1">{{ $pelatihan->nama }}</h3>
                        <div class="text-lg font-bold text-gray-800 mb-2">Rp {{ number_format($pelatihan->harga, 0, ',', '.') }}</div>
                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $pelatihan->deskripsi ?? 'Pelatihan K3 profesional bersertifikat nasional.' }}</p>

                        <div class="space-y-1 text-sm text-gray-600 mb-4">
                            @if($pelatihan->tgl_mulai)
                            <div>
                                📅 {{ $pelatihan->tgl_mulai->format('d M Y') }}
                                @if($pelatihan->tgl_selesai && $pelatihan->tgl_selesai != $pelatihan->tgl_mulai)
                                    - {{ $pelatihan->tgl_selesai->format('d M Y') }}
                                @endif
                            </div>
                            @elseif($pelatihan->tanggal_usul)
                            <div>📅 {{ $pelatihan->tanggal_usul->format('d M Y') }}</div>
                            @endif
                            @if($pelatihan->jam_pertemuan)
                            <div>⏰ {{ substr($pelatihan->jam_pertemuan, 0, 5) }} WIB</div>
                            @endif
                            @if($pelatihan->lokasi)
                            <div>📍 {{ $pelatihan->lokasi }}</div>
                            @endif
                            @if($pelatihan->kapasitas)
                            <div>👥 Kapasitas: {{ $pelatihan->kapasitas }} peserta</div>
                            @endif
                        </div>

                        <div class="border-t pt-4">
                            <a href="{{ route('training.detail', $pelatihan->id_layanan) }}"
                               class="block w-full text-center bg-[#1E6B3D] text-white py-2 rounded hover:opacity-90 transition">
                                Lihat Detail & Daftar
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection