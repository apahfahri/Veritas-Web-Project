@extends('layouts.app')
@section('title', 'Dashboard | PT Katiga Veritas Indonesia')
@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#7d2ae7] via-[#3969e7] to-[#07b9ce] text-white py-8">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Dashboard</h1>
                <p class="text-gray-200">Selamat datang, <strong>{{ $user->username }}</strong></p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('training.list') }}" class="px-4 py-2 hover:bg-white/10 rounded text-sm">Pelatihan</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 hover:bg-white/10 rounded text-sm">Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">

        {{-- FLASH MESSAGES --}}
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-300 text-green-700 p-4 rounded-lg">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-300 text-red-700 p-4 rounded-lg">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- STATS -->
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Total Pendaftaran</p>
                    <p class="text-3xl font-bold text-[#7d2ae7]">{{ $stats['total'] }}</p>
                </div>
                <div class="text-3xl">📋</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Menunggu</p>
                    <p class="text-3xl font-bold text-orange-500">{{ $stats['menunggu'] }}</p>
                </div>
                <div class="text-3xl">⏳</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Selesai</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['selesai'] }}</p>
                </div>
                <div class="text-3xl">✅</div>
            </div>
            <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Sertifikat</p>
                    <p class="text-3xl font-bold text-[#7d2ae7]">{{ $stats['sertifikat'] }}</p>
                </div>
                <div class="text-3xl">🏆</div>
            </div>
        </div>

        <!-- PENDAFTARAN LIST -->
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-xl font-semibold text-[#7d2ae7]">Riwayat Pendaftaran</h2>
                <a href="{{ route('training.list') }}"
                   class="bg-[#7d2ae7] text-white px-4 py-2 rounded text-sm hover:opacity-90">
                    + Daftar Layanan Baru
                </a>
            </div>

            @if($pendaftarans->isEmpty())
                <div class="text-center py-16">
                    <div class="text-5xl mb-4">📭</div>
                    <h3 class="text-xl font-bold text-gray-600">Belum Ada Pendaftaran</h3>
                    <p class="text-gray-500 mb-6">Mulai dengan mendaftar pelatihan K3 pilihan Anda</p>
                    <a href="{{ route('training.list') }}"
                       class="bg-[#7d2ae7] text-white px-6 py-3 rounded-lg hover:opacity-90">
                        Lihat Pelatihan
                    </a>
                </div>
            @else
                <div class="divide-y">
                    @foreach($pendaftarans as $p)
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-lg text-[#7d2ae7]">
                                    {{ $p->layanan?->nama ?? 'Layanan K3' }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Didaftarkan: {{ $p->tanggal_daftar->format('d M Y') }}
                                </p>
                            </div>
                            <div class="flex gap-2 flex-wrap justify-end">
                                {{-- Status Progres --}}
                                @php
                                    $progresColor = match($p->status_progres) {
                                        'selesai'   => 'bg-green-100 text-green-700',
                                        'diproses'  => 'bg-blue-100 text-blue-700',
                                        'dibatalkan'=> 'bg-red-100 text-red-700',
                                        default     => 'bg-orange-100 text-orange-700',
                                    };
                                    $progresLabel = match($p->status_progres) {
                                        'selesai'   => '✅ Selesai',
                                        'diproses'  => '🔄 Diproses',
                                        'dibatalkan'=> '❌ Dibatalkan',
                                        default     => '⏳ Menunggu',
                                    };
                                @endphp
                                <span class="text-xs px-3 py-1 rounded-full {{ $progresColor }}">
                                    {{ $progresLabel }}
                                </span>

                                {{-- Status Bayar --}}
                                @php
                                    $bayarColor = match($p->status_bayar) {
                                        'lunas'               => 'bg-green-100 text-green-700',
                                        'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-700',
                                        default               => 'bg-gray-100 text-gray-600',
                                    };
                                    $bayarLabel = match($p->status_bayar) {
                                        'lunas'               => '💰 Lunas',
                                        'menunggu_konfirmasi' => '⏳ Konfirmasi',
                                        default               => '💳 Belum Bayar',
                                    };
                                @endphp
                                <span class="text-xs px-3 py-1 rounded-full {{ $bayarColor }}">
                                    {{ $bayarLabel }}
                                </span>
                            </div>
                        </div>

                        <div class="flex gap-2 mt-3">
                            {{-- Sertifikat jika ada --}}
                            @if($p->sertifikat)
                                <a href="{{ route('verification') }}?no={{ $p->sertifikat->no_sertifikat }}"
                                   class="bg-[#7d2ae7] text-white px-4 py-1.5 rounded text-sm hover:opacity-90">
                                    🏆 Lihat Sertifikat ({{ $p->sertifikat->no_sertifikat }})
                                </a>
                            @endif

                            {{-- Batalkan jika masih menunggu --}}
                            @if($p->status_progres === 'menunggu')
                                <form method="POST" action="{{ route('pendaftaran.destroy', $p->id) }}"
                                      onsubmit="return confirm('Yakin ingin membatalkan pendaftaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="border border-red-400 text-red-500 px-4 py-1.5 rounded text-sm hover:bg-red-50">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</div>

@endsection