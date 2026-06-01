@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#F5F7FA]">

    <!-- HEADER -->
    <div class="relative overflow-hidden bg-gradient-to-r from-[#1E6B3D] via-[#24824A] to-[#3CDA7D] text-white py-12 shadow-sm">
        <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -left-10 -bottom-10 w-72 h-72 bg-[#3CDA7D]/20 rounded-full blur-3xl"></div>
        
        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex items-center gap-4 mb-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 backdrop-blur-md border border-white/20 text-white shadow-inner text-2xl">
                    <i class="fi fi-rr-clipboard-list"></i>
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Audit K3 Veritas</h1>
            </div>
            <p class="text-base md:text-lg text-emerald-50 max-w-2xl font-light">Layanan audit K3 profesional untuk memastikan kesesuaian implementasi sistem K3 di perusahaan Anda.</p>
        </div>
    </div>


    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- ALERT -->
        <!-- <div class="mb-8 border border-amber-200 bg-amber-50/60 backdrop-blur-sm text-xs md:text-sm p-4 rounded-xl flex items-center gap-3 text-amber-800 shadow-sm">
            <i class="fi fi-rr-warning text-amber-600 text-lg shrink-0 mt-0.5"></i>
            <div>
                <strong class="font-bold">Penting:</strong> Layanan audit hanya ditujukan untuk entitas perusahaan. 
                Untuk perorangan/individu, silakan gunakan layanan <a href="/consultation" class="underline font-bold text-amber-900 hover:text-amber-950 transition">Konsultasi K3</a>.
            </div>
        </div> -->


        <div class="grid lg:grid-cols-3 gap-8">

            <!-- FORM -->
            <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-2xl border border-slate-100 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.03)]">

                <h2 class="text-2xl font-semibold text-[#1E6B3D] mb-2">
                    Form Pengajuan Audit
                </h2>

                <p class="text-gray-600 mb-6 text-sm">
                    Lengkapi informasi perusahaan dan kebutuhan audit Anda
                </p>

                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-300 text-green-700 p-4 rounded-lg flex items-center gap-2">
                        <i class="fi fi-rr-check-circle text-green-500 text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
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
                    @endphp
                    
                    <input type="hidden" name="kategori_id" value="{{ $kategoriAudit?->id_kategori }}">
                    <input type="hidden" name="jenis_klien" value="perusahaan">

                    <!-- COMPANY -->
                    <div>
                        <h3 class="font-bold text-base mb-3 text-[#1E6B3D]">Informasi Perusahaan</h3>

                        <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" placeholder="Nama Perusahaan *" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400 mb-4" required>

                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <input type="text" name="sektor_industri" value="{{ old('sektor_industri') }}" placeholder="Bidang Industri" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400">
                            <input type="number" name="jumlah_karyawan" value="{{ old('jumlah_karyawan') }}" placeholder="Jumlah Karyawan" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400">
                        </div>

                        <textarea name="alamat_perusahaan" placeholder="Alamat Perusahaan *" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400 resize-none" rows="2" required>{{ old('alamat_perusahaan') }}</textarea>
                    </div>

                    <!-- PIC -->
                    <div>
                        <h3 class="font-bold text-base mb-3 text-[#1E6B3D]">Person In Charge (PIC)</h3>

                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama PIC *" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400" required>
                            <input type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Jabatan" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400">
                        </div>

                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email PIC *" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400" required>
                            <input type="text" name="no_telp" value="{{ old('no_telp') }}" placeholder="Nomor HP / WhatsApp *" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400" required>
                        </div>
                        
                        <input type="text" name="pendidikan" value="{{ old('pendidikan') }}" placeholder="Pendidikan Terakhir *" class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400" required>
                    </div>

                    <hr class="border-slate-100">
                    
                    <!-- JADWAL & MODE -->
                    <div>
                        <h3 class="font-bold text-base mb-3 text-[#1E6B3D]">Rencana Jadwal & Mode Audit</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Tanggal Usulan *</label>
                                <input type="date" name="tanggal_usul" required
                                       value="{{ old('tanggal_usul') }}"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all text-slate-700">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Mode Audit *</label>
                                <select name="mode_pertemuan" id="mode_pertemuan" required
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all text-slate-700 cursor-pointer"
                                        onchange="toggleLokasi(this.value)">
                                    <option value="offline" {{ old('mode_pertemuan') === 'offline' ? 'selected' : '' }}>On-Site (Langsung di Lokasi)</option>
                                    <option value="online" {{ old('mode_pertemuan') === 'online' ? 'selected' : '' }}>Remote Audit (Online)</option>
                                </select>
                            </div>
                            
                            <div id="lokasi-box" class="{{ old('mode_pertemuan', 'offline') === 'offline' ? '' : 'hidden' }}">
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Lokasi Pelaksanaan Audit *</label>
                                <textarea name="lokasi" id="lokasi" rows="2"
                                          placeholder="Tuliskan lokasi perusahaan untuk audit..."
                                          class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400 resize-none">{{ old('lokasi') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">
                    <div class="flex items-center gap-4 mt-8 pt-4 border-t border-slate-100">
                        <a href="/" class="border border-slate-200 px-6 py-3 rounded-xl flex items-center justify-center font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition active:scale-[0.98]">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 bg-[#1E6B3D] text-white py-3 px-6 rounded-xl hover:bg-[#24824A] font-bold transition-all shadow-[0_4px_12px_-3px_rgba(30,107,61,0.2)] hover:shadow-[0_6px_20px_-3px_rgba(30,107,61,0.3)] active:scale-[0.98]">
                            Ajukan Audit Sekarang
                        </button>
                    </div>

                </form>

            </div>


            <!-- SIDEBAR -->
            <div class="space-y-6">

                <!-- SERVICE -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.03)]">
                    <h3 class="font-bold text-slate-800 mb-4 text-base">Layanan Audit Kami</h3>
                    <ul class="space-y-3.5 text-xs text-slate-600">
                        <li class="flex items-start gap-2.5">
                            <span class="text-emerald-500 font-bold shrink-0 flex items-center"><i class="fi fi-rr-check"></i></span>
                            <span>Auditor bersertifikat & teregistrasi resmi.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-emerald-500 font-bold shrink-0 flex items-center"><i class="fi fi-rr-check"></i></span>
                            <span>Laporan komprehensif & terperinci.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-emerald-500 font-bold shrink-0 flex items-center"><i class="fi fi-rr-check"></i></span>
                            <span>Rekomendasi perbaikan (Corrective Action) aplikatif.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="text-emerald-500 font-bold shrink-0 flex items-center"><i class="fi fi-rr-check"></i></span>
                            <span>Layanan pendampingan & follow-up audit pasca penilaian.</span>
                        </li>
                    </ul>
                </div>

                <!-- STANDAR -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.03)]">
                    <h3 class="font-bold text-slate-800 mb-4 text-base">Standar Acuan Audit</h3>
                    <div class="flex gap-2 flex-wrap">
                        <span class="bg-[#1E6B3D]/10 text-[#1E6B3D] text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-lg">ISO 45001</span>
                        <span class="bg-[#1E6B3D]/10 text-[#1E6B3D] text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-lg">PP 50/2012</span>
                        <span class="bg-[#1E6B3D]/10 text-[#1E6B3D] text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-lg">Permenaker</span>
                    </div>
                </div>

                <!-- PROCESS (TIMELINE) -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.03)]">
                    <h3 class="font-bold text-slate-800 mb-5 text-base">Alur Proses Audit</h3>
                    <ol class="space-y-6 text-xs text-slate-700 relative border-l-2 border-slate-100 ml-3 pl-5">
                        <li class="relative">
                            <span class="absolute -left-[27px] top-0.5 bg-[#1E6B3D] text-white flex items-center justify-center w-3 h-3 rounded-full border border-white shadow-sm ring-4 ring-emerald-500/10"></span>
                            <strong class="text-slate-800 font-semibold block mb-0.5">1. Pengajuan & Registrasi</strong>
                            <span class="text-slate-500">Lengkapi data kebutuhan audit dan perusahaan Anda.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[27px] top-0.5 bg-[#1E6B3D] text-white flex items-center justify-center w-3 h-3 rounded-full border border-white shadow-sm ring-4 ring-emerald-500/10"></span>
                            <strong class="text-slate-800 font-semibold block mb-0.5">2. Tinjauan & Penawaran</strong>
                            <span class="text-slate-500">Tim kami akan mengkaji data untuk merumuskan penawaran resmi.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[27px] top-0.5 bg-[#1E6B3D] text-white flex items-center justify-center w-3 h-3 rounded-full border border-white shadow-sm ring-4 ring-emerald-500/10"></span>
                            <strong class="text-slate-800 font-semibold block mb-0.5">3. Persiapan & Audit</strong>
                            <span class="text-slate-500">Penyusunan rencana audit (audit plan) dan pelaksanaan penilaian lapangan.</span>
                        </li>
                        <li class="relative">
                            <span class="absolute -left-[27px] top-0.5 bg-[#1E6B3D] text-white flex items-center justify-center w-3 h-3 rounded-full border border-white shadow-sm ring-4 ring-emerald-500/10"></span>
                            <strong class="text-slate-800 font-semibold block mb-0.5">4. Penyusunan Laporan</strong>
                            <span class="text-slate-500">Penyerahan laporan akhir hasil temuan audit berserta rekomendasi.</span>
                        </li>
                    </ol>
                </div>

                <!-- CTA -->
                <div class="relative overflow-hidden bg-gradient-to-br from-[#1E6B3D] via-[#24824A] to-[#3CDA7D] text-white p-6 rounded-2xl shadow-[0_8px_30px_-6px_rgba(30,107,61,0.2)]">
                    <div class="absolute -right-10 -bottom-10 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                    <h3 class="font-bold text-base mb-2 relative z-10">Butuh Konsultasi Awal?</h3>
                    <p class="text-xs text-emerald-50 mb-5 relative z-10 leading-relaxed">Jika Anda ingin berkonsultasi mengenai persiapan sistem manajemen K3 terlebih dahulu sebelum diaudit, silakan hubungi tim kami.</p>
                    <a href="/consultation" class="relative z-10 w-full bg-white text-[#1E6B3D] font-bold px-4 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-slate-50 active:scale-[0.98] transition-all shadow-sm">
                        <i class="fi fi-rr-comment-alt text-[#1E6B3D]"></i> Konsultasi K3
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>

<script>
    window.toggleLokasi = function(val) {
        const box    = document.getElementById('lokasi-box');
        const lokasi = document.getElementById('lokasi');
        if (!box || !lokasi) return;

        if (val === 'offline') {
            box.classList.remove('hidden');
            lokasi.required = true;
        } else {
            box.classList.add('hidden');
            lokasi.required = false;
            lokasi.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modePertemuan = document.getElementById('mode_pertemuan');
        if (modePertemuan) {
            toggleLokasi(modePertemuan.value);
        }
    });
</script>

@endsection