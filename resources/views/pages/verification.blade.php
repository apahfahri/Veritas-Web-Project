@extends('layouts.app')
@section('title', 'Verifikasi Sertifikat — PT Katiga Veritas Indonesia')
@section('content')

<!-- Google Fonts (Montserrat) & Custom CSS -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    .font-montserrat {
        font-family: 'Montserrat', sans-serif;
    }
    .glow-green {
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.05);
    }
    .glow-red {
        box-shadow: 0 10px 30px rgba(239, 68, 68, 0.05);
    }
    .pulse-glow {
        animation: pulseGlow 2s infinite;
    }
    @keyframes pulseGlow {
        0% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.2);
        }
        70% {
            box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
        }
    }
    .hover-lift {
        transition: all 0.2s ease-in-out;
    }
    .hover-lift:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.03);
    }
</style>

<div class="min-h-screen bg-[#F8FAFC] font-montserrat pb-12">

    <!-- HEADER / BANNER (Simple & Compact) -->
    <div class="relative overflow-hidden bg-gradient-to-br from-[#124E27] via-[#1E6B3D] to-[#2B9A57] text-white py-10 px-6">
        <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full bg-white/5 blur-3xl pointer-events-none"></div>
        <div class="absolute -left-20 -bottom-20 w-80 h-80 rounded-full bg-emerald-500/5 blur-3xl pointer-events-none"></div>
        
        <div class="max-w-xl mx-auto text-center relative z-10 space-y-2">
            <span class="inline-flex items-center gap-1.5 bg-white/10 backdrop-blur-md px-3 py-1 rounded-full text-[9px] font-bold text-emerald-300 tracking-wider uppercase border border-white/10">
                <i class="fi fi-rr-lock"></i> Secured Verification
            </span>
            <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight">Verifikasi Sertifikat</h1>
            <p class="text-emerald-100 max-w-sm mx-auto text-xs font-light leading-relaxed opacity-90">
                Periksa keabsahan dokumen pelatihan K3 yang diterbitkan oleh PT Katiga Veritas Indonesia.
            </p>
        </div>
    </div>

    <!-- MAIN CONTAINER (Compact Width) -->
    <div class="max-w-xl mx-auto px-6 -mt-8 relative z-20">

        <!-- FORM CARD (Compact & Simple) -->
        <div class="bg-white rounded-2xl p-5 shadow-lg border border-slate-100/80 mb-5 hover-lift">
            <form method="POST" action="{{ route('verification.cek') }}" class="space-y-4">
                @csrf
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#1E6B3D] transition-colors">
                        <i class="fi fi-rr-search text-base"></i>
                    </div>
                    <input type="text" name="no_sertifikat" id="no_sertifikat"
                           value="{{ old('no_sertifikat', request('no')) }}"
                           placeholder="CONTOH: KV-K3-2026-000001"
                           class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-center text-sm font-bold uppercase tracking-wider text-slate-800 placeholder-slate-400/80 focus:outline-none focus:bg-white focus:border-[#1E6B3D] focus:ring-4 focus:ring-emerald-500/5 transition-all duration-200 @error('no_sertifikat') border-red-400 focus:ring-red-500/5 @enderror">
                </div>
                
                @error('no_sertifikat')
                    <p class="text-red-500 text-xs text-center font-medium animate-pulse">{{ $message }}</p>
                @enderror
                
                <button type="submit" class="w-full bg-[#1E6B3D] hover:bg-[#154c2b] text-white py-3 rounded-xl font-bold active:scale-[0.99] transition-all duration-200 flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                    <span>Periksa Sertifikat</span>
                    <i class="fi fi-rr-arrow-right"></i>
                </button>
            </form>
        </div>

        {{-- HASIL VERIFIKASI --}}
        @isset($status)
        <div class="space-y-4">

            @if($status === 'valid' && $sertifikat)

                <!-- VALID HEADER CARD (Compact & Simple) -->
                <div class="border border-emerald-500/20 bg-emerald-50/40 rounded-2xl p-5 text-center relative overflow-hidden glow-green">
                    <div class="w-12 h-12 bg-gradient-to-br from-[#3CDA7D] to-[#1E6B3D] text-white rounded-full flex items-center justify-center mx-auto mb-2 text-xl shadow shadow-emerald-500/20 pulse-glow">
                        <i class="fi fi-rr-check"></i>
                    </div>
                    <span class="inline-block px-2.5 py-0.5 bg-emerald-100 text-emerald-800 rounded-full text-[9px] font-bold tracking-wider uppercase mb-1">
                        Official Document
                    </span>
                    <h2 class="text-xl font-extrabold text-emerald-900 tracking-tight">Sertifikat Valid</h2>
                    <p class="text-emerald-700/85 mt-0.5 text-xs">
                        Terdaftar resmi di basis data PT Katiga Veritas Indonesia.
                    </p>
                </div>

                <!-- DETAIL CARD (Montserrat - Compact & Clean) -->
                <div class="bg-white rounded-2xl p-5 shadow-lg border border-slate-100/80 hover-lift relative overflow-hidden">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                            <span class="w-1 h-4 bg-[#1E6B3D] rounded-full"></span>
                            Detail Sertifikat
                        </h3>
                        <span class="bg-[#1E6B3D] text-white text-[8px] font-bold px-2 py-1 rounded-full uppercase tracking-wider flex items-center gap-1">
                            <span class="w-1 h-1 bg-emerald-400 rounded-full animate-ping"></span>
                            Valid
                        </span>
                    </div>

                    <!-- Details Layout (Compact List) -->
                    <div class="space-y-3.5">
                        <!-- 1. Nomor Sertifikat -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between py-2 border-b border-slate-100 gap-1">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center">
                                    <i class="fi fi-rr-shield-check text-sm text-emerald-600"></i>
                                </div>
                                <span class="text-xs font-semibold text-slate-400">Nomor Sertifikat</span>
                            </div>
                            <span class="text-xs font-bold text-slate-800 font-mono tracking-wide bg-slate-50 px-2.5 py-1 rounded-lg border border-slate-100">{{ $sertifikat->no_sertifikat }}</span>
                        </div>

                        <!-- 2. Nama Pemegang -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between py-2 border-b border-slate-100 gap-1">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center">
                                    <i class="fi fi-rr-user text-sm text-[#1E6B3D]"></i>
                                </div>
                                <span class="text-xs font-semibold text-slate-400">Nama Pemegang</span>
                            </div>
                            <span class="text-xs font-extrabold text-slate-800 uppercase tracking-tight">{{ $sertifikat->nama_lengkap }}</span>
                        </div>

                        <!-- 3. Layanan / Pelatihan -->
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between py-2 border-b border-slate-100 gap-1">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center shrink-0">
                                    <i class="fi fi-rr-home text-sm text-[#1E6B3D]"></i>
                                </div>
                                <span class="text-xs font-semibold text-slate-400">Layanan / Pelatihan</span>
                            </div>
                            <span class="text-xs font-bold text-[#1E6B3D] text-left sm:text-right max-w-xs sm:max-w-sm">{{ $sertifikat->pendaftaran?->layanan?->nama ?? '-' }}</span>
                        </div>

                        <!-- 4. Penerbit Sertifikat -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between py-2 border-b border-slate-100 gap-1">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center">
                                    <i class="fi fi-rr-lock text-sm text-[#1E6B3D]"></i>
                                </div>
                                <span class="text-xs font-semibold text-slate-400">Penerbit</span>
                            </div>
                            <span class="text-xs font-bold text-slate-700 text-left sm:text-right">{{ $sertifikat->penerbit ?? 'PT Katiga Veritas Indonesia' }}</span>
                        </div>

                        <!-- 5. Tanggal Terbit & Masa Berlaku (Compact Side-by-side) -->
                        <div class="grid grid-cols-2 gap-3 pt-1.5">
                            <div class="p-2.5 bg-slate-50/50 rounded-xl border border-slate-100/50 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-white text-emerald-600 shadow-sm flex items-center justify-center shrink-0 border border-slate-100">
                                    <i class="fi fi-rr-check text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-[8px] font-bold uppercase tracking-wider text-slate-400">Tgl Terbit</div>
                                    <div class="text-[11px] font-bold text-slate-800">{{ $sertifikat->tanggal_terbit ? $sertifikat->tanggal_terbit->format('d M Y') : '-' }}</div>
                                </div>
                            </div>
                            
                            <div class="p-2.5 bg-slate-50/50 rounded-xl border border-slate-100/50 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-white text-orange-500 shadow-sm flex items-center justify-center shrink-0 border border-slate-100">
                                    <i class="fi fi-rr-hourglass text-sm"></i>
                                </div>
                                <div>
                                    <div class="text-[8px] font-bold uppercase tracking-wider text-slate-400">Masa Berlaku</div>
                                    <div class="text-[11px] font-bold text-slate-800">{{ $sertifikat->masa_berlaku ? $sertifikat->masa_berlaku->format('d M Y') : 'Seumur Hidup' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @else

                <!-- INVALID / NOT FOUND CARD (Compact & Simple) -->
                <div class="border border-red-500/20 bg-red-50/30 rounded-2xl p-5 text-center relative overflow-hidden glow-red">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-red-600 text-white rounded-full flex items-center justify-center mx-auto mb-2 text-xl shadow shadow-red-500/10">
                        <i class="fi fi-rr-cross-circle"></i>
                    </div>
                    <span class="inline-block px-2.5 py-0.5 bg-red-100 text-red-800 rounded-full text-[9px] font-bold tracking-wider uppercase mb-1">
                        Failed
                    </span>
                    <h2 class="text-xl font-extrabold text-red-950 tracking-tight">Tidak Ditemukan</h2>
                    <p class="text-red-700/80 mt-1 text-xs">
                        Nomor <strong class="text-red-900 font-mono">"{{ old('no_sertifikat', request('no_sertifikat')) }}"</strong> tidak terdaftar.
                    </p>
                </div>

            @endif

            <!-- ACTION BUTTONS (Compact & Simple) -->
            <div class="flex gap-3">
                <a href="{{ route('verification') }}" class="flex-1 bg-[#1E6B3D] text-white py-3 rounded-xl text-center font-bold hover:bg-[#154c2b] active:scale-[0.99] transition text-xs uppercase tracking-wider flex items-center justify-center gap-1.5 shadow-sm">
                    <i class="fi fi-rr-undo"></i>
                    <span>Verifikasi Lagi</span>
                </a>
                <a href="{{ route('home') }}" class="px-5 bg-white border border-slate-200 text-slate-600 py-3 rounded-xl text-center font-bold hover:bg-slate-50 transition active:scale-[0.99] text-xs uppercase tracking-wider flex items-center justify-center gap-1.5">
                    <i class="fi fi-rr-home"></i>
                    <span>Beranda</span>
                </a>
            </div>

        </div>
        @endisset

        <!-- HELP / CONTACT CARD (Compact & Simple) -->
        <div class="mt-6 bg-gradient-to-br from-[#1E6B3D] to-[#2B9A57] text-white rounded-2xl p-5 shadow-lg relative overflow-hidden hover-lift">
            <div class="absolute -right-10 -bottom-10 w-40 h-40 rounded-full bg-white/5 blur-2xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                <div class="space-y-1 max-w-sm">
                    <h3 class="text-sm font-bold tracking-tight uppercase">Butuh Bantuan?</h3>
                    <p class="text-[11px] text-emerald-100 font-light leading-relaxed opacity-95">
                        Ada kendala mencocokkan keaslian sertifikat? Tim bantuan kami siap membantu Anda.
                    </p>
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <a href="https://wa.me/628123456789" target="_blank" class="flex-1 md:flex-initial bg-white text-slate-800 px-3.5 py-2 rounded-xl text-[10px] font-bold hover:bg-slate-50 hover:shadow shadow-white/10 transition active:scale-[0.98] flex items-center justify-center gap-1">
                        <i class="fi fi-brands-whatsapp text-emerald-600 text-sm"></i>
                        <span>WhatsApp</span>
                    </a>
                    <a href="mailto:info@katigaveritas.co.id" class="flex-1 md:flex-initial border border-white/20 bg-white/10 hover:bg-white/20 px-3.5 py-2 rounded-xl text-[10px] font-bold transition active:scale-[0.98] flex items-center justify-center gap-1">
                        <i class="fi fi-rr-envelope text-sm"></i>
                        <span>Email</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection