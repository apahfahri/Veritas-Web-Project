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

        <!-- HUBUNGI KLIEN VIA WA & BUKTI BAYAR -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    Aksi Layanan
                </h3>
                <div class="flex gap-2">
                    @if($pendaftaran->status_bayar == 'lunas')
                        <button onclick="showUploadModal()" class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold text-xs px-4 py-2 rounded-xl transition flex items-center gap-2 border border-indigo-100">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            {{ $pendaftaran->bukti_bayar ? 'Update Bukti' : 'Upload Bukti Bayar' }}
                        </button>
                    @else
                        <button onclick="showInvoice()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-4 py-2 rounded-xl transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Pratinjau Invoice
                        </button>
                    @endif
                </div>
            </div>

            @if($pendaftaran->bukti_bayar)
                <div class="mb-6 p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Bukti Pembayaran Terlampir:</span>
                    <div class="relative group cursor-pointer overflow-hidden rounded-xl border border-slate-200 shadow-sm max-w-sm" onclick="window.open('{{ asset('uploads/pembayaran/' . $pendaftaran->bukti_bayar) }}', '_blank')">
                        <img src="{{ asset('uploads/pembayaran/' . $pendaftaran->bukti_bayar) }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                            <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-4 py-2 rounded-full border border-white/30">Klik untuk Memperbesar</span>
                        </div>
                    </div>
                </div>
            @endif

            <p class="text-sm text-slate-500 mb-6">Template WhatsApp untuk menghubungi klien terkait pendaftaran ini.</p>

            @php
                $no_telp = $pendaftaran->user?->no_telp ?? '';
                $clean_telp = preg_replace('/\D/', '', $no_telp);
                if (str_starts_with($clean_telp, '0')) {
                    $clean_telp = '62' . substr($clean_telp, 1);
                }
                
                $nama = $pendaftaran->user?->nama ?? 'Bapak/Ibu';
                $layanan_nama = $pendaftaran->layanan?->nama ?? 'layanan kami';
                $id_reg = $pendaftaran->id_pendaftaran;
                
                // Menentukan template pesan berdasarkan status
                if ($pendaftaran->status_progres == 'menunggu') {
                    $wa_message = "Halo $nama,\n\nKami dari Katiga Veritas telah menerima pendaftaran Anda pada layanan $layanan_nama (#$id_reg). Silakan melakukan pembayaran agar kami dapat segera memproses pendaftaran Anda. Berikut adalah rincian invoice pendaftaran Anda.\n\nTerima kasih!";
                } elseif ($pendaftaran->status_bayar == 'belum_bayar' || $pendaftaran->status_progres == 'menunggu_pembayaran') {
                    $wa_message = "Halo $nama,\n\nKami mengingatkan kembali terkait pendaftaran Anda pada layanan $layanan_nama (#$id_reg). Mohon segera melakukan pembayaran dan mengirimkan bukti transfer di sini agar kami dapat melanjutkan ke tahap pemrosesan. Terima kasih!";
                } elseif ($pendaftaran->status_progres == 'diproses') {
                    $wa_message = "Halo $nama,\n\nTerima kasih telah melakukan pembayaran. Pendaftaran Anda pada layanan $layanan_nama (#$id_reg) saat ini sedang kami proses. Kami akan segera mengonfirmasi jadwal pelaksanaan kepada Anda. Mohon ditunggu ya!";
                } elseif ($pendaftaran->status_progres == 'selesai') {
                    $wa_message = "Halo $nama,\n\nSelamat! Pendaftaran Anda pada layanan $layanan_nama (#$id_reg) telah selesai diproses. Anda sekarang dapat mengakses layanan tersebut sesuai jadwal. Terima kasih telah memilih Katiga Veritas!";
                } else {
                    $wa_message = "Halo $nama,\n\nKami dari Katiga Veritas ingin mengonfirmasi status pendaftaran Anda pada layanan $layanan_nama (#$id_reg). Apakah ada yang bisa kami bantu?";
                }
            @endphp

            <div class="bg-emerald-50 rounded-2xl p-6 border border-emerald-100 mb-6 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform duration-500 text-emerald-600">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                </div>
                <span class="text-[10px] font-black text-emerald-600 uppercase tracking-widest block mb-2">Template Pesan WA:</span>
                <p class="text-sm italic text-emerald-800 leading-relaxed font-medium">"{{ $wa_message }}"</p>
            </div>

            <a href="https://wa.me/{{ $clean_telp }}?text={{ urlencode($wa_message) }}" target="_blank" class="inline-flex items-center gap-3 bg-emerald-500 hover:bg-emerald-600 text-white font-black text-sm px-8 py-4 rounded-2xl shadow-lg shadow-emerald-500/20 transition-all hover:scale-[1.02] active:scale-95">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                Hubungi via WhatsApp
            </a>
        </div>
    </div>

    <!-- UPDATE FORM & ADMIN NOTES -->
    <div class="lg:col-span-1 space-y-8">
        <!-- Aksi Verifikasi -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <h3 class="text-lg font-black text-slate-900 tracking-tight mb-8">Status Pendaftaran</h3>

            <form id="statusUpdateForm" method="POST" action="{{ route('subadmin.pendaftaran.update', ['id' => $pendaftaran->id_pendaftaran, 'context' => request('context')]) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="status_progres" id="input_status_progres" value="{{ $pendaftaran->status_progres }}">
                <input type="hidden" name="status_bayar" id="input_status_bayar" value="{{ $pendaftaran->status_bayar }}">

                <div class="space-y-10">
                    <!-- Progres Layanan Buttons -->
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-4">Progres Layanan</label>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 mb-6 flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-black text-slate-800 uppercase tracking-wide">
                                    @if($pendaftaran->status_progres == 'menunggu') Menunggu Konfirmasi
                                    @elseif($pendaftaran->status_progres == 'menunggu_pembayaran') Menunggu Pembayaran
                                    @elseif($pendaftaran->status_progres == 'diproses') Dalam Proses
                                    @elseif($pendaftaran->status_progres == 'selesai') Selesai
                                    @else {{ ucfirst($pendaftaran->status_progres) }}
                                    @endif
                                </span>
                                <div class="flex gap-1">
                                    <div class="w-1.5 h-1.5 rounded-full {{ $pendaftaran->status_progres == 'menunggu' ? 'bg-cyan-500 animate-pulse' : 'bg-slate-200' }}"></div>
                                    <div class="w-1.5 h-1.5 rounded-full {{ $pendaftaran->status_progres == 'menunggu_pembayaran' ? 'bg-cyan-500 animate-pulse' : 'bg-slate-200' }}"></div>
                                    <div class="w-1.5 h-1.5 rounded-full {{ $pendaftaran->status_progres == 'diproses' ? 'bg-cyan-500 animate-pulse' : 'bg-slate-200' }}"></div>
                                    <div class="w-1.5 h-1.5 rounded-full {{ $pendaftaran->status_progres == 'selesai' ? 'bg-emerald-500 shadow-sm shadow-emerald-500/50' : 'bg-slate-200' }}"></div>
                                </div>
                            </div>
                            <div class="h-1.5 w-full bg-slate-200 rounded-full overflow-hidden">
                                @php
                                    $progressPercent = [
                                        'menunggu' => 25,
                                        'menunggu_pembayaran' => 50,
                                        'diproses' => 75,
                                        'selesai' => 100
                                    ][$pendaftaran->status_progres] ?? 0;
                                @endphp
                                <div class="h-full bg-cyan-500 transition-all duration-1000" style="width: {{ $progressPercent }}%"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-3">
                            @php
                                $statusList = ['menunggu', 'menunggu_pembayaran', 'diproses', 'selesai'];
                                $currentIndex = array_search($pendaftaran->status_progres, $statusList);
                                $prevStatus = ($currentIndex > 0) ? $statusList[$currentIndex - 1] : null;
                                $nextStatus = ($currentIndex !== false && $currentIndex < count($statusList) - 1) ? $statusList[$currentIndex + 1] : null;
                                
                                $statusLabels = [
                                    'menunggu' => 'Menunggu Konfirmasi',
                                    'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                    'diproses' => 'Diproses',
                                    'selesai' => 'Selesai',
                                    'dibatalkan' => 'Batalkan Pendaftaran'
                                ];
                            @endphp

                            @if($nextStatus)
                                <button type="button" 
                                    onclick="confirmStatus('status_progres', '{{ $nextStatus }}', '{{ $statusLabels[$nextStatus] }}')" 
                                    class="w-full flex items-center justify-between bg-cyan-600 hover:bg-cyan-700 text-white font-black text-xs px-5 py-4 rounded-2xl shadow-xl shadow-cyan-600/20 transition-all hover:translate-y-[-2px] {{ ($nextStatus == 'selesai' && $pendaftaran->status_bayar != 'lunas') ? 'opacity-50 cursor-not-allowed grayscale' : '' }}"
                                    {{ ($nextStatus == 'selesai' && $pendaftaran->status_bayar != 'lunas') ? 'disabled' : '' }}>
                                    <span>Lanjut ke: {{ $statusLabels[$nextStatus] }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </button>
                                @if($nextStatus == 'selesai' && $pendaftaran->status_bayar != 'lunas')
                                    <p class="text-[9px] text-red-500 font-bold mt-1 leading-tight italic">* Pembayaran harus Lunas untuk menyelesaikan pendaftaran.</p>
                                @endif
                            @endif

                            @if($prevStatus)
                                <button type="button" onclick="confirmStatus('status_progres', '{{ $prevStatus }}', '{{ $statusLabels[$prevStatus] }}')" class="w-full flex items-center justify-between bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs px-5 py-4 rounded-2xl transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path></svg>
                                    <span>Kembali ke: {{ $statusLabels[$prevStatus] }}</span>
                                </button>
                            @endif

                            <div class="h-px bg-slate-50 my-2"></div>

                            <button type="button" onclick="confirmDelete()" class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 font-black text-[10px] px-5 py-3.5 rounded-2xl transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Hapus Pendaftaran
                            </button>
                        </div>
                    </div>

                    <!-- Status Pembayaran Buttons -->
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] block mb-4">Status Pembayaran</label>
                        <div class="flex gap-2">
                            <button type="button" 
                                onclick="confirmStatus('status_bayar', 'belum_bayar', 'Belum Bayar')"
                                class="flex-1 py-4 rounded-2xl text-[10px] font-black transition-all border-2 {{ $pendaftaran->status_bayar == 'belum_bayar' ? 'bg-amber-500 border-amber-500 text-white shadow-lg shadow-amber-500/30' : 'bg-white border-slate-100 text-slate-400 hover:bg-slate-50' }}">
                                BELUM BAYAR
                            </button>
                            <button type="button" 
                                onclick="confirmStatus('status_bayar', 'lunas', 'Lunas')"
                                class="flex-1 py-4 rounded-2xl text-[10px] font-black transition-all border-2 {{ $pendaftaran->status_bayar == 'lunas' ? 'bg-emerald-500 border-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-white border-slate-100 text-slate-400 hover:bg-slate-50' }}">
                                LUNAS
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Catatan Subadmin (Internal) -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
            <h3 class="text-lg font-black text-slate-900 tracking-tight mb-2 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Catatan Internal
            </h3>
            <p class="text-xs text-slate-400 font-medium mb-6">Hanya terlihat oleh tim subadmin.</p>

            @if($pendaftaran->last_reminder_sent_at)
                <div class="mb-6 p-4 bg-amber-50/50 border border-amber-100 rounded-2xl">
                    <span class="text-[9px] font-black text-amber-600 uppercase tracking-widest block mb-1">Terakhir Diperbarui:</span>
                    <p class="text-xs font-bold text-slate-700 mb-3">{{ $pendaftaran->last_reminder_sent_at->format('d M Y, H:i') }}</p>
                    <p class="text-sm font-medium text-slate-600 leading-relaxed italic bg-white p-3 rounded-xl border border-amber-100">"{{ $pendaftaran->last_reminder_details }}"</p>
                </div>
            @endif

            <form method="POST" action="{{ route('subadmin.pendaftaran.update-note', ['id' => $pendaftaran->id_pendaftaran, 'context' => request('context')]) }}">
                @csrf
                <textarea name="admin_note" rows="3" placeholder="Tulis catatan penting di sini..." required class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-3.5 text-sm font-medium outline-none focus:ring-4 focus:ring-amber-500/10 transition mb-4"></textarea>
                
                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-black text-[10px] px-6 py-3.5 rounded-2xl transition shadow-lg">
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
            Kembali Ke Daftar
        </a>
    </div>
