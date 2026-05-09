@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA] py-10">
    <div class="max-w-3xl mx-auto px-6">

        {{-- ── HEADER ──────────────────────────────────────────────── --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm mb-8 border border-gray-100">
            <a href="{{ route('training.list') }}"
               class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#7d2ae7] mb-4 transition">
                ← Kembali ke Daftar Pelatihan
            </a>
            <h1 class="text-2xl font-bold text-[#7d2ae7]">Form Request Pelatihan Perusahaan</h1>
            <p class="text-gray-500 mt-1 text-sm">Silakan isi formulir di bawah ini untuk mengajukan permintaan pelatihan khusus bagi instansi/perusahaan Anda.</p>
        </div>

        {{-- ── ALERT ERRORS ─────────────────────────────────────────── --}}
        @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-5 py-4 mb-6">
            <p class="font-semibold mb-1">Terdapat kesalahan pada form:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ── FORM ────────────────────────────────────────────────── --}}
        <form method="POST" action="{{ route('request.training.store') }}" id="form-request-pelatihan">
            @csrf

            {{-- ── STEP 1 · Data PIC & Perusahaan ────────────────────── --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-semibold text-[#7d2ae7] mb-5">1. Data PIC & Perusahaan</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Lengkap PIC <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_lengkap" required
                               value="{{ old('nama_lengkap') }}"
                               placeholder="Masukkan nama penanggung jawab"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" required
                                   value="{{ old('email') }}"
                                   placeholder="Email aktif perusahaan/PIC"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nomor HP / WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="no_telp" required
                                   value="{{ old('no_telp') }}"
                                   placeholder="Contoh: 08123456789"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_perusahaan" required
                               value="{{ old('nama_perusahaan') }}"
                               placeholder="PT / CV / Instansi"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan PIC (Opsional)</label>
                        <input type="text" name="jabatan"
                               value="{{ old('jabatan') }}"
                               placeholder="Contoh: HRD Manager, Training Officer"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat_perusahaan" rows="2" required
                                  placeholder="Alamat lengkap kantor / perusahaan"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition resize-none">{{ old('alamat_perusahaan') }}</textarea>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sektor Industri (Opsional)</label>
                            <input type="text" name="sektor_industri"
                                   value="{{ old('sektor_industri') }}"
                                   placeholder="Contoh: Manufaktur, Jasa, dll."
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Karyawan (Opsional)</label>
                            <input type="number" name="jumlah_karyawan" min="1"
                                   value="{{ old('jumlah_karyawan') }}"
                                   placeholder="Contoh: 50"
                                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── STEP 2 · Detail Request Pelatihan ────────────────── --}}
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-6">
                <h2 class="text-lg font-semibold text-[#7d2ae7] mb-5">2. Detail Request Pelatihan</h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Topik Pelatihan yang Diinginkan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="topik_pelatihan" required
                               value="{{ old('topik_pelatihan') }}"
                               placeholder="Contoh: Ahli K3 Umum, K3 Ketinggian, dll."
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Tanggal Pelaksanaan (Opsional)</label>
                        <input type="date" name="tanggal_harapan"
                               value="{{ old('tanggal_harapan') }}"
                               class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pesan / Persyaratan Tambahan (Opsional)</label>
                        <textarea name="pesan_tambahan" rows="4"
                                  placeholder="Sebutkan kebutuhan khusus, lokasi pelatihan, atau pertanyaan lainnya..."
                                  class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition resize-none">{{ old('pesan_tambahan') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- ── TOMBOL SUBMIT ───────────────────────────────────── --}}
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('training.list') }}"
                   class="text-sm text-gray-500 hover:text-[#7d2ae7] transition">
                    ← Batalkan
                </a>
                <button type="submit"
                        class="bg-[#7d2ae7] hover:bg-[#008f8f] text-white font-semibold px-8 py-3 rounded-xl transition-all shadow-sm hover:shadow-md active:scale-95">
                    Kirim Permintaan →
                </button>
            </div>

        </form>

    </div>
</div>

@endsection
