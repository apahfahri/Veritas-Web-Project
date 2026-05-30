<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pendaftaran;
use Carbon\Carbon;

class AutoClosePassedTrainings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pendaftaran:auto-close-trainings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengubah status pendaftaran pelatihan yang sudah lewat tanggal pelaksanaannya menjadi selesai secara otomatis';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today()->toDateString();

        // Cari pendaftaran pelatihan (kategori selain konsultasi/kategori ID = 1 atau filter pendaftaran yang punya jadwal)
        // yang status progresnya 'diproses' (Terkonfirmasi)
        // dan tanggal pelaksanaan sudah lewat (hari ini > tgl_selesai, atau jika tgl_selesai null, hari ini > tgl_mulai)
        $pendaftarans = Pendaftaran::where('status_progres', 'diproses')
            ->whereHas('jadwal', function ($query) use ($today) {
                $query->where(function ($q) use ($today) {
                    $q->whereNotNull('tgl_selesai')
                      ->where('tgl_selesai', '<', $today);
                })->orWhere(function ($q) use ($today) {
                    $q->whereNull('tgl_selesai')
                      ->where('tgl_mulai', '<', $today);
                });
            })
            ->get();

        $count = 0;
        foreach ($pendaftarans as $pendaftaran) {
            $pendaftaran->update([
                'status_progres' => 'selesai'
            ]);
            $count++;
        }

        $this->info("Berhasil mengubah {$count} pendaftaran pelatihan menjadi Selesai secara otomatis.");
        return 0;
    }
}
