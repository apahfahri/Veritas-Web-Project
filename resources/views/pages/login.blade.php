@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-[#0A2540] via-[#0d3456] to-[#00A8A8] flex items-center justify-center p-4">

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

                <h2 class="text-2xl font-bold">Login</h2>

                <p class="text-sm text-gray-600 mt-2">
                    Masuk ke akun PT Katiga Veritas Indonesia
                </p>
            </div>

            <!-- FORM -->
            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <!-- EMAIL -->
                <div>
                    <label class="text-sm font-medium">Email</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            📧
                        </span>
                        <input 
                            type="email" 
                            name="email"
                            placeholder="nama@email.com"
                            class="w-full border rounded px-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#00A8A8]"
                        >
                    </div>
                </div>

                <!-- PASSWORD -->
                <div>
                    <label class="text-sm font-medium">Password</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            🔒
                        </span>
                        <input 
                            type="password" 
                            name="password"
                            placeholder="••••••••"
                            class="w-full border rounded px-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#00A8A8]"
                        >
                    </div>
                </div>

                <!-- OPTIONS -->
                <div class="flex justify-between items-center text-sm">
                    <label class="flex items-center gap-2">
                        <input type="checkbox">
                        <span class="text-gray-600">Ingat saya</span>
                    </label>

                    <a href="#" class="text-[#00A8A8] hover:underline">
                        Lupa password?
                    </a>
                </div>

                <!-- BUTTON -->
                <button 
                    type="submit"
                    class="w-full bg-[#00A8A8] hover:bg-[#008888] text-white py-3 rounded font-semibold transition"
                >
                    Login
                </button>

            </form>

            <!-- REGISTER -->
            <div class="mt-6 text-center text-sm">
                <p class="text-gray-600">
                    Belum punya akun?
                    <a href="/register" class="text-[#00A8A8] font-medium hover:underline">
                        Daftar sekarang
                    </a>
                </p>
            </div>

            <!-- DEMO -->
            <div class="mt-6 bg-[#F5F7FA] p-4 rounded-lg text-sm">
                <p class="font-medium mb-2">Demo Account:</p>

                <div class="text-gray-600 space-y-1">
                    <div><strong>User:</strong> user@example.com</div>
                    <div><strong>Admin:</strong> admin@katigaveritas.com</div>
                    <div class="text-xs mt-2 text-gray-500">
                        Password bebas untuk demo
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@endsection