<?php

namespace App\Services;

/**
 * Сервис содержит работу с CloudPayments
 */

use App\Consts\SubscriptionPeriods;
use App\Consts\TariffPeriods;
use App\Models\User;
use App\Utilits\CloudPayments\CloudPayments;
use Carbon\Carbon;

class CloudPaymentsService
{

    protected $cloudPayments;

    public function __construct(OptionsService $optionsService)
    {

        $this->cloudPayments = new CloudPayments(
            $optionsService->get('cloud_payments_public'),
            $optionsService->get('cloud_payments_private')
        );

    }

    protected function dateToString(Carbon $date) : string
    {
        return $date->format('Y-m-d\TH:i:s');
    }

    public function getPublic() : string
    {
        return $this->cloudPayments->public;
    }

    /**
     * Tariff->period to CloudPayments period
     */
    public function tariffPeriodToCloudPeriod(string $period) : string
    {

        $periods = [
            TariffPeriods::DAY => 'Day',
            TariffPeriods::WEEK => 'Week',
            TariffPeriods::MONTH => 'Month',
            TariffPeriods::YEAR => 'Year'
        ];

        return $periods[$period];

    }

    /**
     * Subscription->period to CloudPayments period
     */
    public function subscriptionPeriodToCloudPeriod(string $period) : string
    {

        $periods = [
            SubscriptionPeriods::DAY => 'Day',
            SubscriptionPeriods::WEEK => 'Week',
            SubscriptionPeriods::MONTH => 'Month',
            SubscriptionPeriods::YEAR => 'Year'
        ];

        return $periods[$period];

    }

    /**
     * Создание новой подписки
     */
    public function createSubscription(User $user, string $token, int $price, int $duration, string $period, Carbon $startDate = null) : array
    {

        return $this->cloudPayments->request('subscriptions/create', [
            'Token' => $token,
            'AccountId' => $user->id,
            'Description' => 'Оплата подписки',
            'Email' => $user->email,
            'Amount' => $price,
            'Currency' => 'RUB',
            'RequireConfirmation' => false,
            'StartDate' => $this->dateToString($startDate ?: now()),
            'Interval' => $period,
            'Period' => $duration,
            'CustomerReceipt' => [
                'Items' => [
                    [
                        'label' => 'Оплата подписки на обучающие информационно-аналитические материалы',
                        'price' => $price,
                        'quantity' => 1,
                        'amount' => $price,
                        'vat' => 0,
                        'method' => 4,
                        'object' => 4
                    ]
                ],
                'taxationSystem' => 0,
                'email' => $user->email,
                'phone' => $user->phone,
                'isBso' => true,
                'amounts' => [
                    'electronic' => $price,
                    'advancePayment' => 0.00,
                    'credit' => 0.00,
                    'provision' => 0.00
                ]
            ]
        ]);

    }


    /**
     * Изменение существующей подписки
     */
    public function editSubscription(string $subscription_id, ?int $price = null, ?int $duration = null, ?string $period = null, Carbon $startDate = null) : array
    {

        $data = [
            'Id' => $subscription_id
        ];

        if($price){
            $data['Amount'] = $price;
        }

        if($duration){
            $data['Period'] = $duration;
        }

        if($period){
            $data['Interval'] = $period;
        }

        if($startDate){
            $data['StartDate'] = $this->dateToString($startDate);
        }

        return $this->cloudPayments->request('subscriptions/update', $data);

    }

    /**
     * Отмена подписки
     */
    public function cancelSubscription(string $subscription_id) : array
    {

        return $this->cloudPayments->request('subscriptions/cancel', [
            'Id' => $subscription_id
        ]);

    }

    /**
     * Подпись данных приватным ключом
     */
    public function signature(array $data) : string
    {

        ksort($data);

        return $this->cloudPayments->sign(
            json_encode($data)
        );

    }





}
