<?php
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\CleanOldInvoices;

return function (Schedule $schedule) {
    $schedule->command(CleanOldInvoices::class)->hourly();

    // Autres tâches planifiées :
    $schedule->command('backup:run')->dailyAt('03:00');

    $schedule->command('emails:send-digest')->weeklyOn(1, '8:00'); // Chaque lundi à 08h00
};
