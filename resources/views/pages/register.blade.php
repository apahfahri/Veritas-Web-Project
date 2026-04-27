@extends('layouts.app')

@section('title', 'Daftar Akun — PT Katiga Veritas Indonesia')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-[#0A2540] via-[#0d3456] to-[#00A8A8] flex items-center justify-center p-4 py-8">

    <div class="w-full max-w-md">

        <!-- BACK -->
        <div class="text-center mb-6">
            <a href="/" class="text-white hover:bg-white/10 px-4 py-2 rounded inline-flex items-center gap-2">
                ← Kembali ke Beranda
            </a>
        </div>

        <!-- CARD -->
        <div class="bg-white rounded-xl shadow-2xl p-8">

            <!-- HEADER -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-[#0A2540] rounded-full flex items-center justify-center mx-auto mb-4 text-white text-2xl">
                    🛡️
                </div>

                <h2 class="text-2xl font-bold">Daftar Akun</h2>

                <p class="text-sm text-gray-600 mt-2">
                    Buat akun untuk mengakses layanan kami
                </p>
            </div>

            <!-- ERROR VALIDASI -->
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-300 text-red-700 rounded-lg p-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- TOMBOL GOOGLE -->
            <a href="{{ route('google.login') }}"
               class="w-full flex items-center justify-center gap-3 border border-gray-300 rounded-lg px-4 py-2.5 text-sm font-medium hover:bg-gray-50 transition mb-4">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Daftar dengan Google
            </a>

            <!-- SEPARATOR -->
            <div class="flex items-center gap-3 mb-4">
                <hr class="flex-1 border-gray-200">
                <span class="text-xs text-gray-400">atau daftar dengan email</span>
                <hr class="flex-1 border-gray-200">
            </div>

            <!-- FORM -->
            <form method="POST" action="/register" class="space-y-4">
                @csrf

                <!-- USER TYPE -->
                <div>
                    <label class="text-sm font-medium">Jenis Akun</label>

                    <div class="grid grid-cols-2 gap-4 mt-2">

                        <label class="cursor-pointer border-2 rounded-lg p-4 text-center hover:border-[#00A8A8]">
                            <input type="radio" name="user_type" value="individual" checked class="mb-2">
                            <div class="text-2xl">👤</div>
                            <div class="text-sm font-medium">Individu</div>
                        </label>

                        <label class="cursor-pointer border-2 rounded-lg p-4 text-center hover:border-[#00A8A8]">
                            <input type="radio" name="user_type" value="company" class="mb-2">
                            <div class="text-2xl">🏢</div>
                            <div class="text-sm font-medium">Perusahaan</div>
                        </label>

                    </div>
                </div>

                <hr>

                <!-- NAME -->
                <div>
                    <label class="text-sm font-medium">Nama Lengkap</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">👤</span>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Nama lengkap"
                            class="w-full border rounded px-10 py-2 focus:ring-2 focus:ring-[#00A8A8] @error('name') border-red-400 @enderror"
                        >
                    </div>
                </div>

                <!-- COMPANY (ditampilkan, tidak disimpan ke DB) -->
                <div>
                    <label class="text-sm font-medium">Nama Perusahaan <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🏢</span>
                        <input
                            type="text"
                            name="company"
                            value="{{ old('company') }}"
                            placeholder="PT. Nama Perusahaan"
                            class="w-full border rounded px-10 py-2 focus:ring-2 focus:ring-[#00A8A8]"
                        >
                    </div>
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="text-sm font-medium">Email</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">📧</span>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="w-full border rounded px-10 py-2 focus:ring-2 focus:ring-[#00A8A8] @error('email') border-red-400 @enderror"
                        >
                    </div>
                </div>

                <!-- PHONE (ditampilkan, tidak disimpan ke DB) -->
                <div>
                    <label class="text-sm font-medium">Nomor Telepon <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">📞</span>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="08xxxxxxxxxx"
                            class="w-full border rounded px-10 py-2 focus:ring-2 focus:ring-[#00A8A8]"
                        >
                    </div>
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="text-sm font-medium">Password</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔒</span>
                        <input
                            type="password"
                            name="password"
                            placeholder="Minimal 6 karakter"
                            class="w-full border rounded px-10 py-2 focus:ring-2 focus:ring-[#00A8A8] @error('password') border-red-400 @enderror"
                        >
                    </div>
                </div>

                <!-- CONFIRM -->
                <div>
                    <label class="text-sm font-medium">Konfirmasi Password</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔒</span>
                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            class="w-full border rounded px-10 py-2 focus:ring-2 focus:ring-[#00A8A8]"
                        >
                    </div>
                </div>

                <!-- AGREEMENT -->
                <div class="flex gap-2 text-sm">
                    <input type="checkbox" required>
                    <span class="text-gray-600">
                        Saya setuju dengan
                        <a href="#" class="text-[#00A8A8] hover:underline">syarat</a>
                        dan
                        <a href="#" class="text-[#00A8A8] hover:underline">privasi</a>
                    </span>
                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full bg-[#00A8A8] hover:bg-[#008888] text-white py-3 rounded font-semibold transition"
                >
                    Daftar
                </button>

            </form>

            <!-- LOGIN -->
            <div class="mt-6 text-center text-sm">
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="/login" class="text-[#00A8A8] font-medium hover:underline">
                        Login di sini
                    </a>
                </p>
            </div>

        </div>
    </div>

</div>

@endsection