@extends('layouts.auth')

@section('title', 'Login — Katiga Veritas Indonesia')

@section('content')

<div class="min-h-screen bg-slate-50 flex items-center justify-center p-6 relative overflow-hidden">
    <!-- BACKGROUND DECORATION -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 via-cyan-400 to-indigo-500"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-cyan-50 rounded-full blur-3xl opacity-50"></div>

    <div class="w-full max-w-md relative">

        <!-- LOGO / BACK -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2 text-slate-400 hover:text-indigo-600 font-black text-[10px] uppercase tracking-widest transition group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- LOGIN CARD -->
        <div class="bg-white rounded-[40px] shadow-2xl shadow-indigo-100/50 border border-slate-100 p-10">

            <!-- HEADER -->
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-slate-900 text-white rounded-3xl flex items-center justify-center shadow-xl mx-auto mb-6 transform -rotate-3">
                    <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>

                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Login Portal</h2>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-2">
                    PT Katiga Veritas Indonesia
                </p>
            </div>

            <!-- STATUS MESSAGES -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-100 text-red-600 rounded-2xl p-4">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="text-[11px] font-black uppercase tracking-tighter flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="mb-6 bg-indigo-50 border border-indigo-100 text-indigo-600 rounded-2xl p-4 text-[11px] font-black uppercase tracking-widest text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="/login" class="space-y-6">
                @csrf

                <!-- LOGIN INPUT -->
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 ml-1">Username / Email Staf</label>
                    <div class="relative group">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </span>
                        <input
                            type="text"
                            name="login"
                            value="{{ old('login') }}"
                            placeholder="Ketik username Anda..."
                            required
                            class="w-full bg-slate-50 border border-slate-100 px-14 py-4 rounded-2xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all @error('login') border-red-400 @enderror"
                        >
                    </div>
                </div>

                <!-- PASSWORD -->
                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Security Password</label>
                    </div>
                    <div class="relative group">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <input
                            id="login-password"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full bg-slate-50 border border-slate-100 px-14 py-4 rounded-2xl text-sm font-bold text-slate-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:bg-white transition-all"
                        >
                        <button type="button" onclick="togglePassword('login-password', this)" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 focus:outline-none p-1 rounded-lg transition">
                            <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- REMEMBER ME -->
                <div class="flex items-center">
                    <label class="flex items-center gap-3 cursor-pointer group select-none">
                        <div class="relative">
                            <input type="checkbox" name="remember_me" class="sr-only peer">
                            <div class="w-10 h-6 bg-slate-100 rounded-full peer peer-checked:bg-indigo-600 transition-colors"></div>
                            <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-4"></div>
                        </div>
                        <span class="text-[11px] font-black text-slate-400 uppercase tracking-widest group-hover:text-slate-600 transition">Ingat Akun Saya</span>
                    </label>
                </div>

                <!-- SUBMIT BUTTON -->
                <button
                    type="submit"
                    class="w-full bg-slate-900 text-white py-5 rounded-2xl text-sm font-black hover:bg-slate-800 transform active:scale-[0.98] transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-3 group"
                >
                    <span class="uppercase tracking-widest">Masuk Sekarang</span>
                    <svg class="w-5 h-5 text-cyan-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </button>

            </form>
        </div>

        <!-- FOOTER -->
        <div class="mt-10 text-center">
            <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.2em]">© 2024 PT Katiga Veritas Indonesia • All Rights Reserved</p>
        </div>
    </div>
</div>

<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('#eye-icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.024 10.024 0 014.13-5.326m9.404 9.404l-2.004-2.004m-1.414-1.414l-4.242-4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>`;
        } else {
            input.type = 'password';
            icon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
        }
    }
</script>

@endsection