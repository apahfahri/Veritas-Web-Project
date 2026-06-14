<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendaftaran;
use App\Models\Jadwal;
use App\Models\User;
use App\Models\Perusahaan;
use Carbon\Carbon;

class PendaftaranSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $companies = Perusahaan::all();
        $jadwals = Jadwal::orderBy('tgl_mulai', 'asc')->get();

        if ($users->isEmpty() || $jadwals->isEmpty()) {
            return;
        }

        $registrationCount = 0;

        foreach ($jadwals as $jadwal) {
            $isPast = $jadwal->tgl_mulai->isBefore(Carbon::create(2026, 6, 1));
            
            if ($isPast) {
                // Past schedules are completed, generate 3 to 6 participants per schedule
                $participantCount = rand(3, 6);
                for ($i = 0; $i < $participantCount; $i++) {
                    $user = $users->random();
                    $isUtusan = (rand(1, 10) <= 4); // 40% corporate, 60% individual
                    $company = $isUtusan ? $companies->random() : null;
                    
                    $regDate = (clone $jadwal->tgl_mulai)->subDays(rand(10, 25));

                    Pendaftaran::create([
                        'id_jadwal' => $jadwal->id_jadwal,
                        'id_user' => $user->id_user,
                        'is_utusan_perusahaan' => $isUtusan,
                        'id_perusahaan' => $company ? $company->id_perusahaan : null,
                        'is_kustom' => false,
                        'tanggal_daftar' => $regDate,
                        'mode_pertemuan' => $jadwal->jenis_pertemuan,
                        'status_progres' => 'selesai',
                        'status_bayar' => 'lunas',
                        'bukti_bayar' => 'bukti_bayar/mock_bukti_' . rand(1, 5) . '.jpg',
                        'created_at' => $regDate,
                        'updated_at' => (clone $regDate)->addDays(rand(1, 5)),
                    ]);
                    $registrationCount++;
                }
            } else {
                // Ongoing or future schedules (June - August 2026)
                // Generate 2 to 4 participants with varied status
                $participantCount = rand(2, 4);
                for ($i = 0; $i < $participantCount; $i++) {
                    $user = $users->random();
                    $isUtusan = (rand(1, 10) <= 4);
                    $company = $isUtusan ? $companies->random() : null;

                    // Some could be custom bespoke training requests
                    $isKustom = (rand(1, 10) === 1); // 10% chance
                    
                    $regDate = (clone $jadwal->tgl_mulai)->subDays(rand(2, 12));
                    if ($regDate->isAfter(Carbon::create(2026, 6, 13))) {
                        // Cap date to current mock date
                        $regDate = Carbon::create(2026, 6, 13)->subHours(rand(1, 12));
                    }

                    // Determine status based on custom or normal
                    if ($isKustom) {
                        $statusProgres = collect(['meninjau', 'dibatalkan'])->random();
                        $statusBayar = 'belum_bayar';
                    } else {
                        // Normal registrations
                        $statusProgres = collect(['menunggu_pembayaran', 'diproses', 'dibatalkan'])->random();
                        $statusBayar = ($statusProgres === 'diproses') ? 'lunas' : 'belum_lunas';
                    }

                    Pendaftaran::create([
                        'id_jadwal' => $jadwal->id_jadwal,
                        'id_user' => $user->id_user,
                        'is_utusan_perusahaan' => $isUtusan,
                        'id_perusahaan' => $company ? $company->id_perusahaan : null,
                        'is_kustom' => $isKustom,
                        'tanggal_daftar' => $regDate,
                        'mode_pertemuan' => $jadwal->jenis_pertemuan,
                        'status_progres' => $statusProgres,
                        'status_bayar' => $statusBayar,
                        'bukti_bayar' => ($statusBayar === 'lunas') ? 'bukti_bayar/mock_bukti_' . rand(1, 5) . '.jpg' : null,
                        'created_at' => $regDate,
                        'updated_at' => (clone $regDate)->addDays(rand(0, 2)),
                    ]);
                    $registrationCount++;
                }
            }
        }
    }
}
