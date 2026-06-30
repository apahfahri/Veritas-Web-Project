@extends('layouts.app')
@section('title', ($jadwal->jenis?->nama ?? 'Detail Pelatihan') . ' — PT Katiga Veritas Indonesia')
@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- BREADCRUMB -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 text-sm">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-[#1E6B3D]">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('training.list') }}" class="text-gray-500 hover:text-[#1E6B3D]">Pelatihan</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-[#1E6B3D] font-medium">{{ $jadwal->jenis?->nama }}</span>
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
                            {{ $jadwal->kategori?->nama ?? 'Pelatihan K3' }}
                        </span>
                        <span class="border text-xs px-3 py-1 rounded {{ $jadwal->jenis_pertemuan === 'online' ? 'border-[#1E6B3D] text-[#1E6B3D]' : 'border-orange-400 text-orange-500' }}">
                            {{ ucfirst($jadwal->jenis_pertemuan) }}
                        </span>
                        @if($jadwal->status_pelaksanaan === 'Berlangsung')
                            <span class="bg-rose-500 text-white text-xs px-3 py-1 rounded font-bold shadow-sm flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-ping"></span>
                                Berlangsung
                            </span>
                        @elseif($jadwal->status_pelaksanaan === 'Akan Datang')
                            <span class="bg-sky-500 text-white text-xs px-3 py-1 rounded font-bold shadow-sm">
                                Akan Datang
                            </span>
                        @else
                            <span class="bg-slate-600 text-white text-xs px-3 py-1 rounded font-bold shadow-sm">
                                {{ $jadwal->status_pelaksanaan }}
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl font-bold text-[#1E6B3D] mb-2">{{ $jadwal->jenis?->nama }}</h1>
                    <div class="text-2xl font-bold text-gray-800 mb-4">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</div>

                    <!-- INFO GRID -->
                    <div class="grid sm:grid-cols-3 gap-4 mb-6 text-sm bg-[#F5F7FA] p-4 rounded-lg">
                        @if($jadwal->kapasitas)
                        <div>
                            <div class="text-gray-500">Kapasitas</div>
                            <div class="font-semibold">{{ $sisaKursi }} / {{ $jadwal->kapasitas }} kursi</div>
                        </div>
                        @endif
                        <div>
                            <div class="text-gray-500">Mode</div>
                            <div class="font-semibold">{{ ucfirst($jadwal->jenis_pertemuan) }}</div>
                        </div>
                        @if($jadwal->tgl_mulai)
                        <div>
                            <div class="text-gray-500">Tanggal Mulai</div>
                            <div class="font-semibold">{{ $jadwal->tgl_mulai->format('d M Y') }}</div>
                        </div>
                        @endif
                    </div>

                    <hr class="my-6">

                    <!-- DESCRIPTION -->
                    @if($jadwal->deskripsi)
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-[#1E6B3D] mb-3">Deskripsi Pelatihan</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $jadwal->deskripsi }}</p>
                    </div>
                    @endif

                    <!-- SCHEDULE -->
                    <div>
                        <h2 class="text-xl font-semibold text-[#1E6B3D] mb-4">Jadwal</h2>
                        <div class="border rounded-lg p-4 space-y-2 text-sm">
                            @if($jadwal->tgl_mulai)
                            <div class="flex items-center gap-1.5"><i class="fi fi-rr-calendar text-gray-500"></i> <span>{{ $jadwal->tgl_mulai->format('l, d F Y') }} @if($jadwal->tgl_selesai) - {{ $jadwal->tgl_selesai->format('l, d F Y') }} @endif</span></div>
                            @endif
                            @if($jadwal->jam_pertemuan)
                            <div class="flex items-center gap-1.5"><i class="fi fi-rr-clock text-gray-500"></i> <span>{{ substr($jadwal->jam_pertemuan, 0, 5) }} WIB</span></div>
                            @endif
                            @if($jadwal->lokasi)
                            <div class="flex items-center gap-1.5"><i class="fi fi-rr-marker text-gray-500"></i> <span>{{ $jadwal->lokasi }}</span></div>
                            @else
                            <div class="flex items-center gap-1.5"><i class="fi fi-rr-marker text-gray-500"></i> <span>Online (Zoom / Google Meet)</span></div>
                            @endif
                            @if($jadwal->kapasitas)
                            <div class="{{ $sisaKursi > 5 ? 'text-green-600' : 'text-orange-500' }} font-medium">
                                {{ $sisaKursi }} kursi tersedia
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- PEMATERI -->
                    @if($jadwal->pemateri && $jadwal->pemateri->count() > 0)
                    <div class="mt-8">
                        <h2 class="text-xl font-semibold text-[#1E6B3D] mb-4">Pemateri</h2>
                        <div class="grid sm:grid-cols-2 gap-4">
                            @foreach($jadwal->pemateri as $pemateri)
                            <div class="border border-gray-200 rounded-lg p-4 flex items-center gap-4 bg-white hover:shadow-md transition">
                                @if($pemateri->foto)
                                <img src="{{ asset('storage/' . $pemateri->foto) }}" alt="{{ $pemateri->nama_lengkap }}" class="w-12 h-12 rounded-full object-cover shrink-0 border-2 border-gray-100">
                                @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($pemateri->nama_lengkap) }}&background=1E6B3D&color=fff" alt="{{ $pemateri->nama_lengkap }}" class="w-12 h-12 rounded-full object-cover shrink-0 border-2 border-gray-100">
                                @endif
                                <div>
                                    <h3 class="font-semibold text-gray-800 line-clamp-1" title="{{ $pemateri->nama_lengkap }}">{{ $pemateri->nama_lengkap }}</h3>
                                    @if($pemateri->kompetensi)
                                        <p class="text-xs text-gray-500 line-clamp-2 mt-0.5" title="{{ $pemateri->kompetensi }}">{{ $pemateri->kompetensi }}</p>
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
                        <div class="text-xl font-bold text-[#1E6B3D] mb-1">{{ $jadwal->kategori?->nama }}</div>
                        <div class="text-2xl font-extrabold text-gray-800">Rp {{ number_format($jadwal->harga, 0, ',', '.') }}</div>
                    </div>

                    <hr class="my-4">

                    <ul class="space-y-2 text-sm mb-6">
                        <li class="flex items-center"><i class="fi fi-rr-check text-[#1E6B3D] mr-2 font-bold"></i> Sertifikat resmi terakreditasi</li>
                        <li class="flex items-center"><i class="fi fi-rr-check text-[#1E6B3D] mr-2 font-bold"></i> Materi lengkap & terstructured</li>
                        <li class="flex items-center"><i class="fi fi-rr-check text-[#1E6B3D] mr-2 font-bold"></i> Instruktur berpengalaman</li>
                        <li class="flex items-center"><i class="fi fi-rr-check text-[#1E6B3D] mr-2 font-bold"></i> Berlaku seumur hidup</li>
                    </ul>

                    <a href="{{ route('training.register', $jadwal->id_jadwal) }}"
                       class="block w-full text-center bg-[#1E6B3D] text-white py-3 rounded-lg font-semibold hover:opacity-90 transition">
                        Daftar Sekarang
                    </a>
                </div>

                @if(!$related->isEmpty())
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold text-[#1E6B3D] mb-4">Pelatihan Lainnya</h3>
                    <div class="space-y-3">
                        @foreach($related as $rel)
                        <a href="{{ route('training.detail', $rel->id_jadwal) }}"
                           class="block p-3 border rounded hover:border-[#1E6B3D] transition text-sm">
                            <div class="font-medium text-[#1E6B3D]">{{ $rel->jenis?->nama }}</div>
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