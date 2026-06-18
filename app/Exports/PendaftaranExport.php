<?php

namespace App\Exports;

use App\Models\Pendaftaran;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PendaftaranExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Pendaftaran::query()->with(['user', 'jadwal.jenis']);

        if (!empty($this->filters['year'])) {
            $query->whereYear('tanggal_daftar', $this->filters['year']);
        }

        if (!empty($this->filters['month'])) {
            $query->whereMonth('tanggal_daftar', $this->filters['month']);
        }

        if (!empty($this->filters['category_name_like'])) {
            $query->whereHas('jadwal.kategori', function($q) {
                $q->where('nama', 'like', '%' . $this->filters['category_name_like'] . '%');
            });
        }

        if (isset($this->filters['is_kustom'])) {
            $query->where('is_kustom', $this->filters['is_kustom']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Peserta',
            'Layanan',
            'Tanggal Daftar',
            'Status Progres',
            'Status Bayar'
        ];
    }

    public function map($pendaftaran): array
    {
        return [
            $pendaftaran->id_pendaftaran,
            $pendaftaran->user?->nama,
            $pendaftaran->jadwal?->jenis?->nama ?? ($pendaftaran->jadwal?->kategori?->nama ?? '-'),
            $pendaftaran->tanggal_daftar ? $pendaftaran->tanggal_daftar->format('d/m/Y') : '-',
            strtoupper(str_replace('_', ' ', $pendaftaran->status_progres)),
            strtoupper(str_replace('_', ' ', $pendaftaran->status_bayar))
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
