@extends('layouts.auth')

@section('title', 'Reset Password — PT Katiga Veritas Indonesia')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-[#0A2540] via-[#0d3456] to-[#00A8A8] flex items-center justify-center p-4 py-10">
    <div class="w-full max-w-md">

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">

            {{-- HEADER --}}
            <div class="text-center mb-7">
                <div class="w-16 h-16 bg-[#0A2540] rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-lg">
                    🔒
                </div>
                <h1 class="text-2xl font-bold text-[#0A2540]">Buat Password Baru</h1>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                    Masukkan password baru untuk akun <span class="font-medium text-[#0A2540]">{{ $email }}</span>
                </p>
            </div>

            {{-- ERROR --}}
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
            <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                @csrf

                {{-- Password Baru --}}
                <div>
                    <label for="new-password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password Baru <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-base pointer-events-none select-none">🔒</span>
                        <input
                            id="new-password"
                            type="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                            autofocus
                            class="w-full border border-gray-300 rounded-xl pl-10 pr-10 py-2.5 text-sm focus:outline-none focus:border-[#00A8A8] focus:ring-2 focus:ring-teal-100 transition {{ $errors->has('password') ? 'border-red-400' : '' }}"
                        >
                        <button type="button" onclick="togglePass('new-password', 'eye1')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-base select-none">
                            <span id="eye1">👁️</span>
                        </button>
                    </div>

                    {{-- Password strength bar --}}
                    <div class="mt-2">
                        <div class="flex gap-1">
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="str-1"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="str-2"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="str-3"></div>
                            <div class="h-1 flex-1 rounded-full bg-gray-200 transition-colors duration-300" id="str-4"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-1" id="str-label"></p>
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="confirm-password" class="block text-sm font-medium text-gray-700 mb-1">
                        Konfirmasi Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-base pointer-events-none select-none">🔒</span>
                        <input
                            id="confirm-password"
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password baru"
                            required
                            class="w-full border border-gray-300 rounded-xl pl-10 pr-10 py-2.5 text-sm focus:outline-none focus:border-[#00A8A8] focus:ring-2 focus:ring-teal-100 transition"
                        >
                        <button type="button" onclick="togglePass('confirm-password', 'eye2')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 text-base select-none">
                            <span id="eye2">👁️</span>
                        </button>
                    </div>
                    <p class="text-xs mt-1 hidden text-red-500" id="match-msg">Password tidak cocok</p>
                    <p class="text-xs mt-1 hidden text-green-600" id="match-ok">✓ Password cocok</p>
                </div>

                {{-- SUBMIT --}}
                <button type="submit"
                    class="w-full bg-[#00A8A8] hover:bg-[#008f8f] active:scale-[.98] text-white py-3 rounded-xl font-semibold text-sm tracking-wide transition-all shadow-md hover:shadow-lg">
                    Simpan Password Baru
                </button>

            </form>

        </div>
    </div>
</div>

<script>
    // ===== TOGGLE PASSWORD VISIBILITY =====
    function togglePass(inputId, eyeId) {
        const input = document.getElementById(inputId);
        const eye   = document.getElementById(eyeId);
        if (input.type === 'password') {
            input.type = 'text';
            eye.textContent = '🙈';
        } else {
            input.type = 'password';
            eye.textContent = '👁️';
        }
    }

    // ===== PASSWORD STRENGTH =====
    const pwInput  = document.getElementById('new-password');
    const bars     = [1,2,3,4].map(i => document.getElementById('str-' + i));
    const strLabel = document.getElementById('str-label');

    const colors = ['bg-red-400', 'bg-orange-400', 'bg-yellow-400', 'bg-green-500'];
    const labels = ['Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];

    pwInput.addEventListener('input', () => {
        const val = pwInput.value;
        let score = 0;
        if (val.length >= 8)            score++;
        if (/[A-Z]/.test(val))          score++;
        if (/[0-9]/.test(val))          score++;
        if (/[^A-Za-z0-9]/.test(val))   score++;

        bars.forEach((bar, i) => {
            bar.className = 'h-1 flex-1 rounded-full transition-colors duration-300 ' +
                (i < score ? colors[score - 1] : 'bg-gray-200');
        });

        strLabel.textContent = val.length > 0 ? labels[score - 1] ?? '' : '';
    });

    // ===== CONFIRM MATCH =====
    const confirmInput = document.getElementById('confirm-password');
    const matchMsg     = document.getElementById('match-msg');
    const matchOk      = document.getElementById('match-ok');

    confirmInput.addEventListener('input', () => {
        if (!confirmInput.value) {
            matchMsg.classList.add('hidden');
            matchOk.classList.add('hidden');
            return;
        }
        const match = pwInput.value === confirmInput.value;
        matchMsg.classList.toggle('hidden', match);
        matchOk.classList.toggle('hidden', !match);
    });
</script>

@endsection
