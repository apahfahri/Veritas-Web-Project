@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#0A2540] to-[#00A8A8] text-white py-8">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">

            <div>
                <h1 class="text-3xl font-bold">Dashboard</h1>
                <p class="text-gray-200">Selamat datang, Budi Santoso</p>
            </div>

            <div class="flex gap-3">
                <a href="/" class="px-4 py-2 hover:bg-white/10 rounded">Beranda</a>
                <a href="/" class="px-4 py-2 hover:bg-white/10 rounded">Keluar</a>
            </div>

        </div>
    </div>

    <!-- CONTENT -->
    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- STATS -->
        <div class="grid md:grid-cols-3 gap-6 mb-8">

            <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Total Pelatihan</p>
                    <p class="text-3xl font-bold text-[#0A2540]">3</p>
                </div>
                <div class="text-3xl">🎓</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Konsultasi</p>
                    <p class="text-3xl font-bold text-[#00A8A8]">2</p>
                </div>
                <div class="text-3xl">💬</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500">Sertifikat</p>
                    <p class="text-3xl font-bold text-[#FF7A00]">1</p>
                </div>
                <div class="text-3xl">🏆</div>
            </div>

        </div>


        <!-- TAB NAV -->
        <div class="bg-white rounded-xl shadow p-4 mb-6 flex gap-4">
            <button class="px-4 py-2 bg-[#0A2540] text-white rounded">Pelatihan</button>
            <button class="px-4 py-2 bg-gray-100 rounded">Konsultasi</button>
            <button class="px-4 py-2 bg-gray-100 rounded">Sertifikat</button>
        </div>


        <!-- TRAINING LIST -->
        <div class="space-y-4">

            <!-- CARD -->
            <div class="bg-white p-6 rounded-xl shadow">

                <div class="flex justify-between mb-3">
                    <h3 class="font-bold text-lg text-[#0A2540]">Pelatihan K3 Umum</h3>
                    <span class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                        Disetujui
                    </span>
                </div>

                <div class="text-sm text-gray-600 space-y-1 mb-3">
                    <div>📅 12 Januari 2026</div>
                    <div>⏰ 08:00 - 16:00 WIB</div>
                    <div>📍 Jakarta</div>
                </div>

                <div class="text-sm mb-3">
                    Jenis: <span class="font-medium">Individu</span>
                </div>

                <div class="p-3 bg-green-50 border border-green-200 rounded text-sm text-green-700 mb-4">
                    ✔ Pendaftaran disetujui! Silakan hadir sesuai jadwal
                </div>

                <div class="flex gap-2">
                    <a href="#" class="border px-4 py-2 rounded">Detail</a>
                    <a href="#" class="bg-[#FF7A00] text-white px-4 py-2 rounded">Sertifikat</a>
                </div>

            </div>


            <!-- EMPTY STATE (contoh) -->
            <!--
            <div class="text-center py-12">
                <div class="text-5xl mb-4">🎓</div>
                <h3 class="text-xl font-bold text-gray-600">Belum Ada Pelatihan</h3>
                <p class="text-gray-500 mb-4">Mulai sekarang</p>
                <a href="/training" class="bg-[#00A8A8] text-white px-6 py-2 rounded">
                    Lihat Pelatihan
                </a>
            </div>
            -->

        </div>

    </div>

</div>

@endsection