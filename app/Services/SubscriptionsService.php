<?php

namespace App\Services;

/**
 * Работа с подпиской и тарифами
 */

use App\Consts\SubscriptionPeriods;
use App\Consts\SubscriptionStatuses;
use App\Consts\TariffModes;
use App\Consts\UserStages;
use App\Exceptions\Subscriptions\CantContinueSubscriptionException;
use App\Models\Subscription;
use App\Models\Tariff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SubscriptionsService
{

    protected $tariffsService;

    public function __construct(TariffsService $tariffsService)
    {
        $this->tariffsService = $tariffsService;
    }

    /**
     * Возобновление подписки
     */
    public function renew(Subscription $subscription, string $code, ?Carbon $expiration_time) : void
    {

        DB::transaction(function () use ($expiration_time, $subscription, $code) {

            $user = $subscription->user;

            if($user->tariff_id !== $subscription->tariff_id) {
                throw new CantContinueSubscriptionException;
            }

            $user->stage = $subscription->tariff->mode === TariffModes::FULL
                ? UserStages::BUY_THIRD_PART
                : UserStages::BUY_SECOND_PART;
            $user->save();

            $subscription->status = SubscriptionStatuses::ACTIVE;
            $subscription->code = $code;
            $subscription->save();

        });

    }

    /**
     * Продление подписки и установка тарифа
     */
    public function continue(Subscription $subscription)
    {

        DB::transaction(function () use ($subscription) {

            $start = now();
            $end = $this->getEndTime($subscription, $start);;

            $user = $subscription->user;

            if($user->tariff_id !== $subscription->tariff_id) {
                throw new CantContinueSubscriptionException;
            }

            $subscription->status = SubscriptionStatuses::ACTIVE;
            $subscription->last_payment_at = now();
            $subscription->next_payment_at = $this->tariffsService->getEndTime($user->tariff, $start);
            $subscription->save();

            $user->tariff_expired_at = $end;
            $user->save();

        });

    }

    /**
     * Создание новой подписки и установка тарифа
     */
    public function create(User $user, Tariff $tariff, int $amount, string $code, string $card = '', Carbon $expiration_time = null) : Subscription
    {

        return DB::transaction(function () use ($user, $tariff, $code, $card, $expiration_time, $amount) {

            $start = now();
            $end = $expiration_time ?: $this->tariffsService->getEndTime($tariff, $start);

            $user->stage = $tariff->mode === TariffModes::FULL
                ? UserStages::BUY_THIRD_PART
                : UserStages::BUY_SECOND_PART;
            $user->tariff_id = $tariff->id;
            $user->tariff_expired_at = $end;
            $user->save();

            return Subscription::create([
                'status' => SubscriptionStatuses::ACTIVE,
                'card' => $card,
                'amount' => $amount,
                'next_payment_at' => $end,
                'last_payment_at' => $start,
                'user_id' => $user->id,
                'code' => $code,
                'period' => $tariff->period,
                'duration' => $tariff->duration,
                'tariff_id' => $tariff->id
            ]);

        });


    }

    /**
     * Отмена подписки и обнуление тарифа
     */
    public function cancel(Subscription $subscription, bool $reset_tariff = true)
    {

        DB::transaction(function () use ($subscription, $reset_tariff) {

            $user = $subscription->user;

            if($reset_tariff){

                $user->stage = $subscription->tariff->mode === TariffModes::FULL
                    ? UserStages::CANCEL_THIRD_PART
                    : UserStages::CANCEL_SECOND_PART;
                $user->tariff_expired_at = null;
                $user->tariff_id = null;
                $user->save();

            }

            $subscription->status = SubscriptionStatuses::CANCELLED;
            $subscription->save();

        });



    }

    /**
     * Остановка подписки и обнуление тарифа
     */
    public function stop(Subscription $subscription, bool $reset_tariff = true)
    {

        DB::transaction(function () use ($subscription, $reset_tariff) {

            $user = $subscription->user;

            if($reset_tariff){

                $user->stage = $subscription->tariff->mode === TariffModes::FULL
                    ? UserStages::CANCEL_THIRD_PART
                    : UserStages::CANCEL_SECOND_PART;
                $user->tariff_expired_at = null;
                $user->tariff_id = null;
                $user->save();

            }

            $subscription->status = SubscriptionStatuses::STOPPED;
            $subscription->save();

        });

    }


    /**
     * Methods
     */
    public function getEndTime(Subscription $subscription, Carbon $date) : Carbon
    {

        switch($subscription->period){

            case SubscriptionPeriods::DAY:
                return $date->clone()->addDays($subscription->duration);

            case SubscriptionPeriods::WEEK:
                return $date->clone()->addWeeks($subscription->duration);

            case SubscriptionPeriods::MONTH:
                return $date->clone()->addMonths($subscription->duration);

            case SubscriptionPeriods::YEAR:
                return $date->clone()->addYears($subscription->duration);

        }

        throw new \Exception('Undefined subscription period value');

    }

    public function getDurationSeconds(Subscription $subscription) : int
    {

        $now = now();

        return $now->diffInSeconds(
            $this->getEndTime($subscription, $now)
        );

    }

}
