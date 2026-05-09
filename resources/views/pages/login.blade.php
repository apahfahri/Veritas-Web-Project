@extends('layouts.auth')

@section('title', 'Login — PT Katiga Veritas Indonesia')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-[#7d2ae7] via-[#3969e7] to-[#07b9ce] flex items-center justify-center p-4">

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
                <div class="w-16 h-16 bg-[#7d2ae7] rounded-full flex items-center justify-center mx-auto mb-4 text-white text-2xl">
                    🛡️
                </div>

                <h2 class="text-2xl font-bold">Login</h2>

                <p class="text-sm text-gray-600 mt-2">
                    Masuk ke akun PT Katiga Veritas Indonesia
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

            <!-- SUCCESS MESSAGE -->
            @if (session('status'))
                <div class="mb-4 bg-green-50 border border-green-300 text-green-700 rounded-lg p-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif



            <!-- FORM -->
            <form method="POST" action="/login" class="space-y-4">
                @csrf

                <!-- USERNAME / EMAIL -->
                <div>
                    <label class="text-sm font-medium">Username / Email</label>
                    <div class="relative mt-1">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            👤
                        </span>
                        <input
                            type="text"
                            name="login"
                            value="{{ old('login') }}"
                            placeholder="username atau email"
                            class="w-full border rounded px-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#7d2ae7] @error('login') border-red-400 @enderror"
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
                            id="login-password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full border rounded pl-10 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-[#00A8A8]"
                        >
                        <button type="button" onclick="togglePassword('login-password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none text-sm">
                            👁️
                        </button>
                    </div>
                </div>

                <!-- OPTIONS -->
                <div class="flex justify-between items-center text-sm">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember_me">
                        <span class="text-gray-600">Ingat saya</span>
                    </label>


                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="w-full bg-[#7d2ae7] hover:bg-[#008888] text-white py-3 rounded font-semibold transition"
                >
                    Login
                </button>

            </form>



        </div>
    </div>

</div>

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '🙈';
        } else {
            input.type = 'password';
            btn.innerHTML = '👁️';
        }
    }
</script>

@endsection