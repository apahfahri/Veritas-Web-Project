<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use App\Models\Sertifikat;
use App\Models\KategoriLayanan;
use App\Models\JenisLayanan;
use Faker\Factory as Faker;
use Carbon\Carbon;

class MassiveDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        $this->command->info('Creating Users...');
        $users = [];
        for ($i = 0; $i < 50; $i++) {
            $users[] = User::create([
                'nama' => $faker->name,
                'pendidikan' => $faker->randomElement(['SMA', 'D3 K3', 'S1 Teknik Industri', 'S1 Kesehatan Masyarakat', 'S2 Teknik']),
                'no_telp' => '08' . $faker->randomNumber(8, true) . $faker->randomNumber(2, true),
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password123'),
            ]);
        }

        $kategoriList = KategoriLayanan::all();
        $jenisList = JenisLayanan::all();

        if ($kategoriList->isEmpty() || $jenisList->isEmpty()) {
            $this->command->error("Kategori or Jenis is empty. Please run DatabaseSeeder first.");
            return;
        }

        $this->command->info('Creating Jadwals...');
        $jadwals = [];
        for ($i = 0; $i < 40; $i++) {
            $jenis = $jenisList->random();
            $kategori = $kategoriList->where('id_kategori', $jenis->id_kategori)->first() ?? $kategoriList->random();
            
            $urutan = Jadwal::where('id_jenis', $jenis->id_jenis)->count() + 1;
            $kode_jadwal = $kategori->kode_kategori . '-' . $jenis->kode_jenis . '-M-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);

            $tgl_mulai = clone $faker->dateTimeBetween('-1 years', '+3 months');
            $tgl_selesai = (clone $tgl_mulai)->modify('+' . rand(1, 5) . ' days');
            
            $jadwal = Jadwal::create([
                'kode_jadwal' => $kode_jadwal,
                'id_kategori' => $kategori->id_kategori,
                'id_jenis' => $jenis->id_jenis,
                'jenis_pertemuan' => $faker->randomElement(['online', 'offline', 'hybrid']),
                'tgl_mulai' => $tgl_mulai->format('Y-m-d'),
                'tgl_selesai' => $tgl_selesai->format('Y-m-d'),
                'jam_pertemuan' => $faker->time('H:i:s'),
                'lokasi' => $faker->city,
                'link_meet' => $faker->url,
                'kapasitas' => $faker->numberBetween(10, 50),
                'harga' => $faker->numberBetween(1000000, 10000000),
                'deskripsi' => 'Data generated massively for testing. ' . $faker->sentence,
                'foto' => 'jadwal/training_1.png',
            ]);
            $jadwals[] = $jadwal;
        }

        $this->command->info('Creating Pendaftarans and Sertifikats...');
        $statuses = ['menunggu_pembayaran', 'diverifikasi', 'proses', 'selesai', 'dibatalkan'];
        
        for ($i = 0; $i < 300; $i++) {
            $user = $users[array_rand($users)];
            $jadwal = $jadwals[array_rand($jadwals)];
            
            // Weight 'selesai' more so we get more certificates
            $status_progres = $faker->randomElement(['menunggu_pembayaran', 'diverifikasi', 'proses', 'selesai', 'selesai', 'selesai', 'dibatalkan']);
            $status_bayar = in_array($status_progres, ['diverifikasi', 'proses', 'selesai']) ? 'lunas' : 'belum_lunas';
            $mode_pertemuan = $faker->randomElement(['online', 'offline', 'hybrid']);
            
            // Ensure tanggal daftar is before jadwal
            $tglDaftar = clone Carbon::parse($jadwal->tgl_mulai)->subDays(rand(1, 30));

            $pendaftaran = Pendaftaran::create([
                'id_jadwal' => $jadwal->id_jadwal,
                'id_user' => $user->id_user,
                'tanggal_daftar' => $tglDaftar->format('Y-m-d'),
                'mode_pertemuan' => $mode_pertemuan,
                'status_progres' => $status_progres,
                'status_bayar' => $status_bayar,
                'id_perusahaan' => null,
            ]);
            
            if ($status_progres === 'selesai') {
                DB::table('sertifikat')->insert([
                    'no_sertifikat' => 'CERT-' . strtoupper($faker->bothify('???-####')) . '-' . rand(1000, 9999),
                    'id_pendaftaran' => $pendaftaran->id_pendaftaran,
                    'nama_lengkap' => $user->nama,
                    'tanggal_terbit' => Carbon::parse($jadwal->tgl_selesai)->addDays(rand(1, 10))->format('Y-m-d'),
                    'file_pdf' => 'sertifikat/dummy_cert.pdf',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Massive data seeded successfully!');
    }
}
