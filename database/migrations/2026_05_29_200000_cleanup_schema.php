<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop tanggal_usul on jadwal table
        if (Schema::hasColumn('jadwal', 'tanggal_usul')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->dropColumn('tanggal_usul');
            });
        }

        // 2. Drop cabang on pendaftaran table
        if (Schema::hasColumn('pendaftaran', 'cabang')) {
            Schema::table('pendaftaran', function (Blueprint $table) {
                $table->dropColumn('cabang');
            });
        }

        // 3. Populate empty kode_jadwal on jadwal table
        $emptyJadwals = \DB::table('jadwal')->whereNull('kode_jadwal')->orWhere('kode_jadwal', '')->get();
        foreach ($emptyJadwals as $j) {
            $kategori = \DB::table('kategori_layanan')->where('id_kategori', $j->id_kategori)->first();
            $jenis = \DB::table('jenis_layanan')->where('id_jenis', $j->id_jenis)->first();
            
            $kategoriKode = $kategori?->kode_kategori ?? 'KST';
            
            // Generate kode_jenis if empty
            if ($jenis && empty($jenis->kode_jenis)) {
                $words = explode(' ', preg_replace('/[^a-zA-Z0-9\s]/', '', $jenis->nama));
                $code = '';
                if (count($words) > 1) {
                    foreach ($words as $w) {
                        $code .= strtoupper(substr($w, 0, 1));
                    }
                } else {
                    $code = strtoupper(substr($words[0] ?? 'KNS', 0, 4));
                }
                $code = preg_replace('/[^A-Z0-9]/', '', $code);
                if (empty($code)) {
                    $code = 'KNS';
                }
                $jenisKode = substr($code, 0, 15);
                \DB::table('jenis_layanan')->where('id_jenis', $j->id_jenis)->update(['kode_jenis' => $jenisKode]);
            } else {
                $jenisKode = $jenis?->kode_jenis ?? 'KNS';
            }
            
            // Count other jadwals of the same jenis that already have a sequence
            $urutan = \DB::table('jadwal')
                ->where('id_jenis', $j->id_jenis)
                ->where('id_jadwal', '<', $j->id_jadwal)
                ->count() + 1;
            
            $urutanFormat = str_pad($urutan, 2, '0', STR_PAD_LEFT);
            $kode_jadwal = "{$kategoriKode}-{$jenisKode}-{$urutanFormat}";
            
            \DB::table('jadwal')->where('id_jadwal', $j->id_jadwal)->update(['kode_jadwal' => $kode_jadwal]);
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('jadwal', 'tanggal_usul')) {
            Schema::table('jadwal', function (Blueprint $table) {
                $table->date('tanggal_usul')->nullable();
            });
        }

        if (!Schema::hasColumn('pendaftaran', 'cabang')) {
            Schema::table('pendaftaran', function (Blueprint $table) {
                $table->string('cabang')->nullable()->after('bukti_bayar');
            });
        }
    }
};
