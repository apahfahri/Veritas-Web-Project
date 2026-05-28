<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Konfirmasi Pelaksanaan Pelatihan</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #1e293b;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f8fafc;
            padding: 30px;
            border: 1px solid #e2e8f0;
            border-top: none;
            border-radius: 0 0 8px 8px;
        }
        .details-box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #e2e8f0;
        }
        .details-row {
            margin-bottom: 10px;
        }
        .details-label {
            font-weight: bold;
            color: #475569;
            width: 120px;
            display: inline-block;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0;">Surat Konfirmasi Pelaksanaan Pelatihan</h2>
    </div>
    
    <div class="content">
        <p>Yth. <strong>{{ $pendaftaran->user->name ?? $pendaftaran->user->email }}</strong>,</p>
        
        <p>Terima kasih telah mendaftar pelatihan bersama kami. Kami ingin menginformasikan bahwa pelatihan Anda akan segera dimulai. Berikut adalah rincian pelaksanaannya:</p>
        
        <div class="details-box">
            <div class="details-row">
                <span class="details-label">Program:</span>
                {{ $pendaftaran->jadwal->jenis->nama ?? '-' }}
            </div>
            <div class="details-row">
                <span class="details-label">Tanggal:</span>
                {{ $pendaftaran->jadwal->tgl_mulai ? $pendaftaran->jadwal->tgl_mulai->format('d M Y') : '-' }} s/d {{ $pendaftaran->jadwal->tgl_selesai ? $pendaftaran->jadwal->tgl_selesai->format('d M Y') : '-' }}
            </div>
            <div class="details-row">
                <span class="details-label">Waktu:</span>
                {{ $pendaftaran->jadwal->jam_pertemuan ? date('H:i', strtotime($pendaftaran->jadwal->jam_pertemuan)) : '-' }} WIB
            </div>
            <div class="details-row">
                <span class="details-label">Mode:</span>
                <span style="text-transform: capitalize;">{{ $pendaftaran->jadwal->jenis_pertemuan }}</span>
            </div>
            <div class="details-row">
                <span class="details-label">Lokasi:</span>
                {{ $pendaftaran->jadwal->lokasi ?? '-' }}
            </div>
            @if($pendaftaran->jadwal->link_meet)
            <div class="details-row">
                <span class="details-label">Link Meet:</span>
                <a href="{{ $pendaftaran->jadwal->link_meet }}">{{ $pendaftaran->jadwal->link_meet }}</a>
            </div>
            @endif
        </div>

        <p>Bersama email ini, kami telah melampirkan <strong>Rundown</strong> dan <strong>Materi Pelatihan</strong> (jika tersedia) untuk Anda pelajari sebelum kelas dimulai.</p>
        
        <p>Harap hadir tepat waktu sesuai jadwal yang tertera. Jika ada pertanyaan lebih lanjut, silakan balas email ini atau hubungi tim *support* kami.</p>

        <p style="margin-top: 30px;">
            Salam hangat,<br>
            <strong>Tim {{ config('app.name', 'Veritas') }}</strong>
        </p>
    </div>

    <div class="footer">
        Email ini dibuat secara otomatis oleh sistem. Mohon tidak membalas langsung ke alamat email *no-reply*.
    </div>
</body>
</html>
