<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Sertifikat;
use Carbon\Carbon;

class VerifikasiSeeder extends Seeder
{
    public function run()
    {
        $sertifikats = Sertifikat::all();
        if ($sertifikats->isEmpty()) {
            return;
        }

        $ips = [
            '114.122.14.89',
            '182.253.119.5',
            '36.85.201.76',
            '180.244.135.210',
            '103.10.66.14',
            '202.152.19.82',
            '139.192.144.30',
            '110.138.167.24',
        ];

        // Seed 50 valid verifications
        $validCerts = $sertifikats->random(min(50, $sertifikats->count()));
        foreach ($validCerts as $cert) {
            $created = Carbon::parse($cert->tanggal_terbit)->addDays(rand(5, 60));
            if ($created->isAfter(Carbon::create(2026, 6, 13))) {
                $created = Carbon::create(2026, 6, 12)->subHours(rand(1, 10));
            }

            DB::table('verifikasi')->insert([
                'no_sertifikat' => $cert->no_sertifikat,
                'sertifikat_no' => $cert->no_sertifikat,
                'status' => 'valid',
                'catatan' => 'Sertifikat berhasil diverifikasi secara sistem.',
                'ip_address' => collect($ips)->random(),
                'created_at' => $created,
                'updated_at' => $created,
            ]);
        }

        // Seed 10 "tidak_ditemukan" verifications (searched for non-existing certificate numbers)
        for ($i = 0; $i < 10; $i++) {
            $created = Carbon::create(2025, rand(6, 12), rand(1, 28))->addDays(rand(0, 180));
            if ($created->isAfter(Carbon::create(2026, 6, 13))) {
                $created = Carbon::create(2026, 6, 11);
            }
            
            $invalidQuery = 'KV-AK3U-2025-' . rand(900000, 999999);

            DB::table('verifikasi')->insert([
                'no_sertifikat' => $invalidQuery,
                'sertifikat_no' => null,
                'status' => 'tidak_ditemukan',
                'catatan' => 'Nomor sertifikat tidak terdaftar di database.',
                'ip_address' => collect($ips)->random(),
                'created_at' => $created,
                'updated_at' => $created,
            ]);
        }

        // Seed 5 "tidak_valid" verifications (searched for expired/revoked)
        for ($i = 0; $i < 5; $i++) {
            $created = Carbon::create(2026, rand(1, 5), rand(1, 28));
            $invalidQuery = 'KV-K3-2023-000' . rand(100, 200);

            DB::table('verifikasi')->insert([
                'no_sertifikat' => $invalidQuery,
                'sertifikat_no' => null,
                'status' => 'tidak_valid',
                'catatan' => 'Sertifikat tidak valid atau telah dicabut.',
                'ip_address' => collect($ips)->random(),
                'created_at' => $created,
                'updated_at' => $created,
            ]);
        }
    }
}
