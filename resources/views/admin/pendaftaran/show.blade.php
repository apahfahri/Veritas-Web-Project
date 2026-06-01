@extends('layouts.admin')
@section('page-title', 'Detail Pendaftaran #' . $pendaftaran->id_pendaftaran)
@section('page-subtitle', 'Kelola status dan informasi pendaftaran')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.pendaftaran.index') }}" class="text-gray-500 hover:text-[#7d2ae7] text-sm">← Kembali ke Daftar Pendaftaran</a>
</div>

<div class="grid lg:grid-cols-3 gap-6">

    <!-- DETAIL INFO -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold text-[#7d2ae7] mb-4">Informasi Pendaftaran</h2>
            <dl class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-gray-500">ID Pendaftaran</dt>
                    <dd class="font-semibold">#{{ $pendaftaran->id_pendaftaran }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Tanggal Daftar</dt>
                    <dd class="font-semibold">{{ $pendaftaran->tanggal_daftar ? $pendaftaran->tanggal_daftar->format('d M Y') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Nama Pendaftar / PIC</dt>
                    <dd class="font-semibold">{{ $pendaftaran->user?->nama }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Email</dt>
                    <dd class="font-semibold">{{ $pendaftaran->user?->email }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Layanan</dt>
                    <dd class="font-semibold">{{ $pendaftaran->jadwal?->jenis?->nama ?? '-' }}</dd>
                </div>

                @if($pendaftaran->is_utusan_perusahaan || $pendaftaran->id_perusahaan)
                <div>
                    <dt class="text-gray-500">Tipe Klien</dt>
                    <dd class="font-semibold text-[#7d2ae7]">Perusahaan (B2B)</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Nama Perusahaan</dt>
                    <dd class="font-semibold">{{ $pendaftaran->perusahaan?->nama ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Sektor Industri</dt>
                    <dd class="font-semibold">{{ $pendaftaran->perusahaan?->sektor_industri ?? '-' }}</dd>
                </div>
                <div class="col-span-2">
                    <dt class="text-gray-500">Alamat Perusahaan</dt>
                    <dd class="font-semibold">{{ $pendaftaran->perusahaan?->alamat ?? '-' }}</dd>
                </div>
                @else
                <div>
                    <dt class="text-gray-500">Tipe Klien</dt>
                    <dd class="font-semibold text-emerald-600">Individu (B2C)</dd>
                </div>
                @endif

                @if($pendaftaran->jadwal && $pendaftaran->jadwal->id_kategori == 2)
                <div class="col-span-2 border-t pt-3 mt-1">
                    <h4 class="font-semibold text-slate-800 text-xs uppercase tracking-wider mb-2">Detail Jadwal & Pertemuan</h4>
                </div>
                <div>
                    <dt class="text-gray-500">Mode Pertemuan</dt>
                    <dd class="font-semibold uppercase">{{ $pendaftaran->mode_pertemuan ?? $pendaftaran->jadwal->jenis_pertemuan ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">Waktu Pertemuan</dt>
                    <dd class="font-semibold">
                        {{ $pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('d M Y') : '-' }}
                        @if($pendaftaran->jadwal->jam_pertemuan)
                            ({{ $pendaftaran->jadwal->jam_pertemuan }})
                        @endif
                    </dd>
                </div>
                @if($pendaftaran->jadwal->link_meet)
                <div class="col-span-2">
                    <dt class="text-gray-500">Link Meeting Online</dt>
                    <dd class="font-semibold">
                        <a href="{{ $pendaftaran->jadwal->link_meet }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $pendaftaran->jadwal->link_meet }}</a>
                    </dd>
                </div>
                @endif
                @if($pendaftaran->jadwal->lokasi && $pendaftaran->jadwal->jenis_pertemuan === 'offline')
                <div class="col-span-2">
                    <dt class="text-gray-500">Lokasi Pertemuan</dt>
                    <dd class="font-semibold">{{ $pendaftaran->jadwal->lokasi }}</dd>
                </div>
                @endif
                @if($pendaftaran->jadwal->pemateri && $pendaftaran->jadwal->pemateri->isNotEmpty())
                <div class="col-span-2">
                    <dt class="text-gray-500">Konsultan / Pemateri</dt>
                    <dd class="font-semibold text-slate-700">
                        <ul class="list-disc pl-5 mt-1 space-y-1">
                            @foreach($pendaftaran->jadwal->pemateri as $pemateri)
                                <li>{{ $pemateri->nama_lengkap }} ({{ $pemateri->kompetensi ?? 'Konsultan' }})</li>
                            @endforeach
                        </ul>
                    </dd>
                </div>
                @endif
                @endif
            </dl>
        </div>

        @if($pendaftaran->sertifikat)
        <div class="bg-green-50 border border-green-200 p-6 rounded-xl">
            <h3 class="font-semibold text-green-700 mb-2">🏆 Sertifikat Telah Diterbitkan</h3>
            <p class="text-sm text-green-600">No. Sertifikat: <strong>{{ $pendaftaran->sertifikat->no_sertifikat }}</strong></p>
            <p class="text-sm text-green-600">Nama: <strong>{{ $pendaftaran->sertifikat->nama_lengkap }}</strong></p>
            <p class="text-sm text-green-600">Terbit: <strong>{{ $pendaftaran->sertifikat->tanggal_terbit ? $pendaftaran->sertifikat->tanggal_terbit->format('d M Y') : '-' }}</strong></p>
        </div>
        @endif
    </div>

    <!-- STATUS DETAIL -->
    <div class="bg-white p-6 rounded-xl shadow space-y-6">
        <div>
            <h3 class="font-semibold text-[#7d2ae7] border-b pb-2 mb-4">Status Pendaftaran</h3>

            @php
                $isConsultation = $pendaftaran->jadwal && $pendaftaran->jadwal->id_kategori == 2;

                $progresLabels = [
                    'meninjau' => '🔍 Meninjau',
                    'disetujui' => '👍 Disetujui',
                    'dijadwalkan' => '📅 Dijadwalkan',
                    'berlangsung' => '🔄 Berlangsung',
                    'menunggu_pembayaran' => $isConsultation ? '⏳ Menunggu Pembayaran' : '⏳ Menunggu Bayar',
                    'pembayaran_ditinjau' => '💳 Pembayaran Ditinjau',
                    'diproses' => '🔄 Diproses',
                    'selesai' => '✅ Selesai',
                    'dibatalkan' => '❌ Dibatalkan',
                ];

                $bayarLabels = [
                    'belum_bayar' => '💳 Belum Bayar',
                    'belum_lunas' => '💳 Belum Lunas',
                    'dp' => '💵 DP',
                    'menunggu_konfirmasi' => '⏳ Menunggu Konfirmasi',
                    'lunas' => '💰 Lunas',
                ];

                $currentProgres = $progresLabels[$pendaftaran->status_progres] ?? $pendaftaran->status_progres;
                $currentBayar = $bayarLabels[$pendaftaran->status_bayar] ?? $pendaftaran->status_bayar;
            @endphp

            <div class="space-y-4">
                <div>
                    <span class="block text-xs font-medium mb-1 text-gray-500 uppercase tracking-wider">Status Progres</span>
                    <div class="text-sm font-semibold py-2.5 px-3 bg-gray-50 border rounded-lg text-gray-800 flex items-center">
                        {{ $currentProgres }}
                    </div>
                </div>

                <div>
                    <span class="block text-xs font-medium mb-1 text-gray-500 uppercase tracking-wider">Status Pembayaran</span>
                    <div class="text-sm font-semibold py-2.5 px-3 bg-gray-50 border rounded-lg text-gray-800 flex items-center">
                        {{ $currentBayar }}
                    </div>
                </div>
            </div>
        </div>

        @if($pendaftaran->status_progres === 'selesai' && $pendaftaran->status_bayar === 'lunas' && !$pendaftaran->sertifikat)
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('admin.sertifikat.create', $pendaftaran->id_pendaftaran) }}"
               class="block w-full text-center bg-[#7d2ae7] text-white py-2.5 rounded-lg hover:opacity-90 text-sm">
                🏆 Terbitkan Sertifikat
            </a>
        </div>
        @endif
    </div>

</div>

@endsection
