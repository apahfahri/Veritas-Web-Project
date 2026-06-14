<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Pendaftaran;
use Carbon\Carbon;

class SertifikatSeeder extends Seeder
{
    public function run()
    {
        $completedRegistrations = Pendaftaran::with(['user', 'jadwal.jenis'])
            ->where('status_progres', 'selesai')
            ->orderBy('id_pendaftaran', 'asc')
            ->get();

        $certCounter = 1;

        foreach ($completedRegistrations as $reg) {
            $user = $reg->user;
            $jadwal = $reg->jadwal;
            
            if (!$user || !$jadwal) {
                continue;
            }

            $kodeJenis = $jadwal->jenis?->kode_jenis ?? 'K3';
            $tglSelesai = $jadwal->tgl_selesai ?? $reg->tanggal_daftar->addDays(3);
            $year = $tglSelesai->format('Y');

            $noSertifikat = "KV-{$kodeJenis}-{$year}-" . str_pad($certCounter++, 6, '0', STR_PAD_LEFT);
            $tglTerbit = (clone $tglSelesai)->addDays(rand(1, 3));
            $masaBerlaku = (clone $tglTerbit)->addYears(3);

            DB::table('sertifikat')->insert([
                'no_sertifikat' => $noSertifikat,
                'id_pendaftaran' => $reg->id_pendaftaran,
                'nama_lengkap' => $user->nama,
                'tanggal_terbit' => $tglTerbit->toDateString(),
                'file_pdf' => 'sertifikat/mock_cert_' . $reg->id_pendaftaran . '.pdf',
                'masa_berlaku' => $masaBerlaku->toDateString(),
                'penerbit' => 'PT Katiga Veritas Indonesia',
                'created_at' => $tglTerbit,
                'updated_at' => $tglTerbit,
            ]);
        }
    }
}
