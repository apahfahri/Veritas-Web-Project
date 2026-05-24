<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSetting extends Model
{
    protected $table = 'invoice_settings';

    protected $fillable = [
        'rekening_1_bank',
        'rekening_1_nomor',
        'rekening_1_atas_nama',
        'rekening_1_aktif',
        'rekening_2_bank',
        'rekening_2_nomor',
        'rekening_2_atas_nama',
        'rekening_2_aktif',
        'catatan_invoice',
    ];

    protected $casts = [
        'rekening_1_aktif' => 'boolean',
        'rekening_2_aktif' => 'boolean',
    ];

    /**
     * Get the active bank account data
     */
    public function getActiveRekening(): array
    {
        if ($this->rekening_1_aktif) {
            return [
                'bank' => $this->rekening_1_bank,
                'nomor' => $this->rekening_1_nomor,
                'atas_nama' => $this->rekening_1_atas_nama,
            ];
        }

        if ($this->rekening_2_aktif && $this->rekening_2_nomor) {
            return [
                'bank' => $this->rekening_2_bank,
                'nomor' => $this->rekening_2_nomor,
                'atas_nama' => $this->rekening_2_atas_nama,
            ];
        }

        // Fallback to rekening 1
        return [
            'bank' => $this->rekening_1_bank ?? 'Bank Mandiri',
            'nomor' => $this->rekening_1_nomor ?? '131-00-1886111-1',
            'atas_nama' => $this->rekening_1_atas_nama ?? 'PT Katiga Veritas Indonesia',
        ];
    }

    /**
     * Get or create the singleton settings row
     */
    public static function getSettings(): self
    {
        return self::firstOrCreate([], [
            'rekening_1_bank' => 'Bank Mandiri',
            'rekening_1_nomor' => '131-00-1886111-1',
            'rekening_1_atas_nama' => 'PT Katiga Veritas Indonesia',
            'rekening_1_aktif' => true,
        ]);
    }
}
