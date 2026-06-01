@extends('layouts.app')

@section('title', 'Pendaftaran Konsultasi K3 — PT Katiga Veritas Indonesia')

@section('content')

@php
    $kategoriKonsultasi = \App\Models\KategoriLayanan::where('nama', 'like', '%Konsultasi%')->first();
    $jenisLayanan       = \App\Models\JenisLayanan::where('id_kategori', $kategoriKonsultasi?->id_kategori)->get();
@endphp

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-emerald-50/30 to-slate-100">

    {{-- ── HERO HEADER ─────────────────────────────────────────────────── --}}
    <div class="relative overflow-hidden bg-gradient-to-r from-[#14532d] via-[#1E6B3D] to-[#22c55e]/80 text-white py-14">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=60 height=60 viewBox=0 0 60 60 xmlns=http://www.w3.org/2000/svg%3E%3Cg fill=none fill-rule=evenodd%3E%3Cg fill=%23ffffff fill-opacity=0.04%3E%3Cpath d=M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
        <div class="absolute -right-20 -top-20 w-72 h-72 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 bottom-0 w-56 h-56 bg-emerald-300/10 rounded-full blur-2xl"></div>

        <div class="max-w-7xl mx-auto px-6 relative z-10">
            <div class="flex items-center gap-3 mb-1">
                <a href="/" class="text-emerald-200/80 hover:text-white text-sm font-medium transition">Beranda</a>
                <span class="text-emerald-300/50">›</span>
                <span class="text-white/80 text-sm font-medium">Konsultasi K3</span>
            </div>
            <div class="flex items-start gap-5 mt-4">
                <div class="shrink-0 w-14 h-14 rounded-2xl bg-white/10 backdrop-blur border border-white/20 flex items-center justify-center text-3xl shadow-lg">
                    <i class="fi fi-rr-lightbulb text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight leading-tight">Konsultasi K3 Veritas</h1>
                    <p class="text-emerald-100/80 mt-2 text-base max-w-xl font-light leading-relaxed">
                        Solusi sistem manajemen K3 komprehensif bersama konsultan berpengalaman kami. Khusus untuk badan usaha & perusahaan.
                    </p>
                </div>
            </div>

            {{-- Step Indicators --}}
            <div class="mt-8 flex items-center gap-0 max-w-lg" id="step-indicators">
                @foreach([['1','Data Perusahaan'],['2','Data PIC'],['3','Preferensi']] as $i => $step)
                <div class="flex items-center {{ $i < 2 ? 'flex-1' : '' }}">
                    <div class="step-indicator-item flex items-center gap-2.5" data-step="{{ $i + 1 }}">
                        <div class="step-dot w-8 h-8 rounded-full flex items-center justify-center text-sm font-black border-2 transition-all duration-300
                            {{ $i === 0 ? 'bg-white text-[#1E6B3D] border-white shadow-lg' : 'bg-white/20 text-white/70 border-white/40' }}"
                            id="dot-{{ $i+1 }}">
                            {{ $step[0] }}
                        </div>
                        <span class="text-xs font-semibold {{ $i === 0 ? 'text-white' : 'text-white/60' }} hidden md:block transition-all duration-300"
                              id="label-{{ $i+1 }}">{{ $step[1] }}</span>
                    </div>
                    @if($i < 2)
                    <div class="flex-1 h-0.5 mx-3 rounded-full bg-white/20 step-line-{{ $i+1 }}" id="line-{{ $i+1 }}"></div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid lg:grid-cols-3 gap-8 items-start">

            {{-- ── FORM AREA ──────────────────────────────────────────── --}}
            <div class="lg:col-span-2">
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-800 p-5 rounded-2xl flex items-start gap-3">
                        <i class="fi fi-rr-check-circle text-green-500 text-xl shrink-0 mt-0.5"></i>
                        <div>
                            <p class="font-bold">{{ session('success') }}</p>
                            <p class="text-sm text-emerald-700 mt-1">Tim kami akan meninjau pengajuan Anda dan menghubungi dalam 1×24 jam hari kerja.</p>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-300 text-red-700 p-5 rounded-2xl">
                        <p class="font-bold text-sm mb-2">Harap perbaiki kesalahan berikut:</p>
                        <ul class="list-disc ml-5 text-sm space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('pendaftaran.store') }}" id="form-pendaftaran">
                    @csrf
                    <input type="hidden" name="kategori_id" value="{{ $kategoriKonsultasi?->id_kategori }}">
                    <input type="hidden" name="jenis_klien" value="perusahaan">
                    {{-- pendidikan dummy (required oleh backend) --}}
                    <input type="hidden" name="pendidikan" value="Perusahaan">

                    {{-- ══════════════════════════════════════════════ --}}
                    {{-- STEP 1: DATA PERUSAHAAN                        --}}
                    {{-- ══════════════════════════════════════════════ --}}
                    <div id="step-1" class="step-section bg-white rounded-3xl border border-slate-100 shadow-sm p-8 space-y-6">
                        <div class="flex items-center gap-3 pb-5 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#1E6B3D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Langkah 1 dari 3</p>
                                <h2 class="text-xl font-black text-slate-900">Data Perusahaan</h2>
                            </div>
                        </div>

                        <div class="bg-emerald-50/60 border border-emerald-200/60 rounded-2xl p-4 flex items-start gap-3">
                            <i class="fi fi-rr-building text-blue-500 text-lg shrink-0 mt-0.5"></i>
                            <p class="text-sm text-emerald-800 font-medium leading-relaxed">
                                Layanan konsultasi Veritas ditujukan khusus untuk <strong>badan usaha / perusahaan</strong> (B2B). Kami memastikan solusi yang diberikan tepat dan terukur sesuai skala bisnis Anda.
                            </p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">
                                    Nama Perusahaan / Instansi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_perusahaan" required
                                       value="{{ old('nama_perusahaan') }}"
                                       placeholder="PT / CV / Yayasan / Instansi Pemerintah..."
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400 bg-slate-50/50">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">
                                    Alamat Lengkap Perusahaan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="alamat_perusahaan" required rows="2"
                                          placeholder="Jl. ..., Kota / Kabupaten, Provinsi"
                                          class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400 bg-slate-50/50 resize-none">{{ old('alamat_perusahaan') }}</textarea>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Sektor Industri</label>
                                    <input type="text" name="sektor_industri"
                                           value="{{ old('sektor_industri') }}"
                                           placeholder="Contoh: Pertambangan, Konstruksi..."
                                           class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400 bg-slate-50/50">
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Jumlah Karyawan</label>
                                    <input type="number" name="jumlah_karyawan" min="1"
                                           value="{{ old('jumlah_karyawan') }}"
                                           placeholder="Contoh: 150"
                                           class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-emerald-500/10 focus:border-[#1E6B3D] transition-all placeholder-slate-400 bg-slate-50/50">
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="button" onclick="goToStep(2)"
                                    class="bg-[#1E6B3D] hover:bg-[#24824A] text-white font-bold px-8 py-3.5 rounded-xl transition-all shadow-md shadow-emerald-700/10 flex items-center gap-2.5 active:scale-[0.98]">
                                Lanjut ke Data PIC
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════════ --}}
                    {{-- STEP 2: DATA PIC & KONTAK                      --}}
                    {{-- ══════════════════════════════════════════════ --}}
                    <div id="step-2" class="step-section hidden bg-white rounded-3xl border border-slate-100 shadow-sm p-8 space-y-6">
                        <div class="flex items-center gap-3 pb-5 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Langkah 2 dari 3</p>
                                <h2 class="text-xl font-black text-slate-900">Data PIC & Kontak</h2>
                            </div>
                        </div>

                        <div class="bg-blue-50/60 border border-blue-200/60 rounded-2xl p-4 flex items-start gap-3">
                            <span class="text-blue-500 text-lg shrink-0">ℹ️</span>
                            <p class="text-sm text-blue-800 font-medium leading-relaxed">
                                Isi data <strong>Person in Charge (PIC)</strong> perusahaan Anda — orang yang akan menjadi penghubung utama dengan tim konsultan kami.
                            </p>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">
                                    Nama Lengkap PIC <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_lengkap" required
                                       value="{{ old('nama_lengkap') }}"
                                       placeholder="Nama lengkap penghubung"
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder-slate-400 bg-slate-50/50">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-1.5">Jabatan PIC</label>
                                <input type="text" name="jabatan"
                                       value="{{ old('jabatan') }}"
                                       placeholder="Contoh: HSE Manager, Direktur Operasional..."
                                       class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder-slate-400 bg-slate-50/50">
                            </div>

                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">
                                        Email Aktif <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="email" required
                                           value="{{ old('email') }}"
                                           placeholder="pic@perusahaan.com"
                                           class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder-slate-400 bg-slate-50/50">
                                    <p class="text-xs text-slate-400 mt-1.5">Notifikasi & jadwal konsultasi akan dikirim ke email ini.</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-1.5">
                                        No. HP / WhatsApp <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="no_telp" required
                                           value="{{ old('no_telp') }}"
                                           placeholder="08xx xxxx xxxx"
                                           class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all placeholder-slate-400 bg-slate-50/50">
                                    <p class="text-xs text-slate-400 mt-1.5">Tim kami akan menghubungi via WhatsApp ini.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 flex items-center justify-between gap-3">
                            <button type="button" onclick="goToStep(1)"
                                    class="flex items-center gap-2 text-slate-500 hover:text-slate-800 font-semibold px-5 py-3.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition-all text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                                Kembali
                            </button>
                            <button type="button" onclick="goToStep(3)"
                                    class="bg-[#1E6B3D] hover:bg-[#24824A] text-white font-bold px-8 py-3.5 rounded-xl transition-all shadow-md shadow-emerald-700/10 flex items-center gap-2.5 active:scale-[0.98]">
                                Lanjut ke Preferensi
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- ══════════════════════════════════════════════ --}}
                    {{-- STEP 3: PREFERENSI KONSULTASI                  --}}
                    {{-- ══════════════════════════════════════════════ --}}
                    <div id="step-3" class="step-section hidden bg-white rounded-3xl border border-slate-100 shadow-sm p-8 space-y-6">
                        <div class="flex items-center gap-3 pb-5 border-b border-slate-100">
                            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Langkah 3 dari 3</p>
                                <h2 class="text-xl font-black text-slate-900">Preferensi Konsultasi</h2>
                            </div>
                        </div>

                        <div class="space-y-5">
                            {{-- Jenis Konsultasi --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Jenis Konsultasi yang Dibutuhkan <span class="text-red-500">*</span>
                                </label>
                                <select name="topik_layanan" id="topik_layanan" required
                                        onchange="toggleCatatan(this.value)"
                                        class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm bg-slate-50/50 focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition-all text-slate-700 cursor-pointer">
                                    <option value="">-- Pilih Jenis Layanan Konsultasi --</option>
                                    @foreach($jenisLayanan as $jenis)
                                        <option value="{{ $jenis->nama }}" {{ old('topik_layanan') == $jenis->nama ? 'selected' : '' }}>
                                            {{ $jenis->nama }}
                                        </option>
                                    @endforeach
                                    <option value="Lainnya" {{ old('topik_layanan') == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya — saya akan jelaskan di catatan
                                    </option>
                                </select>
                            </div>

                            {{-- Catatan jika "Lainnya" --}}
                            <div id="catatan-box" class="{{ old('topik_layanan') == 'Lainnya' ? '' : 'hidden' }}">
                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Jelaskan Kebutuhan Konsultasi Anda <span class="text-red-500">*</span>
                                </label>
                                <textarea name="catatan" id="catatan" rows="3"
                                          placeholder="Tuliskan jenis konsultasi atau kebutuhan spesifik Anda secara singkat..."
                                          class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition-all placeholder-slate-400 bg-slate-50/50 resize-none">{{ old('catatan') }}</textarea>
                            </div>

                            <div class="grid sm:grid-cols-2 gap-5">
                                {{-- Tanggal Usulan --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">
                                        Tanggal Mulai Usulan <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="tanggal_usul" required
                                           value="{{ old('tanggal_usul') }}"
                                           min="{{ date('Y-m-d') }}"
                                           class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition-all text-slate-700 bg-slate-50/50">
                                    <p class="text-xs text-slate-400 mt-1.5">Tanggal ini bersifat usulan — tim kami akan menyesuaikan.</p>
                                </div>

                                {{-- Mode Pertemuan --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">
                                        Preferensi Mode Pertemuan <span class="text-red-500">*</span>
                                    </label>
                                    <select name="mode_pertemuan" id="mode_pertemuan" required
                                            onchange="toggleLokasi(this.value)"
                                            class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm bg-slate-50/50 focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition-all text-slate-700 cursor-pointer">
                                        <option value="online" {{ old('mode_pertemuan') === 'online' ? 'selected' : '' }}>Online (Zoom / Google Meet)</option>
                                        <option value="offline" {{ old('mode_pertemuan') === 'offline' ? 'selected' : '' }}>Tatap Muka (Offline)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Lokasi jika offline --}}
                            <div id="lokasi-box" class="{{ old('mode_pertemuan') === 'offline' ? '' : 'hidden' }}">
                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Lokasi Pertemuan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="lokasi" id="lokasi" rows="2"
                                          placeholder="Alamat lengkap tempat pertemuan..."
                                          class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition-all placeholder-slate-400 bg-slate-50/50 resize-none">{{ old('lokasi') }}</textarea>
                            </div>

                            {{-- Catatan Tambahan (Opsional) --}}
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">
                                    Catatan Tambahan (Opsional)
                                </label>
                                <textarea name="catatan_tambahan" id="catatan_tambahan" rows="3"
                                          placeholder="Tuliskan catatan tambahan atau pesan khusus untuk tim kami (opsional)..."
                                          class="w-full border border-slate-200 rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-4 focus:ring-purple-500/10 focus:border-purple-500 transition-all placeholder-slate-400 bg-slate-50/50 resize-none">{{ old('catatan_tambahan') }}</textarea>
                            </div>
                        </div>

                        {{-- Summary Card sebelum submit --}}
                        <div class="bg-gradient-to-br from-slate-50 to-emerald-50/50 border border-slate-200/60 rounded-2xl p-5 space-y-2">
                            <p class="text-xs font-black text-slate-600 uppercase tracking-wider mb-3">Ringkasan Sebelum Kirim</p>
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <span class="text-emerald-500 flex items-center"><i class="fi fi-rr-check"></i></span> Setelah dikirim, tim kami akan <strong>meninjau pengajuan</strong> dalam 1×24 jam kerja.
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <span class="text-emerald-500 flex items-center"><i class="fi fi-rr-check"></i></span> Anda akan dihubungi melalui <strong>email & WhatsApp</strong> untuk konfirmasi lanjut.
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <span class="text-emerald-500 flex items-center"><i class="fi fi-rr-check"></i></span> <strong>Tidak ada biaya</strong> di tahap ini — konsultasi awal gratis.
                            </div>
                        </div>

                        <div class="pt-2 flex items-center justify-between gap-3">
                            <button type="button" onclick="goToStep(2)"
                                    class="flex items-center gap-2 text-slate-500 hover:text-slate-800 font-semibold px-5 py-3.5 rounded-xl border border-slate-200 hover:bg-slate-50 transition-all text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                                Kembali
                            </button>
                            <button type="submit" id="btn-submit"
                                    class="bg-gradient-to-r from-[#1E6B3D] to-[#24824A] hover:from-[#24824A] hover:to-[#2d9e5a] text-white font-black px-8 py-3.5 rounded-xl transition-all shadow-lg shadow-emerald-700/20 flex items-center gap-2.5 active:scale-[0.98]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                Kirim Pengajuan Konsultasi
                            </button>
                        </div>
                    </div>

                </form>
            </div>

            {{-- ── SIDEBAR ─────────────────────────────────────────────── --}}
            <div class="space-y-5 lg:sticky lg:top-24">

                {{-- Alur Konsultasi --}}
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                    <h3 class="font-black text-slate-900 text-base mb-5">Bagaimana Alurnya?</h3>
                    <ol class="space-y-5 relative">
                        <div class="absolute left-5 top-5 bottom-5 w-0.5 bg-gradient-to-b from-emerald-400 via-emerald-200 to-transparent"></div>
                        @php
                        $alur = [
                            ['<i class="fi fi-rr-comment-alt text-lg"></i>', 'Kirim Pengajuan', 'Isi form ini. Gratis, tanpa komitmen.'],
                            ['<i class="fi fi-rr-eye text-lg"></i>', 'Tim Kami Meninjau', 'Kami menganalisis kebutuhan & menghubungi Anda dalam 1 hari kerja.'],
                            ['<i class="fi fi-rr-calendar text-lg"></i>', 'Jadwal Ditetapkan', 'Kita sepakati tanggal & jadwal konsultasi bersama.'],
                            ['<i class="fi fi-rr-handshake text-lg"></i>', 'Sesi Konsultasi', 'Konsultasi dengan ahli K3 kami — online atau tatap muka.'],
                            ['<i class="fi fi-rr-check text-lg"></i>', 'Laporan & Selesai', 'Rekomendasi & pendampingan implementasi K3 siap dijalankan.'],
                        ];
                        @endphp
                        @foreach($alur as $i => $item)
                        <li class="flex items-start gap-4 relative">
                            <div class="w-10 h-10 rounded-xl {{ $i === 0 ? 'bg-[#1E6B3D] text-white' : 'bg-slate-100 text-slate-600' }} flex items-center justify-center text-base shrink-0 z-10 shadow-sm">
                                {!! $item[0] !!}
                            </div>
                            <div class="pt-1">
                                <p class="text-sm font-bold text-slate-800">{{ $item[1] }}</p>
                                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">{{ $item[2] }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ol>
                </div>

                {{-- Keunggulan --}}
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                    <h3 class="font-black text-slate-900 text-base mb-4">Mengapa Pilih Kami?</h3>
                    <ul class="space-y-3">
                        @foreach([
                            ['<i class="fi fi-rr-trophy text-[#1E6B3D] text-lg"></i>','Pengalaman 10+ tahun di bidang K3 & SMK3'],
                            ['<i class="fi fi-rr-target text-[#1E6B3D] text-lg"></i>','Solusi disesuaikan skala & industri Anda'],
                            ['<i class="fi fi-rr-clipboard-list text-[#1E6B3D] text-lg"></i>','Panduan dari perencanaan hingga sertifikasi'],
                            ['<i class="fi fi-rr-lock text-[#1E6B3D] text-lg"></i>','Kerahasiaan data perusahaan terjamin'],
                        ] as $item)
                        <li class="flex items-start gap-3">
                            <span class="text-lg shrink-0 flex items-center">{!! $item[0] !!}</span>
                            <span class="text-sm text-slate-600 leading-relaxed">{{ $item[1] }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- CTA WhatsApp --}}
                <div class="relative overflow-hidden bg-gradient-to-br from-[#1E6B3D] via-[#24824A] to-[#22c55e]/80 text-white p-6 rounded-3xl shadow-lg">
                    <div class="absolute -right-8 -bottom-8 w-28 h-28 bg-white/10 rounded-full blur-2xl"></div>
                    <p class="text-xs text-emerald-200 font-semibold uppercase tracking-wider mb-1 relative z-10">Butuh Bantuan?</p>
                    <h3 class="font-black text-base mb-2 relative z-10">Hubungi Kami Langsung</h3>
                    <p class="text-xs text-emerald-100 mb-5 relative z-10 leading-relaxed">Tim kami siap membantu menjawab pertanyaan Anda via WhatsApp.</p>
                    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo, saya ingin berkonsultasi mengenai layanan K3 Veritas.') }}"
                       target="_blank"
                       class="relative z-10 w-full bg-white text-[#1E6B3D] font-black px-4 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-emerald-50 active:scale-[0.98] transition-all shadow-sm text-sm">
                        <svg class="w-4 h-4 fill-[#25D366]" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.938 3.659 1.435 5.63 1.435h.008c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Chat WhatsApp Sekarang
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 3;

    // Restore state if validation failed (show last step that had errors)
    document.addEventListener('DOMContentLoaded', function() {
        const modePertemuan = document.getElementById('mode_pertemuan');
        if (modePertemuan) toggleLokasi(modePertemuan.value);

        // If there are old input errors, jump to appropriate step
        @if($errors->any())
            // Try to detect which step has the error
            const hasStep3Error = @json($errors->has('topik_layanan') || $errors->has('tanggal_usul') || $errors->has('mode_pertemuan') || $errors->has('catatan') || $errors->has('catatan_tambahan'));
            const hasStep2Error = @json($errors->has('nama_lengkap') || $errors->has('email') || $errors->has('no_telp'));
            if (hasStep3Error) {
                showStep(3);
            } else if (hasStep2Error) {
                showStep(2);
            } else {
                showStep(1);
            }
        @else
            showStep(1);
        @endif
    });

    function showStep(n) {
        currentStep = n;

        // Hide all steps
        document.querySelectorAll('.step-section').forEach(s => s.classList.add('hidden'));

        // Show target step
        const target = document.getElementById('step-' + n);
        if (target) {
            target.classList.remove('hidden');
            // Smooth scroll to top of form
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        // Update step indicators in hero
        for (let i = 1; i <= totalSteps; i++) {
            const dot   = document.getElementById('dot-' + i);
            const label = document.getElementById('label-' + i);
            if (!dot) continue;

            if (i < n) {
                // Completed
                dot.className = 'step-dot w-8 h-8 rounded-full flex items-center justify-center text-sm font-black border-2 transition-all duration-300 bg-emerald-400 text-white border-emerald-400 shadow-lg';
                dot.textContent = '✓';
                if (label) { label.className = 'text-xs font-semibold text-white hidden md:block transition-all duration-300'; }
            } else if (i === n) {
                // Active
                dot.className = 'step-dot w-8 h-8 rounded-full flex items-center justify-center text-sm font-black border-2 transition-all duration-300 bg-white text-[#1E6B3D] border-white shadow-lg';
                dot.textContent = i;
                if (label) { label.className = 'text-xs font-semibold text-white hidden md:block transition-all duration-300'; }
            } else {
                // Upcoming
                dot.className = 'step-dot w-8 h-8 rounded-full flex items-center justify-center text-sm font-black border-2 transition-all duration-300 bg-white/20 text-white/70 border-white/40';
                dot.textContent = i;
                if (label) { label.className = 'text-xs font-semibold text-white/60 hidden md:block transition-all duration-300'; }
            }

            // Update connecting lines
            const line = document.getElementById('line-' + i);
            if (line) {
                if (i < n) {
                    line.className = line.className.replace('bg-white/20', '') + ' bg-emerald-400';
                } else {
                    line.className = line.className.replace('bg-emerald-400', '') + ' bg-white/20';
                }
            }
        }
    }

    function goToStep(n) {
        // Basic validation before advancing
        if (n > currentStep) {
            if (!validateStep(currentStep)) return;
        }
        showStep(n);
    }

    function validateStep(step) {
        let valid = true;
        let firstError = null;

        if (step === 1) {
            const namaPerusahaan = document.querySelector('[name="nama_perusahaan"]');
            const alamat         = document.querySelector('[name="alamat_perusahaan"]');
            [namaPerusahaan, alamat].forEach(el => {
                if (el && !el.value.trim()) {
                    el.classList.add('border-red-400', 'bg-red-50/30');
                    if (!firstError) firstError = el;
                    valid = false;
                } else if (el) {
                    el.classList.remove('border-red-400', 'bg-red-50/30');
                }
            });
        }

        if (step === 2) {
            const nama  = document.querySelector('[name="nama_lengkap"]');
            const email = document.querySelector('[name="email"]');
            const telp  = document.querySelector('[name="no_telp"]');
            [nama, email, telp].forEach(el => {
                if (el && !el.value.trim()) {
                    el.classList.add('border-red-400', 'bg-red-50/30');
                    if (!firstError) firstError = el;
                    valid = false;
                } else if (el) {
                    el.classList.remove('border-red-400', 'bg-red-50/30');
                }
            });
        }

        if (!valid && firstError) {
            firstError.focus();
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        return valid;
    }

    window.toggleCatatan = function(val) {
        const box     = document.getElementById('catatan-box');
        const catatan = document.getElementById('catatan');
        if (!box || !catatan) return;
        if (val === 'Lainnya') {
            box.classList.remove('hidden');
            catatan.required = true;
        } else {
            box.classList.add('hidden');
            catatan.required = false;
            catatan.value = '';
        }
    };

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
    };

    // Prevent double submit
    document.getElementById('form-pendaftaran')?.addEventListener('submit', function() {
        const btn = document.getElementById('btn-submit');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = `<svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg> Mengirim...`;
        }
    });
</script>

@endsection