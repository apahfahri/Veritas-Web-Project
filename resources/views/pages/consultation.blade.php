@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#0A2540] to-[#00A8A8] text-white py-12">
        <div class="max-w-5xl mx-auto px-6">

            <a href="/" class="inline-flex items-center gap-2 mb-4 hover:bg-white/10 px-3 py-2 rounded">
                ← Kembali
            </a>

            <h1 class="text-4xl font-bold mb-4">Konsultasi K3</h1>

            <p class="text-gray-200 max-w-2xl">
                Dapatkan solusi terbaik untuk kebutuhan K3 perusahaan atau individu Anda
            </p>

        </div>
    </div>


    <div class="max-w-5xl mx-auto px-6 py-8">

        <div class="grid lg:grid-cols-3 gap-8">

            <!-- FORM -->
            <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow">

                <h2 class="text-2xl font-semibold text-[#0A2540] mb-2">
                    Form Pengajuan Konsultasi
                </h2>

                <p class="text-gray-600 mb-6">
                    Lengkapi form di bawah ini
                </p>

                <form class="space-y-6">

                    <!-- USER TYPE -->
                    <div>
                        <label class="font-medium">Jenis Pendaftar *</label>

                        <div class="grid grid-cols-2 gap-4 mt-2">

                            <label class="border-2 rounded-lg p-4 cursor-pointer hover:border-[#00A8A8]">
                                <input type="radio" name="userType" value="individu" checked class="mb-2">
                                <div class="font-medium">Individu</div>
                                <div class="text-xs text-gray-500">Perorangan</div>
                            </label>

                            <label class="border-2 rounded-lg p-4 cursor-pointer hover:border-[#00A8A8]">
                                <input type="radio" name="userType" value="perusahaan" class="mb-2">
                                <div class="font-medium">Perusahaan</div>
                                <div class="text-xs text-gray-500">Organisasi</div>
                            </label>

                        </div>
                    </div>

                    <hr>


                    <!-- PERSONAL -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Nama Lengkap" class="border p-2 rounded">
                        <input type="email" placeholder="Email" class="border p-2 rounded">
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <input type="text" placeholder="Nomor Telepon" class="border p-2 rounded">
                        <input type="text" placeholder="Nama Perusahaan" class="border p-2 rounded">
                    </div>

                    <hr>


                    <!-- TYPE -->
                    <div>
                        <label class="font-medium">Jenis Konsultasi *</label>

                        <select class="w-full border p-2 rounded mt-2">
                            <option>Pilih jenis konsultasi</option>
                            <option>Implementasi SMK3</option>
                            <option>Audit K3</option>
                            <option>ISO 45001</option>
                            <option>Lainnya</option>
                        </select>
                    </div>


                    <!-- DATE -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <input type="date" class="border p-2 rounded">
                        <input type="time" class="border p-2 rounded">
                    </div>


                    <!-- MODE -->
                    <div>
                        <label class="font-medium">Mode Konsultasi *</label>

                        <div class="grid grid-cols-2 gap-4 mt-2">

                            <label class="border-2 rounded-lg p-4 cursor-pointer hover:border-[#00A8A8]">
                                <input type="radio" name="mode" checked class="mb-2">
                                <div class="font-medium">Online</div>
                                <div class="text-xs text-gray-500">Zoom / Meet</div>
                            </label>

                            <label class="border-2 rounded-lg p-4 cursor-pointer hover:border-[#00A8A8]">
                                <input type="radio" name="mode" class="mb-2">
                                <div class="font-medium">Offline</div>
                                <div class="text-xs text-gray-500">Tatap muka</div>
                            </label>

                        </div>
                    </div>


                    <!-- LOCATION -->
                    <input type="text" placeholder="Lokasi konsultasi" class="border p-2 rounded">


                    <!-- DESC -->
                    <textarea placeholder="Deskripsi kebutuhan..." class="border p-2 rounded w-full h-32"></textarea>


                    <!-- BUTTON -->
                    <div class="flex gap-3">
                        <a href="/" class="border px-4 py-2 rounded">Batal</a>
                        <button class="flex-1 bg-[#00A8A8] text-white py-2 rounded">
                            Ajukan Konsultasi
                        </button>
                    </div>

                </form>

            </div>


            <!-- SIDEBAR -->
            <div class="space-y-6">

                <!-- INFO -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#0A2540]">
                        Tentang Konsultasi
                    </h3>

                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>✔ Konsultan berpengalaman</li>
                        <li>✔ Solusi sesuai kebutuhan</li>
                        <li>✔ Dokumentasi lengkap</li>
                        <li>✔ Untuk individu & perusahaan</li>
                    </ul>
                </div>


                <!-- PROCESS -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#0A2540]">
                        Alur Proses
                    </h3>

                    <ol class="text-sm space-y-2">
                        <li>1. Submit Form</li>
                        <li>2. Review</li>
                        <li>3. Assign Expert</li>
                        <li>4. Konsultasi</li>
                    </ol>
                </div>


                <!-- CTA -->
                <div class="bg-gradient-to-br from-[#0A2540] to-[#00A8A8] text-white p-6 rounded-xl">
                    <h3 class="font-semibold mb-2">Butuh Bantuan?</h3>

                    <a href="#" class="bg-white text-black px-4 py-2 rounded block text-center">
                        WhatsApp Kami
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection