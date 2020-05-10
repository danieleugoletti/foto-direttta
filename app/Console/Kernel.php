<?php

namespace App\Console;

use App\Console\Notification\Tasks\BeforeStartTask;
use App\Console\Notification\Tasks\DailyFullTask;
use App\Console\Notification\Tasks\DailyShortTask;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $minutesBeforeStart = config('foto-diretta.notification.beforeStart.minutesBeforeStart');
        $schedule->call(new BeforeStartTask)->cron('*/'.$minutesBeforeStart.' * * * *');
        $schedule->call(new DailyShortTask)->dailyAt(config('foto-diretta.notification.dailyShort.runAt'));
        $schedule->call(new DailyFullTask)->dailyAt(config('foto-diretta.notification.dailyFull.runAt'));
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
