<?php

namespace App\Http\Controllers;

use App\Consts\OrderStatuses;
use App\Consts\TariffModes;
use App\Jobs\Telegram\SendReferralReward;
use App\Jobs\Telegram\SendSecondStairInvite;
use App\Jobs\Telegram\SendThirdStairInvite;
use App\Models\CloudPaymentToken;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Tariff;
use App\Models\User;
use App\Services\CloudPaymentsService;
use App\Services\PromocodesService;
use App\Services\StatisticService;
use App\Services\SubscriptionsService;
use App\Services\TariffsService;
use App\Services\UsersService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class CloudPaymentsController extends Controller
{

    protected $bot;
    protected $cloudPaymentsService;
    protected $subscriptionsService;
    protected $statisticService;
    protected $usersService;
    protected $tariffsService;
    protected $promocodesService;

    public function __construct(
        CloudPaymentsService $cloudPaymentsService,
        SubscriptionsService $subscriptionsService,
        UsersService $usersService,
        StatisticService $statisticService,
        TariffsService $tariffsService,
        PromocodesService $promocodesService
    )
    {
        $this->cloudPaymentsService = $cloudPaymentsService;
        $this->subscriptionsService = $subscriptionsService;
        $this->statisticService = $statisticService;
        $this->usersService = $usersService;
        $this->tariffsService = $tariffsService;
        $this->promocodesService = $promocodesService;
    }

    /**
     * Создание платежа
     */
    protected function createPayment(User $user, Subscription $subscription, int $amount, string $transaction_id) : Payment
    {
        return Payment::create([
            'amount' => $amount,
            'subscription_id' => $subscription->id,
            'user_id' => $user->id,
            'hash' => $transaction_id
        ]);
    }


    /**
     * При переходе между тарифами, переводим остаток срока
     * в бонусное время
     */
    protected function getTariffSwitchBonus(
        Tariff $current_tariff,
        Tariff $next_tariff,
        Carbon $expiration_time
    ) : float
    {

        $current_tariff_duration = $this->tariffsService->getDurationSeconds($current_tariff);
        $current_tariff_rest = $expiration_time->getTimestamp() - now()->getTimestamp();
        $current_tariff_rest_percent = $current_tariff_rest / $current_tariff_duration;
        $current_tariff_rest_amount = $current_tariff_rest_percent * $current_tariff->price;

        $next_tariff_percent = $current_tariff_rest_amount / $next_tariff->price;
        $next_tariff_bonus = $this->tariffsService->getDurationSeconds($next_tariff) * $next_tariff_percent;

        return $next_tariff_bonus;

    }

    /**
     * Продление подписки
     */
    protected function onContinuedPayment(
        User $user,
        Subscription $subscription,
        string $transaction_id,
        int $amount
    ) : void{

        DB::transaction(function() use ($subscription, $amount, $transaction_id, $user){

            /**
             * Создаем платеж
             */
            $payment = $this->createPayment($user, $subscription, $amount, $transaction_id);

            /**
             * Продлеваем подписку
             */
            $this->subscriptionsService->continue($subscription);

            /**
             * Пишем общую статистику
             */
            $this->statisticService->onContinueSubscription($subscription, $payment);

        });

    }

    /**
     * Новый платеж
     */
    protected function onNewPayment(
        User $user,
        Order $order,
        Tariff $tariff,
        string $token,
        string $transaction_id,
        string $card
    ) : void {

        /**
         * Сумма подписки: по цене тарифа или по цене оплаты (с учетом скидок)
         */
        $subscription_amount = $tariff->price;

        /**
         * Дата следующего платежа по подписке
         */
        $next_payment_date = $this->tariffsService->getEndTime($tariff, now());

        /**
         * Применим промокод, если он есть
         */
        if($order->promocode_id){

            /**
             * Цена подписки фиксируется по цене скидки
             */
            if(!$order->promocode->only_first_payment){
                $subscription_amount = $order->amount;
            }

            /**
             * Промокод добавляет дополнительное время
             */
            if($order->promocode->bonus_duration){
                $next_payment_date->addSeconds(
                    $this->promocodesService->getBonusSeconds($order->promocode)
                );
            }

        }


        if($user->tariff_id) {

            /**
             * Перерасчет остатка
             */
            $next_payment_date->addSeconds(
                $this->getTariffSwitchBonus($user->tariff, $tariff, $user->tariff_expired_at)
            );

        }else{

            /**
             * Бонусные баллы дают 1 месяц
             */
            if($user->balance >= 4900 && $this->tariffsService->getDurationSeconds($tariff) >= 60 * 60 * 24 * 179){

                $this->usersService->spendBalance($user, 4900);

                $next_payment_date->addMonth();

            }


        }


        /**
         * Отменить прошлую подписку на CloudPayments
         */
        if($user->activeSubscription){
            try {
                $this->cloudPaymentsService->cancelSubscription($user->activeSubscription->code);
            }catch (\Throwable $e){}
        }

        /**
         * Создаем подписку на CloudPayments
         */
        $cloudData = $this->cloudPaymentsService->createSubscription(
            $user,
            $token,
            $subscription_amount,
            $tariff->duration,
            $this->cloudPaymentsService->tariffPeriodToCloudPeriod($tariff->period),
            $next_payment_date
        );


        DB::transaction(function() use ($token, $tariff, $order, $transaction_id, $user, $cloudData, $card, $next_payment_date, $subscription_amount){

            if(!$user->meta_is_buy){
                $user-> meta_is_buy = true;
                $user->first_payment_at = now();
            }

            if(
                !$user->tariff_id ||
                $user->tariff->mode !== $tariff->mode
            ){
                $user->spam_stage = 0;
                $user->last_spam_at = null;
            }

            $user->save();


            $order->status = OrderStatuses::SUCCESS;
            $order->save();

            /**
             * Пытаемся использовать промокод, если нет то и хуй с ним - не отказывать же в оплате
             */
            try {
                $this->promocodesService->use($order->promocode);
            }catch (\Throwable $e){}

            /**
             * Отменяем старую подписку в базе
             */
            if($user->activeSubscription){
                $this->subscriptionsService->stop($user->activeSubscription);
            }

            /**
             * Создаем подписку в базе
             */
            $subscription = $this->subscriptionsService->create(
                $user,
                $tariff,
                $subscription_amount,
                $cloudData['Model']['Id'],
                $card,
                $next_payment_date
            );

            /**
             * Создаем платеж в базе
             */
            $payment = $this->createPayment(
                $user,
                $subscription,
                $order->amount,
                $transaction_id
            );

            /**
             * Записываем общую статистику
             */
            $this->statisticService->onCreateSubscription($subscription, $payment);

            /**
             * Награда партнеру
             */
            if($user->parent_id){

                $this->usersService->depositBalance($user->parent, 2500);

                SendReferralReward::dispatch($user->parent)->onQueue('telegram');

            }

            /**
             * Выдаем пригласительные ссылки
             */
            if($tariff->mode === TariffModes::FULL) {
                SendThirdStairInvite::dispatch($user, $order)->onQueue('telegram');
            }

            SendSecondStairInvite::dispatch($user, $order)->onQueue('telegram');

            /**
             * Сохраняем токен
             */
            CloudPaymentToken::create([
                'user_id' => $user->id,
                'hash' => $token
            ]);

        });

    }

    protected function getOrderFromData(array $data) : ?Order
    {

        if(is_array($data)){

            $order = Arr::get($data, 'order_id');

            if($order){
                return Order::find($order);
            }

        }

        return null;

    }

    /**
     * Точка входа Route
     */
    public function webhook(Request $request) : array
    {

        //@TODO check token
        //Мне похуй, я русский

        $json = collect($request->all());

        $account_id      = (int)$json->get('AccountId');
        $transaction_id  = (string)$json->get('TransactionId');
        $subscription_id = (string)$json->get('SubscriptionId');
        $type   = (string)$json->get('OperationType');
        $status = (string)$json->get('Status');
        $token  = (string)$json->get('Token');
        $card   = (string)$json->get('CardLastFour');
        $amount = (int)$json->get('Amount');

        $data = (string)$json->get('Data');
        $data = json_decode($data, true);

        $user = User::find($account_id);

        if($type !== 'Payment'){
            throw new \Exception('Wrong type');
        }

        if ($status === 'Declined') {
            throw new \Exception('Nothing happened');
        }

        if(!$user){
            throw new \Exception('Wrong user');
        }

        if(Payment::query()->where('hash', $transaction_id)->exists()){
            return ['code' => 0];
        }

        if ($status === 'Completed') {

            if ($subscription_id) {

                $subscription = Subscription::where('code', $subscription_id)->first();

                if(!$subscription){
                    throw new \Exception('Wrong subscription id');
                }

                if(!$user->activeSubscription || $user->activeSubscription->id !== $subscription->id){
                    throw new \Exception('No active subscription');
                }

                $this->onContinuedPayment($user, $subscription, $transaction_id, $amount);

            } else {

                $order = $this->getOrderFromData($data);

                if(!$order || $order->user_id !== $user->id || $order->status !== OrderStatuses::ACTIVE){
                    throw new \Exception('Wrong order id');
                }

                if(!$order->tariff->is_active){
                    throw new \Exception('Tariff not available');
                }

                $this->onNewPayment($user,$order,$order->tariff, $token, $transaction_id, $card);

            }

        }

        return ['code' => 0];

    }
}
