<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pendaftaran;
use App\Mail\PelatihanKustomReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendPelatihanReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'veritas:send-h3-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send H-3 reminder emails to participants of scheduled custom trainings';

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
        $targetDate = now()->addDays(3)->format('Y-m-d');
        
        $pendaftarans = Pendaftaran::where('is_kustom', true)
            ->whereIn('status_progres', ['dijadwalkan', 'menunggu_pelaksanaan', 'menunggu_pembayaran', 'pembayaran_ditinjau', 'selesai'])
            ->whereDate('rencana_tanggal_mulai', $targetDate)
            ->where('is_utusan_perusahaan', false)
            ->with(['jadwal', 'perusahaan', 'user'])
            ->get();
            
        $count = 0;
        
        foreach ($pendaftarans as $p) {
            $participants = Pendaftaran::where('id_jadwal', $p->id_jadwal)
                ->where('id_pendaftaran', '!=', $p->id_pendaftaran)
                ->with('user')
                ->get();
                
            if ($participants->isEmpty()) {
                Log::warning("H-3 Reminder skipped for Pendaftaran ID {$p->id_pendaftaran}: No participants found.");
                continue;
            }
            
            // Send to the PIC
            if ($p->user) {
                Mail::to($p->user->email)->queue(new PelatihanKustomReminderMail($p, $p->user));
                $count++;
            }
            
            // Send to all participants
            foreach ($participants as $part) {
                if ($part->user) {
                    Mail::to($part->user->email)->queue(new PelatihanKustomReminderMail($p, $part->user));
                    $count++;
                }
            }
            
            Log::info("H-3 Reminder sent for Pendaftaran ID {$p->id_pendaftaran} to {$participants->count()} participants.");
        }

        $this->info("Successfully queued {$count} reminder emails for H-3 Custom Trainings.");
        return 0;
    }
}
