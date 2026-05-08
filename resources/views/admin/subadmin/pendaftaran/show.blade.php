@extends('layouts.admin-cabang')

@section('title', 'Detail & Konfirmasi Pendaftaran')
@section('page-title', 'Konfirmasi Pendaftaran #' . $pendaftaran->id)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 select-none">
    <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
        <h3 class="text-lg font-black text-slate-900 tracking-tight mb-4">Informasi Klien & Layanan</h3>

        <div class="space-y-4">
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Layanan</span>
                <p class="text-sm font-bold text-slate-800">{{ $pendaftaran->layanan?->nama }}</p>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Nama Klien</span>
                <p class="text-sm font-bold text-slate-800">{{ $pendaftaran->user?->username }}</p>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Email</span>
                <p class="text-sm font-bold text-slate-800">{{ $pendaftaran->user?->email }}</p>
            </div>
            <div>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Tanggal Pendaftaran</span>
                <p class="text-sm font-bold text-slate-800">{{ $pendaftaran->tanggal_daftar ? $pendaftaran->tanggal_daftar->format('d M Y') : '-' }}</p>
            </div>
        </div>
    </div>

    <!-- PENGINGAT KLIEN / REMINDER EMAIL -->
    <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
        <div class="flex justify-between items-start mb-4">
            <h3 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Pengingat Klien (Email Reminder)
            </h3>
        </div>

        @if($pendaftaran->last_reminder_sent_at)
            <div class="mb-6 bg-slate-50 border border-slate-200 rounded-2xl p-4">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Terakhir Diingatkan</span>
                <p class="text-sm font-bold text-slate-800 mt-1">{{ $pendaftaran->last_reminder_sent_at->format('d M Y, H:i') }}</p>
                
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mt-3">Detail Pesan Reminder Terakhir</span>
                <p class="text-sm font-medium text-slate-600 mt-1 bg-white p-3 rounded-xl border border-slate-100">{{ $pendaftaran->last_reminder_details }}</p>
            </div>
        @else
            <div class="mb-6 bg-slate-50 border border-slate-200 rounded-2xl p-4 text-center">
                <p class="text-sm font-medium text-slate-500">Belum ada reminder yang dicatat untuk klien ini.</p>
            </div>
        @endif

        <form method="POST" action="{{ route('admin-cabang.pendaftaran.send-reminder', $pendaftaran->id) }}">
            @csrf
            <div>
                <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-2">Catat Pengiriman Reminder Hari Ini</label>
                <textarea name="pesan_reminder" rows="3" placeholder="Contoh: Mengingatkan untuk segera melengkapi berkas ijazah..." required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-cyan-500 transition mb-3"></textarea>
                
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="flex-1 bg-slate-800 hover:bg-black text-white font-bold text-sm px-5 py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Catatan Reminder
                    </button>
                    
                    <a href="mailto:{{ $pendaftaran->user?->email }}?subject=Reminder%20Pendaftaran%20Katiga%20Veritas&body=Halo%20{{ urlencode($pendaftaran->user?->username) }},%0D%0A%0D%0AKami%20ingin%20mengingatkan%20terkait%20pendaftaran%20Anda." target="_blank" class="flex-1 bg-amber-50 hover:bg-amber-100 border border-amber-200/60 text-amber-700 font-bold text-sm px-5 py-3 rounded-xl shadow-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        Buka Gmail / Email App
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- UPDATE FORM / SIDEBAR -->
    <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm h-fit">
        <h3 class="text-lg font-black text-slate-900 tracking-tight mb-4">Aksi Verifikasi</h3>

        <form method="POST" action="{{ route('admin-cabang.pendaftaran.update', $pendaftaran->id) }}">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">Status Progres</label>
                    <select name="status_progres" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold outline-none focus:ring-2 focus:ring-cyan-500 transition">
                        <option value="menunggu" {{ $pendaftaran->status_progres == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diproses" {{ $pendaftaran->status_progres == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ $pendaftaran->status_progres == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="dibatalkan" {{ $pendaftaran->status_progres == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div>
                    <label class="text-xs font-extrabold text-slate-600 uppercase tracking-wider block mb-1">Status Bayar</label>
                    <select name="status_bayar" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold outline-none focus:ring-2 focus:ring-cyan-500 transition">
                        <option value="belum_bayar" {{ $pendaftaran->status_bayar == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="menunggu_konfirmasi" {{ $pendaftaran->status_bayar == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                        <option value="lunas" {{ $pendaftaran->status_bayar == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>

                <div class="flex items-center gap-3 bg-slate-50 border border-slate-100 p-4 rounded-2xl">
                    <input type="checkbox" name="dokumen_lengkap" value="1" id="chk_doc" {{ $pendaftaran->dokumen_lengkap ? 'checked' : '' }} class="w-5 h-5 accent-teal-600 rounded">
                    <label for="chk_doc" class="text-sm font-bold text-slate-700 select-none cursor-pointer">
                        Dokumen Lengkap
                    </label>
                </div>

                <button type="submit" class="w-full mt-2 bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-extrabold text-sm px-6 py-3.5 rounded-xl shadow-lg transition">
                    Simpan Perubahan
                </button>

                <a href="{{ route('admin-cabang.pendaftaran.index') }}" class="w-full block text-center bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-sm px-6 py-3.5 rounded-xl transition">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