</div>

<!-- MODAL UPLOAD BUKTI -->
<div id="uploadModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="hideUploadModal()"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-8 text-center">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-2">Upload Bukti Bayar</h3>
                <p class="text-sm text-slate-500 mb-8 leading-relaxed">Pilih foto bukti transfer atau screenshot pembayaran dari klien.</p>

                <form action="{{ route('subadmin.pendaftaran.upload-payment-proof', $pendaftaran->id_pendaftaran) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div class="relative group">
                        <input type="file" name="bukti_bayar" id="bukti_bayar_input" accept="image/*" required class="hidden" onchange="updateFileName(this)">
                        <label for="bukti_bayar_input" class="flex flex-col items-center justify-center w-full h-44 border-2 border-dashed border-slate-200 rounded-[2rem] cursor-pointer hover:bg-slate-50 hover:border-indigo-300 transition-all group-active:scale-95">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-slate-400 group-hover:text-indigo-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p id="fileNameDisplay" class="text-xs text-slate-500 font-black uppercase tracking-widest group-hover:text-indigo-600 transition">Pilih File Gambar</p>
                                <p class="text-[9px] text-slate-400 mt-2 uppercase tracking-[0.2em]">JPG, PNG, JPEG (MAX 2MB)</p>
                            </div>
                        </label>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="hideUploadModal()" class="flex-1 px-6 py-4 bg-white border border-slate-100 text-slate-400 font-black text-[10px] rounded-2xl hover:bg-slate-50 transition uppercase tracking-widest">Batal</button>
                        <button type="submit" class="flex-1 px-6 py-4 bg-indigo-600 text-white font-black text-[10px] rounded-2xl hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition uppercase tracking-widest">Unggah Bukti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL INVOICE -->
