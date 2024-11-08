<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log; // Add logging

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
        // Schedule the child remaining days update to run daily at midnight
        $schedule->command('children:update-remaining-days')->dailyAt('14:05')->withoutOverlapping();
        Log::info('UpdateRemainingDays command started.');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // Load all custom console commands
        $this->load(__DIR__.'/Commands');

        // Include custom routes/console.php file for any additional commands defined there
       // require base_path('routes/console.php');
    }
}
