<?php
/**
 * Увидомление об оплате за несколько дней
 */

namespace App\Jobs\Schedule;

use App\Jobs\Telegram\SendPaymentReminder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyBeforeSubscriptionsExpiration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $bot;

    public function __construct()
    {
    }

    protected function getDaysBefore() : int
    {
        return 3;
    }


    public function handle()
    {

        $date = now()->addDays($this->getDaysBefore());

        $users = User::query()
            ->alive()
            ->whereNotNull('tariff_id')
            ->where('tariff_expired_at', '<', $date)
            ->lazyById(10);

        foreach($users as $user) {
            SendPaymentReminder::dispatch($user)->onQueue('telegram');
        }

    }

}
