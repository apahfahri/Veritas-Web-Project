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
                    <span class="text-2xl mt-0.5">✉️</span>
                    <div>
                        <h4 class="font-bold text-lg text-blue-900">Pendaftaran Berhasil!</h4>
                        @if(session('invoice_email_sent') === false)
                            <p class="text-sm text-red-600 mt-1 font-semibold">
                                Pendaftaran berhasil dicatat, namun sistem gagal mengirimkan invoice otomatis ke email Anda (Error: {{ session('email_error') ?? 'Gangguan server email' }}).
                                Silakan hubungi kami via WhatsApp untuk mendapatkan invoice secara manual.
                            </p>
                        @else
                            <p class="text-sm text-blue-700 mt-1">
                                Invoice resmi dan rincian instruksi pembayaran telah otomatis dikirimkan ke email Anda beserta lampiran PDF (silakan cek inbox/spam). Anda juga dapat melakukan konfirmasi pembayaran dengan membalas email tersebut.
                            </p>
                        @endif
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
                    <div class="text-5xl mb-4">🔍</div>
                    <h3 class="text-xl font-bold text-gray-700">Tidak ada pendaftaran ditemukan</h3>
                    <p class="text-gray-500 mt-2">Pastikan Email atau Nomor WhatsApp yang Anda masukkan sudah benar.</p>
                </div>
            @else
                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                        <span>📋</span> Hasil Pencarian untuk: <span class="text-[#1E6B3D]">{{ $identifier }}</span>
                    </h2>

                    @foreach($pendaftarans as $item)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                            <div class="p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="bg-[#1E6B3D]/10 text-[#1E6B3D] text-xs font-bold px-2 py-1 rounded uppercase tracking-wider">
                                            {{ $item->layanan->kategori->nama ?? 'Pelatihan K3' }}
                                        </span>
                                        <span class="text-gray-400 text-sm">•</span>
                                        <span class="text-gray-500 text-sm">Terdaftar: {{ $item->tanggal_daftar->format('d M Y') }}</span>
                                        @if($item->rencana_tanggal_mulai)
                                            <span class="text-gray-400 text-sm">•</span>
                                            <span class="text-gray-500 text-sm">
                                                Jadwal: {{ $item->rencana_tanggal_mulai->format('d M Y') }}
                                                @if($item->rencana_tanggal_selesai && $item->rencana_tanggal_selesai != $item->rencana_tanggal_mulai)
                                                    s/d {{ $item->rencana_tanggal_selesai->format('d M Y') }}
                                                @endif
                                            </span>
                                        @endif
                                        @if($item->mode_pertemuan)
                                            <span class="text-gray-400 text-sm">•</span>
                                            <span class="bg-[#1E6B3D]/10 text-[#1E6B3D] text-[10px] font-bold px-1.5 py-0.5 rounded uppercase">{{ $item->mode_pertemuan }}</span>
                                        @endif
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $item->layanan->materi }}</h3>
                                    
                                    <div class="flex flex-wrap gap-y-2 gap-x-6 mt-4">
                                        <div class="flex items-center gap-2 text-sm text-gray-600">
                                            <span class="text-gray-400">Status Progres:</span>
                                            @php
                                                $statusClasses = [
                                                    'menunggu' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                    'diproses' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                    'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                                    'dibatalkan' => 'bg-red-100 text-red-700 border-red-200',
                                                ];
                                                $statusLabel = [
                                                    'menunggu' => 'Menunggu Konfirmasi',
                                                    'diproses' => 'Terkonfirmasi',
                                                    'selesai' => 'Selesai',
                                                    'dibatalkan' => 'Dibatalkan',
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
                                                    'belum_bayar' => 'bg-red-50 text-red-600',
                                                    'belum_lunas' => 'bg-red-50 text-red-600',
                                                    'menunggu_konfirmasi' => 'bg-orange-50 text-orange-600',
                                                    'lunas' => 'bg-green-50 text-green-600',
                                                ];
                                                $payLabel = [
                                                    'belum_bayar' => 'Belum Lunas',
                                                    'belum_lunas' => 'Belum Lunas',
                                                    'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
                                                    'lunas' => 'Lunas',
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
                                </div>

                                <div class="flex md:flex-col gap-3">
                                    @if($item->status_progres === 'selesai' && $item->sertifikat)
                                        <a href="#" class="inline-flex items-center justify-center gap-2 bg-[#1E6B3D] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Unduh Sertifikat
                                        </a>
                                    @endif
                                    
                                    @php
                                        $waNumber = config('app.whatsapp_number', '6281234567890');
                                        if ($item->status_bayar === 'belum_bayar' || $item->status_bayar === 'belum_lunas') {
                                            $waText = "Halo Veritas, saya ingin konfirmasi pembayaran untuk Invoice #INV-" . $item->id_pendaftaran;
                                            $btnLabel = "Konfirmasi Bayar";
                                        } else {
                                            $waText = "Halo Admin, saya ingin menanyakan status pendaftaran layanan " . ($item->layanan->materi ?? 'K3') . " atas nama " . $item->user->nama;
                                            $btnLabel = "Tanya Admin";
                                        }
                                        $waUrl = "https://wa.me/" . $waNumber . "?text=" . rawurlencode($waText);
                                    @endphp
                                    <a href="{{ $waUrl }}" 
                                       target="_blank"
                                       class="inline-flex items-center justify-center gap-2 bg-green-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-green-600 transition shadow-sm">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.938 3.659 1.435 5.63 1.435h.008c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                        </svg>
                                        {{ $btnLabel }}
                                    </a>
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

{{-- ── SUCCESS MODAL OVERLAY ────────────────────────────────────── --}}
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
