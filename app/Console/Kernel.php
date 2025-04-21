<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\ProductController;

class Kernel extends ConsoleKernel
{
    /**
     * Register Artisan commands.
     */
    protected $commands = [
        \App\Console\Commands\SendDailyNotifications::class,
    ];

    /**
     * Define the application's command schedule.
     */
   protected function schedule(Schedule $schedule)
{
    // Send daily notifications at 9:00 AM IST
    $schedule->command('daily:notify')
        ->dailyAt('09:00')
        ->timezone('Asia/Kolkata')
        ->description('Send daily notifications to users');
        
    // Update vendor status daily at midnight IST
    $schedule->call(function () {
        app(ProductController::class)->updateVendorStatus();
    })
        ->daily()
        ->timezone('Asia/Kolkata')
        ->description('Update vendor statuses');
}

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}