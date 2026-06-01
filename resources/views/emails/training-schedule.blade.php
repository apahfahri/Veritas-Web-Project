<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Konfirmasi Jadwal Pelaksanaan Pelatihan Kustom</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #334155;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8fafc;
        }
        .container {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        .header {
            background-color: #1E6B3D;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 12px;
        }
        .intro {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 24px;
        }
        .details-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .details-title {
            font-size: 14px;
            font-weight: 700;
            color: #1E6B3D;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }
        .details-row {
            display: table;
            width: 100%;
            margin-bottom: 12px;
            font-size: 14px;
        }
        .details-row:last-child {
            margin-bottom: 0;
        }
        .details-label {
            display: table-cell;
            font-weight: 600;
            color: #475569;
            width: 150px;
            vertical-align: top;
        }
        .details-value {
            display: table-cell;
            color: #1e293b;
            vertical-align: top;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 6px;
            text-transform: uppercase;
        }
        .badge-online {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .badge-offline {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .badge-hybrid {
            background-color: #fef3c7;
            color: #92400e;
        }
        .link-button {
            display: inline-block;
            background-color: #1E6B3D;
            color: white !important;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 5px;
        }
        .link-button:hover {
            opacity: 0.9;
        }
        .pemateri-list {
            margin: 0;
            padding-left: 20px;
            color: #1e293b;
        }
        .pemateri-list li {
            margin-bottom: 4px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Jadwal Pelaksanaan Pelatihan Kustom</h2>
        </div>
        
        <div class="content">
            <p class="greeting">Yth. Perwakilan {{ $pendaftaran->perusahaan->nama ?? 'Klien' }},</p>
            
            <p class="intro">Permintaan pelatihan kustom (in-house/bespoke) untuk perusahaan Anda telah berhasil dijadwalkan oleh tim kami. Berikut adalah rincian pelaksanaan pelatihan:</p>
            
            <div class="details-box">
                <h4 class="details-title">Detail Pelaksanaan Pelatihan</h4>
                
                <div class="details-row">
                    <span class="details-label">ID Pendaftaran:</span>
                    <span class="details-value">#{{ $pendaftaran->id_pendaftaran }}</span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Layanan:</span>
                    <span class="details-value"><strong>{{ $pendaftaran->jadwal->jenis->nama ?? '-' }}</strong></span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Tanggal Pelaksanaan:</span>
                    <span class="details-value">
                        @php
                            $tglMulai = $pendaftaran->jadwal->tgl_mulai ?? $pendaftaran->rencana_tanggal_mulai;
                            $tglSelesai = $pendaftaran->jadwal->tgl_selesai ?? $pendaftaran->rencana_tanggal_selesai;
                        @endphp
                        @if($tglMulai)
                            {{ $tglMulai->format('d M Y') }}
                            @if($tglSelesai && $tglSelesai != $tglMulai)
                                s/d {{ $tglSelesai->format('d M Y') }}
                            @endif
                        @else
                            -
                        @endif
                    </span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Jam Pelaksanaan:</span>
                    <span class="details-value">{{ $pendaftaran->jadwal->jam_pertemuan ?? '-' }}</span>
                </div>
                
                <div class="details-row">
                    <span class="details-label">Mode Pertemuan:</span>
                    <span class="details-value">
                        @php
                            $mode = strtolower($pendaftaran->mode_pertemuan ?? $pendaftaran->jadwal->jenis_pertemuan ?? 'offline');
                        @endphp
                        <span class="badge badge-{{ $mode }}">{{ $mode }}</span>
                    </span>
                </div>
                
                @if($mode === 'offline' && $pendaftaran->jadwal->lokasi)
                <div class="details-row">
                    <span class="details-label">Lokasi Pertemuan:</span>
                    <span class="details-value">{{ $pendaftaran->jadwal->lokasi }}</span>
                </div>
                @endif
 
                @if(($mode === 'online' || $mode === 'hybrid') && $pendaftaran->jadwal->link_meet)
                <div class="details-row">
                    <span class="details-label">Link Meeting:</span>
                    <span class="details-value">
                        <a href="{{ $pendaftaran->jadwal->link_meet }}" target="_blank" class="link-button">Gabung Kelas</a>
                        <div style="margin-top: 5px; font-size: 12px; color: #64748b; word-break: break-all;">
                            {{ $pendaftaran->jadwal->link_meet }}
                        </div>
                    </span>
                </div>
                @endif
 
                @if($pendaftaran->jadwal->pemateri && $pendaftaran->jadwal->pemateri->isNotEmpty())
                <div class="details-row">
                    <span class="details-label">Instruktur / Pemateri:</span>
                    <span class="details-value">
                        <ul class="pemateri-list">
                            @foreach($pendaftaran->jadwal->pemateri as $instruktur)
                                <li><strong>{{ $instruktur->nama_lengkap }}</strong></li>
                            @endforeach
                        </ul>
                    </span>
                </div>
                @endif
            </div>
 
            <p class="intro">Harap informasikan jadwal ini kepada seluruh karyawan/peserta utusan perusahaan Anda agar dapat mempersiapkan diri dan hadir tepat waktu. Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi tim administrasi kami.</p>
            
            <p style="margin-top: 30px; font-size: 14px; color: #1e293b;">
                Salam hangat,<br>
                <strong>Tim {{ config('app.name', 'Veritas') }}</strong>
            </p>
            
            <div class="footer">
                Email ini dikirimkan secara otomatis oleh sistem Veritas. Mohon tidak membalas langsung ke alamat email ini.
            </div>
        </div>
    </div>
</body>
</html>
