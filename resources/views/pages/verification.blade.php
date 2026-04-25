@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#0A2540] to-[#00A8A8] text-white py-12">
        <div class="max-w-4xl mx-auto px-6">

            <a href="/" class="inline-flex items-center gap-2 mb-4 hover:bg-white/10 px-3 py-2 rounded">
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

        <!-- ALERT -->
        <div class="mb-8 border border-[#00A8A8] bg-blue-50 p-4 rounded text-sm">
            Verifikasi sertifikat untuk memastikan keaslian dan mencegah pemalsuan.
        </div>


        <!-- FORM CARD -->
        <div class="bg-white p-8 rounded-xl shadow">

            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-[#0A2540] rounded-full flex items-center justify-center mx-auto mb-4 text-white text-3xl">
                    🛡️
                </div>

                <h2 class="text-2xl font-semibold text-[#0A2540] mb-2">
                    Verifikasi Sertifikat
                </h2>

                <p class="text-gray-600">
                    Masukkan kode sertifikat
                </p>
            </div>

            <!-- FORM -->
            <form method="GET" action="" class="space-y-6">

                <input 
                    type="text"
                    name="code"
                    placeholder="Contoh: KV-K3-2026-001234"
                    class="w-full border p-3 rounded text-center text-lg"
                >

                <button class="w-full bg-[#00A8A8] text-white py-3 rounded">
                    🔍 Verifikasi Sertifikat
                </button>

            </form>


            <!-- DEMO -->
            <div class="mt-8 bg-[#F5F7FA] p-4 rounded">
                <p class="text-sm font-medium mb-2">
                    Demo:
                </p>

                <button class="block w-full text-left bg-white p-2 rounded border text-sm">
                    KV-K3-2026-001234 - Budi
                </button>
            </div>

        </div>


        <!-- RESULT (STATIC DEMO) -->
        <div class="mt-8 space-y-6">

            <!-- VALID -->
            <div class="border-2 border-green-500 bg-green-50 p-8 rounded-xl text-center">
                <div class="text-5xl mb-4">✅</div>

                <h2 class="text-3xl font-bold text-green-700">
                    Sertifikat Valid
                </h2>

                <p class="text-gray-600 mt-2">
                    Sertifikat terdaftar resmi
                </p>
            </div>


            <!-- DETAIL -->
            <div class="bg-white p-8 rounded-xl shadow">

                <div class="flex justify-between mb-6">
                    <h3 class="text-xl font-semibold text-[#0A2540]">
                        Detail Sertifikat
                    </h3>

                    <span class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                        Terverifikasi
                    </span>
                </div>


                <div class="grid md:grid-cols-2 gap-8">

                    <!-- LEFT -->
                    <div class="space-y-4">

                        <div>
                            <div class="text-sm text-gray-500">Kode</div>
                            <div class="font-bold">KV-K3-2026-001234</div>
                        </div>

                        <hr>

                        <div>
                            <div class="text-sm text-gray-500">Peserta</div>
                            <div class="font-bold">Budi Santoso</div>
                        </div>

                        <hr>

                        <div>
                            <div class="text-sm text-gray-500">Pelatihan</div>
                            <div>K3 Umum</div>
                        </div>

                        <hr>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-sm text-gray-500">Selesai</div>
                                <div>12 Jan 2026</div>
                            </div>
                            <div>
                                <div class="text-sm text-gray-500">Terbit</div>
                                <div>15 Jan 2026</div>
                            </div>
                        </div>

                    </div>


                    <!-- QR -->
                    <div class="flex flex-col items-center justify-center">

                        <div class="bg-white border-2 p-4 rounded shadow">
                            <!-- fake QR -->
                            <div class="w-48 h-48 bg-gray-200 flex items-center justify-center">
                                QR
                            </div>
                        </div>

                        <p class="text-sm text-gray-500 mt-4">
                            QR Code Sertifikat
                        </p>

                    </div>

                </div>


                <div class="mt-8 bg-[#F5F7FA] p-4 rounded text-sm">
                    Sertifikat ini memiliki sistem verifikasi digital.
                </div>

            </div>


            <!-- ACTION -->
            <div class="flex gap-3">
                <a href="#" class="flex-1 bg-[#00A8A8] text-white py-2 rounded text-center">
                    Verifikasi Lagi
                </a>

                <a href="/" class="border px-4 py-2 rounded">
                    Beranda
                </a>
            </div>

        </div>


        <!-- HELP -->
        <div class="mt-8 bg-gradient-to-br from-[#0A2540] to-[#00A8A8] text-white p-6 rounded-xl">
            <h3 class="font-semibold mb-2">Butuh Bantuan?</h3>
            <p class="text-sm mb-4">
                Hubungi tim kami
            </p>

            <div class="flex gap-3">
                <a href="#" class="bg-white text-black px-4 py-2 rounded">
                    WhatsApp
                </a>
                <a href="#" class="border px-4 py-2 rounded">
                    Email
                </a>
            </div>
        </div>

    </div>

</div>

@endsection