<?php

namespace App\Http\Controllers;

use App\Consts\SubscriptionStatuses;
use App\Models\Order;
use App\Models\Tariff;
use App\Models\User;
use App\Services\CloudPaymentsService;
use Illuminate\Http\Request;
use App\Services\MaxService;
use App\Services\MaxMailing\MaxBaseService;
use App\Services\OptionsService;
use App\Services\OrdersService;
use App\Services\StatisticService;
use App\Services\SubscriptionsService;
use App\Services\TelegramMailing\TelegramUpgradeService;
use App\Services\TextsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class MaxController extends Controller
{

    public function webhook(Request $request)
    {
        try {
            $data = $request->all();
            $headers = $request->headers->all();

            if($headers['x-max-bot-api-secret'][0] != config('max.secret_phrase')) {
                return response()->json();
            }

            $service = new MaxBaseService();
            $service->parseMaxWebhook($data);
            $user = $service->getOrCreateUser();
            
            // $service->test($user);
            $service->handle($user, $request->input('payload'));

        } catch(Throwable $e) {
            Log::alert('max webhook error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }

        return response()->json(['ok' => true]);
    }

    public function setWebhook()
    {
        $service = new MaxService(config('max.token'));
        $response = $service->setWebhook('https://petr-petr.ru/max/webhook', config('max.secret_phrase'));

        return response()->json($response);
    }

    public function index() {
        return view('max.index');
    }

    public function validateMaxWebAppData(Request $request): JsonResponse
    {
        $maxService = new MaxBaseService();

        return response()->json($maxService->validateMaxWebAppData($request->input('initData')));
    }
    public function setStep(Request $request): JsonResponse
    {
        $chat = $request->input('chat');
        $step = $request->input('step');

        $user = User::where('max_chat', $chat)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }

        $user->start_key = $step;
        $user->last_activity_at = now();
        $user->is_alive = true;
        $user->save();

        return response()->json(['success' => true, 'user' => $user]);
    }

    public function getProfile(Request $request) {
        $user = User::with(['tariff'])
            ->where('max_chat', $request->chat)
            ->first();

        if(!$user) {
            return 'Пользователь не найден';
        } 

        $textsService = new TextsService();

        $refs_count = $user->followers()->count();
        $refs_active_count = $user->followers()->isBuy()->count();

        $profile = $textsService->get('profile_active', [
            'name' => $user->name,
            'link' => 'https://max.ru/id745115760361_bot?start=referral-' . $user->max_chat,
            'refs_count' => $refs_count,
            'balance' => $user->balance,
            'refs_active_count' => $refs_active_count,
            'date' => $user->created_at->format('d.m.Y H:i'),
        ]);

        if(isset($user->tariff)) {
            $subscribe = $textsService->get('subscribe', [
                'tariff' => $user->tariff->name,
                'expired' => $user->tariff_expired_at->format('d.m.Y H:i')
            ]);
        }

        return response()->json([
            'profile' => $profile,
            'tariff' =>  $subscribe ?? '',
            'activeSubscription' => $user->activeSubscription,
            'balance' => $user->balance,
            'refLink' => 'https://max.ru/id745115760361_bot?start=referral-' . $user->max_chat
        ]);

    }

    public function renewTariff(Request $request) {
        $user = User::where('max_chat', $request->chat)->first();

        $optionsService = app(OptionsService::class);

        if($optionsService->get('following_enabled') && !$user->is_test_completed) {
            $tariffs = Tariff::where('is_active', true)
                ->where('mode', 'simple')
                ->get();
        } else if($optionsService->get('following_enabled') && $user->is_test_completed) {
            $tariffs = Tariff::where('is_active', true)
                ->get();
        } else if(!$user->meta_is_buy && !$optionsService->get('following_enabled')) {
            $service = new TextsService();

            return response()->json([
                'tariffs' => [],
                'showForm' => true,
                'message' => $service->get('pre_registration_announcement', [
                    'balance' => $user->balance ?? 0
                ])
            ]); 
        } else if($user->meta_is_buy && $user->is_test_completed) {
            $tariffs = Tariff::where('is_active', true)
                ->get();

        } else if ($user->meta_is_buy && !$user->is_test_completed){
            $tariffs = Tariff::where('is_active', true)
                ->where('mode', 'simple')
                ->get();
        }

        return response()->json([
            'tariffs' => $tariffs,
            'showForm' => false,
        ]); 
    }

    public function enableAutoPayment(Request $request) {
        $user = User::where('max_chat', $request->chat)->first();

        if(!$user) {
            return response()->json([
                'status' => false,
                'message' => '❌ Сейчас это невозможно'
            ]);
        }

        $cloudPaymentsService = app(CloudPaymentsService::class);
        $subscriptionsService = app(SubscriptionsService::class);

        $subscription = $user->subscriptions()
            ->orderBy('id', 'desc')
            ->first();

        $token = $user->cloudPaymentTokens()
            ->orderBy('id', 'desc')
            ->first();

        if (
            !$token || !$subscription ||
            $user->tariff_id !== $subscription->tariff_id ||
            $user->activeSubscription ||
            $user->tariff_expired_at <= now() ||
            $subscription->status !== SubscriptionStatuses::CANCELLED
        ) {
            return response()->json([
                'status' => false,
                'message' => '❌ Сейчас это невозможно'
            ]);
        }

        try {
            $cloudData = $cloudPaymentsService->createSubscription(
                $user,
                $token->hash,
                $subscription->amount,
                $subscription->duration,
                $cloudPaymentsService->subscriptionPeriodToCloudPeriod($subscription->period),
                $user->tariff_expired_at
            );

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => '❌ Не удалось включить автопродление'
            ]);
        }

        $subscriptionsService->renew($subscription, $cloudData['Model']['Id'], $user->tariff_expired_at);

        return response()->json([
            'status' => true,
            'message' => '✅ Автопродление: включено'
        ]);
    }

    public function disableAutoPayment(Request $request) {
        $user = User::where('max_chat', $request->chat)->first();

        if(!$user || $user && !$user->activeSubscription) {
            return response()->json([
                'status' => false,
                'message' => '❌ Сейчас это невозможно'
            ]);
        }

        $cloudPaymentsService = app(CloudPaymentsService::class);
        $subscriptionsService = app(SubscriptionsService::class);
        $statisticService = app(StatisticService::class);

        try {
            $cloudPaymentsService->cancelSubscription(
                $user->activeSubscription->code
            );
        } catch (\Throwable $e){
            return response()->json([
                'status' => false,
                'message' => '❌ Не удалось выключить автопродление, попробуйте ещё раз'
            ]);
        }

        DB::transaction(function () use ($user, $statisticService, $subscriptionsService){
            $statisticService->onCancelSubscription($user->activeSubscription);
            $subscriptionsService->cancel($user->activeSubscription, false);
        });

        return response()->json([
            'status' => true,
            'message' => '✅ Автопродление: выключено'
        ]);
    }

    public function completeTest(Request $request, TelegramUpgradeService $service)
    {
        $answers = $request->input('answers', []);

        $score = 0;
        $questionsCount = $service->getQuestionsCount();

        foreach ($answers as $index => $answerIndex) {
            if (!$service->hasQuestion($index)) continue;

            $question = $service->getQuestion($index);

            if ($question['result'] == $answerIndex) {
                $score++;
            }
        }

        $passed = $service->validateScore($score);

        $user = User::find($request->auth_id);

        $user->is_test_completed = $passed;
        $user->test_started_at = now();
        $user->save();

        if($passed) {
            $service = app(MaxBaseService::class);
            $service->sendInviteToThirdStep($user);
        }

        return response()->json([
            'passed' => $passed,
            'score' => $score,
            'total' => $questionsCount
        ]);
    }

    public function payTariff(Request $request) {
        $orderService = app(OrdersService::class);
        $tariff = Tariff::find($request->tariff_id);
        $user = User::where('id', $request->user_id)->first();

        $order = Order::create([
            'code' => $orderService->generateUniqueCode(),
            'amount' => $tariff->price,
            'tariff_id' => $tariff->id,
            'user_id' => $user->id
        ]);

        return route_public($user, 'public.pay', [$order->id]);
    }
}
