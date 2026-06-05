@extends('layouts.auth')

@section('title', 'Daftar Akun — PT Katiga Veritas Indonesia')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-[#1E6B3D] to-[#3CDA7D] flex items-center justify-center p-4 py-10">

    <div class="w-full max-w-lg">

        {{-- BACK --}}
        <div class="text-center mb-6">
            <a href="/" class="inline-flex items-center gap-2 text-white/80 hover:text-white hover:bg-white/10 px-4 py-2 rounded-lg transition text-sm">
                ← Kembali ke Beranda
            </a>
        </div>

        {{-- CARD --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8">

            {{-- HEADER --}}
            <div class="text-center mb-7">
                <div class="w-16 h-16 bg-[#1E6B3D] text-white rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-lg">
                    <i class="fi fi-rr-shield-check"></i>
                </div>
                <h1 class="text-2xl font-bold text-[#1E6B3D]">Daftar Akun</h1>
                <p class="text-sm text-gray-500 mt-1">Buat akun untuk mengakses layanan kami</p>
            </div>

            {{-- ERROR VALIDASI --}}
            @if ($errors->any())
                <div class="mb-5 bg-red-50 border border-red-300 text-red-700 rounded-xl p-4 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            </a>

            {{-- SEPARATOR --}}
            <div class="flex items-center gap-3 mb-5">
                <hr class="flex-1 border-gray-200">
                <span class="text-xs text-gray-400 whitespace-nowrap">atau daftar dengan email</span>
                <hr class="flex-1 border-gray-200">
            </div>

            {{-- ===== PILIH JENIS AKUN ===== --}}
            <div class="mb-6">
                <p class="text-sm font-semibold text-gray-700 mb-3">Pilih Jenis Akun</p>
                <div class="grid grid-cols-2 gap-3">

                    {{-- INDIVIDU CARD --}}
                    <button type="button" id="card-individual"
                        onclick="switchType('individual')"
                        class="relative flex flex-col items-center gap-1 border-2 border-[#1E6B3D] bg-teal-50 rounded-xl p-4 text-center cursor-pointer transition-all hover:shadow-md focus:outline-none">
                        <span class="absolute top-2 right-2 text-[#1E6B3D] text-xs font-bold" id="check-individual"><i class="fi fi-rr-check"></i></span>
                        <span class="text-3xl text-emerald-600"><i class="fi fi-rr-user"></i></span>
                        <span class="text-sm font-semibold text-[#1E6B3D]">Individu</span>
                        <span class="text-xs text-gray-400">Perorangan / Personal</span>
                    </button>

                    {{-- PERUSAHAAN CARD --}}
                    <button type="button" id="card-company"
                        onclick="switchType('company')"
                        class="relative flex flex-col items-center gap-1 border-2 border-gray-200 bg-white rounded-xl p-4 text-center cursor-pointer transition-all hover:border-[#1E6B3D] hover:bg-teal-50 hover:shadow-md focus:outline-none">
                        <span class="absolute top-2 right-2 text-[#1E6B3D] text-xs font-bold hidden" id="check-company"><i class="fi fi-rr-check"></i></span>
                        <span class="text-3xl text-emerald-600"><i class="fi fi-rr-building"></i></span>
                        <span class="text-sm font-semibold text-[#1E6B3D]">Perusahaan</span>
                        <span class="text-xs text-gray-400">Badan Usaha / Institusi</span>
                    </button>

                </div>
            </div>

            {{-- ===== FORM ===== --}}
            <form method="POST" action="/register" id="register-form">
                @csrf
                <input type="hidden" name="user_type" id="hidden-user-type" value="{{ old('user_type', 'individual') }}">

                {{-- ============================================================
                     FORM INDIVIDU
                ============================================================ --}}
                <div id="form-individual" class="space-y-4">

                    {{-- Divider: Data Pribadi --}}
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gray-400">
                        <span class="flex-1 h-px bg-gray-200"></span>
                        Data Pribadi
                        <span class="flex-1 h-px bg-gray-200"></span>
                    </div>

                    {{-- NIK --}}
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">
                            NIK <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-id-card"></i></span>
                            <input id="nik" type="text" name="nik" value="{{ old('nik') }}"
                                placeholder="16 digit NIK sesuai KTP" maxlength="16"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition {{ $errors->has('nik') ? 'border-red-400' : '' }}">
                        </div>
                    </div>

                    {{-- Username (Nama Lengkap) --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                            Username / Nama Lengkap <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-user"></i></span>
                            <input id="username" type="text" name="username" value="{{ old('username') }}"
                                placeholder="Nama sesuai KTP"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition {{ $errors->has('username') ? 'border-red-400' : '' }}">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email-ind" class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-envelope"></i></span>
                            <input id="email-ind" type="email" name="email" value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition {{ $errors->has('email') ? 'border-red-400' : '' }}">
                        </div>
                    </div>

                    {{-- No. HP --}}
                    <div>
                        <label for="phone-ind" class="block text-sm font-medium text-gray-700 mb-1">
                            Nomor HP <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-smartphone"></i></span>
                            <input id="phone-ind" type="text" name="phone" value="{{ old('phone') }}"
                                placeholder="08xxxxxxxxxx"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition">
                        </div>
                    </div>

                    {{-- Divider: Keamanan --}}
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gray-400">
                        <span class="flex-1 h-px bg-gray-200"></span>
                        Keamanan Akun
                        <span class="flex-1 h-px bg-gray-200"></span>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password-ind" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-lock"></i></span>
                            <input id="password-ind" type="password" name="password"
                                placeholder="Minimal 8 karakter"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-10 py-2.5 text-sm focus:outline-none focus:border-[#00A8A8] focus:ring-2 focus:ring-teal-100 transition {{ $errors->has('password') ? 'border-red-400' : '' }}">
                            <button type="button" onclick="togglePassword('password-ind', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none flex items-center"><i class="fi fi-rr-eye"></i></button>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password-confirm-ind" class="block text-sm font-medium text-gray-700 mb-1">
                            Konfirmasi Password <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-lock"></i></span>
                            <input id="password-confirm-ind" type="password" name="password_confirmation"
                                placeholder="Ulangi password"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-10 py-2.5 text-sm focus:outline-none focus:border-[#00A8A8] focus:ring-2 focus:ring-teal-100 transition">
                            <button type="button" onclick="togglePassword('password-confirm-ind', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none flex items-center"><i class="fi fi-rr-eye"></i></button>
                        </div>
                    </div>

                </div>

                {{-- ============================================================
                     FORM PERUSAHAAN
                ============================================================ --}}
                <div id="form-company" class="hidden space-y-4">

                    {{-- Divider: Data Perusahaan --}}
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gray-400">
                        <span class="flex-1 h-px bg-gray-200"></span>
                        Data Perusahaan
                        <span class="flex-1 h-px bg-gray-200"></span>
                    </div>

                    {{-- Nama Perusahaan --}}
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Perusahaan <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-building"></i></span>
                            <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}"
                                placeholder="PT. Nama Perusahaan"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition {{ $errors->has('company_name') ? 'border-red-400' : '' }}">
                        </div>
                    </div>

                    {{-- Alamat Perusahaan --}}
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">
                            Alamat Perusahaan <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-marker"></i></span>
                            <textarea id="alamat" name="alamat" rows="2"
                                placeholder="Jl. Nama Jalan No. XX, Kota, Provinsi"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition resize-none">{{ old('alamat') }}</textarea>
                        </div>
                    </div>

                    {{-- NPWP --}}
                    <div>
                        <label for="npwp" class="block text-sm font-medium text-gray-700 mb-1">
                            NPWP Perusahaan <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-clipboard-list"></i></span>
                            <input id="npwp" type="text" name="npwp" value="{{ old('npwp') }}"
                                placeholder="xx.xxx.xxx.x-xxx.xxx"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition">
                        </div>
                    </div>

                    {{-- Bidang Usaha --}}
                    <div>
                        <label for="business_field" class="block text-sm font-medium text-gray-700 mb-1">
                            Bidang Usaha <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-briefcase"></i></span>
                            <input id="business_field" type="text" name="business_field" value="{{ old('business_field') }}"
                                placeholder="Misal: Konstruksi, Pertambangan, dll."
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition">
                        </div>
                    </div>

                    {{-- Divider: Data PIC --}}
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gray-400">
                        <span class="flex-1 h-px bg-gray-200"></span>
                        Penanggung Jawab (PIC)
                        <span class="flex-1 h-px bg-gray-200"></span>
                    </div>

                    {{-- Nama PIC --}}
                    <div>
                        <label for="pic_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nama PIC / Contact Person <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-user"></i></span>
                            <input id="pic_name" type="text" name="pic_name" value="{{ old('pic_name') }}"
                                placeholder="Nama penanggung jawab"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition {{ $errors->has('pic_name') ? 'border-red-400' : '' }}">
                        </div>
                    </div>

                    {{-- Jabatan PIC --}}
                    <div>
                        <label for="pic_position" class="block text-sm font-medium text-gray-700 mb-1">
                            Jabatan PIC <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-tag"></i></span>
                            <input id="pic_position" type="text" name="pic_position" value="{{ old('pic_position') }}"
                                placeholder="Misal: HRD Manager, Direktur"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition">
                        </div>
                    </div>

                    {{-- Divider: Kontak & Akses --}}
                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-widest text-gray-400">
                        <span class="flex-1 h-px bg-gray-200"></span>
                        Kontak &amp; Akses
                        <span class="flex-1 h-px bg-gray-200"></span>
                    </div>

                    {{-- Email Perusahaan --}}
                    <div>
                        <label for="email-com" class="block text-sm font-medium text-gray-700 mb-1">
                            Email Perusahaan <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-envelope"></i></span>
                            <input id="email-com" type="email" name="email" value="{{ old('email') }}"
                                placeholder="info@perusahaan.com"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition {{ $errors->has('email') ? 'border-red-400' : '' }}">
                        </div>
                    </div>

                    {{-- No. Telepon --}}
                    <div>
                        <label for="phone-com" class="block text-sm font-medium text-gray-700 mb-1">
                            No. Telepon <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-phone-call"></i></span>
                            <input id="phone-com" type="text" name="phone" value="{{ old('phone') }}"
                                placeholder="021-xxxxxxxx"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:border-[#1E6B3D] focus:ring-2 focus:ring-teal-100 transition">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password-com" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-lock"></i></span>
                            <input id="password-com" type="password" name="password"
                                placeholder="Minimal 8 karakter"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-10 py-2.5 text-sm focus:outline-none focus:border-[#00A8A8] focus:ring-2 focus:ring-teal-100 transition {{ $errors->has('password') ? 'border-red-400' : '' }}">
                            <button type="button" onclick="togglePassword('password-com', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none flex items-center"><i class="fi fi-rr-eye"></i></button>
                        </div>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div>
                        <label for="password-confirm-com" class="block text-sm font-medium text-gray-700 mb-1">
                            Konfirmasi Password <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none select-none flex items-center"><i class="fi fi-rr-lock"></i></span>
                            <input id="password-confirm-com" type="password" name="password_confirmation"
                                placeholder="Ulangi password"
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-10 py-2.5 text-sm focus:outline-none focus:border-[#00A8A8] focus:ring-2 focus:ring-teal-100 transition">
                            <button type="button" onclick="togglePassword('password-confirm-com', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none flex items-center"><i class="fi fi-rr-eye"></i></button>
                        </div>
                    </div>

                </div>

                {{-- AGREEMENT --}}
                <div class="flex items-start gap-2 text-sm mt-5">
                    <input type="checkbox" id="agreement" required
                        class="mt-0.5 w-4 h-4 accent-teal-500 shrink-0 cursor-pointer">
                    <label for="agreement" class="text-gray-600 leading-relaxed">
                        Saya setuju dengan
                        <a href="#" class="text-[#1E6B3D] hover:underline font-medium">Syarat &amp; Ketentuan</a>
                        dan
                        <a href="#" class="text-[#1E6B3D] hover:underline font-medium">Kebijakan Privasi</a>
                        PT Katiga Veritas Indonesia
                    </label>
                </div>

                {{-- SUBMIT BUTTON --}}
                <button type="submit"
                    class="w-full mt-5 bg-[#1E6B3D] hover:bg-[#3CDA7D] active:scale-[.98] text-white py-3 rounded-xl font-semibold text-sm tracking-wide transition-all shadow-md hover:shadow-lg">
                    Buat Akun
                </button>

            </form>

            {{-- LOGIN LINK --}}
            <div class="mt-5 text-center text-sm">
                <p class="text-gray-500">
                    Sudah punya akun?
                    <a href="/login" class="text-[#1E6B3D] font-semibold hover:underline">Login di sini</a>
                </p>
            </div>

        </div>
    </div>

</div>

<script>
    const ACTIVE_CARD   = ['border-[#1E6B3D]', 'bg-teal-50'];
    const INACTIVE_CARD = ['border-gray-200', 'bg-white'];

    function switchType(type) {
        const isIndividual = (type === 'individual');

        // Hidden input
        document.getElementById('hidden-user-type').value = type;

        // Cards
        const cardInd = document.getElementById('card-individual');
        const cardCom = document.getElementById('card-company');

        if (isIndividual) {
            ACTIVE_CARD.forEach(c => cardInd.classList.add(c));
            INACTIVE_CARD.forEach(c => cardInd.classList.remove(c));
            INACTIVE_CARD.forEach(c => cardCom.classList.add(c));
            ACTIVE_CARD.forEach(c => cardCom.classList.remove(c));
        } else {
            ACTIVE_CARD.forEach(c => cardCom.classList.add(c));
            INACTIVE_CARD.forEach(c => cardCom.classList.remove(c));
            INACTIVE_CARD.forEach(c => cardInd.classList.add(c));
            ACTIVE_CARD.forEach(c => cardInd.classList.remove(c));
        }

        // Checkmarks
        document.getElementById('check-individual').classList.toggle('hidden', !isIndividual);
        document.getElementById('check-company').classList.toggle('hidden', isIndividual);

        // Form sections
        const formInd = document.getElementById('form-individual');
        const formCom = document.getElementById('form-company');

        formInd.classList.toggle('hidden', !isIndividual);
        formCom.classList.toggle('hidden', isIndividual);

        // Enable / disable inputs so they don't submit when hidden
        formInd.querySelectorAll('input').forEach(el => el.disabled = !isIndividual);
        formCom.querySelectorAll('input').forEach(el => el.disabled = isIndividual);
    }

    // Init on page load — restore old('user_type') after validation error
    switchType('{{ old('user_type', 'individual') }}');

    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<i class="fi fi-rr-eye-crossed"></i>';
        } else {
            input.type = 'password';
            btn.innerHTML = '<i class="fi fi-rr-eye"></i>';
        }
    }
</script>

@endsection