<?php

namespace App\Http\Controllers\Admin;

use App\Consts\SubscriptionPeriods;
use App\Consts\SubscriptionStatuses;
use App\Models\Subscription;
use App\Services\CloudPaymentsService;
use App\Services\SubscriptionsService;
use App\Utilits\Api\ApiError;
use App\Utilits\Prepare\AdminPrepare;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SubscriptionsController extends Controller
{

    protected $cloudPaymentsService;
    protected $subscriptionsService;

    public function __construct(SubscriptionsService $subscriptionsService, CloudPaymentsService $cloudPaymentsService)
    {
        $this->cloudPaymentsService = $cloudPaymentsService;
        $this->subscriptionsService = $subscriptionsService;
    }

    public function cancel(Request $request, Subscription $subscription) : void
    {

        if($subscription->status !== SubscriptionStatuses::ACTIVE){
            throw new ApiError('Эта подписка уже отменена');
        }

        try{
            $this->cloudPaymentsService->cancelSubscription($subscription->code);
        }catch (\Throwable $e){
            throw new ApiError('Невозможно отменить подписку');
        }

        $this->subscriptionsService->cancel($subscription, false);

    }

    public function edit(Request $request, Subscription $subscription) : array
    {

        $data = $request->validate([
            'next_payment_at' => ['required', 'date'],
            'amount' => ['required', 'integer', 'min:1'],
            'period' => ['required', 'string', Rule::in([SubscriptionPeriods::WEEK, SubscriptionPeriods::MONTH, SubscriptionPeriods::YEAR, SubscriptionPeriods::DAY])],
            'duration' => ['required', 'integer', 'min:1']
        ], [
            'duration.min' => 'Слишком малая длительность тарифа',
            'amount.min' => 'Сумма слишком мала'
        ]);

        $next_payment_at = $data['next_payment_at'];
        $next_payment_at = Carbon::parse($next_payment_at);

        $minimal_next_payment_at = now()->addMinute();

        if($next_payment_at < $minimal_next_payment_at){
            $next_payment_at = $minimal_next_payment_at;
        }

        try{

            $this->cloudPaymentsService->editSubscription(
                $subscription->code,
                $data['amount'],
                $data['duration'],
                $data['period'],
                $next_payment_at
            );

        }catch (\Throwable $e){
            Log::error($e);
            throw new ApiError('Невозможно изменить подписку');
        }

        $subscription->amount = $data['amount'];
        $subscription->period = $data['period'];
        $subscription->duration = $data['duration'];
        $subscription->next_payment_at = $next_payment_at;
        $subscription->save();

        return AdminPrepare::subscription($subscription);

    }

}
