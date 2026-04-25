@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#0A2540] to-[#00A8A8] text-white py-12">
        <div class="max-w-7xl mx-auto px-6">

            <a href="/" class="inline-flex items-center gap-2 mb-4 hover:bg-white/10 px-3 py-2 rounded">
                ← Kembali
            </a>

            <div class="flex items-center gap-3 mb-4">
                <div class="text-3xl">📋</div>
                <h1 class="text-4xl font-bold">Audit K3</h1>
            </div>

            <p class="text-gray-200 max-w-2xl">
                Layanan audit K3 profesional untuk memastikan kesesuaian implementasi sistem K3 di perusahaan Anda
            </p>
        </div>
    </div>


    <div class="max-w-5xl mx-auto px-6 py-8">

        <!-- ALERT -->
        <div class="mb-8 border border-orange-300 bg-orange-50 text-sm p-4 rounded">
            <strong>Penting:</strong> Layanan audit hanya untuk perusahaan. 
            Gunakan <a href="/consultation" class="underline font-medium">Konsultasi K3</a> untuk individu.
        </div>


        <div class="grid lg:grid-cols-3 gap-8">

            <!-- FORM -->
            <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow">

                <h2 class="text-2xl font-semibold text-[#0A2540] mb-2">
                    Form Pengajuan Audit
                </h2>

                <p class="text-gray-600 mb-6">
                    Lengkapi informasi perusahaan dan kebutuhan audit Anda
                </p>


                <form class="space-y-6">

                    <!-- COMPANY -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#0A2540]">Informasi Perusahaan</h3>

                        <input type="text" placeholder="Nama Perusahaan *" class="w-full border p-2 rounded mb-3">

                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" placeholder="Bidang Industri" class="border p-2 rounded">
                            <input type="text" placeholder="Jumlah Karyawan" class="border p-2 rounded">
                        </div>

                        <textarea placeholder="Alamat Perusahaan" class="w-full border p-2 rounded mt-3"></textarea>
                    </div>


                    <hr>


                    <!-- PIC -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#0A2540]">Person In Charge (PIC)</h3>

                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" placeholder="Nama PIC *" class="border p-2 rounded">
                            <input type="text" placeholder="Jabatan" class="border p-2 rounded">
                        </div>

                        <div class="grid md:grid-cols-2 gap-4 mt-3">
                            <input type="email" placeholder="Email PIC *" class="border p-2 rounded">
                            <input type="text" placeholder="Nomor Telepon PIC *" class="border p-2 rounded">
                        </div>
                    </div>


                    <hr>


                    <!-- AUDIT -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#0A2540]">Detail Audit</h3>

                        <select class="w-full border p-2 rounded mb-3">
                            <option>Pilih Jenis Audit</option>
                            <option>Audit SMK3</option>
                            <option>ISO 45001</option>
                        </select>

                        <input type="text" placeholder="Sertifikasi Saat Ini" class="w-full border p-2 rounded mb-3">

                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" placeholder="Lokasi Audit *" class="border p-2 rounded">
                            <input type="date" class="border p-2 rounded">
                        </div>

                        <textarea placeholder="Tujuan Audit" class="w-full border p-2 rounded mt-3"></textarea>

                        <textarea placeholder="Deskripsi Kebutuhan Audit *" class="w-full border p-2 rounded mt-3 h-32"></textarea>
                    </div>


                    <hr>

                    <!-- BUTTON -->
                    <div class="flex gap-3">
                        <a href="/" class="border px-4 py-2 rounded">Batal</a>
                        <button class="flex-1 bg-[#FF7A00] text-white py-2 rounded">
                            Ajukan Audit
                        </button>
                    </div>

                </form>

            </div>


            <!-- SIDEBAR -->
            <div class="space-y-6">

                <!-- SERVICE -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#0A2540]">Layanan Audit Kami</h3>

                    <ul class="space-y-2 text-sm text-gray-600">
                        <li>✔ Auditor bersertifikat</li>
                        <li>✔ Laporan detail</li>
                        <li>✔ Rekomendasi perbaikan</li>
                        <li>✔ Follow-up audit</li>
                    </ul>
                </div>


                <!-- STANDAR -->
                <div class="bg-[#F5F7FA] p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#0A2540]">Standar Audit</h3>

                    <div class="flex gap-2 flex-wrap">
                        <span class="bg-[#0A2540] text-white px-2 py-1 rounded text-xs">ISO 45001</span>
                        <span class="bg-[#00A8A8] text-white px-2 py-1 rounded text-xs">PP 50/2012</span>
                        <span class="bg-[#FF7A00] text-white px-2 py-1 rounded text-xs">Permenaker</span>
                    </div>
                </div>


                <!-- PROCESS -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#0A2540]">Alur Proses</h3>

                    <ol class="space-y-3 text-sm">
                        <li>1. Pengajuan</li>
                        <li>2. Review</li>
                        <li>3. Persiapan</li>
                        <li>4. Audit</li>
                        <li>5. Laporan</li>
                    </ol>
                </div>


                <!-- CTA -->
                <div class="bg-gradient-to-br from-[#0A2540] to-[#00A8A8] text-white p-6 rounded-xl">
                    <h3 class="font-semibold mb-2">Butuh Konsultasi?</h3>
                    <p class="text-sm mb-4">Hubungi tim kami</p>

                    <a href="#" class="bg-white text-black px-4 py-2 rounded block text-center">
                        Hubungi Kami
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection