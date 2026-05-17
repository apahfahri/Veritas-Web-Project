<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #INV-{{ $pendaftaran->id_pendaftaran }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color: #334155;
            background: #ffffff;
            padding: 0;
        }

        /* HEADER */
        .header {
            background-color: #0f172a;
            color: #ffffff;
            padding: 24px 30px;
            border-bottom: 4px solid #0891b2;
        }
        .header-table { width: 100%; }
        .header-logo {
            font-size: 22px;
            font-weight: bold;
            color: #0891b2;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .header-subtitle {
            font-size: 10px;
            color: #94a3b8;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 4px;
        }
        .invoice-label {
            text-align: right;
            color: #ffffff;
        }
        .invoice-label h2 {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
        .invoice-label p {
            font-size: 12px;
            color: #38bdf8;
            margin: 4px 0 0 0;
        }

        /* CONTENT */
        .content { padding: 28px 30px; }

        .greeting { font-size: 14px; margin-bottom: 20px; line-height: 1.6; }

        /* SECTION TITLE */
        .section-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0f172a;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 6px;
            margin-top: 22px;
            margin-bottom: 12px;
        }

        /* DETAIL TABLE */
        .detail-table { width: 100%; border-collapse: collapse; }
        .detail-table td {
            padding: 8px 4px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
            vertical-align: top;
        }
        .detail-table td.lbl {
            font-weight: bold;
            color: #64748b;
            width: 38%;
        }
        .detail-table td.val {
            color: #0f172a;
            font-weight: bold;
            text-align: right;
        }
        .total-row td {
            padding-top: 14px;
            border-bottom: none;
        }
        .total-lbl { font-size: 15px; color: #0f172a; }
        .total-val { font-size: 17px; color: #0891b2; }

        /* BANK INFO */
        .bank-box {
            background-color: #f8fafc;
            border-left: 4px solid #0891b2;
            padding: 16px 20px;
            margin-top: 12px;
        }
        .bank-name { font-weight: bold; color: #0f172a; font-size: 13px; }
        .acc-number { font-size: 17px; font-weight: bold; color: #0891b2; margin: 6px 0; letter-spacing: 0.5px; }
        .acc-holder { color: #475569; font-weight: bold; font-size: 12px; }

        /* CTA */
        .cta-box {
            border: 1px solid #cbd5e1;
            padding: 20px;
            margin-top: 24px;
            text-align: center;
        }
        .cta-box p { font-size: 13px; color: #475569; margin-bottom: 14px; }
        .wa-link {
            display: inline-block;
            background-color: #22c55e;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 22px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .or-divider { margin: 12px 0; font-size: 11px; font-weight: bold; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; }
        .reply-text { font-size: 13px; color: #0f172a; font-weight: bold; }
        .reply-note { font-size: 11px; color: #64748b; }

        /* FOOTER */
        .footer {
            background-color: #f8fafc;
            padding: 16px 30px;
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    {{-- HEADER --}}
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    <div class="header-logo">VERITAS</div>
                    <div class="header-subtitle">PT Katiga Veritas Indonesia</div>
                </td>
                <td class="invoice-label">
                    <h2>INVOICE</h2>
                    <p>#INV-{{ $pendaftaran->id_pendaftaran }}</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- CONTENT --}}
    <div class="content">
        <p class="greeting">
            Halo <strong>{{ $user->nama }}</strong>,<br>
            Terima kasih telah mendaftar di program <strong>PT Katiga Veritas Indonesia</strong>.
            Berikut adalah rincian tagihan invoice pendaftaran Anda:
        </p>

        {{-- DETAIL PENDAFTARAN --}}
        <div class="section-title">Detail Pendaftaran</div>
        <table class="detail-table">
            <tr>
                <td class="lbl">Nama Lengkap</td>
                <td class="val">{{ $user->nama }}</td>
            </tr>
            <tr>
                <td class="lbl">Email Peserta</td>
                <td class="val">{{ $user->email }}</td>
            </tr>
            <tr>
                <td class="lbl">No. Telepon</td>
                <td class="val">{{ $user->no_telp ?? '-' }}</td>
            </tr>
            <tr>
                <td class="lbl">Program / Layanan</td>
                <td class="val">{{ $layanan->nama ?? ($layanan->materi ?? 'Layanan Veritas') }}</td>
            </tr>
            <tr>
                <td class="lbl">Tanggal Pendaftaran</td>
                <td class="val">{{ $pendaftaran->tanggal_daftar ? $pendaftaran->tanggal_daftar->format('d M Y') : now()->format('d M Y') }}</td>
            </tr>
            @if($pendaftaran->rencana_tanggal_mulai)
            <tr>
                <td class="lbl">Rencana Tanggal</td>
                <td class="val">
                    {{ $pendaftaran->rencana_tanggal_mulai->format('d M Y') }}
                    @if($pendaftaran->rencana_tanggal_selesai && $pendaftaran->rencana_tanggal_selesai != $pendaftaran->rencana_tanggal_mulai)
                        s/d {{ $pendaftaran->rencana_tanggal_selesai->format('d M Y') }}
                    @endif
                </td>
            </tr>
            @endif
            @if($pendaftaran->mode_pertemuan)
            <tr>
                <td class="lbl">Mode Pertemuan</td>
                <td class="val">{{ ucfirst($pendaftaran->mode_pertemuan) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td class="lbl total-lbl">Total Tagihan</td>
                <td class="val total-val">Rp {{ number_format($layanan->harga ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>

        {{-- INSTRUKSI PEMBAYARAN --}}
        <div class="section-title">Instruksi Pembayaran</div>
        <p style="font-size:13px; margin-bottom:10px;">
            Silakan lakukan transfer pembayaran penuh sejumlah nominal di atas ke rekening resmi kami:
        </p>
        <div class="bank-box">
            <div class="bank-name">🏦 Bank Mandiri</div>
            <div class="acc-number">131-00-1886111-1</div>
            <div class="acc-holder">A.N. PT Katiga Veritas Indonesia</div>
        </div>

    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <p><strong>PT Katiga Veritas Indonesia</strong></p>
        <p>Email: info@katigaveritas.com | Web: veritas.com</p>
        <p style="margin-top:10px; font-size:9px; color:#cbd5e1;">
            Email ini dikirimkan secara otomatis oleh sistem pendaftaran Veritas.
        </p>
    </div>
</body>
</html>
