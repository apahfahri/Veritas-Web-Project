<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Run daily at 08:00
        $schedule->command('email:send-training-reminders')->dailyAt('08:00');
        
        // Auto close passed trainings daily at 00:05
        $schedule->command('pendaftaran:auto-close-trainings')->dailyAt('00:05');

        // Custom Training H-3 Reminder
        $schedule->command('veritas:send-h3-reminder')->dailyAt('08:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
