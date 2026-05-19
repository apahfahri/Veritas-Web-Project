@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan (404) — PT Katiga Veritas Indonesia')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center bg-gradient-to-b from-[#F5F7FA] to-white py-12 px-6">
    <div class="max-w-xl w-full text-center">
        <!-- Animated Icon Container -->
        <div class="relative mb-8 flex justify-center">
            <!-- Decorative blur backdrops -->
            <div class="absolute w-44 h-44 rounded-full bg-[#3CDA7D]/10 blur-2xl top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute w-36 h-36 rounded-full bg-orange-400/5 blur-xl top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"></div>
            
            <!-- Main 404 Graphic -->
            <div class="relative flex flex-col items-center">
                <div class="text-[120px] font-extrabold leading-none tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-[#1E6B3D] via-[#2E9B56] to-[#3CDA7D] drop-shadow-sm select-none animate-pulse">
                    404
                </div>
                <!-- Floating Badge -->
                <div class="absolute -bottom-2 bg-orange-500 text-white text-xs font-bold uppercase tracking-widest px-3 py-1 rounded-full shadow-lg border-2 border-white flex items-center gap-1.5 animate-bounce">
                    <span>⚠️</span> Tidak Ditemukan
                </div>
            </div>
        </div>

        <!-- Text Content -->
        <h2 class="text-3xl font-bold text-gray-800 mb-3 tracking-tight">
            Ups! Halaman Tidak Ditemukan
        </h2>
        <p class="text-gray-500 mb-8 max-w-md mx-auto text-sm leading-relaxed">
            Maaf, halaman yang Anda cari tidak ada atau telah dipindahkan ke alamat lain. Silakan periksa kembali URL Anda atau kembali ke menu utama.
        </p>

        <!-- Navigation Cards/Buttons -->
        <div class="grid sm:grid-cols-2 gap-4 max-w-md mx-auto mb-8 text-left">
            <a href="/" class="flex items-center gap-3 p-4 bg-white hover:bg-gray-50 border border-gray-100 rounded-2xl shadow-sm hover:shadow transition group">
                <span class="text-2xl">🏠</span>
                <div>
                    <div class="font-bold text-sm text-[#1E6B3D] group-hover:text-[#3CDA7D] transition-colors">Beranda</div>
                    <div class="text-xs text-gray-400">Kembali ke halaman utama</div>
                </div>
            </a>
            <a href="/training" class="flex items-center gap-3 p-4 bg-white hover:bg-gray-50 border border-gray-100 rounded-2xl shadow-sm hover:shadow transition group">
                <span class="text-2xl">🎓</span>
                <div>
                    <div class="font-bold text-sm text-[#1E6B3D] group-hover:text-[#3CDA7D] transition-colors">Pelatihan K3</div>
                    <div class="text-xs text-gray-400">Lihat program pelatihan</div>
                </div>
            </a>
            <a href="{{ route('training.status') }}" class="flex items-center gap-3 p-4 bg-white hover:bg-gray-50 border border-gray-100 rounded-2xl shadow-sm hover:shadow transition group">
                <span class="text-2xl">🔍</span>
                <div>
                    <div class="font-bold text-sm text-[#1E6B3D] group-hover:text-[#3CDA7D] transition-colors">Cek Status</div>
                    <div class="text-xs text-gray-400">Cek progres pendaftaran</div>
                </div>
            </a>
            <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center gap-3 p-4 bg-white hover:bg-gray-50 border border-gray-100 rounded-2xl shadow-sm hover:shadow transition group">
                <span class="text-2xl">💬</span>
                <div>
                    <div class="font-bold text-sm text-[#1E6B3D] group-hover:text-[#3CDA7D] transition-colors">Bantuan PIC</div>
                    <div class="text-xs text-gray-400">Hubungi kami via WhatsApp</div>
                </div>
            </a>
        </div>

        <!-- Back Button -->
        <a href="javascript:history.back()" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-gray-800 transition">
            <span>←</span> Kembali ke Halaman Sebelumnya
        </a>
    </div>
</div>
@endsection
