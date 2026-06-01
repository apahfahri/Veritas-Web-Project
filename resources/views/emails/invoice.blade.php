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
                    <td class="label">No. Pendaftaran</td>
                    <td class="value">
                        <span style="display: inline-block; font-family: Monaco, Consolas, 'Courier New', monospace; background-color: #f1f5f9; border: 1px dashed #0891b2; padding: 4px 8px; border-radius: 4px; color: #0891b2; font-weight: bold; font-size: 13px; letter-spacing: 0.5px; user-select: all; -webkit-user-select: all; -moz-user-select: all; -ms-user-select: all; cursor: text;" title="Klik dua kali atau tekan lama untuk menyalin">{{ $pendaftaran->nomor_pendaftaran }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="label">Program / Layanan</td>
                    <td class="value">{{ $layanan->jenis?->nama ?? ($layanan->nama ?? ($layanan->materi ?? 'Layanan Veritas')) }}</td>
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
                <div class="bank-name">🏦 {{ $rekening?->nama_bank ?? 'Bank Mandiri' }}</div>
                <div style="margin: 8px 0;">
                    <span style="display: inline-block; font-family: Monaco, Consolas, 'Courier New', monospace; background-color: #e2e8f0; border: 1px dashed #0891b2; padding: 6px 12px; border-radius: 6px; color: #0891b2; font-size: 18px; font-weight: 900; letter-spacing: 1px; user-select: all; -webkit-user-select: all; -moz-user-select: all; -ms-user-select: all; cursor: text;" title="Klik dua kali atau tekan lama untuk menyalin">{{ str_replace('-', '', $rekening?->nomor_rekening ?? '1310018861111') }}</span>
                    <span style="font-size: 12px; color: #64748b; margin-left: 8px;">(Salin tanpa tanda hubung)</span>
                </div>
                <div class="acc-name" style="margin-bottom: 12px;">A.N. {{ $rekening?->atas_nama ?? 'PT Katiga Veritas Indonesia' }}</div>
                
                <!-- Unique Code Instruction -->
                <div style="background-color: #f0fdf4; border-left: 3px solid #22c55e; padding: 12px; margin-top: 10px; border-radius: 6px; text-align: left;">
                    <p style="margin: 0; font-size: 13px; color: #15803d; font-weight: bold; line-height: 1.4;">
                        ⚠️ PENTING: Masukkan 5 digit kode transfer berikut pada <strong>Berita Transfer / Catatan Transaksi</strong> Anda saat melakukan pembayaran untuk memudahkan pelacakan & verifikasi bukti bayar:
                    </p>
                    <p style="margin: 6px 0 0 0; font-family: Monaco, Consolas, 'Courier New', monospace; font-size: 20px; color: #166534; font-weight: 900; letter-spacing: 2px;">
                        {{ explode('-', $pendaftaran->nomor_pendaftaran)[0] }}
                    </p>
                </div>
            </div>
            
            @if(!empty($invoiceSettings) && $invoiceSettings->catatan_invoice)
            <div style="margin-top: 15px; padding: 15px; background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px;">
                <p style="margin: 0; font-size: 13px; color: #475569;">
                    <strong>Catatan:</strong><br>
                    {{ $invoiceSettings->catatan_invoice }}
                </p>
            </div>
            @endif

            <!-- CTA Section -->
            <div class="section-title">Konfirmasi Pembayaran</div>
            <div class="cta-section">
                <p>Untuk melanjutkan ke tahap berikutnya, silakan lakukan pembayaran dan kirimkan bukti transfer melalui halaman <strong>Cek Status Pendaftaran</strong> kami:</p>
                
                <div style="background-color: #fffbeb; border-left: 3px solid #fbbf24; padding: 12px; margin-bottom: 20px; text-align: left; border-radius: 4px;">
                    <p style="margin: 0; font-size: 13px; color: #b45309;">
                        <strong>Nomor Pendaftaran Anda:</strong><br>
                        <span style="display: inline-block; margin-top: 4px; font-family: Monaco, Consolas, 'Courier New', monospace; background-color: #fef3c7; border: 1px dashed #d97706; padding: 4px 8px; border-radius: 4px; color: #b45309; font-weight: 900; font-size: 14px; letter-spacing: 0.5px; user-select: all; -webkit-user-select: all; -moz-user-select: all; -ms-user-select: all; cursor: text;" title="Klik dua kali atau tekan lama untuk menyalin">{{ $pendaftaran->nomor_pendaftaran }}</span><br>
                        <span style="font-size: 11px; display: inline-block; margin-top: 6px;">Simpan nomor ini untuk mengirim bukti pembayaran di halaman Cek Status.</span>
                    </p>
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
