<?php
$content = <<<'EOD'
@extends('layouts.subadmin')
@section('page-title', 'Detail Pendaftaran #' . $pendaftaran->id_pendaftaran)
@section('page-subtitle', 'Kelola status dan informasi pendaftaran')

@section('content')

<div class="mb-6 flex items-center justify-between">
    @php
        $backRoute = route('subadmin.pendaftaran.index');
        $context = request('context');
        if ($context == 'pelatihan') $backRoute = route('subadmin.pelatihan.index');
        elseif ($context == 'konsultasi') $backRoute = route('subadmin.konsultasi.index');
        elseif ($context == 'audit') $backRoute = route('subadmin.audit.index');
    @endphp
    <a href="{{ $backRoute }}" class="text-slate-500 hover:text-cyan-600 text-sm font-semibold flex items-center gap-2 transition w-max">
        <i class="fi fi-rr-arrow-left"></i>
        Kembali ke Daftar
    </a>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden select-none">
    <!-- Header Card -->
    <div class="bg-slate-50/50 border-b border-slate-100 p-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="bg-cyan-100 text-cyan-700 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">ID: {{ substr($pendaftaran->nomor_pendaftaran ?? $pendaftaran->id_pendaftaran, 0, 5) }}</span>
                <span class="text-sm font-medium text-slate-500">{{ $pendaftaran->tanggal_daftar ? $pendaftaran->tanggal_daftar->format('d M Y') : '-' }}</span>
            </div>
            <h2 class="text-2xl font-black text-slate-900">{{ $pendaftaran->user?->nama }}</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium">{{ $pendaftaran->jadwal?->jenis?->nama ?? '-' }}</p>
        </div>

        <div class="flex gap-4 overflow-x-auto pb-2 md:pb-0">
            @php
                $isConsultation = $pendaftaran->jadwal && $pendaftaran->jadwal->id_kategori == 2;
                $progresLabels = [
                    'meninjau' => '<i class="fi fi-rr-eye mt-1"></i> Meninjau',
                    'disetujui' => '<i class="fi fi-rr-check-circle mt-1"></i> Disetujui',
                    'dijadwalkan' => '<i class="fi fi-rr-calendar mt-1"></i> Dijadwalkan',
                    'berlangsung' => '<i class="fi fi-rr-play-alt mt-1"></i> Berlangsung',
                    'menunggu_pembayaran' => '<i class="fi fi-rr-credit-card mt-1"></i> Menunggu Pembayaran',
                    'pembayaran_ditinjau' => '<i class="fi fi-rr-document-signed mt-1"></i> Pembayaran Ditinjau',
                    'diproses' => '<i class="fi fi-rr-refresh mt-1"></i> Diproses',
                    'selesai' => '<i class="fi fi-rr-magic-wand mt-1"></i> Selesai',
                    'dibatalkan' => '<i class="fi fi-rr-ban mt-1"></i> Dibatalkan',
                ];
                $bayarLabels = [
                    'belum_bayar' => '<i class="fi fi-rr-credit-card mt-1"></i> Belum Bayar',
                    'belum_lunas' => '<i class="fi fi-rr-wallet mt-1"></i> Belum Lunas',
                    'dp' => '<i class="fi fi-rr-money mt-1"></i> DP',
                    'menunggu_konfirmasi' => '<i class="fi fi-rr-time-past mt-1"></i> Menunggu Konfirmasi',
                    'lunas' => '<i class="fi fi-rr-check-circle mt-1"></i> Lunas',
                ];
                $currentProgres = $progresLabels[$pendaftaran->status_progres] ?? str_replace('_', ' ', $pendaftaran->status_progres);
                $currentBayar = $bayarLabels[$pendaftaran->status_bayar] ?? str_replace('_', ' ', $pendaftaran->status_bayar);
            @endphp
            <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm min-w-[160px] shrink-0">
                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status Progres</span>
                <span class="text-sm font-bold text-cyan-600 flex items-center gap-1.5">{!! $currentProgres !!}</span>
            </div>
            <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm min-w-[160px] shrink-0">
                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status Pembayaran</span>
                <span class="text-sm font-bold {{ $pendaftaran->status_bayar === 'lunas' ? 'text-emerald-600' : 'text-amber-600' }} flex items-center gap-1.5">{!! $currentBayar !!}</span>
            </div>
        </div>
    </div>

    <!-- Body Card -->
    <div class="p-8">
        <div class="grid lg:grid-cols-2 gap-10">
            <!-- Left Column: User Info & Documents -->
            <div class="space-y-8">
                <!-- Info Pendaftar -->
                <div>
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-cyan-50 flex items-center justify-center text-cyan-600">
                            <i class="fi fi-rr-user"></i>
                        </div>
                        Informasi Lengkap Klien
                    </h3>
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-6 space-y-4">
                        <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-4">
                            <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Nama Lengkap</div>
                            <div class="col-span-2 text-sm font-semibold text-slate-900">{{ $pendaftaran->user?->nama }}</div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-4">
                            <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Pendidikan</div>
                            <div class="col-span-2 text-sm font-semibold text-slate-900">{{ $pendaftaran->user?->pendidikan ?? '-' }}</div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-4">
                            <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Email</div>
                            <div class="col-span-2 text-sm font-semibold text-slate-900">{{ $pendaftaran->user?->email }}</div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-4">
                            <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Telepon / WA</div>
                            <div class="col-span-2 text-sm font-semibold text-slate-900">{{ $pendaftaran->user?->no_telp }}</div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 pt-1">
                            <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Layanan</div>
                            <div class="col-span-2 text-sm font-semibold text-cyan-700">{{ $pendaftaran->jadwal?->jenis?->nama }}</div>
                        </div>
                    </div>
                </div>

                <!-- Dokumen & Pembayaran -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500">
                                <i class="fi fi-rr-document-signed"></i>
                            </div>
                            Dokumen & Pembayaran
                        </h3>
                    </div>

                    @if($pendaftaran->status_bayar === 'menunggu_konfirmasi')
                    <div class="mb-6 p-5 bg-amber-50 border border-amber-200 rounded-2xl">
                        <div class="flex items-start gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center shrink-0">
                                <i class="fi fi-rr-info text-amber-600"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-black text-amber-800">Bukti Pembayaran Menunggu Konfirmasi</p>
                                <p class="text-xs text-amber-700 mt-1">Pelanggan telah mengunggah bukti transfer. Tinjau foto di bawah dan pilih aksi yang sesuai.</p>
                            </div>
                        </div>
                        <div class="flex gap-3 mt-4">
                            <!-- Tombol Konfirmasi -->
                            <button type="button" onclick="showKonfirmasiModal()"
                                    class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs px-4 py-3 rounded-xl transition shadow-lg shadow-emerald-600/20">
                                <i class="fi fi-rr-check"></i>
                                Konfirmasi Pembayaran
                            </button>
                            <!-- Tombol Tolak -->
                            <button type="button" onclick="showTolakModal()"
                                    class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 font-black text-xs px-4 py-3 rounded-xl transition border border-red-200">
                                <i class="fi fi-rr-cross"></i>
                                Bukti Tidak Valid
                            </button>
                        </div>
                        
                        <!-- Hidden forms to be triggered by modals -->
                        <form id="formKonfirmasiBukti" action="{{ route('subadmin.pendaftaran.konfirmasi-bukti', $pendaftaran->id_pendaftaran) }}" method="POST" class="hidden">
                            @csrf
                        </form>
                        <form id="formTolakBukti" action="{{ route('subadmin.pendaftaran.batalkan', $pendaftaran->id_pendaftaran) }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                    @endif

                    @if($pendaftaran->bukti_bayar)
                        <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-3">Bukti Pembayaran Terlampir:</span>
                            <div class="relative group cursor-pointer overflow-hidden rounded-xl border border-slate-200 shadow-sm" onclick="window.open('{{ asset('uploads/pembayaran/' . $pendaftaran->bukti_bayar) }}', '_blank')">
                                <img src="{{ asset('uploads/pembayaran/' . $pendaftaran->bukti_bayar) }}" class="w-full h-48 md:h-64 object-cover group-hover:scale-105 transition duration-500">
                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <span class="bg-white/20 backdrop-blur-md text-white text-xs font-bold px-4 py-2 rounded-full border border-white/30">Klik untuk Memperbesar</span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-8 text-center bg-slate-50 border border-slate-100 rounded-2xl border-dashed">
                            <p class="text-sm font-bold text-slate-400">Belum ada bukti pembayaran yang dilampirkan.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Update Status, Notes, Danger Zone -->
            <div class="space-y-8">
                <!-- Indikator Progres -->
                <div>
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <i class="fi fi-rr-refresh"></i>
                        </div>
                        Progres Layanan Saat Ini
                    </h3>

                    <div class="p-6 bg-slate-50/50 border border-slate-100 rounded-2xl">
                        <div class="p-4 bg-white rounded-xl border border-slate-200 flex flex-col gap-3 shadow-sm">
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
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
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
                    </div>
                </div>

                <!-- Catatan Subadmin (Internal) -->
                <div>
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                            <i class="fi fi-rr-notebook"></i>
                        </div>
                        Catatan Internal
                    </h3>
                    
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-6">
                        @if($pendaftaran->last_reminder_sent_at)
                            <div class="mb-4 p-4 bg-amber-50 border border-amber-100 rounded-xl">
                                <span class="text-[9px] font-black text-amber-600 uppercase tracking-widest block mb-1">Terakhir Diperbarui:</span>
                                <p class="text-xs font-bold text-slate-700 mb-2">{{ $pendaftaran->last_reminder_sent_at->format('d M Y, H:i') }}</p>
                                <p class="text-xs font-medium text-slate-600 leading-relaxed italic bg-white p-3 rounded-lg border border-amber-100">"{{ $pendaftaran->last_reminder_details }}"</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('subadmin.pendaftaran.update-note', ['id' => $pendaftaran->id_pendaftaran, 'context' => request('context')]) }}">
                            @csrf
                            <textarea name="admin_note" rows="3" placeholder="Tulis catatan internal untuk tim subadmin..." required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition mb-3 shadow-sm"></textarea>
                            
                            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-black text-[10px] px-6 py-3 rounded-xl transition shadow-md uppercase tracking-widest">
                                Perbarui Catatan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Danger Zone -->
                <div class="pt-6 border-t border-red-100">
                    <form id="deleteForm" action="{{ route('subadmin.pendaftaran.destroy', ['id' => $pendaftaran->id_pendaftaran]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="showDeleteModal()" class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-600 font-black text-xs px-5 py-4 rounded-xl transition-all border border-red-100">
                            <i class="fi fi-rr-trash"></i>
                            Hapus Permanen Pendaftaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reusable Modal Confirm -->
