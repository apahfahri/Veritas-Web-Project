@extends('layouts.subadmin')

@section('title', 'Tambah Klien')
@section('page-title', 'Tambah Profil Klien Baru')

@section('content')
<div class="max-w-4xl">
    <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
        <form action="{{ route('subadmin.klien.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- User Account -->
                <div class="md:col-span-2">
                    <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">Akun User Terkait</label>
                    <select name="user_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none appearance-none" required>
                        <option value="" disabled selected>Pilih Akun User...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id_user }}">{{ $user->nama }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Personal Info -->
                <div class="space-y-6">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-2">Informasi Pribadi</h4>
                    
                    <div>
                        <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">Nama Lengkap (Sesuai KTP)</label>
                        <input type="text" name="nama_lengkap" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div>
                        <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">NIK (16 Digit)</label>
                        <input type="text" name="nik" maxlength="16" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none" placeholder="Masukkan NIK">
                    </div>

                    <div>
                        <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">Nomor WhatsApp</label>
                        <input type="text" name="no_hp" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none" placeholder="Contoh: 08123456789">
                    </div>
                </div>

                <!-- Company Integration -->
                <div class="space-y-6">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-2">Afiliasi Perusahaan (Opsional)</h4>
                    
                    <div>
                        <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">Perusahaan / Mitra</label>
                        <select name="id_perusahaan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none appearance-none">
                            <option value="">-- Mandiri / Tidak Ada --</option>
                            @foreach($perusahaans as $p)
                                <option value="{{ $p->id_perusahaan }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-extrabold text-slate-500 uppercase tracking-widest block mb-2">Jabatan</label>
                        <input type="text" name="jabatan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 text-sm font-bold focus:ring-2 focus:ring-cyan-500 transition outline-none" placeholder="Contoh: Staff HRD / Safety Officer">
                    </div>

                    <div class="bg-amber-50 rounded-2xl p-4 border border-amber-100">
                        <p class="text-[10px] text-amber-700 font-bold leading-relaxed">
                            <span class="block mb-1 underline">CATATAN:</span>
                            Jika klien adalah utusan perusahaan, pastikan memilih perusahaan yang benar untuk sinkronisasi penagihan dan laporan.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-8 border-t border-slate-50 flex items-center gap-4">
                <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white font-black text-sm px-10 py-4 rounded-xl shadow-lg transition">
                    Simpan Profil Klien
                </button>
                <a href="{{ route('subadmin.klien.index') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

