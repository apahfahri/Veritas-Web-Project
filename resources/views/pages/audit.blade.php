@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="bg-gradient-to-r from-[#7d2ae7] via-[#3969e7] to-[#07b9ce] text-white py-12">
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

                <h2 class="text-2xl font-semibold text-[#7d2ae7] mb-2">
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

                <form method="POST" action="{{ route('pendaftaran.store') }}" class="space-y-6">
                    @csrf
                    @php 
                        $kategoriAudit = \App\Models\KategoriLayanan::where('nama', 'like', '%Audit%')->first();
                        $layananAudit = \App\Models\Layanan::where('id_kategori', $kategoriAudit?->id_kategori)->first(); 
                        
                        // Fallback id if seeder not run completely
                        $layananId = $layananAudit ? $layananAudit->id_layanan : 1;
                    @endphp
                    
                    <input type="hidden" name="layanan_id" value="{{ $layananId }}">
                    <input type="hidden" name="jenis_klien" value="perusahaan">

                    <!-- COMPANY -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#7d2ae7]">Informasi Perusahaan</h3>

                        <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" placeholder="Nama Perusahaan *" class="w-full border p-2 rounded mb-3 focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]" required>

                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" name="sektor_industri" value="{{ old('sektor_industri') }}" placeholder="Bidang Industri" class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                            <input type="number" name="jumlah_karyawan" value="{{ old('jumlah_karyawan') }}" placeholder="Jumlah Karyawan" class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                        </div>

                        <textarea name="alamat_perusahaan" placeholder="Alamat Perusahaan *" class="w-full border p-2 rounded mt-3 focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]" required>{{ old('alamat_perusahaan') }}</textarea>
                    </div>


                    <hr>


                    <!-- PIC -->
                    <div>
                        <h3 class="font-semibold text-lg mb-4 text-[#7d2ae7]">Person In Charge (PIC)</h3>

                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama PIC *" class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]" required>
                            <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Jabatan" class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                        </div>

                        <div class="grid md:grid-cols-2 gap-4 mt-3">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email PIC *" class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]" required>
                            <input type="text" name="no_telp" value="{{ old('no_telp') }}" placeholder="Nomor HP / WhatsApp *" class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]" required>
                        </div>
                        
                        <input type="text" name="pendidikan" value="{{ old('pendidikan') }}" placeholder="Pendidikan Terakhir (Opsional)" class="w-full border p-2 rounded mt-3 focus:outline-none focus:ring-2 focus:ring-[#7d2ae7]">
                    </div>

                    <hr>

                    <!-- BUTTON -->
                    <div class="flex gap-3 mt-6">
                        <a href="/" class="border px-4 py-2 rounded flex items-center justify-center hover:bg-gray-50">Batal</a>
                        <button type="submit" class="flex-1 bg-[#7d2ae7] text-white py-2 rounded hover:opacity-90 font-semibold shadow-sm">
                            Ajukan Audit Sekarang
                        </button>
                    </div>

                </form>

            </div>


            <!-- SIDEBAR -->
            <div class="space-y-6">

                <!-- SERVICE -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#7d2ae7]">Layanan Audit Kami</h3>

                    <ul class="space-y-2 text-sm text-gray-600">
                        <li>✔ Auditor bersertifikat</li>
                        <li>✔ Laporan detail</li>
                        <li>✔ Rekomendasi perbaikan</li>
                        <li>✔ Follow-up audit</li>
                    </ul>
                </div>


                <!-- STANDAR -->
                <div class="bg-[#F5F7FA] p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#7d2ae7]">Standar Audit</h3>

                    <div class="flex gap-2 flex-wrap">
                        <span class="bg-[#7d2ae7] text-white px-2 py-1 rounded text-xs">ISO 45001</span>
                        <span class="bg-[#7d2ae7] text-white px-2 py-1 rounded text-xs">PP 50/2012</span>
                        <span class="bg-[#7d2ae7] text-white px-2 py-1 rounded text-xs">Permenaker</span>
                    </div>
                </div>


                <!-- PROCESS -->
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="font-semibold mb-4 text-[#7d2ae7]">Alur Proses</h3>

                    <ol class="space-y-3 text-sm">
                        <li>1. Pengajuan</li>
                        <li>2. Review</li>
                        <li>3. Persiapan</li>
                        <li>4. Audit</li>
                        <li>5. Laporan</li>
                    </ol>
                </div>


                <!-- CTA -->
                <div class="bg-gradient-to-br from-[#7d2ae7] via-[#3969e7] to-[#07b9ce] text-white p-6 rounded-xl">
                    <h3 class="font-semibold mb-2">Butuh Konsultasi?</h3>
                    <p class="text-sm mb-4">Hubungi tim kami</p>

                    <a href="/consultation" class="bg-white text-black px-4 py-2 rounded block text-center hover:bg-gray-100 transition">
                        Hubungi Kami
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection