<?php

namespace App\Console;

use App\Jobs\Schedule\ScheduleCheckExpiredSubscriptions;
use App\Jobs\Schedule\ScheduleNotifyBeforeSubscriptionsExpiration;
use App\Jobs\Schedule\ScheduleSpamContinue;
use App\Jobs\Schedule\ScheduleSpamPosts;
use App\Jobs\Schedule\ScheduleSpamRemaining;
use App\Jobs\Schedule\ScheduleSuggestTesting;
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
        $schedule->job(ScheduleCheckExpiredSubscriptions::class)->everyMinute();

        //Telegram mailing
        $schedule->job(ScheduleNotifyBeforeSubscriptionsExpiration::class)->hourly();
        $schedule->job(ScheduleSuggestTesting::class)->daily();

        $schedule->job(ScheduleSpamPosts::class)->everyTenMinutes()
            ->between('8:00', '20:00')
            ->timezone('Europe/Moscow');

        $schedule->job(ScheduleSpamContinue::class)->hourly()
            ->between('8:00', '20:00')
            ->timezone('Europe/Moscow');

        $schedule->job(ScheduleSpamRemaining::class)->hourly()
            ->between('8:00', '20:00')
            ->timezone('Europe/Moscow');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
