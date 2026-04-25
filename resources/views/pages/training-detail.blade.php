@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- BREADCRUMB -->
    <div class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-6 py-4 text-sm">
            <a href="/" class="text-gray-500 hover:text-[#00A8A8]">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="/training" class="text-gray-500 hover:text-[#00A8A8]">Pelatihan</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-[#0A2540] font-medium">Pelatihan K3 Umum</span>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- BACK -->
        <a href="/training" class="inline-flex items-center gap-2 mb-6 text-gray-600 hover:underline">
            ← Kembali
        </a>

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- LEFT -->
            <div class="lg:col-span-2 space-y-6">

                <!-- IMAGE -->
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="aspect-video">
                        <img src="https://images.unsplash.com/photo-1601021545082-4385509b3074"
                             class="w-full h-full object-cover">
                    </div>
                </div>

                <!-- INFO -->
                <div class="bg-white p-8 rounded-xl shadow">

                    <div class="flex gap-3 mb-4">
                        <span class="bg-[#0A2540] text-white text-xs px-3 py-1 rounded">
                            K3 Umum
                        </span>
                        <span class="border text-xs px-3 py-1 rounded">
                            Online
                        </span>
                    </div>

                    <h1 class="text-3xl font-bold text-[#0A2540] mb-4">
                        Pelatihan K3 Umum Sertifikasi
                    </h1>

                    <!-- STATS -->
                    <div class="grid sm:grid-cols-3 gap-4 mb-6 text-sm">

                        <div>
                            <div class="text-gray-500">Durasi</div>
                            <div class="font-medium">3 Hari</div>
                        </div>

                        <div>
                            <div class="text-gray-500">Max Peserta</div>
                            <div class="font-medium">30 orang</div>
                        </div>

                        <div>
                            <div class="text-gray-500">Mode</div>
                            <div class="font-medium">Online</div>
                        </div>

                    </div>

                    <hr class="my-6">

                    <!-- DESC -->
                    <div>
                        <h2 class="text-xl font-semibold text-[#0A2540] mb-3">
                            Deskripsi Pelatihan
                        </h2>

                        <p class="text-gray-600">
                            Pelatihan lengkap K3 untuk meningkatkan keselamatan kerja di perusahaan Anda.
                        </p>
                    </div>

                    <hr class="my-6">

                    <!-- SYLLABUS -->
                    <div>
                        <h2 class="text-xl font-semibold text-[#0A2540] mb-4">
                            Materi yang Dipelajari
                        </h2>

                        <div class="grid sm:grid-cols-2 gap-3 text-sm">
                            <div>✔ Dasar K3</div>
                            <div>✔ Manajemen Risiko</div>
                            <div>✔ APD</div>
                            <div>✔ Investigasi Kecelakaan</div>
                        </div>
                    </div>

                    <hr class="my-6">

                    <!-- INSTRUCTOR -->
                    <div class="flex gap-4 items-start">
                        <div class="w-16 h-16 bg-[#0A2540] rounded-full flex items-center justify-center text-white font-bold">
                            AS
                        </div>

                        <div>
                            <h3 class="font-semibold text-lg text-[#0A2540]">
                                Ahmad Setiawan
                            </h3>
                            <p class="text-gray-600 text-sm">
                                Instruktur berpengalaman di bidang K3 selama 10 tahun
                            </p>
                        </div>
                    </div>

                </div>

                <!-- SCHEDULE -->
                <div class="bg-white p-8 rounded-xl shadow">

                    <h2 class="text-xl font-semibold text-[#0A2540] mb-6">
                        Jadwal Tersedia
                    </h2>

                    <!-- ITEM -->
                    <div class="border p-4 rounded mb-4">

                        <div class="space-y-2 text-sm">

                            <div>
                                📅 Senin, 12 Januari 2026
                            </div>

                            <div>
                                ⏰ 08:00 - 16:00 WIB
                            </div>

                            <div>
                                📍 Jakarta
                            </div>

                            <div class="text-green-600">
                                10 kursi tersedia
                            </div>

                        </div>

                        <a href="/training/1/register"
                           class="mt-4 inline-block bg-[#00A8A8] text-white px-4 py-2 rounded">
                            Pilih Jadwal
                        </a>

                    </div>

                </div>

            </div>


            <!-- RIGHT -->
            <div class="space-y-6">

                <!-- PRICE -->
                <div class="bg-white p-6 rounded-xl shadow sticky top-4">

                    <div class="mb-4">
                        <div class="text-sm text-gray-500">Harga</div>
                        <div class="text-3xl font-bold text-[#0A2540]">
                            Rp 2.000.000
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="space-y-2 text-sm mb-6">
                        <div>✔ Sertifikat resmi</div>
                        <div>✔ Materi lengkap</div>
                        <div>✔ Instruktur profesional</div>
                        <div>✔ Konsumsi</div>
                    </div>

                    <a href="/training/1/register"
                       class="block w-full text-center bg-[#FF7A00] text-white py-3 rounded">
                        Daftar Sekarang
                    </a>

                    <div class="mt-4 text-center text-sm">
                        <a href="#" class="text-[#00A8A8] hover:underline">
                            Hubungi kami
                        </a>
                    </div>

                </div>

                <!-- CTA -->
                <div class="bg-gradient-to-br from-[#0A2540] to-[#00A8A8] text-white p-6 rounded-xl">
                    <h3 class="font-semibold mb-2">
                        Pelatihan untuk Perusahaan?
                    </h3>
                    <p class="text-sm mb-4">
                        Dapatkan harga khusus
                    </p>

                    <a href="#" class="bg-white text-black px-4 py-2 rounded block text-center">
                        Hubungi Sales
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection