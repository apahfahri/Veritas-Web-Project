@extends('layouts.app')

@section('title', 'Cek Status Pendaftaran — PT Katiga Veritas Indonesia')

@section('content')
<div class="min-h-screen bg-[#F5F7FA] py-12">
    <div class="max-w-4xl mx-auto px-6">

        {{-- ── HEADER ──────────────────────────────────────────────── --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-[#1E6B3D] mb-2">Cek Status Pendaftaran</h1>
            <p class="text-gray-500">Masukkan Email atau Nomor WhatsApp Anda untuk melihat progres pendaftaran layanan kami.</p>
        </div>

        @if(session('registration_success'))
            <div class="mb-8 p-6 bg-blue-50 border border-blue-200 text-blue-800 rounded-2xl shadow-sm animate-fade-in max-w-2xl mx-auto">
                <div class="flex items-start gap-3">
                    <i class="fi fi-rr-envelope text-blue-500 text-2xl mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-lg text-blue-900">Pendaftaran Berhasil!</h4>
                        @if(session('is_konsultasi'))
                            <p class="text-sm text-blue-700 mt-1">
                                Permintaan konsultasi Anda telah berhasil dikirimkan. Tim kami akan segera meninjau detail pengajuan Anda dan menghubungi Anda via Email atau WhatsApp untuk koordinasi jadwal pelaksanaan.
                            </p>
                        @elseif(session('invoice_email_sent') === false)
                            <p class="text-sm text-red-600 mt-1 font-semibold">
                                Pendaftaran berhasil dicatat, namun sistem gagal mengirimkan invoice otomatis ke email Anda (Error: {{ session('email_error') ?? 'Gangguan server email' }}).
                                Silakan hubungi kami via WhatsApp untuk mendapatkan invoice secara manual.
                            </p>
                        @else
                            <p class="text-sm text-blue-700 mt-1">
                                Invoice resmi dan rincian instruksi pembayaran telah otomatis dikirimkan ke email Anda beserta lampiran PDF (silakan cek inbox/spam). Simpan <strong>Nomor Pendaftaran</strong> yang ada di email untuk mengirim bukti pembayaran.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if(session('bukti_terkirim'))
            <div class="mb-8 p-6 bg-green-50 border border-green-200 text-green-800 rounded-2xl shadow-sm max-w-2xl mx-auto">
                <div class="flex items-start gap-3">
                    <i class="fi fi-rr-check-circle text-green-500 text-2xl mt-0.5"></i>
                    <div>
                        <h4 class="font-bold text-lg text-green-900">Bukti Pembayaran Terkirim!</h4>
                        <p class="text-sm text-green-700 mt-1">Bukti pembayaran Anda telah berhasil dikirim. Tim kami akan memverifikasi dalam jam kerja dan status pendaftaran Anda akan segera diperbarui.</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- ── FORM SEARCH ─────────────────────────────────────────── --}}
        <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 mb-8 max-w-2xl mx-auto">
            <form action="{{ route('training.status.check') }}" method="POST">
                @csrf
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input type="text" name="identifier" 
                               value="{{ $identifier ?? old('identifier') }}"
                               placeholder="Email atau No. WhatsApp" 
                               class="w-full border border-gray-300 rounded-xl pl-12 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#1E6B3D] transition"
                               required>
                    </div>
                    <button type="submit" class="bg-[#1E6B3D] hover:bg-[#3CDA7D] text-white font-semibold px-8 py-3 rounded-xl transition shadow-sm active:scale-95">
                        Cek Status
                    </button>
                </div>
                @error('identifier')
                    <p class="text-red-500 text-sm mt-3">{{ $message }}</p>
                @enderror
            </form>
        </div>

        {{-- ── RESULT ──────────────────────────────────────────────── --}}
        @if(isset($pendaftarans))
            @if($pendaftarans->isEmpty())
                <div class="text-center py-12 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <i class="fi fi-rr-search text-gray-400 text-5xl mb-4 block"></i>
                    <h3 class="text-xl font-bold text-gray-700">Tidak ada pendaftaran ditemukan</h3>
                    <p class="text-gray-500 mt-2">Pastikan Email atau Nomor WhatsApp yang Anda masukkan sudah benar.</p>
                </div>
            @else
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fi fi-rr-clipboard-list text-gray-600 text-xl mr-1"></i> Hasil Pencarian untuk: <span class="text-[#1E6B3D]">{{ $identifier }}</span>
                    </h2>

                    @foreach($pendaftarans as $item)
                        @php $isKonsultasi = ($item->jadwal?->id_kategori == 2); @endphp
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                            <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="bg-[#1E6B3D]/10 text-[#1E6B3D] text-xs font-bold px-2 py-1 rounded uppercase tracking-wider">
                                            {{ $item->jadwal?->kategori?->nama ?? 'Pelatihan K3' }}
                                        </span>
                                        <span class="text-gray-400 text-sm">•</span>
                                        <span class="text-gray-500 text-sm">Terdaftar: {{ $item->tanggal_daftar->format('d M Y') }}</span>
                                        @if($item->rencana_tanggal_mulai && !$isKonsultasi)
                                            <span class="text-gray-400 text-sm">•</span>
                                            <span class="text-gray-500 text-sm">
                                                Jadwal: {{ $item->rencana_tanggal_mulai->format('d M Y') }}
                                                @if($item->rencana_tanggal_selesai && $item->rencana_tanggal_selesai != $item->rencana_tanggal_mulai)
                                                    s/d {{ $item->rencana_tanggal_selesai->format('d M Y') }}
                                                @endif
                                            </span>
                                        @endif
                                        @if($item->mode_pertemuan && !$isKonsultasi)
                                            <span class="text-gray-400 text-sm">•</span>
                                            <span class="bg-[#1E6B3D]/10 text-[#1E6B3D] text-[10px] font-bold px-1.5 py-0.5 rounded uppercase">{{ $item->mode_pertemuan }}</span>
                                        @endif
                                    </div>

                                    @if($isKonsultasi)
                                        @php
                                            $konsultasiStages = [
                                                'meninjau'            => ['icon' => '<i class="fi fi-rr-eye"></i>', 'label' => 'Ditinjau',    'desc' => 'Tim kami sedang meninjau pengajuan Anda'],
                                                'disetujui'           => ['icon' => '<i class="fi fi-rr-check-circle"></i>', 'label' => 'Disetujui',   'desc' => 'Pengajuan disetujui, siap masuk tahap penjadwalan'],
                                                'dijadwalkan'         => ['icon' => '<i class="fi fi-rr-calendar"></i>', 'label' => 'Penjadwalan', 'desc' => 'Jadwal pertemuan sedang ditentukan oleh tim'],
                                                'menunggu_pelaksanaan' => ['icon' => '<i class="fi fi-rr-clock"></i>', 'label' => 'Terjadwal',  'desc' => 'Jadwal telah dikonfirmasi, menunggu pelaksanaan konsultasi'],
                                                'menunggu_pembayaran' => ['icon' => '<i class="fi fi-rr-credit-card"></i>', 'label' => 'Tagihan',     'desc' => 'Sesi konsultasi selesai — silakan selesaikan pembayaran'],
                                                'selesai'             => ['icon' => '<i class="fi fi-rr-trophy"></i>', 'label' => 'Selesai',     'desc' => 'Seluruh proses pendaftaran berhasil diselesaikan'],
                                            ];
                                            $stageKeys  = array_keys($konsultasiStages);
                                            $curStatus  = $item->status_progres;
                                            $isCanceled = ($curStatus === 'dibatalkan');
                                            $currentIdx = array_search($curStatus, $stageKeys);
                                        @endphp

                                        @if($isCanceled)
                                            <div class="mt-4 flex items-center gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                                                <i class="fi fi-rr-cross-circle text-red-500 text-xl"></i>
                                                <div>
                                                    <p class="text-sm font-bold text-red-800">Permintaan Dibatalkan</p>
                                                    <p class="text-xs text-red-600 mt-0.5">Pengajuan pendaftaran ini telah dibatalkan. Hubungi kami jika ada pertanyaan.</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="mt-5 mb-2">
                                                <div class="flex items-center gap-0 overflow-x-auto pb-1">
                                                    @foreach($konsultasiStages as $stageKey => $stageInfo)
                                                        @php
                                                            $stageIdx = array_search($stageKey, $stageKeys);
                                                            $isDone   = ($currentIdx !== false && $stageIdx < $currentIdx);
                                                            $isActive = ($curStatus === $stageKey);
                                                        @endphp
                                                        <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }} shrink-0">
                                                            <div class="flex flex-col items-center gap-1 min-w-[52px]">
                                                                <div class="w-9 h-9 rounded-full flex items-center justify-center text-base border-2 transition-all
                                                                    @if($isDone) bg-emerald-500 border-emerald-500 text-white shadow-sm
                                                                    @elseif($isActive) bg-[#1E6B3D] border-[#1E6B3D] text-white shadow-md ring-4 ring-[#1E6B3D]/15
                                                                    @else bg-gray-50 border-gray-200 text-gray-300
                                                                    @endif">
                                                                    @if($isDone)<i class="fi fi-rr-check text-xs"></i>@else{!! $stageInfo['icon'] !!}@endif
                                                                </div>
                                                                <span class="text-[9px] font-bold text-center leading-tight whitespace-nowrap
                                                                    @if($isDone) text-emerald-600
                                                                    @elseif($isActive) text-[#1E6B3D]
                                                                    @else text-gray-300
                                                                    @endif">{{ $stageInfo['label'] }}</span>
                                                            </div>
                                                            @if(!$loop->last)
                                                                <div class="flex-1 h-0.5 mx-1 rounded-full {{ $stageIdx < $currentIdx ? 'bg-emerald-400' : 'bg-gray-200' }}"></div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>

                                                @if(isset($konsultasiStages[$curStatus]))
                                                    <div class="mt-3 flex items-start gap-2.5 bg-[#1E6B3D]/5 border border-[#1E6B3D]/15 rounded-xl px-3.5 py-2.5">
                                                        <span class="text-base mt-0.5 flex items-center text-[#1E6B3D]">{!! $konsultasiStages[$curStatus]['icon'] !!}</span>
                                                        <div>
                                                            <p class="text-xs font-bold text-[#1E6B3D]">Tahap Saat Ini: {{ $konsultasiStages[$curStatus]['label'] }}</p>
                                                            <p class="text-xs text-gray-600 mt-0.5">{{ $konsultasiStages[$curStatus]['desc'] }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                    {{-- ── PELATIHAN: Status badges seperti semula ─────── --}}
                                    @else
                                        <div class="flex flex-wrap gap-y-2 gap-x-6 mt-4">
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <span class="text-gray-400">Status Progres:</span>
                                                @php
                                                    $statusClasses = [
                                                        'menunggu'            => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                        'meninjau'            => 'bg-slate-100 text-slate-700 border-slate-200',
                                                        'disetujui'           => 'bg-amber-100 text-amber-700 border-amber-200',
                                                        'dijadwalkan'         => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                                        'menunggu_pelaksanaan' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                        'menunggu_pembayaran' => 'bg-orange-100 text-orange-700 border-orange-200',
                                                        'pembayaran_ditinjau' => 'bg-purple-100 text-purple-700 border-purple-200',
                                                        'diproses'            => 'bg-blue-100 text-blue-700 border-blue-200',
                                                        'selesai'             => 'bg-green-100 text-green-700 border-green-200',
                                                        'dibatalkan'          => 'bg-red-100 text-red-700 border-red-200',
                                                    ];
                                                    $statusLabel = [
                                                        'menunggu'            => 'Menunggu Konfirmasi',
                                                        'meninjau'            => 'Menunggu Tinjauan',
                                                        'disetujui'           => 'Disetujui',
                                                        'dijadwalkan'         => 'Dijadwalkan',
                                                        'menunggu_pelaksanaan' => 'Terjadwal',
                                                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                                        'pembayaran_ditinjau' => 'Bukti Dikirim',
                                                        'diproses'            => 'Terkonfirmasi',
                                                        'selesai'             => 'Selesai',
                                                        'dibatalkan'          => 'Dibatalkan',
                                                    ];
                                                    $curStatus = $item->status_progres;
                                                    $class = $statusClasses[$curStatus] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                                    $label = $statusLabel[$curStatus] ?? ucfirst(str_replace('_', ' ', $curStatus));
                                                @endphp
                                                <span class="px-3 py-1 rounded-full border text-xs font-semibold {{ $class }}">
                                                    {{ $label }}
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <span class="text-gray-400">Pembayaran:</span>
                                                @php
                                                    $payClasses = [
                                                        'belum_bayar'        => 'bg-red-50 text-red-600',
                                                        'belum_lunas'        => 'bg-red-50 text-red-600',
                                                        'menunggu_konfirmasi'=> 'bg-orange-50 text-orange-600',
                                                        'lunas'              => 'bg-green-50 text-green-600',
                                                    ];
                                                    $payLabel = [
                                                        'belum_bayar'        => 'Belum Lunas',
                                                        'belum_lunas'        => 'Belum Lunas',
                                                        'menunggu_konfirmasi'=> 'Menunggu Konfirmasi',
                                                        'lunas'              => 'Lunas',
                                                    ];
                                                    $curPay = $item->status_bayar;
                                                    $pClass = $payClasses[$curPay] ?? 'bg-gray-50 text-gray-600';
                                                    $pLabel = $payLabel[$curPay] ?? ucfirst(str_replace('_', ' ', $curPay));
                                                @endphp
                                                <span class="font-bold {{ $pClass }} px-2 py-0.5 rounded">
                                                    {{ $pLabel }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Tampilkan info rekening & kode transfer jika statusnya menunggu pembayaran --}}
                                    @if($item->status_progres === 'menunggu_pembayaran' && !in_array($item->status_bayar, ['lunas', 'menunggu_konfirmasi']))
                                        <div class="mt-4 bg-emerald-50 border border-emerald-100 rounded-2xl p-4 text-emerald-800 max-w-xl animate-fade-in">
                                            <p class="text-xs font-bold flex items-center gap-1.5 mb-1.5 text-emerald-900">
                                                <i class="fi fi-rr-info text-emerald-600 text-sm"></i> Petunjuk Pembayaran Transfer Bank
                                            </p>
                                            <p class="text-xs leading-relaxed text-emerald-700 font-medium">
                                                Transfer pembayaran penuh ke rekening <strong>{{ $rekening?->nama_bank ?? 'Bank Mandiri' }} {{ $rekening?->nomor_rekening ?? '131-00-1886111-1' }}</strong> A.N. {{ $rekening?->atas_nama ?? 'PT Katiga Veritas Indonesia' }}.<br>
                                                <span class="text-amber-800 font-bold">PENTING:</span> Masukkan 5 digit kode transfer unik berikut ke <strong>Berita Transfer / Catatan Transaksi</strong> Anda saat transfer:
                                            </p>
                                            <p class="mt-2 font-mono text-sm font-black bg-white border border-emerald-200 rounded-xl px-3 py-1.5 inline-block text-emerald-900 tracking-widest select-all" title="Klik/Ketuk untuk menyalin">
                                                {{ explode('-', $item->nomor_pendaftaran)[0] }}
                                            </p>
                                        </div>
                                    @endif
                                </div>

                                {{-- ── ACTION BUTTONS ──────────────────────────────── --}}
                                <div class="flex md:flex-col gap-3 shrink-0">
                                    @if($item->status_progres === 'selesai' && $item->sertifikat)
                                        <a href="#" class="inline-flex items-center justify-center gap-2 bg-[#1E6B3D] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Unduh Sertifikat
                                        </a>

                                    {{-- ── Konsultasi action buttons ── --}}
                                    @elseif($isKonsultasi)
                                        @if($item->status_progres === 'menunggu_pembayaran' && !in_array($item->status_bayar, ['lunas','menunggu_konfirmasi']))
                                            <button type="button"
                                                onclick="bukaModalBukti('{{ $item->id_pendaftaran }}', '{{ $identifier }}')"
                                                class="inline-flex items-center justify-center gap-2 bg-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-amber-600 transition shadow-sm animate-pulse">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                Kirim Bukti Bayar
                                            </button>
                                        @elseif($item->status_bayar === 'menunggu_konfirmasi')
                                            <span class="inline-flex items-center justify-center gap-1.5 bg-orange-50 border border-orange-200 text-orange-600 px-4 py-2.5 rounded-xl text-xs font-bold">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                Bukti Sedang Diverifikasi
                                            </span>
                                        @elseif($item->status_bayar === 'lunas')
                                            <span class="inline-flex items-center justify-center gap-1.5 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-2.5 rounded-xl text-xs font-bold">
                                                <i class="fi fi-rr-check-circle text-emerald-600 text-sm"></i> Pembayaran Lunas
                                            </span>
                                        @elseif($item->status_progres !== 'dibatalkan')
                                            @php
                                                $waNumber = config('app.whatsapp_number', '6281234567890');
                                                $waText   = "Halo Admin, saya ingin menanyakan status konsultasi atas nama " . $item->user->nama . " (No. " . ($item->nomor_pendaftaran ?? '') . ")";
                                                $waUrl    = "https://wa.me/" . $waNumber . "?text=" . rawurlencode($waText);
                                            @endphp
                                            <a href="{{ $waUrl }}" target="_blank"
                                               class="inline-flex items-center justify-center gap-2 bg-[#25D366] text-white px-4 py-2.5 rounded-xl text-xs font-semibold hover:bg-green-600 transition shadow-sm">
                                                <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.938 3.659 1.435 5.63 1.435h.008c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                                Tanya Admin
                                            </a>
                                        @endif

                                    {{-- ── Pelatihan action buttons ── --}}
                                    @elseif(in_array($item->status_bayar, ['belum_bayar', 'belum_lunas']) || $item->status_progres === 'menunggu_pembayaran')
                                        <button type="button"
                                            onclick="bukaModalBukti('{{ $item->id_pendaftaran }}', '{{ $identifier }}')"
                                            class="inline-flex items-center justify-center gap-2 bg-amber-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-amber-600 transition shadow-sm animate-pulse">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                            </svg>
                                            Kirim Bukti Bayar
                                        </button>
                                    @elseif($item->status_bayar === 'menunggu_konfirmasi')
                                        <span class="inline-flex items-center justify-center gap-1.5 bg-orange-50 border border-orange-200 text-orange-600 px-5 py-2.5 rounded-xl text-sm font-semibold">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Menunggu Verifikasi
                                        </span>
                                    @else
                                        @php
                                            $waNumber = config('app.whatsapp_number', '6281234567890');
                                            $waText   = "Halo Admin, saya ingin menanyakan status pendaftaran layanan " . ($item->jadwal?->jenis?->nama ?? 'K3') . " atas nama " . $item->user->nama;
                                            $waUrl    = "https://wa.me/" . $waNumber . "?text=" . rawurlencode($waText);
                                        @endphp
                                        <a href="{{ $waUrl }}" target="_blank"
                                           class="inline-flex items-center justify-center gap-2 bg-green-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-green-600 transition shadow-sm">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.938 3.659 1.435 5.63 1.435h.008c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                            Tanya Admin
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

        {{-- ── FAQ / HELP ────────────────────────────────────────── --}}
        <div class="mt-12 max-w-2xl mx-auto text-center border-t border-gray-200 pt-8">
            <h4 class="font-semibold text-gray-700 mb-2">Butuh bantuan?</h4>
            <p class="text-sm text-gray-500">Jika Anda tidak menemukan data pendaftaran atau status tidak kunjung berubah, silakan hubungi kami melalui WhatsApp.</p>
        </div>

    </div>
</div>

{{-- ── MODAL KIRIM BUKTI PEMBAYARAN (2-STEP) ─────────────────── --}}
<div id="modalBukti" class="fixed inset-0 z-[200] hidden overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="tutupModalBukti()"></div>
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden">

            {{-- STEP 1: Verifikasi Nomor --}}
            <div id="step1">
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Kirim Bukti Pembayaran</h3>
                            <p class="text-xs text-gray-500">Langkah 1 dari 2 — Verifikasi Identitas</p>
                        </div>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-6">
                        <p class="text-xs text-amber-800 font-medium">Masukkan <strong>Nomor Pendaftaran</strong> yang tercantum di email invoice Anda. Nomor ini berfungsi sebagai verifikasi keamanan.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Nomor Pendaftaran *</label>
                            <input type="text" id="inputNomor" placeholder="Contoh: PLT-AK3U-02-24052026-0001"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm font-mono uppercase focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500 tracking-wider"
                                   oninput="this.value = this.value.toUpperCase()">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Email Pendaftaran *</label>
                            <input type="email" id="inputEmail" placeholder="Email yang digunakan saat daftar"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-amber-500/30 focus:border-amber-500">
                        </div>

                        <div id="pesanVerifikasi" class="hidden text-xs font-semibold px-3 py-2 rounded-xl"></div>

                        <div class="flex gap-3 pt-2">
                            <button type="button" onclick="tutupModalBukti()" class="flex-1 py-3 border border-gray-200 text-gray-500 text-sm font-bold rounded-xl hover:bg-gray-50 transition">Batal</button>
                            <button type="button" onclick="verifikasiNomor()" id="btnVerifikasi"
                                    class="flex-1 py-3 bg-amber-500 text-white text-sm font-bold rounded-xl hover:bg-amber-600 transition flex items-center justify-center gap-2">
                                <span id="btnVerifikasiText">Verifikasi</span>
                                <svg id="spinnerVerifikasi" class="hidden animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STEP 2: Upload Bukti --}}
            <div id="step2" class="hidden">
                <form action="{{ route('pendaftaran.kirim-bukti') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    <input type="hidden" name="nomor_pendaftaran" id="hiddenNomor">
                    <input type="hidden" name="email" id="hiddenEmail">

                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Upload Bukti Transfer</h3>
                            <p class="text-xs text-gray-500">Langkah 2 dari 2 — Upload Foto</p>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-2xl p-4 mb-6">
                        <p class="text-xs text-green-800 font-medium">✅ Nomor pendaftaran terverifikasi. Silakan upload foto bukti transfer bank Anda.</p>
                        <p id="infoProgram" class="text-xs text-green-700 font-bold mt-1 mb-2"></p>
                        
                        <!-- Account & Unique Code Instruction -->
                        <div class="mt-2.5 pt-2.5 border-t border-green-200/50 text-[11px] text-green-800">
                            <p class="font-bold mb-1">🏦 <span id="infoBankName">Rekening Mandiri</span>: <span id="infoBankAcc">131-00-1886111-1</span></p>
                            <p class="mb-1">A.N. <span id="infoBankRecipient">PT Katiga Veritas Indonesia</span></p>
                            <p class="leading-relaxed">
                                <span class="text-amber-800 font-bold">Catatan Transfer:</span> Pastikan memasukkan 5 digit kode unik berikut pada berita transfer Anda: 
                                <strong id="infoKodeUnik" class="font-mono text-xs bg-white px-1.5 py-0.5 rounded border border-green-300 font-black"></strong>
                            </p>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-bold text-gray-700 mb-2">Foto Bukti Transfer *</label>
                        <label for="inputBukti" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer hover:border-amber-400 hover:bg-amber-50 transition group">
                            <svg class="w-8 h-8 text-gray-400 group-hover:text-amber-500 mb-2 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <p id="namaFileBukti" class="text-xs text-gray-500 font-semibold group-hover:text-amber-600 transition">Klik untuk pilih foto</p>
                            <p class="text-[10px] text-gray-400 mt-1">JPEG, PNG, WebP — Maks. 1 MB</p>
                        </label>
                        <input type="file" id="inputBukti" name="bukti_bayar" accept="image/jpeg,image/png,image/jpg,image/webp" required class="hidden" onchange="tampilkanNamaFile(this)">
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="kembaliStep1()" class="flex-1 py-3 border border-gray-200 text-gray-500 text-sm font-bold rounded-xl hover:bg-gray-50 transition">← Kembali</button>
                        <button type="submit" class="flex-1 py-3 bg-[#1E6B3D] text-white text-sm font-bold rounded-xl hover:bg-[#3CDA7D] transition">Kirim Bukti</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const csrfToken = '{{ csrf_token() }}';
    const verifikasiUrl = '{{ route("pendaftaran.verifikasi-nomor") }}';
    let currentIdentifier = '';

    function bukaModalBukti(idPendaftaran, identifier) {
        currentIdentifier = identifier || '';
        document.getElementById('modalBukti').classList.remove('hidden');
        document.getElementById('step1').classList.remove('hidden');
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('inputNomor').value = '';
        document.getElementById('inputEmail').value = currentIdentifier.includes('@') ? currentIdentifier : '';
        document.getElementById('pesanVerifikasi').classList.add('hidden');
    }

    function tutupModalBukti() {
        document.getElementById('modalBukti').classList.add('hidden');
    }

    function verifikasiNomor() {
        const nomor  = document.getElementById('inputNomor').value.trim();
        const email  = document.getElementById('inputEmail').value.trim();
        const pesan  = document.getElementById('pesanVerifikasi');
        const btn    = document.getElementById('btnVerifikasi');
        const spinner = document.getElementById('spinnerVerifikasi');
        const btnText = document.getElementById('btnVerifikasiText');

        if (!nomor || !email) {
            pesan.className = 'text-xs font-semibold px-3 py-2 rounded-xl bg-red-50 text-red-700 border border-red-200';
            pesan.textContent = 'Mohon isi Nomor Pendaftaran dan Email terlebih dahulu.';
            pesan.classList.remove('hidden');
            return;
        }

        // Tampilkan loading
        btn.disabled = true;
        spinner.classList.remove('hidden');
        btnText.textContent = 'Memverifikasi...';
        pesan.classList.add('hidden');

        fetch(verifikasiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ nomor_pendaftaran: nomor, email: email }),
        })
        .then(res => res.json().then(data => ({ ok: res.ok, data })))
        .then(({ ok, data }) => {
            btn.disabled = false;
            spinner.classList.add('hidden');
            btnText.textContent = 'Verifikasi';

            if (ok && data.valid) {
                // Berhasil — lanjut ke step 2
                document.getElementById('hiddenNomor').value = data.nomor_pendaftaran;
                document.getElementById('hiddenEmail').value  = email;
                document.getElementById('infoProgram').textContent = 'Program: ' + data.program;
                
                // Set the unique code and bank account info in the modal
                const uniqueCode = data.nomor_pendaftaran.split('-')[0];
                const infoKodeEl = document.getElementById('infoKodeUnik');
                if (infoKodeEl) {
                    infoKodeEl.textContent = uniqueCode;
                }
                
                const infoBankNameEl = document.getElementById('infoBankName');
                const infoBankAccEl = document.getElementById('infoBankAcc');
                const infoBankRecipientEl = document.getElementById('infoBankRecipient');
                if (infoBankNameEl) {
                    infoBankNameEl.textContent = 'Rekening ' + (data.bank_name || 'Mandiri');
                }
                if (infoBankAccEl) {
                    infoBankAccEl.textContent = data.bank_account || '131-00-1886111-1';
                }
                if (infoBankRecipientEl) {
                    infoBankRecipientEl.textContent = data.bank_recipient || 'PT Katiga Veritas Indonesia';
                }
                
                document.getElementById('step1').classList.add('hidden');
                document.getElementById('step2').classList.remove('hidden');
            } else {
                pesan.className = 'text-xs font-semibold px-3 py-2 rounded-xl bg-red-50 text-red-700 border border-red-200';
                pesan.textContent = data.message || 'Nomor pendaftaran tidak valid.';
                pesan.classList.remove('hidden');
            }
        })
        .catch(() => {
            btn.disabled = false;
            spinner.classList.add('hidden');
            btnText.textContent = 'Verifikasi';
            pesan.className = 'text-xs font-semibold px-3 py-2 rounded-xl bg-red-50 text-red-700 border border-red-200';
            pesan.textContent = 'Terjadi kesalahan jaringan, coba lagi.';
            pesan.classList.remove('hidden');
        });
    }

    function kembaliStep1() {
        document.getElementById('step1').classList.remove('hidden');
        document.getElementById('step2').classList.add('hidden');
    }

    function tampilkanNamaFile(input) {
        const el = document.getElementById('namaFileBukti');
        if (input.files && input.files[0]) {
            el.textContent = input.files[0].name;
            el.classList.add('text-amber-600');
        }
    }

    // Tekan Enter di field nomor/email untuk trigger verifikasi
    document.addEventListener('DOMContentLoaded', () => {
        ['inputNomor', 'inputEmail'].forEach(id => {
            document.getElementById(id)?.addEventListener('keydown', e => {
                if (e.key === 'Enter') { e.preventDefault(); verifikasiNomor(); }
            });
        });
    });
</script>
@endpush

{{-- ── SUCCESS MODAL OVERLAY ─────────────────── --}}
@if(session('registration_success'))
<div id="success-modal" class="fixed inset-0 z-[9999] flex items-center justify-center p-6 bg-black/50 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-3xl p-10 max-w-sm w-full shadow-2xl text-center transform transition-all duration-500 scale-90 opacity-0" id="modal-content">
        
        <!-- Animated Checkmark -->
        <div class="success-checkmark mb-6">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>

        @if(session('is_konsultasi'))
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Permintaan Dikirim!</h2>
            <p class="text-gray-500 text-sm mb-8">
                Permintaan konsultasi Anda berhasil diajukan. Tim kami akan segera meninjau detail dan menghubungi Anda via Email/WhatsApp untuk koordinasi jadwal.
            </p>
        @else
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Berhasil!</h2>
            @if(session('invoice_email_sent') === false)
                <p class="text-red-500 text-sm mb-8 font-semibold">
                    Sistem gagal mengirimkan email invoice (Error: {{ session('email_error') ?? 'Server SMTP gagal' }}). Silakan kontak admin via WhatsApp untuk mendapatkan invoice manual.
                </p>
            @else
                <p class="text-gray-500 text-sm mb-8">
                    Invoice resmi dalam bentuk PDF telah dikirimkan ke email Anda. Silakan periksa kotak masuk atau folder spam Anda untuk instruksi pembayaran.
                </p>
            @endif
        @endif

        <button onclick="closeModal()" class="w-full bg-[#1E6B3D] hover:bg-[#3CDA7D] text-white font-bold py-3 rounded-xl shadow-lg transition-all active:scale-95">
            Lihat Status Saya
        </button>
    </div>
</div>

<style>
    /* MODAL ANIMATION */
    #modal-content.show {
        scale: 1;
        opacity: 1;
    }

    /* CHECKMARK ANIMATION (Pure CSS) */
    .success-checkmark {
        width: 80px;
        height: 115px;
        margin: 0 auto;
    }
    .check-icon {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid #4CAF50;
    }
    .check-icon::before, .check-icon::after {
        content: '';
        height: 100px;
        position: absolute;
        background: #FFFFFF;
        transform: rotate(-45deg);
    }
    .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }
    .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: rotate-circle 4.25s ease-in;
    }
    .icon-line {
        height: 5px;
        background-color: #4CAF50;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }
    .line-tip {
        top: 46px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
        animation: icon-line-tip 0.75s;
    }
    .line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
        animation: icon-line-long 0.75s;
    }
    .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        border: 4px solid rgba(76, 175, 80, 0.5);
        box-sizing: content-box;
    }
    .icon-fix {
        top: 8px;
        width: 5px;
        left: 26px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background-color: #FFFFFF;
    }

    @keyframes rotate-circle {
        0% { transform: rotate(-45deg); }
        5% { transform: rotate(-45deg); }
        12% { transform: rotate(-405deg); }
        100% { transform: rotate(-405deg); }
    }
    @keyframes icon-line-tip {
        0% { width: 0; left: 1px; top: 19px; }
        54% { width: 0; left: 1px; top: 19px; }
        70% { width: 50px; left: -8px; top: 37px; }
        84% { width: 17px; left: 21px; top: 48px; }
        100% { width: 25px; left: 14px; top: 46px; }
    }
    @keyframes icon-line-long {
        0% { width: 0; right: 46px; top: 54px; }
        65% { width: 0; right: 46px; top: 54px; }
        84% { width: 55px; right: 0px; top: 35px; }
        100% { width: 47px; right: 8px; top: 38px; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('success-modal');
        const content = document.getElementById('modal-content');
        
        if (modal && content) {
            setTimeout(() => {
                content.classList.add('show');
            }, 100);
        }
    });

    function closeModal() {
        const modal = document.getElementById('success-modal');
        const content = document.getElementById('modal-content');
        
        content.classList.remove('show');
        setTimeout(() => {
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.remove();
            }, 300);
        }, 300);
    }
</script>
@endif
@endsection
