@extends('layouts.auth')

@section('title', $title . ' — PT Katiga Veritas Indonesia')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-[#1E6B3D] to-[#3CDA7D] flex items-center justify-center p-4 py-10">
    <div class="w-full max-w-md">

        {{-- BACK --}}
        <div class="text-center mb-6">
            <a href="{{ $type === 'register' ? route('register') : route('password.request') }}"
               class="inline-flex items-center gap-2 text-white/80 hover:text-white hover:bg-white/10 px-4 py-2 rounded-lg transition text-sm">
                ← Kembali
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">

            {{-- HEADER --}}
            <div class="text-center mb-7">
                <div class="w-16 h-16 bg-[#1E6B3D] rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-lg">
                    📧
                </div>
                <h1 class="text-2xl font-bold text-[#1E6B3D]">{{ $title }}</h1>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">{{ $message }}</p>
            </div>

            {{-- EMAIL TARGET --}}
            <div class="flex items-center justify-center gap-2 bg-teal-50 border border-teal-200 rounded-xl px-4 py-3 mb-6">
                <span class="text-lg">📩</span>
                <span class="text-sm font-medium text-[#1E6B3D]">{{ $email }}</span>
            </div>

            {{-- INFO / ERROR --}}
            @if (session('info'))
                <div class="mb-5 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl px-4 py-3 text-sm flex items-start gap-2">
                    <span class="shrink-0 mt-0.5">ℹ️</span>
                    <span>{{ session('info') }}</span>
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

            {{-- OTP FORM --}}
            <form method="POST" action="{{ $action }}" id="otp-form">
                @csrf

                {{-- 6 Kotak OTP --}}
                <div class="flex justify-center gap-3 mb-6" id="otp-boxes">
                    @for ($i = 0; $i < 6; $i++)
                        <input
                            type="text"
                            inputmode="numeric"
                            pattern="[0-9]"
                            maxlength="1"
                            id="otp-{{ $i }}"
                            class="w-12 h-14 text-center text-xl font-bold border-2 border-gray-300 rounded-xl focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition caret-transparent"
                            autocomplete="off"
                        >
                    @endfor
                </div>

                {{-- Hidden input gabungan OTP --}}
                <input type="hidden" name="otp" id="otp-combined">

                {{-- TIMER --}}
                <div class="text-center mb-5">
                    <p class="text-sm text-gray-500">
                        Kode berlaku selama
                        <span id="timer" class="font-semibold text-[#1E6B3D]">10:00</span>
                    </p>
                </div>

                {{-- SUBMIT --}}
                <button type="submit" id="submit-btn"
                    class="w-full bg-[#1E6B3D] hover:bg-[#3CDA7D] active:scale-[.98] text-white py-3 rounded-xl font-semibold text-sm tracking-wide transition-all shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                    Verifikasi OTP
                </button>

            </form>

            {{-- RESEND --}}
            <div class="mt-5 text-center">
                <p class="text-sm text-gray-500 mb-2">Tidak menerima kode?</p>
                <form method="POST"
                      action="{{ $type === 'register' ? route('register.otp.resend') : route('password.otp.resend') }}">
                    @csrf
                    <button type="submit"
                        class="text-[#1E6B3D] font-semibold text-sm hover:underline disabled:text-gray-400 disabled:no-underline"
                        id="resend-btn">
                        Kirim ulang kode OTP
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    // ===== AUTO-FOCUS & INPUT NAVIGATION =====
    const inputs = Array.from({ length: 6 }, (_, i) => document.getElementById('otp-' + i));
    const combined = document.getElementById('otp-combined');
    const form     = document.getElementById('otp-form');

    inputs.forEach((input, idx) => {
        input.addEventListener('input', (e) => {
            // Hanya angka
            input.value = input.value.replace(/\D/g, '').slice(-1);

            if (input.value && idx < 5) {
                inputs[idx + 1].focus();
            }

            updateCombined();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && idx > 0) {
                inputs[idx - 1].focus();
                inputs[idx - 1].value = '';
                updateCombined();
            }
            // Arrow navigation
            if (e.key === 'ArrowLeft' && idx > 0) inputs[idx - 1].focus();
            if (e.key === 'ArrowRight' && idx < 5) inputs[idx + 1].focus();
        });

        // Handle paste (e.g. paste 6 digits at once)
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            pasted.split('').slice(0, 6).forEach((digit, i) => {
                if (inputs[i]) inputs[i].value = digit;
            });
            inputs[Math.min(pasted.length, 5)].focus();
            updateCombined();
        });
    });

    function updateCombined() {
        combined.value = inputs.map(i => i.value).join('');
    }

    // Submit via Enter di kotak terakhir
    inputs[5].addEventListener('keydown', (e) => {
        if (e.key === 'Enter') { updateCombined(); form.submit(); }
    });

    // Focus kotak pertama saat load
    inputs[0].focus();

    // ===== COUNTDOWN TIMER (10 menit) =====
    let seconds = 10 * 60;
    const timerEl  = document.getElementById('timer');
    const resendBtn = document.getElementById('resend-btn');

    function pad(n) { return String(n).padStart(2, '0'); }

    const interval = setInterval(() => {
        seconds--;
        if (seconds <= 0) {
            clearInterval(interval);
            timerEl.textContent = '00:00';
            timerEl.classList.replace('text-[#1E6B3D]', 'text-red-500');
        } else {
            timerEl.textContent = pad(Math.floor(seconds / 60)) + ':' + pad(seconds % 60);
        }
    }, 1000);
</script>

@endsection
