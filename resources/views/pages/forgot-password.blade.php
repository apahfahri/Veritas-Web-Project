@extends('layouts.auth')

@section('title', 'Lupa Password — PT Katiga Veritas Indonesia')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-[#0A2540] via-[#0d3456] to-[#00A8A8] flex items-center justify-center p-4 py-10">
    <div class="w-full max-w-md">

        {{-- BACK --}}
        <div class="text-center mb-6">
            <a href="{{ route('login') }}"
               class="inline-flex items-center gap-2 text-white/80 hover:text-white hover:bg-white/10 px-4 py-2 rounded-lg transition text-sm">
                ← Kembali ke Login
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">

            {{-- HEADER --}}
            <div class="text-center mb-7">
                <div class="w-16 h-16 bg-[#0A2540] rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-lg">
                    🔑
                </div>
                <h1 class="text-2xl font-bold text-[#0A2540]">Lupa Password?</h1>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                    Masukkan email akun Anda. Kami akan mengirimkan kode OTP untuk mereset password.
                </p>
            </div>

            {{-- INFO / ERROR --}}
            @if (session('error'))
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm flex items-start gap-2">
                    <span class="shrink-0">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="fp-email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-base pointer-events-none select-none">📧</span>
                        <input
                            id="fp-email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                            autofocus
                            class="w-full border border-gray-300 rounded-xl pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#00A8A8] focus:ring-2 focus:ring-teal-100 transition {{ $errors->has('email') ? 'border-red-400' : '' }}"
                        >
                    </div>
                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                    class="w-full bg-[#00A8A8] hover:bg-[#008f8f] active:scale-[.98] text-white py-3 rounded-xl font-semibold text-sm tracking-wide transition-all shadow-md hover:shadow-lg">
                    Kirim Kode OTP
                </button>

            </form>

            {{-- DIVIDER --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Ingat password Anda?
                    <a href="{{ route('login') }}" class="text-[#00A8A8] font-semibold hover:underline">Login di sini</a>
                </p>
            </div>

        </div>
    </div>
</div>

@endsection
