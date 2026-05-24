<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengingat Pelatihan - Veritas</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 20px;
            color: #334155;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #0891b2;
            color: #ffffff;
            padding: 25px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 13px;
            color: #cffafe;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 16px;
            color: #0f172a;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f8fafc;
            border-left: 4px solid #0891b2;
            padding: 20px;
            border-radius: 0 8px 8px 0;
            margin-bottom: 25px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-item:last-child {
            margin-bottom: 0;
        }
        .info-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .info-value {
            font-size: 15px;
            color: #0f172a;
            font-weight: 800;
        }
        .section-title {
            font-size: 14px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 8px;
            margin-top: 25px;
            margin-bottom: 15px;
        }
        .deskripsi {
            background-color: #f1f5f9;
            padding: 15px;
            border-radius: 8px;
            font-size: 14px;
            color: #475569;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
        .footer a {
            color: #0891b2;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>PENGINGAT PELATIHAN (H-3)</h1>
            <p>PT Katiga Veritas Indonesia</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $user->nama }}</strong>,
                <br><br>
                Kami ingin mengingatkan bahwa program pelatihan Anda di <strong>PT Katiga Veritas Indonesia</strong> akan dilaksanakan dalam waktu 3 hari ke depan. Berikut adalah detail pelaksanaan kegiatan:
            </div>

            <div class="info-box">
                <div class="info-item">
                    <div class="info-label">Program Pelatihan</div>
                    <div class="info-value">{{ $jadwal->nama_program }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Jadwal Pelaksanaan</div>
                    <div class="info-value">
                        {{ $jadwal->tgl_mulai ? $jadwal->tgl_mulai->format('d M Y') : '-' }} 
                        @if($jadwal->tgl_selesai && $jadwal->tgl_selesai != $jadwal->tgl_mulai)
                            s.d {{ $jadwal->tgl_selesai->format('d M Y') }}
                        @endif
                    </div>
                </div>
                @if($jadwal->jam_pertemuan)
                <div class="info-item">
                    <div class="info-label">Waktu</div>
                    <div class="info-value">{{ date('H:i', strtotime($jadwal->jam_pertemuan)) }} WIB</div>
                </div>
                @endif
                <div class="info-item">
                    <div class="info-label">Mode / Lokasi</div>
                    <div class="info-value">
                        {{ strtoupper($jadwal->jenis_pertemuan) }} 
                        @if($jadwal->lokasi) - {{ $jadwal->lokasi }} @endif
                    </div>
                </div>
            </div>

            @if($jadwal->deskripsi)
            <div class="section-title">Materi & Rundown Pelatihan</div>
            <div class="deskripsi">
                {!! nl2br(e($jadwal->deskripsi)) !!}
            </div>
            @endif

            <p style="margin-top: 25px; font-size: 14px;">
                Harap mempersiapkan diri sesuai dengan jadwal yang telah ditentukan. Jika ada pertanyaan lebih lanjut, silakan hubungi tim kami.
                <br><br>
                Terima kasih,<br>
                <strong>Tim PT Katiga Veritas Indonesia</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} PT Katiga Veritas Indonesia. All rights reserved.<br>
            <a href="{{ url('/') }}">Kunjungi Website Kami</a>
        </div>
    </div>
</body>
</html>
