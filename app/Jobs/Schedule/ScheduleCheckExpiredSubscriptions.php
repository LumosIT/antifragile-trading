<?php

namespace App\Jobs\Schedule;

use App\Consts\SubscriptionStatuses;
use App\Jobs\Telegram\KickFromChannels;
use App\Jobs\Telegram\SendSubscribeCancelation;
use App\Models\Subscription;
use App\Models\User;
use App\Services\SubscriptionsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduleCheckExpiredSubscriptions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $bot;

    public function __construct()
    {
    }

    protected function getAllowedDelayDays() : int
    {
        return 3;
    }

    /**
     * Останавливает истекшие подписки
     * Удаляет из канала пользователей с истекшим сроком тарифа
     */
    public function handle(SubscriptionsService $subscriptionsService)
    {

        /**
         * Подписки у которых день назад истек срок
         */
        $subscriptions = Subscription::query()
            ->where('next_payment_at', now()->subDays($this->getAllowedDelayDays()))
            ->where('status', SubscriptionStatuses::ACTIVE)
            ->lazyById(10);

        foreach($subscriptions as $subscription){
            $subscriptionsService->stop($subscription);
        }

        /**
         * Юзеры у которых истек срок тарифа, но нет подписки
         */
        $users = User::query()
            ->whereNotNull('tariff_id')
            ->where(function($query){
                $query->orWhere(function($subQuery){
                    $subQuery->where('tariff_expired_at', '<', now()->subDays($this->getAllowedDelayDays()));
                    $subQuery->whereHas('activeSubscription');
                });
                $query->orWhere(function($subQuery){
                    $subQuery->where('tariff_expired_at', '<', now());
                    $subQuery->whereDoesntHave('activeSubscription');
                });
            })
            ->lazyById(10);

        foreach($users as $user){

            \DB::transaction(function () use ($subscriptions, $user){

                $user->tariff_id = null;
                $user->tariff_expired_at = null;
                $user->save();

                if($user->is_alive){
                    SendSubscribeCancelation::dispatch($user)->onQueue('telegram');
                }

                KickFromChannels::dispatch($user)->onQueue('telegram');

            });

        }


    }
}
