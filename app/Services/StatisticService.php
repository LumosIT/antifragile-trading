<?php

namespace App\Services;

/**
 * Работа с общей статистикой
 */

use App\Consts\SubscriptionStatuses;
use App\Models\Payment;
use App\Models\StatisticDay;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;

class StatisticService
{

    public function getOrCreateDay(Carbon $date) : StatisticDay
    {
        $date = $date->format('Y-m-d');

        $day = StatisticDay::query()
            ->where('date', $date)
            ->first();

        return $day ?: StatisticDay::create([
            'date' => $date
        ]);

    }

    public function getCurrentDay() : StatisticDay
    {
        return $this->getOrCreateDay(
            now()
        );
    }

    public function onRegister(User $user){

        $day = $this->getCurrentDay();

        $day->increment('registers');

    }

    public function onActivity(User $user)
    {

        $day = $this->getCurrentDay();

        $day->increment('activities');

    }

    public function onCancelSubscription(Subscription $subscription)
    {
        $day = $this->getCurrentDay();

        $day->increment('cancels');
    }

    public function onCreateSubscription(Subscription $subscription, Payment $payment)
    {

        \DB::transaction(function () use ($subscription) {

            $day = $this->getCurrentDay();

            $hasCanceledSubscriptionsBefore = Subscription::query()
                ->where('user_id', $subscription->user_id)
                ->where('id', '!=', $subscription->id)
                ->where('status', SubscriptionStatuses::CANCELLED)
                ->exists();

            $day->increment('sells');

            if($hasCanceledSubscriptionsBefore){

                $day->increment('sells_after_cancel');

            }else{

                $day->increment('sells_new');

            }

        });

    }

    public function onContinueSubscription(Subscription $subscription, Payment $payment)
    {

        \DB::transaction(function () use ($subscription) {

            $day = $this->getCurrentDay();

            $day->increment('sells');
            $day->increment('sells_continues');

            if($subscription->payments()->count() > 2){
            }else{
                $day->increment('sells_continues_first');
            }

        });



    }


}
