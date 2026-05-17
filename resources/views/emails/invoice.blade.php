<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pendaftaran - Veritas</title>
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
        }
        .header {
            background-color: #0f172a;
            color: #ffffff;
            padding: 30px;
            text-align: left;
            border-bottom: 4px solid #0891b2;
        }
        .header-logo {
            font-size: 24px;
            font-weight: 800;
            color: #0891b2;
            letter-spacing: 2px;
            margin: 0;
            text-transform: uppercase;
        }
        .header-subtitle {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 700;
            margin: 5px 0 0 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .invoice-title {
            float: right;
            text-align: right;
            color: #ffffff;
        }
        .invoice-title h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 900;
        }
        .invoice-title p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #38bdf8;
            font-weight: bold;
        }
        .content {
            padding: 30px;
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
        .table-details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-details td {
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        .table-details td.label {
            font-weight: 600;
            color: #64748b;
            width: 35%;
        }
        .table-details td.value {
            color: #0f172a;
            font-weight: 700;
            text-align: right;
        }
        .bank-info {
            background-color: #f8fafc;
            border-left: 4px solid #0891b2;
            border-radius: 8px;
            padding: 20px;
            margin-top: 15px;
        }
        .bank-info p {
            margin: 5px 0;
            font-size: 14px;
        }
        .bank-info .bank-name {
            font-weight: 800;
            color: #0f172a;
        }
        .bank-info .acc-number {
            font-size: 18px;
            font-weight: 900;
            color: #0891b2;
            margin: 8px 0;
            letter-spacing: 0.5px;
        }
        .bank-info .acc-name {
            font-weight: 700;
            color: #475569;
        }
        .cta-section {
            text-align: center;
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            padding: 25px;
            margin-top: 30px;
        }
        .cta-section p {
            font-size: 14px;
            color: #475569;
            margin-top: 0;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .btn-whatsapp {
            display: inline-block;
            background-color: #22c55e;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 800;
            border-radius: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .option-divider {
            margin: 15px 0;
            font-size: 12px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .option-email {
            font-size: 14px;
            color: #0f172a;
            font-weight: bold;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            margin: 5px 0;
        }
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header clearfix">
            <div style="float: left;">
                <h1 class="header-logo">VERITAS</h1>
                <p class="header-subtitle">PT Katiga Veritas Indonesia</p>
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <p>#INV-{{ $pendaftaran->id_pendaftaran }}</p>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <p style="margin-top: 0; font-size: 15px;">
                Halo <strong>{{ $user->nama }}</strong>,<br>
                Terima kasih telah mendaftar di program <strong>PT Katiga Veritas Indonesia</strong>. Berikut adalah rincian tagihan invoice pendaftaran Anda:
            </p>

            <!-- Invoice Details -->
            <div class="section-title">Detail Pendaftaran</div>
            <table class="table-details">
                <tr>
                    <td class="label">Nama Lengkap</td>
                    <td class="value">{{ $user->nama }}</td>
                </tr>
                <tr>
                    <td class="label">Email Peserta</td>
                    <td class="value">{{ $user->email }}</td>
                </tr>
                <tr>
                    <td class="label">Program / Layanan</td>
                    <td class="value">{{ $layanan->nama ?? ($layanan->materi ?? 'Layanan Veritas') }}</td>
                </tr>
                @if($pendaftaran->rencana_tanggal_mulai)
                <tr>
                    <td class="label">Rencana Tanggal</td>
                    <td class="value">
                        {{ $pendaftaran->rencana_tanggal_mulai->format('d M Y') }}
                        @if($pendaftaran->rencana_tanggal_selesai && $pendaftaran->rencana_tanggal_selesai != $pendaftaran->rencana_tanggal_mulai)
                            s/d {{ $pendaftaran->rencana_tanggal_selesai->format('d M Y') }}
                        @endif
                    </td>
                </tr>
                @endif
                @if($pendaftaran->mode_pertemuan)
                <tr>
                    <td class="label">Mode Pertemuan</td>
                    <td class="value">{{ ucfirst($pendaftaran->mode_pertemuan) }}</td>
                </tr>
                @endif
                <tr>
                    <td class="label">Tanggal Transaksi</td>
                    <td class="value">{{ $pendaftaran->created_at ? $pendaftaran->created_at->format('d M Y - H:i') : now()->format('d M Y') }} WIB</td>
                </tr>
                <tr>
                    <td class="label" style="font-size: 16px; color: #0f172a; font-weight: 800; border-bottom: none; padding-top: 15px;">Total Tagihan</td>
                    <td class="value" style="font-size: 18px; color: #0891b2; font-weight: 900; border-bottom: none; padding-top: 15px;">
                        Rp {{ number_format($layanan->harga ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            </table>

            <!-- Payment Instructions -->
            <div class="section-title">Instruksi Pembayaran</div>
            <p style="font-size: 14px; margin-bottom: 10px;">
                Silakan lakukan transfer pembayaran penuh sejumlah nominal di atas ke rekening resmi kami berikut:
            </p>
            <div class="bank-info">
                <div class="bank-name">🏦 Bank Mandiri</div>
                <div class="acc-number">131-00-1886111-1</div>
                <div class="acc-name">A.N. PT Katiga Veritas Indonesia</div>
            </div>

            <!-- CTA Section -->
            <div class="section-title">Konfirmasi Pembayaran</div>
            <div class="cta-section">
                <p>Untuk melanjutkan ke tahap berikutnya, silakan lakukan pembayaran dan konfirmasikan bukti transfer Anda melalui salah satu cara di bawah ini:</p>
                
                <div style="background-color: #fffbeb; border-left: 3px solid #fbbf24; padding: 12px; margin-bottom: 20px; text-align: left; border-radius: 4px;">
                    <p style="margin: 0; font-size: 13px; color: #b45309;">
                        <strong>Informasi Penting:</strong> Proses konfirmasi pembayaran dilakukan pada jam kerja operasional kami. Jika konfirmasi pembayaran dilakukan di luar jam kerja, maka akan diproses pada jam kerja berikutnya.
                    </p>
                </div>
                
                <!-- Option 1: WhatsApp -->
                @php
                    $waNumber = config('app.whatsapp_number', '6281234567890');
                    $waText = "Halo Veritas, Saya ingin konfirmasi pembayaran untuk Invoice #INV-" . $pendaftaran->id_pendaftaran;
                    $waUrl = "https://wa.me/" . $waNumber . "?text=" . rawurlencode($waText);
                @endphp
                <a href="{{ $waUrl }}" target="_blank" class="btn-whatsapp">
                    Konfirmasi via WhatsApp
                </a>

                <div class="option-divider">— ATAU —</div>

                <!-- Option 2: Email -->
                <div class="option-email">
                    Reply / Balas langsung email ini<br>
                    <span style="font-size: 12px; color: #64748b; font-weight: 500;">(sambil melampirkan foto/file bukti transfer Anda)</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>PT Katiga Veritas Indonesia</strong></p>
            <p>Email: info@katigaveritas.com | Halaman Web: veritas.com</p>
            <p style="margin-top: 15px; font-size: 10px; color: #cbd5e1;">Email ini dikirimkan secara otomatis oleh sistem pendaftaran Veritas.</p>
        </div>
    </div>
</body>
</html>
