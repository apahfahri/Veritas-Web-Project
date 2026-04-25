@extends('layouts.app')

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
                            placeholder="Nama lengkap"
                            class="w-full border rounded px-10 py-2 focus:ring-2 focus:ring-[#00A8A8]"
                        >
                    </div>
                </div>

                <!-- COMPANY (optional static dulu) -->
                <div>
                    <label class="text-sm font-medium">Nama Perusahaan</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🏢</span>
                        <input 
                            type="text" 
                            name="company"
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
                            placeholder="nama@email.com"
                            class="w-full border rounded px-10 py-2 focus:ring-2 focus:ring-[#00A8A8]"
                        >
                    </div>
                </div>

                <!-- PHONE -->
                <div>
                    <label class="text-sm font-medium">Nomor Telepon</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">📞</span>
                        <input 
                            type="text" 
                            name="phone"
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
                            class="w-full border rounded px-10 py-2 focus:ring-2 focus:ring-[#00A8A8]"
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
                    class="w-full bg-[#00A8A8] hover:bg-[#008888] text-white py-3 rounded font-semibold"
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