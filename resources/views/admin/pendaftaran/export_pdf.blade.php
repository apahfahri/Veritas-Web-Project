<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendaftaran - PT Katiga Veritas Indonesia</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #334155; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #0f172a; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #0f172a; font-size: 18px; }
        .header p { margin: 5px 0 0; color: #64748b; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f8fafc; color: #475569; font-weight: bold; text-align: left; padding: 10px; border: 1px solid #e2e8f0; text-transform: uppercase; font-size: 9px; }
        td { padding: 10px; border: 1px solid #e2e8f0; vertical-align: top; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #94a3b8; }
        .badge { padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 8px; text-transform: uppercase; }
        .badge-success { background-color: #f0fdf4; color: #166534; }
        .badge-info { background-color: #eff6ff; color: #1e40af; }
        .badge-warning { background-color: #fffbeb; color: #92400e; }
        .badge-danger { background-color: #fef2f2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENDAFTARAN LAYANAN</h1>
        <p>PT KATIGA VERITAS INDONESIA</p>
        <p style="font-size: 10px;">Periode: {{ $month ? \Carbon\Carbon::create()->month($month)->format('F') : 'Semua Bulan' }} {{ $year }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Pendaftar</th>
                <th width="25%">Program Layanan</th>
                <th width="15%">Tgl Daftar</th>
                <th width="15%">Status</th>
                <th width="10%">Bayar</th>
                <th width="10%">Cabang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftarans as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>{{ $p->user?->nama }}</strong><br>
                    {{ $p->user?->email }}
                </td>
                <td>{{ $p->jadwal?->jenis?->nama ?? ($p->jadwal?->kategori?->nama ?? '-') }}</td>
                <td>{{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d/m/Y') : '-' }}</td>
                <td>
                    <span class="badge {{ $p->status_progres == 'selesai' ? 'badge-success' : ($p->status_progres == 'diproses' ? 'badge-info' : 'badge-warning') }}">
                        {{ str_replace('_', ' ', $p->status_progres) }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $p->status_bayar == 'lunas' ? 'badge-success' : 'badge-danger' }}">
                        {{ $p->status_bayar }}
                    </span>
                </td>
                <td>{{ strtoupper($p->cabang) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d M Y H:i:s') }}
    </div>
</body>
</html>
