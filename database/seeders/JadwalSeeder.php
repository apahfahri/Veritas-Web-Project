<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\JenisLayanan;
use App\Models\KategoriLayanan;
use Carbon\Carbon;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        // Get all categories
        $categories = KategoriLayanan::all()->keyBy('kode_kategori');
        if ($categories->isEmpty()) {
            return;
        }

        // We will generate schedules from June 2025 to August 2026
        // Past: June 2025 to May 2026
        // Current/Future: June 2026 to August 2026

        $locations = [
            'Hotel Aston Bandung',
            'Hotel Hilton Jakarta',
            'Hotel Grand Tjokro Bandung',
            'Veritas Training Center Jakarta',
            'Zoom Meeting',
            'Hotel JW Marriott Surabaya',
            'Novotel Balikpapan',
            'Microsoft Teams',
        ];

        // Let's map kinds of services to seed them properly
        $services = JenisLayanan::all()->groupBy('id_kategori');

        $currentDate = Carbon::create(2025, 6, 1);
        $endDate = Carbon::create(2026, 8, 31);

        $scheduleCounter = 1;

        while ($currentDate->lessThanOrEqualTo($endDate)) {
            $isPast = $currentDate->isBefore(Carbon::create(2026, 6, 1));
            $month = $currentDate->month;
            $year = $currentDate->year;

            // 1. Seed 2-3 Pelatihan K3 (Category ID 1) per month
            $pelatihanServices = $services->get(1) ?? collect();
            if ($pelatihanServices->isNotEmpty()) {
                $count = $isPast ? rand(2, 3) : 3;
                for ($i = 0; $i < $count; $i++) {
                    $service = $pelatihanServices->random();
                    $dayStart = rand(5, 20);
                    $tglMulai = Carbon::create($year, $month, $dayStart);
                    $tglSelesai = (clone $tglMulai)->addDays(rand(2, 4));

                    $jenisPertemuan = collect(['online', 'offline', 'hybrid'])->random();
                    $lokasi = ($jenisPertemuan === 'online') ? 'Zoom Meeting' : collect($locations)->reject(fn($l) => $l === 'Zoom Meeting' || $l === 'Microsoft Teams')->random();

                    $harga = collect([1500000, 2500000, 3500000, 4500000, 5000000, 6500000])->random();

                    $j = Jadwal::create([
                        'id_kategori' => 1,
                        'id_jenis' => $service->id_jenis,
                        'kode_jadwal' => "PLT-{$service->kode_jenis}-" . str_pad($scheduleCounter++, 3, '0', STR_PAD_LEFT),
                        'jenis_pertemuan' => $jenisPertemuan,
                        'tgl_mulai' => $tglMulai,
                        'tgl_selesai' => $tglSelesai,
                        'jam_pertemuan' => '08:00:00',
                        'lokasi' => $lokasi,
                        'kapasitas' => rand(15, 30),
                        'harga' => $harga,
                        'deskripsi' => "Pelatihan sertifikasi {$service->nama} tingkat nasional.",
                        'link_meet' => ($jenisPertemuan !== 'offline') ? 'https://zoom.us/j/' . rand(100000000, 999999999) : null,
                        'created_at' => (clone $tglMulai)->subDays(rand(20, 30)),
                        'updated_at' => (clone $tglMulai)->subDays(rand(20, 30)),
                    ]);

                    // Sync 1-2 random instructors
                    $j->pemateri()->sync(collect(range(1, 10))->random(rand(1, 2))->toArray());
                    // Sync 1-2 random materials
                    $j->materi()->sync(collect(range(1, 3))->random(rand(1, 2))->toArray());
                }
            }

            // 2. Seed 1 Konsultasi SMK3 (Category ID 2) every 2 months
            if ($month % 2 === 0) {
                $konsulServices = $services->get(2) ?? collect();
                if ($konsulServices->isNotEmpty()) {
                    $service = $konsulServices->random();
                    $tglMulai = Carbon::create($year, $month, 10);
                    $tglSelesai = (clone $tglMulai)->addDays(rand(1, 2));

                    $jenisPertemuan = 'hybrid';
                    $lokasi = 'Kantor Klien & Hybrid Zoom';

                    $j = Jadwal::create([
                        'id_kategori' => 2,
                        'id_jenis' => $service->id_jenis,
                        'kode_jadwal' => "KST-{$service->kode_jenis}-" . str_pad($scheduleCounter++, 3, '0', STR_PAD_LEFT),
                        'jenis_pertemuan' => $jenisPertemuan,
                        'tgl_mulai' => $tglMulai,
                        'tgl_selesai' => $tglSelesai,
                        'jam_pertemuan' => '09:00:00',
                        'lokasi' => $lokasi,
                        'kapasitas' => 10,
                        'harga' => collect([15000000, 25000000, 30000000])->random(),
                        'deskripsi' => "Pendampingan dan konsultasi program {$service->nama}.",
                        'link_meet' => 'https://zoom.us/j/' . rand(100000000, 999999999),
                        'created_at' => (clone $tglMulai)->subDays(rand(30, 40)),
                        'updated_at' => (clone $tglMulai)->subDays(rand(30, 40)),
                    ]);

                    $j->pemateri()->sync(collect(range(1, 5))->random(rand(1, 2))->toArray());
                }
            }

            // 3. Seed 1 Audit K3 (Category ID 3) every 2 months
            if ($month % 2 !== 0) {
                $auditServices = $services->get(3) ?? collect();
                if ($auditServices->isNotEmpty()) {
                    $service = $auditServices->random();
                    $tglMulai = Carbon::create($year, $month, 15);
                    $tglSelesai = (clone $tglMulai)->addDays(rand(2, 3));

                    $j = Jadwal::create([
                        'id_kategori' => 3,
                        'id_jenis' => $service->id_jenis,
                        'kode_jadwal' => "ADT-{$service->kode_jenis}-" . str_pad($scheduleCounter++, 3, '0', STR_PAD_LEFT),
                        'jenis_pertemuan' => 'offline',
                        'tgl_mulai' => $tglMulai,
                        'tgl_selesai' => $tglSelesai,
                        'jam_pertemuan' => '08:30:00',
                        'lokasi' => 'Pabrik / Site Klien',
                        'kapasitas' => 5,
                        'harga' => collect([20000000, 35000000, 45000000])->random(),
                        'deskripsi' => "Audit Independen {$service->nama} untuk sertifikasi industri.",
                        'created_at' => (clone $tglMulai)->subDays(rand(25, 35)),
                        'updated_at' => (clone $tglMulai)->subDays(rand(25, 35)),
                    ]);

                    $j->pemateri()->sync(collect(range(1, 3))->random(1)->toArray());
                }
            }

            $currentDate->addMonth();
        }
    }
}
