<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('check:undo-expiry')->everyMinute();
        $schedule->command('app:reset-score-anually')->yearlyOn(12, 31, '23:59');
        $schedule->command('app:tier-change')->everySecond();
        $schedule->exec('nrb')->everySecond();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
