<?php

namespace App\Console;

use App\Jobs\RemoveOffer;
use App\Jobs\Schedule\ScheduleCheckExpiredSubscriptions;
use App\Jobs\Schedule\ScheduleNotifyBeforeSubscriptionsExpiration;
use App\Jobs\Schedule\ScheduleNotifyBeforeSubscriptionsExpirationOneDay;
use App\Jobs\Schedule\ScheduleSpamContinue;
use App\Jobs\Schedule\ScheduleSpamPosts;
use App\Jobs\Schedule\ScheduleSpamRemaining;
use App\Jobs\Schedule\ScheduleSuggestTesting;
use App\Models\Offer;
use Carbon\Carbon;
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

        //Telegram and MAX mailing
        $schedule->job(ScheduleNotifyBeforeSubscriptionsExpiration::class)->hourly();
        $schedule->job(ScheduleNotifyBeforeSubscriptionsExpirationOneDay::class)->hourly();
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

        $schedule->call(function() {
            $now = Carbon::now();
            $offers = Offer::where('is_deleted', false)->get();

            foreach ($offers as $offer) {
                $deleteAfter = null;

                if ($offer->type === 'max') {
                    $deleteAfter = $offer->created_at->copy()->addHours(23)->addMinutes(30);
                } elseif ($offer->type === 'telegram') {
                    $deleteAfter = $offer->created_at->copy()->addHours(47)->addMinutes(30);
                }

                if ($deleteAfter && $now->gte($deleteAfter)) {
                    $offer->update([
                        'is_deleted' => true
                    ]);

                    RemoveOffer::dispatch($offer)->onQueue('default');
                }
            }

        })->everyMinute();
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
