@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-6">
        
        <!-- Header -->
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Pengaturan Profil</h1>
            <p class="text-gray-500">Kelola informasi pribadi dan keamanan akun Anda</p>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in">
                <span class="text-xl">✅</span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-sm">
                <ul class="list-disc ml-5 space-y-1 text-sm font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- Informasi Dasar -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-[#7d2ae7] to-[#3969e7] px-8 py-6">
                    <h2 class="text-xl font-bold text-white flex items-center gap-3">
                        <span>👤</span> Informasi Akun
                    </h2>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition-all outline-none" required>
                            @error('name') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition-all outline-none" required>
                            @error('email') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Spesifik (Individu / Perusahaan) -->
            @if($user->klienIndividu)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-8 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-3">
                        <span>🆔</span> Detail Identitas (Individu)
                    </h2>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">NIK (KTP)</label>
                            <input type="text" name="nik" value="{{ old('nik', $individu->nik) }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition-all outline-none">
                            @error('nik') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $individu->no_hp) }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition-all outline-none">
                            @error('no_hp') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if($user->klienPerusahaan)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-8 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-3">
                        <span>🏢</span> Detail Perusahaan
                    </h2>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Perusahaan</label>
                            <input type="text" name="nama_perusahaan" value="{{ old('nama_perusahaan', $perusahaan->nama ?? '') }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition-all outline-none">
                            @error('nama_perusahaan') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ old('jabatan', $perusahaanProfil->jabatan ?? '') }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition-all outline-none">
                            @error('jabatan') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">NIB OSS</label>
                            <input type="text" name="nib_oss" value="{{ old('nib_oss', $perusahaan->nib_oss ?? '') }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition-all outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">NPWP Perusahaan</label>
                            <input type="text" name="npwp_perusahaan" value="{{ old('npwp_perusahaan', $perusahaan->npwp_perusahaan ?? '') }}" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition-all outline-none">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Keamanan -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-8 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-3">
                        <span>🔒</span> Konfirmasi Kata Sandi
                    </h2>
                </div>
                
                <div class="p-8 space-y-6">
                    <p class="text-sm text-gray-500 mb-4">Kosongkan jika tidak ingin mengganti kata sandi.</p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Baru</label>
                            <input type="password" name="password" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition-all outline-none">
                            @error('password') <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" 
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#7d2ae7] focus:border-transparent transition-all outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end gap-4 pt-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition-colors">Batal</a>
                <button type="submit" 
                    class="bg-gradient-to-r from-[#7d2ae7] to-[#3969e7] text-white px-10 py-3 rounded-xl font-bold shadow-lg shadow-[#7d2ae7]/30 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
