<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['nama' => 'Budi Santoso', 'pendidikan' => 'S1 Teknik Industri', 'no_telp' => '081234560001', 'email' => 'budi@example.com'],
            ['nama' => 'Andi Wijaya', 'pendidikan' => 'D3 K3', 'no_telp' => '081234560002', 'email' => 'andi@example.com'],
            ['nama' => 'Ahmad Fauzi', 'pendidikan' => 'S1 Kesehatan Masyarakat', 'no_telp' => '081234560003', 'email' => 'ahmad.fauzi@example.com'],
            ['nama' => 'Siti Nurhaliza', 'pendidikan' => 'S1 Teknik Sipil', 'no_telp' => '081234560004', 'email' => 'siti.nur@example.com'],
            ['nama' => 'Dewi Puspitasari', 'pendidikan' => 'S1 Teknik Lingkungan', 'no_telp' => '081234560005', 'email' => 'dewi.puspa@example.com'],
            ['nama' => 'Rizky Ananda', 'pendidikan' => 'D3 Teknik Mesin', 'no_telp' => '081234560006', 'email' => 'rizky.ananda@example.com'],
            ['nama' => 'Hendra Kurniawan', 'pendidikan' => 'SMA IPA', 'no_telp' => '081234560007', 'email' => 'hendra.k@example.com'],
            ['nama' => 'Fitriani Rahayu', 'pendidikan' => 'S1 Psikologi', 'no_telp' => '081234560008', 'email' => 'fitri.rahayu@example.com'],
            ['nama' => 'Muhamad Yusuf', 'pendidikan' => 'S1 Kedokteran', 'no_telp' => '081234560009', 'email' => 'yusuf.hidayat@example.com'],
            ['nama' => 'Rini Setiawati', 'pendidikan' => 'D3 Farmasi', 'no_telp' => '081234560010', 'email' => 'rini.s@example.com'],
            ['nama' => 'Agus Budiman', 'pendidikan' => 'S1 Teknik Elektro', 'no_telp' => '081234560011', 'email' => 'agus.budi@example.com'],
            ['nama' => 'Mega Utami', 'pendidikan' => 'S1 Manajemen', 'no_telp' => '081234560012', 'email' => 'mega.utami@example.com'],
            ['nama' => 'Joko Susilo', 'pendidikan' => 'SMA IPS', 'no_telp' => '081234560013', 'email' => 'joko.s@example.com'],
            ['nama' => 'Indah Lestari', 'pendidikan' => 'S1 Teknik Kimia', 'no_telp' => '081234560014', 'email' => 'indah.l@example.com'],
            ['nama' => 'Hadi Pranoto', 'pendidikan' => 'D3 Teknik Sipil', 'no_telp' => '081234560015', 'email' => 'hadi.p@example.com'],
            ['nama' => 'Sri Wahyuni', 'pendidikan' => 'S1 Ilmu Keperawatan', 'no_telp' => '081234560016', 'email' => 'sri.wahyuni@example.com'],
            ['nama' => 'Eko Prasetyo', 'pendidikan' => 'S1 Hukum', 'no_telp' => '081234560017', 'email' => 'eko.prast@example.com'],
            ['nama' => 'Yulianti', 'pendidikan' => 'D3 Administrasi Bisnis', 'no_telp' => '081234560018', 'email' => 'yulianti@example.com'],
            ['nama' => 'Bambang Hartono', 'pendidikan' => 'S1 Teknik Pertambangan', 'no_telp' => '081234560019', 'email' => 'bambang.h@example.com'],
            ['nama' => 'Kartika Sari', 'pendidikan' => 'S1 Teknik Industri', 'no_telp' => '081234560020', 'email' => 'kartika.s@example.com'],
            ['nama' => 'Rudi Hermawan', 'pendidikan' => 'D3 Teknik Listrik', 'no_telp' => '081234560021', 'email' => 'rudi.h@example.com'],
            ['nama' => 'Ani Wijayanti', 'pendidikan' => 'S1 Kesehatan Masyarakat', 'no_telp' => '081234560022', 'email' => 'ani.wijay@example.com'],
            ['nama' => 'Dedi Mulyadi', 'pendidikan' => 'SMA IPA', 'no_telp' => '081234560023', 'email' => 'dedi.m@example.com'],
            ['nama' => 'Rina Marlina', 'pendidikan' => 'S1 Psikologi', 'no_telp' => '081234560024', 'email' => 'rina.m@example.com'],
            ['nama' => 'Taufik Hidayat', 'pendidikan' => 'S1 Teknik Mesin', 'no_telp' => '081234560025', 'email' => 'taufik.h@example.com'],
            ['nama' => 'Siti Aminah', 'pendidikan' => 'S1 Teknik Lingkungan', 'no_telp' => '081234560026', 'email' => 'siti.aminah@example.com'],
            ['nama' => 'Wawan Setiawan', 'pendidikan' => 'D3 K3', 'no_telp' => '081234560027', 'email' => 'wawan.s@example.com'],
            ['nama' => 'Dian Sastrowardoyo', 'pendidikan' => 'S1 Manajemen', 'no_telp' => '081234560028', 'email' => 'dian.sastro@example.com'],
            ['nama' => 'Fajar Nugraha', 'pendidikan' => 'S1 Teknik Sipil', 'no_telp' => '081234560029', 'email' => 'fajar.nug@example.com'],
            ['nama' => 'Ratna Sari', 'pendidikan' => 'D3 Farmasi', 'no_telp' => '081234560030', 'email' => 'ratna.sari@example.com'],
            ['nama' => 'Heri Setiawan', 'pendidikan' => 'SMA IPS', 'no_telp' => '081234560031', 'email' => 'heri.s@example.com'],
            ['nama' => 'Lilis Suryani', 'pendidikan' => 'S1 Kesehatan Masyarakat', 'no_telp' => '081234560032', 'email' => 'lilis.s@example.com'],
            ['nama' => 'Mulyadi', 'pendidikan' => 'D3 Teknik Elektronika', 'no_telp' => '081234560033', 'email' => 'mulyadi.m@example.com'],
            ['nama' => 'Yuni Shara', 'pendidikan' => 'S1 Ekonomi', 'no_telp' => '081234560034', 'email' => 'yuni.shara@example.com'],
            ['nama' => 'Dani Ramdani', 'pendidikan' => 'S1 Teknik Geologi', 'no_telp' => '081234560035', 'email' => 'dani.ram@example.com'],
            ['nama' => 'Novianti', 'pendidikan' => 'D3 Kebidanan', 'no_telp' => '081234560036', 'email' => 'novianti@example.com'],
            ['nama' => 'Budi Wijaya', 'pendidikan' => 'S1 Teknik Kelautan', 'no_telp' => '081234560037', 'email' => 'budi.wij@example.com'],
            ['nama' => 'Eka Putri', 'pendidikan' => 'S1 Hubungan Internasional', 'no_telp' => '081234560038', 'email' => 'eka.putri@example.com'],
            ['nama' => 'Zainal Abidin', 'pendidikan' => 'D3 Teknik Otomotif', 'no_telp' => '081234560039', 'email' => 'zainal.a@example.com'],
            ['nama' => 'Tri Wahyudi', 'pendidikan' => 'SMA IPA', 'no_telp' => '081234560040', 'email' => 'tri.wahyudi@example.com'],
            ['nama' => 'Sri Rahayu', 'pendidikan' => 'S1 Sastra Inggris', 'no_telp' => '081234560041', 'email' => 'sri.rahayu@example.com'],
            ['nama' => 'Dadang Suhendar', 'pendidikan' => 'D3 K3', 'no_telp' => '081234560042', 'email' => 'dadang.s@example.com'],
            ['nama' => 'Kiki Amelia', 'pendidikan' => 'S1 Akuntansi', 'no_telp' => '081234560043', 'email' => 'kiki.amel@example.com'],
            ['nama' => 'Ari Wibowo', 'pendidikan' => 'S1 Hukum', 'no_telp' => '081234560044', 'email' => 'ari.wibowo@example.com'],
            ['nama' => 'Susi Pudjiastuti', 'pendidikan' => 'SMA IPS', 'no_telp' => '081234560045', 'email' => 'susi.p@example.com'],
            ['nama' => 'Edi Sudrajat', 'pendidikan' => 'S1 Teknik Penerbangan', 'no_telp' => '081234560046', 'email' => 'edi.sud@example.com'],
            ['nama' => 'Yanti', 'pendidikan' => 'D3 Manajemen Informatika', 'no_telp' => '081234560047', 'email' => 'yanti.m@example.com'],
            ['nama' => 'Indra Wijaya', 'pendidikan' => 'S1 Teknik Fisika', 'no_telp' => '081234560048', 'email' => 'indra.w@example.com'],
            ['nama' => 'Desi Ratnasari', 'pendidikan' => 'S1 Ilmu Komunikasi', 'no_telp' => '081234560049', 'email' => 'desi.ratna@example.com'],
            ['nama' => 'Lukman Hakim', 'pendidikan' => 'S1 Teknik Mesin', 'no_telp' => '081234560050', 'email' => 'lukman.h@example.com'],
            ['nama' => 'Nurhayati', 'pendidikan' => 'D3 Gizi', 'no_telp' => '081234560051', 'email' => 'nurhayati@example.com'],
            ['nama' => 'Gunawan', 'pendidikan' => 'S1 Teknik Metalurgi', 'no_telp' => '081234560052', 'email' => 'gunawan.m@example.com'],
            ['nama' => 'Tuti Alawiyah', 'pendidikan' => 'S1 Pendidikan Agama', 'no_telp' => '081234560053', 'email' => 'tuti.a@example.com'],
            ['nama' => 'Sholeh', 'pendidikan' => 'D3 Teknik Kimia', 'no_telp' => '081234560054', 'email' => 'sholeh@example.com'],
            ['nama' => 'Cucu Sumiati', 'pendidikan' => 'S1 Farmasi', 'no_telp' => '081234560055', 'email' => 'cucu.s@example.com'],
        ];

        $defaultPassword = Hash::make('password123');

        foreach ($users as $u) {
            User::create([
                'nama' => $u['nama'],
                'pendidikan' => $u['pendidikan'],
                'no_telp' => $u['no_telp'],
                'email' => $u['email'],
                'password' => $defaultPassword,
            ]);
        }
    }
}