<div id="invoiceModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="hideInvoice()"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div id="invoiceContent" class="p-12 bg-white">
                <!-- Header Invoice -->
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <div class="w-12 h-12 bg-cyan-600 rounded-xl flex items-center justify-center text-white font-black text-xl mb-4 shadow-lg shadow-cyan-600/30">KV</div>
                        <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter">Invoice Pendaftaran</h2>
                        <p class="text-sm font-bold text-slate-400 tracking-tight">#INV-{{ date('Y') }}-{{ $pendaftaran->id_pendaftaran }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Terbit</p>
                        <p class="text-sm font-bold text-slate-800">{{ now()->format('d F Y') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-12 mb-12">
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Ditagihkan Kepada:</p>
                        <p class="text-sm font-black text-slate-900 leading-tight mb-1">{{ $pendaftaran->user?->nama }}</p>
                        <p class="text-xs font-medium text-slate-500">{{ $pendaftaran->user?->email }}</p>
                        <p class="text-xs font-medium text-slate-500">{{ $pendaftaran->user?->no_telp }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Metode Pembayaran:</p>
                        <p class="text-sm font-black text-slate-900 leading-tight mb-1">Transfer Bank Mandiri</p>
                        <p class="text-xs font-medium text-slate-500">No. Rek: <span class="font-bold text-slate-800">131-00-1886111-1</span></p>
                        <p class="text-xs font-medium text-slate-500">a.n PT Katiga Veritas Indonesia</p>
                    </div>
                </div>

                <div class="border-t border-slate-100 py-6 mb-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Rincian Layanan</p>
                    <div class="flex justify-between items-center bg-slate-50 p-5 rounded-2xl border border-slate-100">
                        <div>
                            <p class="text-sm font-black text-slate-900 mb-1">{{ $pendaftaran->layanan?->nama }}</p>
                            <p class="text-[10px] font-bold text-cyan-600 uppercase tracking-[0.2em]">{{ $pendaftaran->layanan?->materi }}</p>
                        </div>
                        <p class="text-sm font-black text-slate-900">Rp {{ number_format($pendaftaran->layanan?->harga ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="flex justify-between items-center mb-10 px-4">
                    <p class="text-lg font-black text-slate-900 uppercase tracking-tighter">Total Pembayaran</p>
                    <p class="text-3xl font-black text-cyan-700 tracking-tighter">Rp {{ number_format($pendaftaran->layanan?->harga ?? 0, 0, ',', '.') }}</p>
                </div>

                <div class="bg-amber-50 border border-amber-100 p-5 rounded-2xl mb-12">
                    <p class="text-[10px] font-black text-amber-700 uppercase mb-2 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                        Instruksi Verifikasi:
                    </p>
                    <p class="text-[10px] text-amber-800 leading-relaxed font-bold italic">Mohon sertakan Kode Registrasi (#{{ $pendaftaran->id_pendaftaran }}) pada berita transfer untuk mempercepat proses verifikasi oleh admin kami.</p>
                </div>

                <div class="text-center text-[9px] font-black text-slate-300 uppercase tracking-[0.3em]">
                    PT Katiga Veritas Indonesia &bull; Professional K3 Services &bull; 2026
                </div>
            </div>
            <div class="p-6 bg-slate-50 border-t border-slate-100 flex gap-4">
                <button onclick="downloadInvoice()" class="flex-1 bg-slate-900 text-white font-black text-[10px] py-4 rounded-2xl hover:bg-slate-800 transition flex items-center justify-center gap-2 uppercase tracking-widest shadow-lg shadow-slate-900/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Simpan PDF
                </button>
                <button onclick="hideInvoice()" class="flex-1 bg-white border border-slate-100 text-slate-400 font-black text-[10px] py-4 rounded-2xl hover:bg-slate-100 transition uppercase tracking-widest">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL KONFIRMASI CUSTOM -->
<div id="confirmModal" class="fixed inset-0 z-[110] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-sm overflow-hidden animate-in fade-in slide-in-from-bottom-4 duration-300">
            <div class="p-8 text-center">
                <div id="confirmIconContainer" class="w-16 h-16 rounded-2xl bg-cyan-50 flex items-center justify-center mx-auto mb-6">
                    <svg id="confirmIcon" class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-2">Konfirmasi Aksi</h3>
                <p id="confirmMessage" class="text-sm font-medium text-slate-500 leading-relaxed">Apakah Anda yakin ingin melanjutkan tindakan ini ke status <span id="targetStatusName" class="font-black text-slate-800">...</span>?</p>
            </div>
            <div class="flex border-t border-slate-50">
                <button onclick="closeConfirmModal()" class="flex-1 py-5 text-xs font-black text-slate-400 hover:bg-slate-50 transition border-r border-slate-50 uppercase tracking-widest">Batal</button>
                <button id="confirmBtnAction" class="flex-1 py-5 text-xs font-black text-cyan-600 hover:bg-cyan-50 transition uppercase tracking-widest">Ya, Proses</button>
            </div>
        </div>
    </div>
</div>

<!-- FORM HAPUS TERPISAH -->
<form id="deleteForm" action="{{ route('subadmin.pendaftaran.destroy', $pendaftaran->id_pendaftaran) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function confirmStatus(field, value, label) {
        const modal = document.getElementById('confirmModal');
        const targetName = document.getElementById('targetStatusName');
        const confirmBtn = document.getElementById('confirmBtnAction');
        const iconContainer = document.getElementById('confirmIconContainer');
        const icon = document.getElementById('confirmIcon');

        targetName.innerText = label;
        modal.classList.remove('hidden');

        // Reset icon colors
        iconContainer.className = "w-16 h-16 rounded-2xl bg-cyan-50 flex items-center justify-center mx-auto mb-6";
        icon.className = "w-8 h-8 text-cyan-600";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';

        confirmBtn.onclick = function() {
            document.getElementById('input_' + field).value = value;
            document.getElementById('statusUpdateForm').submit();
        };
    }

    function confirmDelete() {
        const modal = document.getElementById('confirmModal');
        const targetName = document.getElementById('targetStatusName');
        const message = document.getElementById('confirmMessage');
        const confirmBtn = document.getElementById('confirmBtnAction');
        const iconContainer = document.getElementById('confirmIconContainer');
        const icon = document.getElementById('confirmIcon');

        targetName.innerText = "Hapus Pendaftaran";
        message.innerHTML = "Tindakan ini <span class='text-red-600 font-bold uppercase'>permanen</span>. Seluruh data pendaftaran ini akan dihapus dari sistem.";
        modal.classList.remove('hidden');

        // Red theme for delete
        iconContainer.className = "w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-6";
        icon.className = "w-8 h-8 text-red-600";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>';

        confirmBtn.onclick = function() {
            document.getElementById('deleteForm').submit();
        };
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').classList.add('hidden');
    }

    function showInvoice() {
        document.getElementById('invoiceModal').classList.remove('hidden');
    }

    function hideInvoice() {
        document.getElementById('invoiceModal').classList.add('hidden');
    }

    function showUploadModal() {
        document.getElementById('uploadModal').classList.remove('hidden');
    }

    function hideUploadModal() {
        document.getElementById('uploadModal').classList.add('hidden');
    }

    function updateFileName(input) {
        if (input.files && input.files[0]) {
            document.getElementById('fileNameDisplay').innerText = input.files[0].name;
            document.getElementById('fileNameDisplay').classList.remove('text-slate-500');
            document.getElementById('fileNameDisplay').classList.add('text-indigo-600');
        }
    }

    function downloadInvoice() {
        const element = document.getElementById('invoiceContent');
        const opt = {
            margin: 0,
            filename: 'Invoice-KV-{{ $pendaftaran->id_pendaftaran }}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true },
            jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>
@endpush
@endsection
