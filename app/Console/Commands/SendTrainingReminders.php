<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Jadwal;
use App\Models\Pendaftaran;
use App\Mail\TrainingReminderMail;
use Illuminate\Support\Facades\Mail;

class SendTrainingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-training-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email H-3 konfirmasi pelaksanaan pelatihan ke pendaftar terkonfirmasi';

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
        // Cari jadwal H-3 (tgl_mulai = now() + 3 days)
        $targetDate = now()->addDays(3)->toDateString();

        $jadwals = Jadwal::whereDate('tgl_mulai', '=', $targetDate)
            ->whereNull('reminder_h3_sent_at')
            ->get();

        $count = 0;
        foreach ($jadwals as $jadwal) {
            // Jika jadwal online/hybrid tapi link meet belum terisi, lewati pengiriman.
            if (in_array($jadwal->jenis_pertemuan, ['online', 'hybrid']) && empty($jadwal->link_meet)) {
                continue;
            }

            $pendaftarans = Pendaftaran::where('id_jadwal', $jadwal->id_jadwal)
                ->whereIn('status_progres', ['terkonfirmasi', 'selesai'])
                ->get();

            foreach ($pendaftarans as $pendaftaran) {
                $email = $pendaftaran->user->email ?? null;
                if ($email) {
                    Mail::to($email)->send(new TrainingReminderMail($pendaftaran));
                    $count++;
                }
            }

            $jadwal->update([
                'reminder_h3_sent_at' => now()
            ]);
        }

        $this->info("Berhasil mengirim $count email reminder untuk jadwal H-3.");
        return 0;
    }
}
