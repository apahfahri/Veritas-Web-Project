@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA] py-8">

    <div class="max-w-4xl mx-auto px-6">

        <!-- HEADER -->
        <div class="bg-white p-6 rounded-xl shadow mb-8">

            <a href="/training" class="inline-block mb-4 text-sm text-gray-600 hover:underline">
                ← Kembali
            </a>

            <h1 class="text-2xl font-bold text-[#0A2540]">
                Pendaftaran Pelatihan
            </h1>

            <p class="text-gray-600">Nama Pelatihan (dummy)</p>

            <!-- PROGRESS -->
            <div class="mt-6">
                <div class="flex justify-between text-sm mb-2">
                    <span>Langkah 1 dari 5</span>
                    <span class="text-[#00A8A8]">20%</span>
                </div>

                <div class="w-full bg-gray-200 h-2 rounded">
                    <div class="bg-[#00A8A8] h-2 rounded w-[20%]"></div>
                </div>
            </div>

        </div>


        <!-- STEP 1 -->
        <div class="bg-white p-8 rounded-xl shadow space-y-6">

            <h2 class="text-2xl font-semibold text-[#0A2540]">
                Pilih Jenis Pendaftaran
            </h2>

            <div class="grid md:grid-cols-2 gap-4">

                <label class="border-2 p-6 rounded-lg cursor-pointer hover:border-[#00A8A8]">
                    <input type="radio" name="type" checked class="mb-2">
                    <div class="font-semibold text-lg">Individu</div>
                    <p class="text-sm text-gray-600">
                        Pendaftaran perorangan
                    </p>
                </label>

                <label class="border-2 p-6 rounded-lg cursor-pointer hover:border-[#00A8A8]">
                    <input type="radio" name="type" class="mb-2">
                    <div class="font-semibold text-lg">Perusahaan</div>
                    <p class="text-sm text-gray-600">
                        Multiple peserta
                    </p>
                </label>

            </div>

            <div class="flex justify-end">
                <button class="bg-[#00A8A8] text-white px-6 py-2 rounded">
                    Lanjutkan →
                </button>
            </div>

        </div>


        <!-- STEP 2 (STATIC DISPLAY) -->
        <div class="bg-white p-8 rounded-xl shadow mt-8 space-y-6">

            <h2 class="text-2xl font-semibold text-[#0A2540]">
                Data Peserta
            </h2>

            <input type="text" placeholder="Nama Lengkap" class="border p-2 rounded w-full">
            <input type="email" placeholder="Email" class="border p-2 rounded w-full">
            <input type="text" placeholder="Nomor Telepon" class="border p-2 rounded w-full">

            <input type="text" placeholder="Nama Perusahaan" class="border p-2 rounded w-full">
            <input type="number" placeholder="Jumlah Peserta" class="border p-2 rounded w-full">

        </div>


        <!-- STEP 3 -->
        <div class="bg-white p-8 rounded-xl shadow mt-8 space-y-6">

            <h2 class="text-2xl font-semibold text-[#0A2540]">
                Pilih Jadwal
            </h2>

            <label class="block border-2 p-4 rounded hover:border-[#00A8A8] cursor-pointer">
                <input type="radio" name="schedule" class="mr-2">
                12 Januari 2026 - Jakarta (10 kursi)
            </label>

            <label class="block border-2 p-4 rounded hover:border-[#00A8A8] cursor-pointer">
                <input type="radio" name="schedule" class="mr-2">
                20 Januari 2026 - Bandung (5 kursi)
            </label>

        </div>


        <!-- STEP 4 -->
        <div class="bg-white p-8 rounded-xl shadow mt-8 space-y-6">

            <h2 class="text-2xl font-semibold text-[#0A2540]">
                Pembayaran
            </h2>

            <!-- SUMMARY -->
            <div class="bg-[#F5F7FA] p-6 rounded">
                <div class="flex justify-between">
                    <span>Harga</span>
                    <span>Rp 2.000.000</span>
                </div>

                <div class="flex justify-between font-bold mt-2">
                    <span>Total</span>
                    <span>Rp 2.000.000</span>
                </div>
            </div>

            <!-- BANK -->
            <div class="border-2 border-[#00A8A8] p-6 rounded">
                <p class="font-semibold">Bank Mandiri</p>
                <p>1234567890</p>
                <p>PT Katiga Veritas</p>
            </div>

            <!-- UPLOAD -->
            <div class="border-2 border-dashed h-32 flex items-center justify-center rounded">
                Upload Bukti Pembayaran
            </div>

        </div>


        <!-- STEP 5 -->
        <div class="bg-white p-8 rounded-xl shadow mt-8 text-center">

            <div class="text-5xl mb-4">✅</div>

            <h2 class="text-2xl font-bold text-[#0A2540]">
                Pendaftaran Berhasil!
            </h2>

            <p class="text-gray-600 mt-2">
                Menunggu verifikasi admin
            </p>

        </div>

    </div>

</div>

@endsection