<div id="confirmModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeConfirmModal()"></div>
    <div class="relative w-full max-w-sm bg-white rounded-[32px] p-8 shadow-2xl transform scale-95 transition-transform duration-300" id="confirmModalContent">
        <div id="confirmIconContainer" class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center mx-auto mb-6">
            <i id="confirmIcon" class="fi fi-rr-interrogation text-slate-600 text-3xl mt-2"></i>
        </div>
        <h3 id="targetStatusName" class="text-xl font-black text-slate-900 text-center mb-3">Konfirmasi</h3>
        <p id="confirmMessage" class="text-sm text-slate-500 text-center mb-8 leading-relaxed">Pesan konfirmasi</p>
        
        <div class="flex gap-3 bg-slate-50 p-2 rounded-2xl border border-slate-100">
            <button onclick="closeConfirmModal()" class="flex-1 py-5 text-xs font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-100 transition rounded-xl uppercase tracking-widest">
                Batal
            </button>
            <button id="confirmBtnAction" class="flex-1 py-5 text-xs font-black text-emerald-600 hover:bg-emerald-50 transition rounded-xl uppercase tracking-widest">
                Konfirmasi
            </button>
        </div>
    </div>
</div>

<script>
    // Animation logic for modal
    const modal = document.getElementById('confirmModal');
    const modalContent = document.getElementById('confirmModalContent');

    function openModalAnimation() {
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }

    function closeConfirmModal() {
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function showKonfirmasiModal() {
        const targetName = document.getElementById('targetStatusName');
        const message = document.getElementById('confirmMessage');
        const confirmBtn = document.getElementById('confirmBtnAction');
        const iconContainer = document.getElementById('confirmIconContainer');
        const icon = document.getElementById('confirmIcon');

        targetName.innerText = "Konfirmasi Lunas";
        message.innerHTML = "Apakah Anda yakin mengonfirmasi pembayaran ini sebagai Lunas? Status progres akan otomatis berubah menjadi <span class='text-emerald-600 font-bold uppercase'>Diproses</span>.";
        
        // Emerald theme for konfirmasi
        iconContainer.className = "w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-6";
        icon.className = "fi fi-rr-check-circle text-emerald-600 text-3xl mt-2";
        
        confirmBtn.className = "flex-1 py-5 text-xs font-black text-emerald-600 hover:bg-emerald-50 transition rounded-xl uppercase tracking-widest";
        confirmBtn.innerText = "Ya, Konfirmasi";

        confirmBtn.onclick = function() {
            document.getElementById('formKonfirmasiBukti').submit();
        };

        openModalAnimation();
    }

    function showTolakModal() {
        const targetName = document.getElementById('targetStatusName');
        const message = document.getElementById('confirmMessage');
        const confirmBtn = document.getElementById('confirmBtnAction');
        const iconContainer = document.getElementById('confirmIconContainer');
        const icon = document.getElementById('confirmIcon');

        targetName.innerText = "Tolak Bukti";
        // As requested by user: Jika ditolak, progres TIDAK dibatalkan. Status bayar saja yang diubah menjadi 'ditolak'
        // (The logic is already updated in controller yesterday)
        message.innerHTML = "Tandai bukti pembayaran sebagai tidak valid? User akan diminta mengirim bukti bayar ulang.";
        
        // Red theme for tolak
        iconContainer.className = "w-16 h-16 rounded-2xl bg-amber-50 flex items-center justify-center mx-auto mb-6";
        icon.className = "fi fi-rr-cross text-amber-600 text-3xl mt-2";
        
        confirmBtn.className = "flex-1 py-5 text-xs font-black text-amber-600 hover:bg-amber-50 transition rounded-xl uppercase tracking-widest";
        confirmBtn.innerText = "Ya, Tolak Bukti";

        confirmBtn.onclick = function() {
            document.getElementById('formTolakBukti').submit();
        };

        openModalAnimation();
    }

    function showDeleteModal() {
        const targetName = document.getElementById('targetStatusName');
        const message = document.getElementById('confirmMessage');
        const confirmBtn = document.getElementById('confirmBtnAction');
        const iconContainer = document.getElementById('confirmIconContainer');
        const icon = document.getElementById('confirmIcon');

        targetName.innerText = "Hapus Pendaftaran";
        message.innerHTML = "Tindakan ini <span class='text-red-600 font-bold uppercase'>permanen</span>. Seluruh data pendaftaran ini akan dihapus dari sistem.";
        
        // Red theme for delete
        iconContainer.className = "w-16 h-16 rounded-2xl bg-red-50 flex items-center justify-center mx-auto mb-6";
        icon.className = "fi fi-rr-trash text-red-600 text-3xl mt-2";

        confirmBtn.className = "flex-1 py-5 text-xs font-black text-red-600 hover:bg-red-50 transition rounded-xl uppercase tracking-widest";
        confirmBtn.innerText = "Ya, Hapus";

        confirmBtn.onclick = function() {
            document.getElementById('deleteForm').submit();
        };

        openModalAnimation();
    }
</script>
@endsection
EOD;

file_put_contents('c:/laragon/www/Veritas-Web-Project/resources/views/subadmin/pendaftaran/show.blade.php', $content);
echo "File created successfully.\n";
