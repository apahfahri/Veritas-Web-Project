<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Hadir Pelatihan</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1e293b;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 18px;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            color: #0f172a;
        }
        .header p {
            margin: 0;
            font-size: 12px;
            color: #475569;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .info-table td:first-child {
            width: 120px;
            font-weight: bold;
        }
        .info-table td:nth-child(2) {
            width: 10px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
        }
        table.data-table th {
            background-color: #f1f5f9;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            font-size: 11px;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .signature-col {
            width: 120px;
            height: 40px;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
        .footer-signature {
            display: inline-block;
            text-align: center;
        }
        .footer-signature p {
            margin: 0 0 60px 0;
        }
        .footer-signature .name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Daftar Hadir Peserta</h1>
        <p>PT Katiga Veritas Indonesia</p>
    </div>

    <table class="info-table">
        <tr>
            <td>Nama Pelatihan</td>
            <td>:</td>
            <td><strong>{{ $jadwal->jenis?->nama ?? '—' }}</strong></td>
            <td>Instruktur</td>
            <td>:</td>
            <td>
                @forelse($jadwal->pemateri as $pm)
                    {{ $pm->nama_lengkap }}{{ !$loop->last ? ', ' : '' }}
                @empty
                    —
                @endforelse
            </td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>
                {{ $jadwal->tgl_mulai ? $jadwal->tgl_mulai->format('d F Y') : '—' }}
                @if($jadwal->tgl_selesai && $jadwal->tgl_selesai->ne($jadwal->tgl_mulai))
                s.d. {{ $jadwal->tgl_selesai->format('d F Y') }}
                @endif
            </td>
            <td>Lokasi</td>
            <td>:</td>
            <td>{{ $jadwal->lokasi ?? '—' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 30px; text-align: center;">No</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>No. Telepon</th>
                <th colspan="2" style="text-align: center;">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pesertas as $index => $p)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td><strong>{{ $p->user?->nama ?? '—' }}</strong></td>
                <td>{{ $p->user?->email ?? '—' }}</td>
                <td>{{ $p->user?->no_telp ?? '—' }}</td>
                <td class="signature-col" style="border-right: none;">
                    @if(($index + 1) % 2 != 0)
                        <span style="font-size: 10px; color: #94a3b8;">{{ $index + 1 }}.</span>
                    @endif
                </td>
                <td class="signature-col" style="border-left: none;">
                    @if(($index + 1) % 2 == 0)
                        <span style="font-size: 10px; color: #94a3b8;">{{ $index + 1 }}.</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 20px;">Belum ada peserta yang terdaftar</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="footer-signature">
            <p>................., .......................... 20....</p>
            <p>Instruktur / Penanggung Jawab,</p>
            <br><br><br>
            <div class="name">( .................................................... )</div>
        </div>
    </div>

</body>
</html>
