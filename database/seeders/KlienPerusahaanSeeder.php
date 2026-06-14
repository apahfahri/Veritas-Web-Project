<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Perusahaan;

class KlienPerusahaanSeeder extends Seeder
{
    public function run()
    {
        $users = User::orderBy('id_user', 'asc')->take(15)->get();
        $companies = Perusahaan::orderBy('id_perusahaan', 'asc')->take(15)->get();

        $jabatans = [
            'HSE Manager',
            'HR Staff',
            'Safety Officer',
            'HR Director',
            'OHS Coordinator',
            'Training Supervisor',
            'Operations Manager',
            'Project Manager',
            'Admin HRD',
            'Safety Inspector',
            'HSE Director',
            'General Manager',
            'HR Executive',
            'Operation Specialist',
            'Security Commander'
        ];

        foreach ($companies as $index => $company) {
            $user = $users[$index] ?? null;
            if (!$user) break;

            DB::table('klien_perusahaan')->insert([
                'id_user' => $user->id_user,
                'id_perusahaan' => $company->id_perusahaan,
                'jabatan' => $jabatans[$index] ?? 'Manager',
                'nama_cp' => $user->nama,
                'no_hp_cp' => $user->no_telp,
                'catatan' => 'PIC Utama untuk koordinasi pelatihan.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
