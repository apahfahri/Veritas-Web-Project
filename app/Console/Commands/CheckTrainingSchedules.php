<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Jadwal;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrainingReminderMail;

class CheckTrainingSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'training:check-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check training schedules H-3. Close if quota not met, send reminder emails if met.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting training schedule check (H-3)...');
        
        $targetDate = Carbon::today()->addDays(3)->format('Y-m-d');
        
        // Find all active schedules starting exactly 3 days from now
        $jadwals = Jadwal::with(['jenis', 'kategori', 'pendaftarans.user'])
                    ->where('tgl_mulai', $targetDate)
                    ->where('is_active', true)
                    ->get();

        if ($jadwals->isEmpty()) {
            $this->info("No active schedules found starting on {$targetDate}.");
            return 0;
        }

        foreach ($jadwals as $jadwal) {
            $this->info("Checking Schedule ID: {$jadwal->id_jadwal} - {$jadwal->nama_program}");
            
            // Valid participants (paid and confirmed)
            $validPendaftarans = $jadwal->pendaftarans->filter(function ($p) {
                return in_array($p->status_progres, ['diproses', 'selesai']) && $p->status_bayar === 'lunas';
            });
            
            $participantCount = $validPendaftarans->count();
            
            // Check quota
            if ($jadwal->kuota_minimal > 0 && $participantCount < $jadwal->kuota_minimal) {
                $this->info(" -> Quota not met ({$participantCount}/{$jadwal->kuota_minimal}). Closing schedule.");
                
                $jadwal->is_active = false;
                $jadwal->save();
                
                // Optionally cancel valid registrations or notify them of cancellation
                // For now, we just close the schedule and keep their status, admin handles refund/reschedule
                
                Log::info("Schedule {$jadwal->id_jadwal} closed automatically at H-3 due to unmet quota.");
            } else {
                $this->info(" -> Quota met or no minimum ({$participantCount}). Sending reminders.");
                
                foreach ($validPendaftarans as $pendaftaran) {
                    if ($pendaftaran->user && $pendaftaran->user->email) {
                        try {
                            Mail::to($pendaftaran->user->email)->send(new TrainingReminderMail($pendaftaran));
                            $this->line("    -> Sent email to {$pendaftaran->user->email}");
                        } catch (\Exception $e) {
                            $this->error("    -> Failed to send to {$pendaftaran->user->email}: " . $e->getMessage());
                            Log::error("Training reminder email failed for User {$pendaftaran->user->id_user}: " . $e->getMessage());
                        }
                    }
                }
            }
        }
        
        $this->info('Finished schedule check.');
        return 0;
    }
}
