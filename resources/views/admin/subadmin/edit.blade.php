@extends('layouts.admin')
@section('title', 'Edit Subadmin')
@section('page-title', 'Edit Subadmin')
@section('page-subtitle', 'Perbarui data akun dan akses staf operasional')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.subadmin.index') }}" class="inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase tracking-widest transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 border-b border-slate-50 bg-slate-50/30 text-center">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-3xl flex items-center justify-center shadow-sm mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
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
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Username (ID Login Utama) *
                    </label>
                    <input type="text" name="username" value="{{ old('username', $admin->username) }}" required
                           class="w-full bg-white border border-indigo-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 focus:outline-none transition @error('username') border-red-400 @enderror">
                    @error('username')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Ganti Password (Opsional)
                    </label>
                    <input type="password" name="password"
                           class="w-full bg-white border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                    <p class="text-[9px] text-indigo-400 font-bold mt-2 uppercase tracking-widest">💡 Kosongkan jika tidak ingin mengganti password staf</p>
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        Nomor WhatsApp / Telp
                    </label>
                    <input type="text" name="no_telp" value="{{ old('no_telp', $admin->no_telp) }}"
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition">
                    <p class="text-[9px] text-slate-400 font-bold mt-2 uppercase tracking-widest">Media koordinasi utama</p>
                </div>

                <div>
                    <label class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Email Cadangan *
                    </label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                           class="w-full bg-slate-50 border border-slate-200 px-5 py-3 rounded-2xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:outline-none transition @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">{{ $message }}</p>@enderror
                    <p class="text-[9px] text-slate-400 font-bold mt-2 uppercase tracking-widest">Digunakan untuk notifikasi sistem</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-4 pt-8 border-t border-slate-50">
                <a href="{{ route('admin.subadmin.index') }}" class="px-8 py-4 text-sm font-black text-slate-400 hover:text-slate-600 transition">Batal</a>
                <button type="submit" class="flex-1 bg-slate-900 text-white py-4 rounded-2xl text-sm font-black hover:bg-slate-800 transition shadow-lg shadow-slate-200 flex items-center justify-center gap-2 group">
                    <svg class="w-5 h-5 text-cyan-400 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan Data
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
