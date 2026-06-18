@extends('layouts.admin')
@section('page-title', 'Detail Pendaftaran #' . $pendaftaran->id_pendaftaran)
@section('page-subtitle', 'Kelola status dan informasi pendaftaran')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.pendaftaran.index') }}" class="text-slate-500 hover:text-indigo-600 text-sm font-semibold flex items-center gap-2 transition w-max">
        <i class="fi fi-rr-arrow-left"></i>
        Kembali ke Daftar
    </a>
</div>

<div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
    <!-- Header Card -->
    <div class="bg-slate-50/50 border-b border-slate-100 p-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="bg-indigo-100 text-indigo-700 text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">ID: #{{ $pendaftaran->id_pendaftaran }}</span>
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
                    'menunggu_pembayaran' => $isConsultation ? '<i class="fi fi-rr-credit-card mt-1"></i> Menunggu Pembayaran' : '<i class="fi fi-rr-credit-card mt-1"></i> Menunggu Bayar',
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
                <span class="text-sm font-bold text-indigo-600 flex items-center gap-1.5">{!! $currentProgres !!}</span>
            </div>
            <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm min-w-[160px] shrink-0">
                <span class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status Pembayaran</span>
                <span class="text-sm font-bold {{ $pendaftaran->status_bayar === 'lunas' ? 'text-emerald-600' : 'text-amber-600' }} flex items-center gap-1.5">{!! $currentBayar !!}</span>
            </div>
        </div>
    </div>

    <!-- Body Card -->
    <div class="p-8">
        <div class="grid md:grid-cols-2 gap-10">
            <!-- Left Column: User & Company Info -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
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
                        <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-4">
                            <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Tipe Klien</div>
                            <div class="col-span-2 text-sm font-semibold text-slate-900">
                                @if($pendaftaran->is_utusan_perusahaan || $pendaftaran->id_perusahaan)
                                    <span class="text-indigo-600 font-bold bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">Perusahaan (B2B)</span>
                                @else
                                    <span class="text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">Individu (B2C)</span>
                                @endif
                            </div>
                        </div>

                        @if($pendaftaran->is_utusan_perusahaan || $pendaftaran->id_perusahaan)
                            <div class="grid grid-cols-3 gap-4 pb-1">
                                <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Perusahaan</div>
                                <div class="col-span-2 text-sm font-semibold text-slate-900">{{ $pendaftaran->perusahaan?->nama ?? '-' }}</div>
                            </div>
                            <div class="grid grid-cols-3 gap-4 pb-1">
                                <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Sektor</div>
                                <div class="col-span-2 text-sm font-semibold text-slate-900">{{ $pendaftaran->perusahaan?->sektor_industri ?? '-' }}</div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Alamat</div>
                                <div class="col-span-2 text-sm font-medium text-slate-600 leading-relaxed">{{ $pendaftaran->perusahaan?->alamat ?? '-' }}</div>
                            </div>
                        @endif
                    </div>
                </div>
                
                @if($pendaftaran->sertifikat)
                <div>
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-200 rounded-2xl p-6 relative overflow-hidden group">
                        <div class="absolute -right-6 -top-6 text-emerald-500/10 group-hover:scale-110 transition duration-500">
                            <i class="fi fi-rr-star"></i>
                        </div>
                        <h3 class="font-bold text-emerald-800 mb-4 relative z-10 flex items-center gap-2 text-sm uppercase tracking-widest">
                            <i class="fi fi-rr-diploma"></i>
                            Sertifikat Diterbitkan
                        </h3>
                        <div class="space-y-3 relative z-10">
                            <p class="text-sm text-emerald-800 flex flex-col"><span class="font-semibold text-[10px] uppercase tracking-widest text-emerald-600/70 mb-0.5">No. Sertifikat:</span> <span class="font-black">{{ $pendaftaran->sertifikat->no_sertifikat }}</span></p>
                            <p class="text-sm text-emerald-800 flex flex-col"><span class="font-semibold text-[10px] uppercase tracking-widest text-emerald-600/70 mb-0.5">Nama Tercantum:</span> <span class="font-black">{{ $pendaftaran->sertifikat->nama_lengkap }}</span></p>
                            <p class="text-sm text-emerald-800 flex flex-col"><span class="font-semibold text-[10px] uppercase tracking-widest text-emerald-600/70 mb-0.5">Tanggal Terbit:</span> <span class="font-black">{{ $pendaftaran->sertifikat->tanggal_terbit ? $pendaftaran->sertifikat->tanggal_terbit->format('d M Y') : '-' }}</span></p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column: Training Schedule & Action -->
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
                        @php
                            $isBespoke = $pendaftaran->jadwal && in_array($pendaftaran->jadwal->id_kategori, [2, 3]) || $pendaftaran->is_kustom;
                            
                            if ($isBespoke) {
                                $stages = [
                                    'meninjau'            => ['icon' => '<i class="fi fi-rr-eye"></i>', 'label' => 'Ditinjau'],
                                    'disetujui'           => ['icon' => '<i class="fi fi-rr-check-circle"></i>', 'label' => 'Disetujui'],
                                    'dijadwalkan'         => ['icon' => '<i class="fi fi-rr-calendar"></i>', 'label' => 'Penjadwalan'],
                                    'menunggu_pelaksanaan' => ['icon' => '<i class="fi fi-rr-clock"></i>', 'label' => 'Terjadwal'],
                                    'berlangsung'         => ['icon' => '<i class="fi fi-rr-play"></i>', 'label' => 'Berlangsung'],
                                    'menunggu_pembayaran' => ['icon' => '<i class="fi fi-rr-credit-card"></i>', 'label' => 'Tagihan'],
                                    'pembayaran_ditinjau' => ['icon' => '<i class="fi fi-rr-time-past"></i>', 'label' => 'Verifikasi'],
                                    'selesai'             => ['icon' => '<i class="fi fi-rr-trophy"></i>', 'label' => 'Selesai'],
                                ];
                            } else {
                                $stages = [
                                    'menunggu_pembayaran' => ['icon' => '<i class="fi fi-rr-credit-card"></i>', 'label' => 'Tagihan'],
                                    'menunggu'            => ['icon' => '<i class="fi fi-rr-clock"></i>', 'label' => 'Verifikasi'],
                                    'diproses'            => ['icon' => '<i class="fi fi-rr-checkbox"></i>', 'label' => 'Terkonfirmasi'],
                                    'berlangsung'         => ['icon' => '<i class="fi fi-rr-play"></i>', 'label' => 'Berlangsung'],
                                    'selesai'             => ['icon' => '<i class="fi fi-rr-trophy"></i>', 'label' => 'Selesai'],
                                ];
                            }
                            
                            $stageKeys  = array_keys($stages);
                            $curStatus  = $pendaftaran->status_progres;
                            
                            // Dynamic logic for berlangsung
                            if (!$isBespoke && $curStatus === 'diproses' && $pendaftaran->jadwal && in_array($pendaftaran->jadwal->status_pelaksanaan, ['Berlangsung', 'Selesai'])) {
                                $curStatus = 'berlangsung';
                            } elseif ($isBespoke && $curStatus === 'menunggu_pelaksanaan' && $pendaftaran->jadwal && in_array($pendaftaran->jadwal->status_pelaksanaan, ['Berlangsung', 'Selesai'])) {
                                $curStatus = 'berlangsung';
                            }
                            
                            $isCanceled = ($curStatus === 'dibatalkan');
                            $currentIdx = array_search($curStatus, $stageKeys);
                        @endphp

                        @if($isCanceled)
                            <div class="flex items-center gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                                <i class="fi fi-rr-cross-circle text-red-500 text-xl"></i>
                                <div>
                                    <p class="text-sm font-bold text-red-800">Pendaftaran Dibatalkan</p>
                                    <p class="text-xs text-red-600 mt-0.5">Layanan ini telah dibatalkan.</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-0 overflow-x-auto pb-1 scrollbar-hide">
                                @foreach($stages as $stageKey => $stageInfo)
                                    @php
                                        $stageIdx = array_search($stageKey, $stageKeys);
                                        $isDone   = ($currentIdx !== false && $stageIdx < $currentIdx);
                                        $isActive = ($curStatus === $stageKey);
                                    @endphp
                                    <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }} shrink-0">
                                        <div class="flex flex-col items-center gap-1.5 min-w-[52px]">
                                             <div class="w-10 h-10 rounded-full flex items-center justify-center text-base border-2 transition-all
                                                @if($isDone) bg-emerald-500 border-emerald-500 text-white shadow-sm
                                                @elseif($isActive) bg-indigo-600 border-indigo-600 text-white shadow-md ring-4 ring-indigo-600/20
                                                @else bg-white border-slate-200 text-slate-300
                                                @endif">
                                                @if($isDone)<i class="fi fi-rr-check text-sm mt-1"></i>@else{!! str_replace('<i class="', '<i class="mt-1 ', $stageInfo['icon']) !!}@endif
                                            </div>
                                            <span class="text-[9px] font-bold text-center leading-tight whitespace-nowrap
                                                @if($isDone) text-emerald-600
                                                @elseif($isActive) text-indigo-700
                                                @else text-slate-400
                                                @endif">{{ $stageInfo['label'] }}</span>
                                        </div>
                                        @if(!$loop->last)
                                            <div class="flex-1 h-0.5 mx-2 rounded-full {{ $stageIdx < $currentIdx ? 'bg-emerald-400' : 'bg-slate-200' }}"></div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Catatan Internal (Read-only) -->
                <div>
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                            <i class="fi fi-rr-notebook"></i>
                        </div>
                        Catatan Internal
                    </h3>
                    
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-6">
                        @if($pendaftaran->last_reminder_sent_at)
                            <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl mb-3">
                                <span class="text-[9px] font-black text-amber-600 uppercase tracking-widest block mb-1">Pembaruan Terakhir oleh Tim:</span>
                                <p class="text-xs font-bold text-slate-700 mb-2">{{ $pendaftaran->last_reminder_sent_at->format('d M Y, H:i') }}</p>
                                <p class="text-xs font-medium text-slate-600 leading-relaxed italic bg-white p-3 rounded-lg border border-amber-100">"{{ $pendaftaran->last_reminder_details }}"</p>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <p class="text-xs font-bold text-slate-400">Belum ada catatan internal dari tim subadmin.</p>
                            </div>
                        @endif
                        <p class="text-[10px] text-slate-500 mt-2 text-center">Anda hanya dapat melihat catatan. Catatan dikelola oleh tim pelaksana.</p>
                    </div>
                </div>

                @if($pendaftaran->jadwal && $pendaftaran->jadwal->id_kategori == 2)
                <div>
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500">
                            <i class="fi fi-rr-calendar"></i>
                        </div>
                        Detail Jadwal
                    </h3>
                    <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-6 space-y-4">
                        <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-4">
                            <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Mode</div>
                            <div class="col-span-2 text-sm font-semibold text-slate-900 uppercase">
                                <span class="bg-amber-100 text-amber-700 px-2 py-0.5 rounded border border-amber-200/50">{{ $pendaftaran->mode_pertemuan ?? $pendaftaran->jadwal->jenis_pertemuan ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-4">
                            <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Waktu</div>
                            <div class="col-span-2 text-sm font-semibold text-slate-900">
                                {{ $pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('d M Y') : '-' }}
                                @if($pendaftaran->jadwal->jam_pertemuan)
                                    <span class="text-slate-400 ml-1 font-medium bg-white border px-1.5 py-0.5 rounded text-xs">{{ $pendaftaran->jadwal->jam_pertemuan }}</span>
                                @endif
                            </div>
                        </div>

                        @if($pendaftaran->jadwal->link_meet)
                        <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-4">
                            <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Link</div>
                            <div class="col-span-2 text-sm font-semibold">
                                <a href="{{ $pendaftaran->jadwal->link_meet }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 hover:underline break-all">{{ $pendaftaran->jadwal->link_meet }}</a>
                            </div>
                        </div>
                        @endif

                        @if($pendaftaran->jadwal->lokasi && $pendaftaran->jadwal->jenis_pertemuan === 'offline')
                        <div class="grid grid-cols-3 gap-4 border-b border-slate-100 pb-4">
                            <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Lokasi</div>
                            <div class="col-span-2 text-sm font-medium text-slate-600 leading-relaxed">{{ $pendaftaran->jadwal->lokasi }}</div>
                        </div>
                        @endif

                        @if($pendaftaran->jadwal->pemateri && $pendaftaran->jadwal->pemateri->isNotEmpty())
                        <div class="grid grid-cols-3 gap-4 pt-1">
                            <div class="col-span-1 text-xs font-bold text-slate-500 uppercase tracking-wider pt-0.5">Konsultan</div>
                            <div class="col-span-2 text-sm font-semibold text-slate-900">
                                <ul class="space-y-2">
                                    @foreach($pendaftaran->jadwal->pemateri as $pemateri)
                                        <li class="flex flex-col">
                                            <span>{{ $pemateri->nama_lengkap }}</span>
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ $pemateri->kompetensi ?? 'Konsultan' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                @if($pendaftaran->status_progres === 'selesai' && $pendaftaran->status_bayar === 'lunas' && !$pendaftaran->sertifikat)
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <a href="{{ route('admin.sertifikat.create', $pendaftaran->id_pendaftaran) }}"
                       class="flex items-center justify-center gap-3 w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-slate-800 transition shadow-lg shadow-slate-200 group">
                        <i class="fi fi-rr-diploma text-amber-400 group-hover:scale-110 transition"></i>
                        Terbitkan Sertifikat
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
