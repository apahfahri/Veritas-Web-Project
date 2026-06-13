<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat K3 — PT Katiga Veritas Indonesia</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html, body {
            width: 297mm;
            height: 210mm;
            overflow: hidden;
            font-family: 'Times New Roman', Georgia, serif;
            background: #fff;
        }

        /* ===== OUTER WRAPPER ===== */
        .cert-wrap {
            width: 297mm;
            height: 210mm;
            position: relative;
            background: #ffffff;
            overflow: hidden;
        }

        /* ===== DECORATIVE BACKGROUND ELEMENTS ===== */
        .bg-left-bar {
            position: absolute;
            left: 0; top: 0;
            width: 22mm;
            height: 210mm;
            background: #0B3D25;
        }
        .bg-left-bar-accent {
            position: absolute;
            left: 22mm; top: 0;
            width: 3mm;
            height: 210mm;
            background: #C8A84B;
        }
        .bg-right-bar {
            position: absolute;
            right: 0; top: 0;
            width: 22mm;
            height: 210mm;
            background: #0B3D25;
        }
        .bg-right-bar-accent {
            position: absolute;
            right: 22mm; top: 0;
            width: 3mm;
            height: 210mm;
            background: #C8A84B;
        }
        .bg-top-bar {
            position: absolute;
            top: 0; left: 25mm;
            width: 247mm;
            height: 14mm;
            background: #0B3D25;
        }
        .bg-top-bar-accent {
            position: absolute;
            top: 14mm; left: 25mm;
            width: 247mm;
            height: 2mm;
            background: #C8A84B;
        }
        .bg-bottom-bar {
            position: absolute;
            bottom: 0; left: 25mm;
            width: 247mm;
            height: 14mm;
            background: #0B3D25;
        }
        .bg-bottom-bar-accent {
            position: absolute;
            bottom: 14mm; left: 25mm;
            width: 247mm;
            height: 2mm;
            background: #C8A84B;
        }

        /* Star ornament corners */
        .corner-ornament {
            position: absolute;
            width: 10mm;
            height: 10mm;
        }
        .corner-ornament.tl { top: 2mm; left: 5mm; }
        .corner-ornament.tr { top: 2mm; right: 5mm; }
        .corner-ornament.bl { bottom: 2mm; left: 5mm; }
        .corner-ornament.br { bottom: 2mm; right: 5mm; }
        .corner-ornament svg { width: 10mm; height: 10mm; }

        /* Vertical text on side bars */
        .side-text-left {
            position: absolute;
            left: 0mm; top: 0;
            width: 22mm;
            height: 210mm;
            display: flex;
            align-items: center;
            justify-content: center;
            writing-mode: vertical-lr;
            transform: rotate(180deg);
            font-size: 7pt;
            font-family: Arial, sans-serif;
            font-weight: bold;
            color: #C8A84B;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .side-text-right {
            position: absolute;
            right: 0mm; top: 0;
            width: 22mm;
            height: 210mm;
            display: flex;
            align-items: center;
            justify-content: center;
            writing-mode: vertical-lr;
            font-size: 7pt;
            font-family: Arial, sans-serif;
            font-weight: bold;
            color: #C8A84B;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        /* ===== MAIN CONTENT AREA ===== */
        .cert-content {
            position: absolute;
            top: 16mm;
            left: 28mm;
            right: 28mm;
            bottom: 16mm;
            /* width = 297 - 28 - 28 = 241mm */
            /* height = 210 - 16 - 16 = 178mm */
        }

        /* ===== HEADER ===== */
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-logo-cell {
            width: 18mm;
            vertical-align: middle;
        }
        .header-logo-cell img {
            width: 16mm;
            height: auto;
        }
        .header-title-cell {
            vertical-align: middle;
            padding-left: 3mm;
        }
        .header-company {
            font-family: Arial, sans-serif;
            font-size: 8pt;
            font-weight: bold;
            color: #0B3D25;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .header-tagline {
            font-family: Arial, sans-serif;
            font-size: 6pt;
            color: #888;
            letter-spacing: 1px;
            margin-top: 0.5mm;
        }
        .header-reg-cell {
            width: 70mm;
            text-align: right;
            vertical-align: middle;
        }
        .header-reg {
            font-family: Arial, sans-serif;
            font-size: 5.5pt;
            color: #555;
            line-height: 1.5;
            border-left: 1.5px solid #C8A84B;
            padding-left: 3mm;
            display: inline-block;
            text-align: left;
        }
        .header-reg strong {
            color: #0B3D25;
            text-transform: uppercase;
        }

        /* Divider line after header */
        .divider-gold {
            width: 100%;
            height: 0.8mm;
            background: linear-gradient(to right, #C8A84B, #F0D080, #C8A84B);
            margin: 3mm 0 2mm 0;
        }
        .divider-thin {
            width: 100%;
            height: 0.3mm;
            background: #e0c87a;
            margin-bottom: 3mm;
        }

        /* ===== SERTIFIKAT TITLE ===== */
        .cert-title-block {
            text-align: center;
        }
        .cert-title-label {
            font-family: Arial, sans-serif;
            font-size: 6pt;
            color: #C8A84B;
            letter-spacing: 5px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .cert-title-main {
            font-size: 30pt;
            font-weight: bold;
            color: #0B3D25;
            letter-spacing: 1px;
            font-family: 'Times New Roman', Georgia, serif;
            line-height: 1;
            text-transform: uppercase;
        }
        .cert-title-sub {
            font-family: Arial, sans-serif;
            font-size: 8pt;
            color: #888;
            letter-spacing: 2px;
            font-style: italic;
            margin-top: 0.5mm;
        }

        /* ===== CERTIFY TEXT ===== */
        .certify-text {
            text-align: center;
            font-size: 9pt;
            color: #555;
            font-style: italic;
            margin-top: 2.5mm;
        }

        /* ===== NAME SECTION ===== */
        .name-section {
            text-align: center;
            margin-top: 2mm;
        }
        .name-text {
            font-size: 22pt;
            font-weight: bold;
            color: #0B3D25;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-family: 'Times New Roman', Georgia, serif;
        }
        .name-underline-wrapper {
            width: 100%;
            text-align: center;
            margin: 1mm 0 1.5mm;
        }
        .name-underline {
            display: inline-block;
            width: 100mm;
            height: 0.8mm;
            background: #C8A84B;
        }

        /* ===== PROGRAM INFO ===== */
        .program-section {
            text-align: center;
            margin-top: 1.5mm;
        }
        .program-pretext {
            font-size: 8pt;
            color: #444;
            font-style: italic;
        }
        .program-name {
            font-size: 11pt;
            font-weight: bold;
            color: #B71C1C;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-family: Arial, sans-serif;
            margin-top: 0.5mm;
        }
        .program-sub {
            font-size: 7pt;
            color: #777;
            font-style: italic;
            margin-top: 0.5mm;
        }

        /* ===== BOTTOM SECTION ===== */
        .bottom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 3mm;
        }
        .bottom-table td {
            vertical-align: bottom;
            padding: 0;
        }
        .col-signature {
            width: 60mm;
            text-align: center;
        }
        .col-meta {
            text-align: center;
        }
        .col-syllabus {
            width: 70mm;
            text-align: left;
        }

        /* Signature area */
        .sig-img {
            height: 14mm;
            max-width: 55mm;
            object-fit: contain;
            display: block;
            margin: 0 auto 0.5mm;
        }
        .sig-line {
            width: 55mm;
            height: 0.4mm;
            background: #555;
            margin: 0 auto;
        }
        .sig-name {
            font-family: Arial, sans-serif;
            font-size: 7.5pt;
            font-weight: bold;
            color: #1a1a1a;
            text-align: center;
            margin-top: 1mm;
        }
        .sig-title {
            font-family: Arial, sans-serif;
            font-size: 6pt;
            color: #666;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Center meta */
        .cert-meta-box {
            text-align: center;
        }
        .cert-no-label {
            font-family: Arial, sans-serif;
            font-size: 5.5pt;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .cert-no-value {
            font-family: Arial, sans-serif;
            font-size: 8pt;
            font-weight: bold;
            color: #0B3D25;
            letter-spacing: 1px;
        }
        .cert-date {
            font-family: Arial, sans-serif;
            font-size: 6.5pt;
            color: #555;
            margin-top: 1mm;
        }
        .cert-valid {
            font-family: Arial, sans-serif;
            font-size: 6pt;
            color: #888;
            margin-top: 0.5mm;
            font-style: italic;
        }

        /* Official seal SVG */
        .seal-area {
            text-align: center;
            margin-bottom: 1mm;
        }

        /* Syllabus box */
        .syllabus-box {
            border: 0.6mm solid #C8A84B;
            border-radius: 1.5mm;
            background: #FAFDF8;
            padding: 2.5mm 3mm;
        }
        .syllabus-title {
            font-family: Arial, sans-serif;
            font-size: 5.5pt;
            font-weight: bold;
            color: #0B3D25;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: #0B3D25;
            color: #fff;
            padding: 0.5mm 2mm;
            display: inline-block;
            margin-bottom: 2mm;
            border-radius: 0.5mm;
        }
        .syllabus-inner {
            width: 100%;
            border-collapse: collapse;
        }
        .syllabus-inner td {
            font-family: Arial, sans-serif;
            font-size: 5.5pt;
            color: #444;
            line-height: 1.55;
            vertical-align: top;
            padding: 0 1mm 0 0;
        }
        .syllabus-bullet {
            color: #C8A84B;
            font-weight: bold;
        }

        /* Bottom bar text */
        .bottom-bar-text {
            position: absolute;
            bottom: 3.5mm;
            left: 28mm;
            right: 28mm;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 6pt;
            color: #C8A84B;
            letter-spacing: 2px;
        }

        /* Top bar text */
        .top-bar-text {
            position: absolute;
            top: 3.5mm;
            left: 28mm;
            right: 28mm;
            text-align: center;
            font-family: Arial, sans-serif;
            font-size: 6pt;
            color: #C8A84B;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<div class="cert-wrap">

    <!-- BORDER BARS -->
    <div class="bg-left-bar"></div>
    <div class="bg-left-bar-accent"></div>
    <div class="bg-right-bar"></div>
    <div class="bg-right-bar-accent"></div>
    <div class="bg-top-bar"></div>
    <div class="bg-top-bar-accent"></div>
    <div class="bg-bottom-bar"></div>
    <div class="bg-bottom-bar-accent"></div>

    <!-- SIDE TEXT -->
    <div class="side-text-left">K3 · Keselamatan dan Kesehatan Kerja · Indonesia</div>
    <div class="side-text-right">SK KEMNAKER RI · Terakreditasi Nasional · 2026</div>

    <!-- TOP BAR TEXT -->
    <div class="top-bar-text">PT Katiga Veritas Indonesia — Pusat Pelatihan dan Sertifikasi K3 Nasional</div>

    <!-- BOTTOM BAR TEXT -->
    <div class="bottom-bar-text">Dokumen ini sah dan dapat diverifikasi secara digital · www.veritask3.id · +62 800-VERITAS</div>

    <!-- MAIN CONTENT -->
    <div class="cert-content">

        <!-- HEADER ROW -->
        <table class="header-table">
            <tr>
                <td class="header-logo-cell">
                    <img src="{{ public_path('images/logo.png') }}" alt="Logo Veritas">
                </td>
                <td class="header-title-cell">
                    <div class="header-company">PT Katiga Veritas Indonesia</div>
                    <div class="header-tagline">Pusat Pelatihan &amp; Sertifikasi Keselamatan dan Kesehatan Kerja</div>
                </td>
                <td class="header-reg-cell">
                    <div class="header-reg">
                        <strong>Kementerian Ketenagakerjaan RI</strong><br>
                        No. Reg: KV-SK-KEMNAKER-2026<br>
                        Terakreditasi: Pusat K3 Nasional<br>
                        ISO 9001:2015 Certified Organization
                    </div>
                </td>
            </tr>
        </table>

        <!-- GOLD DIVIDER -->
        <div class="divider-gold"></div>
        <div class="divider-thin"></div>

        <!-- TITLE BLOCK -->
        <div class="cert-title-block">
            <div class="cert-title-label">Keselamatan dan Kesehatan Kerja</div>
            <div class="cert-title-main">Sertifikat Kompetensi</div>
            <div class="cert-title-sub">Certificate of Competence — Occupational Health &amp; Safety</div>
        </div>

        <!-- CERTIFY TEXT -->
        <div class="certify-text">
            Dengan ini menyatakan bahwa &nbsp;|&nbsp; <em>This is to certify that the following individual</em>
        </div>

        <!-- NAME -->
        <div class="name-section">
            <div class="name-text">{{ strtoupper($sertifikat->nama_lengkap) }}</div>
            <div class="name-underline-wrapper">
                <span class="name-underline"></span>
            </div>
        </div>

        <!-- PROGRAM -->
        <div class="program-section">
            <div class="program-pretext">telah dinyatakan LULUS dan KOMPETEN dalam program pelatihan K3:</div>
            <div class="program-name">{{ strtoupper($sertifikat->pendaftaran?->nama_program ?? 'Ahli K3 Umum') }}</div>
            <div class="program-sub"><em>has successfully passed and demonstrated competency in the above Occupational Safety &amp; Health training program.</em></div>
        </div>

        <!-- DIVIDER -->
        <div class="divider-gold" style="margin-top:3mm;"></div>

        <!-- BOTTOM SECTION: Signature | Meta | Syllabus -->
        <table class="bottom-table">
            <tr>

                <!-- LEFT: Signature -->
                <td class="col-signature">
                    <img class="sig-img" src="{{ public_path('images/signature_direktur.png') }}" alt="Tanda Tangan">
                    <div class="sig-line"></div>
                    <div class="sig-name">Dr. Ahmad Ridwan, S.T., M.K3</div>
                    <div class="sig-title">Direktur Utama / Chief Executive Officer</div>
                    <div class="sig-title">PT Katiga Veritas Indonesia</div>
                </td>

                <!-- CENTER: Cert Number, Date, Seal -->
                <td class="col-meta">
                    <div class="seal-area">
                        <!-- Official Seal SVG -->
                        <svg viewBox="0 0 120 120" width="28mm" height="28mm" xmlns="http://www.w3.org/2000/svg">
                            <!-- Outer starburst -->
                            <polygon points="60,3 65,22 80,10 76,29 94,24 83,40 103,42 86,53 103,62 84,66 96,81 76,77 74,97 60,85 46,97 44,77 24,81 36,66 17,62 34,53 17,42 37,40 26,24 44,29 40,10 55,22" fill="#0B3D25"/>
                            <!-- Middle ring -->
                            <circle cx="60" cy="60" r="40" fill="#0B3D25"/>
                            <circle cx="60" cy="60" r="37" fill="none" stroke="#C8A84B" stroke-width="2"/>
                            <circle cx="60" cy="60" r="30" fill="none" stroke="#C8A84B" stroke-width="0.8"/>
                            <!-- K3 Text -->
                            <text x="60" y="52" text-anchor="middle" font-family="Arial" font-weight="bold" font-size="18" fill="#C8A84B">K3</text>
                            <text x="60" y="62" text-anchor="middle" font-family="Arial" font-size="6" fill="#ffffff" letter-spacing="2">VERITAS</text>
                            <text x="60" y="71" text-anchor="middle" font-family="Arial" font-size="5" fill="#C8A84B" letter-spacing="1">INDONESIA</text>
                            <!-- Decorative arc text -->
                            <path id="topArc" d="M 22 60 A 38 38 0 0 1 98 60" fill="none"/>
                            <path id="botArc" d="M 22 62 A 38 38 0 0 0 98 62" fill="none"/>
                        </svg>
                    </div>
                    <div class="cert-meta-box">
                        <div class="cert-no-label">Nomor Sertifikat</div>
                        <div class="cert-no-value">{{ $sertifikat->no_sertifikat }}</div>
                        <div class="cert-date">
                            Diterbitkan: {{ $sertifikat->tanggal_terbit ? $sertifikat->tanggal_terbit->format('d F Y') : '-' }}
                        </div>
                        @if($sertifikat->masa_berlaku)
                        <div class="cert-valid">Berlaku hingga: {{ $sertifikat->masa_berlaku->format('d F Y') }}</div>
                        @else
                        <div class="cert-valid">Berlaku seumur hidup (Lifetime Valid)</div>
                        @endif
                    </div>
                </td>

                <!-- RIGHT: Syllabus -->
                <td class="col-syllabus">
                    <div class="syllabus-box">
                        <div class="syllabus-title">Materi Program Pelatihan</div>
                        <table class="syllabus-inner">
                            <tr>
                                <td style="width:50%;">
                                    <span class="syllabus-bullet">▸</span> UU No. 1 Tahun 1970<br>
                                    <span class="syllabus-bullet">▸</span> Kebijakan K3 Nasional<br>
                                    <span class="syllabus-bullet">▸</span> Dasar-dasar K3 Umum<br>
                                    <span class="syllabus-bullet">▸</span> Manajemen Risiko K3<br>
                                    <span class="syllabus-bullet">▸</span> SMK3 &amp; Audit K3
                                </td>
                                <td style="width:50%;">
                                    <span class="syllabus-bullet">▸</span> Higiene Industri<br>
                                    <span class="syllabus-bullet">▸</span> Investigasi Kecelakaan<br>
                                    <span class="syllabus-bullet">▸</span> P3K &amp; Tanggap Darurat<br>
                                    <span class="syllabus-bullet">▸</span> Job Safety Analysis<br>
                                    <span class="syllabus-bullet">▸</span> Laporan &amp; Statistik K3
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

            </tr>
        </table>

    </div><!-- end cert-content -->

</div><!-- end cert-wrap -->
</body>
</html>
