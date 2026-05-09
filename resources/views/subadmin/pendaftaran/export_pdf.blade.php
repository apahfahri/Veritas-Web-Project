<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendaftaran - Veritas</title>
    <style>
        @page { margin: 1cm; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #334155;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0891b2;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #0891b2;
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            font-weight: bold;
            color: #64748b;
        }
        .meta {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: bold;
            text-align: left;
            padding: 10px;
            border: 1px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 10px;
        }
        td {
            padding: 10px;
            border: 1px solid #e2e8f0;
        }
        .status {
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 50px;
            text-align: right;
        }
        .footer p { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PT KATIGA VERITAS INDONESIA</h1>
        <p>LAPORAN PENDAFTARAN LAYANAN — CABANG {{ strtoupper($cabang) }}</p>
        <p style="font-size: 10px;">Periode: {{ $filters['month'] ? \Carbon\Carbon::create()->month($filters['month'])->format('F') : 'Semua Bulan' }} {{ $filters['year'] }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Peserta</th>
                <th width="25%">Materi Layanan</th>
                <th width="15%">Tanggal</th>
                <th width="15%">Status Progres</th>
                <th width="20%">Status Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftarans as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $p->user?->nama }}</strong></td>
                    <td>{{ $p->layanan?->nama }}</td>
                    <td>{{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d/m/Y') : '-' }}</td>
                    <td class="status">{{ str_replace('_', ' ', $p->status_progres) }}</td>
                    <td class="status">{{ str_replace('_', ' ', $p->status_bayar) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
        <p>Oleh: Subadmin {{ strtoupper($cabang) }}</p>
        <br><br><br>
        <p>( __________________________ )</p>
        <p>Manajer Operasional</p>
    </div>
</body>
</html>
