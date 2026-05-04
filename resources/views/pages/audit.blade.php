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

        @php
            $isIndividuOnly = false;
            if(Auth::check()) {
                $user = Auth::user();
                $isIndividuOnly = $user->klienIndividu && !$user->klienPerusahaan;
            }
        @endphp

        @if($isIndividuOnly)
            <div class="bg-red-50 border border-red-300 text-red-700 p-12 rounded-xl text-center shadow-sm max-w-3xl mx-auto mt-10">
                <div class="text-6xl mb-6">⚠️</div>
                <h3 class="text-2xl font-bold mb-3">Akses Ditolak</h3>
                <p class="text-xl">Layanan audit hanya tersedia untuk perusahaan.</p>
                <p class="mt-6 text-base text-red-600">
                    Akun Anda saat ini terdaftar sebagai pendaftar individu. Silakan gunakan layanan 
                    <a href="/consultation" class="font-bold underline hover:text-red-800">Konsultasi K3</a>.
                </p>
                <div class="mt-8">
                    <a href="/" class="inline-block bg-[#0A2540] text-white px-6 py-3 rounded-lg hover:bg-opacity-90 transition">Kembali ke Beranda</a>
                </div>
            </div>
        @else

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

                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-300 text-green-700 p-4 rounded-lg">✅ {{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-300 text-red-700 p-4 rounded-lg">
                        <ul class="list-disc ml-5 text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @auth
                @php
                    $user = Auth::user();
                    $profilPerusahaan = $user->klienPerusahaan;
                    $perusahaan = $profilPerusahaan ? $profilPerusahaan->perusahaan : null;
                @endphp
                <form method="POST" action="{{ route('pendaftaran.store') }}" class="space-y-6">
                    @csrf
                    @php $layananAudit = \App\Models\Layanan::where('nama', 'like', '%Audit%')->first(); @endphp
                    <input type="hidden" name="layanan_id" value="{{ $layananAudit?->id }}">
                    <input type="hidden" name="jenis_klien" value="perusahaan">

                    <!-- COMPANY -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#0A2540]">Informasi Perusahaan</h3>

                        <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $perusahaan->nama ?? '') }}" placeholder="Nama Perusahaan *" class="w-full border p-2 rounded mb-3" required>

                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" name="sektor_industri" value="{{ old('sektor_industri', $perusahaan->sektor_industri ?? '') }}" placeholder="Bidang Industri" class="border p-2 rounded">
                            <input type="number" name="jumlah_karyawan" value="{{ old('jumlah_karyawan', $perusahaan->jumlah_karyawan ?? '') }}" placeholder="Jumlah Karyawan" class="border p-2 rounded">
                        </div>

                        <textarea name="alamat_perusahaan" placeholder="Alamat Perusahaan *" class="w-full border p-2 rounded mt-3" required>{{ old('alamat_perusahaan', $perusahaan->alamat ?? '') }}</textarea>
                    </div>


                    <hr>


                    <!-- PIC -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#0A2540]">Person In Charge (PIC)</h3>

                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profilPerusahaan->nama_lengkap ?? Auth::user()->name) }}" placeholder="Nama PIC *" class="border p-2 rounded" required>
                            <input type="text" name="jabatan" value="{{ old('jabatan', $profilPerusahaan->jabatan ?? '') }}" placeholder="Jabatan" class="border p-2 rounded">
                        </div>

                        <div class="grid md:grid-cols-2 gap-4 mt-3">
                            <input type="email" value="{{ Auth::user()->email }}" placeholder="Email PIC *" class="border p-2 rounded bg-gray-50" readonly>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Nomor Telepon PIC" class="border p-2 rounded">
                        </div>
                    </div>


                    <hr>


                    <!-- AUDIT -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#0A2540]">Detail Audit</h3>

                        <select name="jenis_audit" class="w-full border p-2 rounded mb-3">
                            <option value="">Pilih Jenis Audit</option>
                            <option value="Audit SMK3">Audit SMK3</option>
                            <option value="ISO 45001">ISO 45001</option>
                        </select>

                        <input type="text" name="sertifikasi_saat_ini" placeholder="Sertifikasi Saat Ini" class="w-full border p-2 rounded mb-3">

                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" name="lokasi_audit" placeholder="Lokasi Audit *" class="border p-2 rounded">
                            <input type="date" name="tanggal_daftar" value="{{ old('tanggal_daftar') }}" min="{{ date('Y-m-d') }}" class="border p-2 rounded" required>
                        </div>

                        <textarea name="tujuan_audit" placeholder="Tujuan Audit" class="w-full border p-2 rounded mt-3"></textarea>

                        <textarea name="deskripsi_audit" placeholder="Deskripsi Kebutuhan Audit *" class="w-full border p-2 rounded mt-3 h-32"></textarea>
                    </div>


                    <hr>

                    <!-- BUTTON -->
                    <div class="flex gap-3">
                        <a href="/" class="border px-4 py-2 rounded flex items-center justify-center">Batal</a>
                        <button type="submit" class="flex-1 bg-[#FF7A00] text-white py-2 rounded hover:opacity-90">
                            Ajukan Audit
                        </button>
                    </div>

                </form>
                @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-4">🔒</div>
                    <p class="text-gray-600 mb-4">Silakan login terlebih dahulu untuk mengajukan audit</p>
                    <a href="{{ route('login') }}" class="bg-[#FF7A00] text-white px-6 py-2 rounded hover:opacity-90 transition">Login Sekarang</a>
                </div>
                @endauth

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

                    <a href="/consultation" class="bg-white text-black px-4 py-2 rounded block text-center">
                        Hubungi Kami
                    </a>
                </div>

            </div>

        </div>
        @endif

    </div>

</div>

@endsection