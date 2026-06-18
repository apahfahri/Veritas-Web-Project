@extends('layouts.admin')
@section('title', 'Edit Subadmin')
@section('page-title', 'Edit Subadmin')
@section('page-subtitle', 'Perbarui data akun dan akses staf operasional')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.subadmin.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <i class="fi fi-rr-arrow-left"></i>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30 text-center">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-3xl flex items-center justify-center shadow-sm mx-auto mb-4">
                <i class="fi fi-rr-edit w-8 h-8"></i>
            </div>
            <h2 class="text-xl font-black text-slate-900 tracking-tight">Edit Akun Staf</h2>
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Username: <span class="text-indigo-600">{{ $admin->username }}</span></p>
        </div>

        <form method="POST" action="{{ route('admin.subadmin.update', $admin->id_admin) }}" class="p-8 space-y-8">
            @csrf @method('PUT')

            <!-- SECTION 1: IDENTITAS LOGIN -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 bg-indigo-50/30 rounded-3xl border border-indigo-100/50">
                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-indigo-500 mb-2">
                        <i class="fi fi-rr-user"></i>
                        Username (ID Login Utama) *
                    </label>
                    <input type="text" name="username" value="{{ old('username', $admin->username) }}" required
                           class="w-full bg-white border border-indigo-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('username') border-red-400 @enderror">
                    @error('username')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-lock text-indigo-500"></i>
                        Ganti Password (Opsional)
                    </label>
                    <input type="password" name="password"
                           class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-check-circle text-indigo-500"></i>
                        Status Akun *
                    </label>
                    <select name="status" class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                        <option value="aktif" {{ old('status', $admin->status) === 'aktif' ? 'selected' : '' }}>Aktif (Dapat Login)</option>
                        <option value="nonaktif" {{ old('status', $admin->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif (Blokir Akses)</option>
                    </select>
                </div>
            </div>

            <!-- SECTION 2: KONTAK & INFORMASI -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-phone-call text-indigo-500"></i>
                        Nomor WhatsApp / Telp
                    </label>
                    <input type="text" name="no_telp" value="{{ old('no_telp', $admin->no_telp) }}" required
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-envelope text-indigo-500"></i>
                        Email Cadangan *
                    </label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <i class="fi fi-rr-building .5 .5 text-indigo-500"></i>
                        Cabang Operasional (Opsional)
                    </label>
                    <input type="text" name="cabang" value="{{ old('cabang', $admin->cabang) }}"
                           placeholder="Contoh: Pusat, Jakarta, Surabaya"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition @error('cabang') border-red-400 @enderror">
                    @error('cabang')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex flex-wrap gap-4 pt-8 border-t border-slate-50">
                <a href="{{ route('admin.subadmin.index') }}" class="px-8 py-4 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl text-sm font-black hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center justify-center gap-2 group">
                    <i class="fi fi-rr-check text-cyan-400 group-hover:scale-110 transition"></i>
                    Simpan Perubahan Data
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
