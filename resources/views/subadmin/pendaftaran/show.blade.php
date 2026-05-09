@extends('layouts.subadmin')

@section('title', 'Detail & Konfirmasi Pendaftaran')
@section('page-title', 'Konfirmasi Pendaftaran #' . $pendaftaran->id_pendaftaran)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 select-none">
    <div class="lg:col-span-2 space-y-8">
        <!-- Informasi Klien & Layanan -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <h3 class="text-lg font-black text-slate-900 tracking-tight mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Informasi Lengkap Klien
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap</span>
                    <p class="text-sm font-bold text-slate-800">{{ $pendaftaran->user?->nama }}</p>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Pendidikan Terakhir</span>
                    <p class="text-sm font-bold text-slate-800">{{ $pendaftaran->user?->pendidikan ?? '-' }}</p>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Nomor Telepon / WA</span>
                    <p class="text-sm font-bold text-slate-800">{{ $pendaftaran->user?->no_telp }}</p>
                </div>
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Alamat Email</span>
                    <p class="text-sm font-bold text-slate-800">{{ $pendaftaran->user?->email }}</p>
                </div>
                <div class="md:col-span-2 pt-4 border-t border-slate-50">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Layanan Yang Dipesan</span>
                    <p class="text-base font-black text-cyan-700 mt-1">{{ $pendaftaran->layanan?->nama }}</p>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Daftar pada: {{ $pendaftaran->tanggal_daftar ? $pendaftaran->tanggal_daftar->format('d M Y') : '-' }}</p>
                </div>
            </div>
        </div>

        <!-- HUBUNGI KLIEN VIA WA -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <h3 class="text-lg font-black text-slate-900 tracking-tight mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                Kontak WhatsApp
            </h3>
            <p class="text-sm text-slate-500 mb-6">Gunakan template di bawah untuk menghubungi klien secara langsung terkait pendaftaran mereka.</p>

            @php
                $no_telp = $pendaftaran->user?->no_telp ?? '';
                $clean_telp = preg_replace('/\D/', '', $no_telp);
                if (str_starts_with($clean_telp, '0')) {
                    $clean_telp = '62' . substr($clean_telp, 1);
                }
                $wa_message = "Halo " . ($pendaftaran->user?->nama ?? 'Bapak/Ibu') . ",\n\nKami dari Katiga Veritas ingin mengonfirmasi pendaftaran Anda pada layanan " . ($pendaftaran->layanan?->nama ?? '') . ". Apakah ada yang bisa kami bantu terkait proses administrasinya?";
            @endphp

            <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100 mb-6">
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest block mb-2">Template Pesan:</span>
                <p class="text-sm italic text-emerald-800">"{{ $wa_message }}"</p>
            </div>

            <a href="https://wa.me/{{ $clean_telp }}?text={{ urlencode($wa_message) }}" target="_blank" class="inline-flex items-center gap-3 bg-emerald-500 hover:bg-emerald-600 text-white font-black text-sm px-8 py-4 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all hover:scale-[1.02] active:scale-95">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                Kirim Pesan Sekarang
            </a>
        </div>
    </div>

    <!-- UPDATE FORM & ADMIN NOTES -->
    <div class="space-y-8">
        <!-- Aksi Verifikasi -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <h3 class="text-lg font-black text-slate-900 tracking-tight mb-6">Status Pendaftaran</h3>

            <form method="POST" action="{{ route('subadmin.pendaftaran.update', ['id' => $pendaftaran->id_pendaftaran, 'context' => request('context')]) }}">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <div>
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] block mb-2">Progres Layanan</label>
                        <select name="status_progres" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-3.5 text-sm font-bold outline-none focus:ring-4 focus:ring-cyan-500/10 transition">
                            <option value="menunggu" {{ $pendaftaran->status_progres == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="menunggu_pembayaran" {{ $pendaftaran->status_progres == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="diproses" {{ $pendaftaran->status_progres == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $pendaftaran->status_progres == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ $pendaftaran->status_progres == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] block mb-2">Status Pembayaran</label>
                        <select name="status_bayar" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-3.5 text-sm font-bold outline-none focus:ring-4 focus:ring-cyan-500/10 transition">
                            <option value="belum_bayar" {{ $pendaftaran->status_bayar == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="lunas" {{ $pendaftaran->status_bayar == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full mt-4 bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-black text-sm px-6 py-4 rounded-2xl shadow-xl shadow-cyan-600/20 transition-all hover:scale-[1.02]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Catatan Admin (Internal) -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Catatan Internal
            </h3>
            <p class="text-xs text-slate-400 font-medium mb-6">Catatan ini hanya terlihat oleh admin cabang (contoh: "User akan bayar tgl 15").</p>

            @if($pendaftaran->last_reminder_sent_at)
                <div class="mb-6 p-4 bg-amber-50/50 border border-amber-100 rounded-2xl">
                    <span class="text-[9px] font-black text-amber-600 uppercase tracking-widest block mb-1">Terakhir Diperbarui:</span>
                    <p class="text-xs font-bold text-slate-700 mb-3">{{ $pendaftaran->last_reminder_sent_at->format('d M Y, H:i') }}</p>
                    <p class="text-sm font-medium text-slate-600 leading-relaxed italic bg-white p-3 rounded-xl border border-amber-100">"{{ $pendaftaran->last_reminder_details }}"</p>
                </div>
            @endif

            <form method="POST" action="{{ route('subadmin.pendaftaran.update-note', ['id' => $pendaftaran->id_pendaftaran, 'context' => request('context')]) }}">
                @csrf
                <textarea name="admin_note" rows="4" placeholder="Tulis catatan penting di sini..." required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-3.5 text-sm font-medium outline-none focus:ring-4 focus:ring-amber-500/10 transition mb-4"></textarea>
                
                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-black text-xs px-6 py-3.5 rounded-2xl transition shadow-lg">
                    Perbarui Catatan
                </button>
            </form>
        </div>

        @php
            $backRoute = route('subadmin.pendaftaran.index');
            $context = request('context');
            if ($context == 'pelatihan') $backRoute = route('subadmin.pelatihan.index');
            elseif ($context == 'konsultasi') $backRoute = route('subadmin.konsultasi.index');
            elseif ($context == 'audit') $backRoute = route('subadmin.audit.index');
        @endphp
        <a href="{{ $backRoute }}" class="w-full block text-center bg-slate-100 hover:bg-slate-200 text-slate-600 font-black text-xs px-6 py-4 rounded-2xl transition">
            Kembali
        </a>
    </div>
</div>
@endsection
