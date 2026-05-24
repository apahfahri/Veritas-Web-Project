<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendaftaran - PT Katiga Veritas Indonesia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #0891b2;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #0f172a;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #64748b;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f8fafc;
            color: #0f172a;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }
        td {
            font-size: 10px;
        }
        .text-center { text-align: center; }
        .footer {
            margin-top: 30px;
            font-size: 9px;
            color: #94a3b8;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Pendaftaran - PT Katiga Veritas Indonesia</h1>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }} | Cabang: {{ Auth::user()->cabang ? strtoupper(Auth::user()->cabang) : 'SEMUA CABANG' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Daftar</th>
                <th>Nama Peserta</th>
                <th>Instansi/Perusahaan</th>
                <th>Program Layanan</th>
                <th>Kategori</th>
                <th>Tgl Daftar</th>
                <th>Status Pembayaran</th>
                <th>Status Progres</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftarans as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $p->nomor_pendaftaran ?? ('#INV-' . $p->id_pendaftaran) }}</td>
                    <td>{{ $p->user?->nama }}</td>
                    <td>{{ $p->perusahaan ? $p->perusahaan->nama : ($p->user?->instansi ?? '-') }}</td>
                    <td>{{ $p->jadwal?->jenis?->nama ?? '-' }}</td>
                    <td>{{ $p->jadwal?->kategori?->nama ?? '-' }}</td>
                    <td class="text-center">{{ $p->tanggal_daftar ? $p->tanggal_daftar->format('d/m/Y') : '-' }}</td>
                    <td class="text-center">{{ strtoupper($p->status_bayar) }}</td>
                    <td class="text-center">
                        @if($p->status_progres == 'menunggu')
                            MENUNGGU
                        @elseif($p->status_progres == 'menunggu_pembayaran')
                            MENUNGGU PEMBAYARAN
                        @elseif($p->status_progres == 'diproses')
                            DALAM PROSES
                        @elseif($p->status_progres == 'selesai')
                            SELESAI
                        @elseif($p->status_progres == 'dibatalkan')
                            DIBATALKAN
                        @else
                            {{ strtoupper($p->status_progres) }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data pendaftaran yang sesuai kriteria.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh: {{ Auth::user()->username }}
    </div>

</body>
</html>
