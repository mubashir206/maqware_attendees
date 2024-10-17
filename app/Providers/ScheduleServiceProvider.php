<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        // $this->commands([
        //     \App\Console\Commands\ReminderCommand::class,
        // ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(Schedule $schedule): void
    {
        // Schedule your command to run every minute
        // $schedule->command('reminder:send')->everyMinute();
    }
}
