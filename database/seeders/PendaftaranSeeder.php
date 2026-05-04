<?php

namespace Database\Seeders;

use App\Models\Pendaftaran;
use App\Models\Layanan;
use App\Models\User;
use App\Models\Petugas;
use App\Models\Sertifikat;
use App\Models\Verifikasi;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PendaftaranSeeder extends Seeder
{
    public function run()
    {
        $layanan   = Layanan::all();
        $users     = User::whereDoesntHave('admin')->get(); // Ambil user klien
        $petugas   = Petugas::all();

        if ($layanan->isEmpty() || $users->isEmpty()) return;

        // 1. Pendaftaran Menunggu (Individu)
        Pendaftaran::create([
            'layanan_id'      => $layanan->where('nama', 'Pelatihan K3')->first()->id,
            'user_id'         => $users->where('email', 'ahmad.z@example.com')->first()->id,
            'petugas_id'      => null,
            'tanggal_daftar'  => Carbon::now()->subDays(2),
            'status_progres'  => 'menunggu',
            'status_bayar'    => 'belum_bayar',
        ]);

        // 2. Pendaftaran Diproses (Perusahaan)
        $p2 = Pendaftaran::create([
            'layanan_id'      => $layanan->where('nama', 'Audit K3')->first()->id,
            'user_id'         => $users->where('email', 'herry.k@adhikarya.com')->first()->id,
            'petugas_id'      => $petugas->first()->id,
            'tanggal_daftar'  => Carbon::now()->subDays(5),
            'status_progres'  => 'diproses',
            'status_bayar'    => 'lunas',
        ]);

        // 3. Pendaftaran Selesai + Sertifikat (Individu)
        $userSelesai = $users->where('email', 'linda.p@example.com')->first();
        $p3 = Pendaftaran::create([
            'layanan_id'      => $layanan->where('nama', 'Pelatihan K3')->first()->id,
            'user_id'         => $userSelesai->id,
            'petugas_id'      => $petugas->last()->id,
            'tanggal_daftar'  => Carbon::now()->subDays(15),
            'status_progres'  => 'selesai',
            'status_bayar'    => 'lunas',
        ]);

        $sertifikat = Sertifikat::create([
            'no_sertifikat'  => 'VERITAS/K3/' . date('Y') . '/0001',
            'pendaftaran_id' => $p3->id,
            'nama_lengkap'   => 'Linda Permata, S.K.M.',
            'tanggal_terbit' => Carbon::now()->subDays(2),
            'file'           => 'sertifikat/dummy.pdf',
        ]);

        // 4. Verifikasi Log
        Verifikasi::create([
            'no_sertifikat'  => $sertifikat->no_sertifikat,
            'sertifikat_id'  => $sertifikat->id,
            'status'         => 'valid',
            'catatan'        => 'Verifikasi sukses melalui portal publik.',
            'ip_address'     => '127.0.0.1',
        ]);

        Verifikasi::create([
            'no_sertifikat'  => 'VERITAS/FAKE/9999',
            'sertifikat_id'  => null,
            'status'         => 'tidak_ditemukan',
            'catatan'        => 'User mencoba memverifikasi nomor yang tidak terdaftar.',
            'ip_address'     => '192.168.1.1',
        ]);
    }
}
