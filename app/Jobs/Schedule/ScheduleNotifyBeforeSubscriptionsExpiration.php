<?php
/**
 * Увидомление об оплате за несколько дней
 */

namespace App\Jobs\Schedule;

use App\Jobs\Telegram\SendCancelReminder;
use App\Jobs\Telegram\SendPaymentReminder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduleNotifyBeforeSubscriptionsExpiration implements ShouldQueue
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

        $days = $this->getDaysBefore();

        //Истекают через 3 дня
        $date_expiration = now()->addDays($days);

        //Уведомлений не было 3 дня
        $date_notify = now()->subDays($days);

        $users = User::query()
            ->alive()
            ->whereNotNull('tariff_id')
            ->where(function(Builder $query) use ($date_notify){
                $query->orWhereNull('subscription_notify_at');
                $query->orWhere('subscription_notify_at', '<', $date_notify);
            })
            ->where('tariff_expired_at', '<', $date_expiration)
            ->with('activeSubscription')
            ->lazyById(10);

        foreach($users as $user) {

            $user->subscription_notify_at = now();
            $user->save();

            if($user->activeSubscription){
                SendPaymentReminder::dispatch($user)->onQueue('telegram');
            }else{
                SendCancelReminder::dispatch($user)->onQueue('telegram');
            }

        }

    }

}
