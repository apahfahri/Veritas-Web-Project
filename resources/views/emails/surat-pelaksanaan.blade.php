<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Undangan Pelaksanaan Pelatihan Kustom</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #1E6B3D; padding-bottom: 20px; margin-bottom: 20px; }
        .header h1 { color: #1E6B3D; margin: 0; font-size: 24px; }
        .content p { margin: 10px 0; }
        .details { background-color: #f0fdf4; border-left: 4px solid #1E6B3D; padding: 15px; margin: 20px 0; }
        .details p { margin: 5px 0; }
        .btn { display: inline-block; padding: 10px 20px; background-color: #1E6B3D; color: #fff; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 15px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Surat Undangan Pelatihan</h1>
        </div>
        
        <div class="content">
            <p>Halo <strong>{{ $participant->nama }}</strong>,</p>
            <p>Ini adalah pengingat bahwa Anda telah dijadwalkan untuk mengikuti <strong>Pelatihan Kustom (B2B)</strong> yang diselenggarakan oleh perusahaan Anda melalui platform kami.</p>
            
            <div class="details">
                <p><strong>Topik Pelatihan:</strong> {{ $pendaftaran->jadwal?->jenis?->nama ?? 'Pelatihan Kustom B2B' }}</p>
                <p><strong>Tanggal Pelaksanaan:</strong> {{ $pendaftaran->rencana_tanggal_mulai ? $pendaftaran->rencana_tanggal_mulai->format('d M Y') : '-' }}</p>
                <p><strong>Jam:</strong> {{ $pendaftaran->jadwal?->jam_pertemuan ?? '-' }} WIB</p>
                <p><strong>Mode Pelaksanaan:</strong> {{ ucfirst($pendaftaran->mode_pertemuan ?? '-') }}</p>
                
                @if(in_array($pendaftaran->mode_pertemuan, ['online', 'hybrid']) && $pendaftaran->jadwal?->link_meet)
                    <p><strong>Tautan Kelas:</strong> <a href="{{ $pendaftaran->jadwal->link_meet }}">{{ $pendaftaran->jadwal->link_meet }}</a></p>
                @elseif($pendaftaran->mode_pertemuan === 'offline' && $pendaftaran->jadwal?->lokasi)
                    <p><strong>Lokasi:</strong> {{ $pendaftaran->jadwal->lokasi }}</p>
                @endif
            </div>

            <p>Silakan persiapkan diri Anda dan hadir tepat waktu. Jika Anda memiliki pertanyaan lebih lanjut, Anda dapat menghubungi PIC perusahaan Anda atau membalas email ini.</p>
            
            @if(in_array($pendaftaran->mode_pertemuan, ['online', 'hybrid']) && $pendaftaran->jadwal?->link_meet)
                <div style="text-align: center;">
                    <a href="{{ $pendaftaran->jadwal->link_meet }}" class="btn">Bergabung ke Kelas</a>
                </div>
            @endif
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} PT Katiga Veritas Solusindo. Semua hak dilindungi.</p>
        </div>
    </div>
</body>
</html>
