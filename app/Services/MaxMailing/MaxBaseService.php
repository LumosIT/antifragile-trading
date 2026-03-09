<?php

namespace App\Services\MaxMailing;

use App\Consts\FileTypes;
use App\Models\Order;
use App\Models\Post;
use App\Models\Tariff;
use App\Models\User;
use App\Services\CloudPaymentsService;
use App\Services\MaxService;
use App\Services\OptionsService;
use App\Services\OrdersService;
use App\Services\PathService;
use App\Services\PostsService;
use App\Services\TariffsService;
use App\Services\TextsService;
use App\Services\StatisticService;
use App\Services\SubscriptionsService;
use App\Services\MaxMailing\MaxWelcomeService;
use App\Services\TelegramService;
use App\Services\UsersService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MaxBaseService
{
    public $menuButtonProfile = '⛄️ Профиль';
    public $menuButtonAbout = '📌 Презентация клуба';
    public $menuButtonBuy = '☁️ Войти в Клуб 257';
    public $menuButtonSignature = '💎 Управление подпиской';

    protected $maxService;
    protected $textsService;
    protected $optionsService;
    protected $pathService;
    protected $tariffsService;
    protected $ordersService;
    protected $statisticService;
    protected $postsService;
    protected $cloudPaymentsService;
    protected $subscriptionsService;
    protected $maxWelcomeService;

    public $message;
    public $firstName;
    public $lastName;
    public $max_chat;
    public $user_id; 

    public function __construct() {
        $this->maxService = new MaxService(config('max.token'));
        $this->textsService =  new TextsService();
        $this->optionsService = new OptionsService();
        $this->pathService = new PathService();
        $this->tariffsService = new TariffsService();
        $this->ordersService = new OrdersService();
        $this->statisticService = new StatisticService();
        $this->postsService = new PostsService($this->textsService);
        $this->cloudPaymentsService = new CloudPaymentsService($this->optionsService);
        $this->subscriptionsService = new SubscriptionsService($this->tariffsService);
        $this->maxWelcomeService = new MaxWelcomeService($this->maxService, $this->textsService, $this->postsService); 
    }

    function parseMaxWebhook(array $data): void
    {
        $this->message = $data['message']['body']['text'] ?? '/start';
        $this->firstName = $data['message']['sender']['first_name'] ?? $data['user']['first_name'];
        $this->lastName = $data['message']['sender']['last_name'] ?? $data['user']['last_name'] ?? "отсутсвует";
        $this->user_id = $data['message']['sender']['user_id'] ?? $data['user']['user_id'];
        $this->max_chat = $data['message']['recipient']['chat_id'] ?? $data['chat_id'];
    }

    public function handle(User $user, $payload = null)
    {
        if($user->is_banned) {
            return;
        }
        
        if(filled($payload)) {
            $this->registerReferral($user, $payload);
            $this->synchronization($user, $payload);
        }

        if(str_starts_with($this->message, 'Перейти к оплате') || str_starts_with($this->message, 'Купить')) {
            $name = str_replace('Перейти к оплате', '' , $this->message);
            $name = str_replace('Купить', '' , $name);

            $tariff = Tariff::where('name', trim($name))->first();
            
            if(
                $this->optionsService->get('payments_enabled') && $tariff && $tariff->is_active &&
                ($user->meta_is_buy || $this->optionsService->get('following_enabled') || $user->offer_ready)
            ) {
                $order = Order::create([
                    'code' => $this->ordersService->generateUniqueCode(),
                    'amount' => $tariff->price,
                    'tariff_id' => $tariff->id,
                    'user_id' => $user->id
                ]);

                $this->sendPaymentForm($user, $order);
            } else {
                $this->sendPaymentDenied($user->max_chat);
            }

            return true;
        } else if(str_starts_with($this->message, '/synchronization-')) {
            $this->synchronization($user, str_replace('/', '', $this->message));
        } else if($this->message == 'Оплатить вход на третью ступень') {
            $tariff = Tariff::find(1);
            
            if($user->is_test_completed) {
                $order = Order::create([
                    'code' => $this->ordersService->generateUniqueCode(),
                    'amount' => $tariff->price,
                    'tariff_id' => $tariff->id,
                    'user_id' => $user->id
                ]);

                $this->sendPaymentForm($user, $order);
            } else {
                $this->sendPaymentDenied($user->max_chat);
            }

            return true;
        } else if($this->message == '/synchronization') {
            $token = $user->createOrGetSynchronizationToken();

            $this->maxService->sendMessage(
                $user->max_chat,
                "Вставьте этот код в телеграм-бота https://t.me/club257bot\n\n" .
                "/synchronization-$token",
            );
        } else if($this->message == 'Отменить подписку') {
            $this->maxService->sendMessage(
                $user->max_chat,
                "Вы уверены, что хотите отменить подписку?",
                [
                    [
                        [
                            'type' => 'message',
                            'text' => 'Хочу отменить подписку',
                        ],
                    ],
                    [
                        [
                            'type' => 'message',
                            'text' => 'Не отменять подписку',
                        ]
                    ]
                ]
            );
        } else if($this->message == 'Хочу отменить подписку') {
            if(!$user->activeSubscription) {
                $this->maxService->sendMessage(
                    $user->max_chat,
                    "❌ Сейчас это сделать невозможно",
                );
                return true;
            }

            try {
                $this->cloudPaymentsService->cancelSubscription(
                    $user->activeSubscription->code
                );

            } catch (\Throwable $e) {
                $this->maxService->sendMessage(
                    $user->max_chat,
                    "❌ Не удается выключить автопродление",
                );
                return true;
            }

            DB::transaction(function () use ($user){
                $this->statisticService->onCancelSubscription($user->activeSubscription);
                $this->subscriptionsService->cancel($user->activeSubscription, false);
            });

            $user->refresh();

            $this->maxService->sendMessage(
                $user->max_chat,
                $this->textsService->get('no_subscribe')
            );
        } else if($this->message == 'Продлить подписку') {
            if($user->meta_is_buy || $this->optionsService->get('following_enabled')) {
                $this->maxWelcomeService->sendTariffs($user);
            } else {
                $this->maxWelcomeService->sendPreRegistrationAnnouncement($user);
            }
        } else {
            $this->sendStartMessage($user);
        }
    }

    protected function synchronization(User $maxUser, string $payload)
    {
        if(is_integer($maxUser->chat)) {
            $this->maxService->sendMessage($maxUser->max_chat, "Ваш аккаунт уже был снихронизирован ранее\n\n$maxUser->chat");
        }

        if(str_starts_with($payload, 'synchronization-')) {
            $token = str_replace('synchronization-', '', $payload);
            $telegramUser = User::where('synchronization_token', $token)->first();

            if($telegramUser && $telegramUser->id !== $maxUser->id) {
                $userService = app(UsersService::class);
                $userService->syncUsers($maxUser, $telegramUser);
            }
        }
    }

    public function sendOffer(User $user, Tariff $tariff)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('offer', [
                'tariff' => $tariff->name,
                'price' => $tariff->price,
            ]),
            [
                [
                    [
                        'type' => 'message',
                        'text' => 'Перейти к оплате ' . $tariff->name,
                    ]
                ]
            ]
        );
    }

    public function registerReferral(User $user, string $payload): void
    {
        if(str_starts_with($payload, 'referral-')) {
            $chat = str_replace('referral-', '', $payload);

            $parent = User::where('max_chat', $chat)->first();

            if($parent && $parent->id !== $user->id) {
                $user->parent_id = $parent->id;
                $user->save();
            }
        }
    }

    protected function sendStartMessage(User $user): void
    {
        $optionsService = app(OptionsService::class);

        if($optionsService->get('following_enabled')) {
            $message = $this->textsService->get('announcement');
            $message = str_replace('</p>', "\n", $message);
            $message = strip_tags($message, '<b><i><u><a>');
            $message = str_replace('{balance}', $user->balance, $message);

            $tariffs = Tariff::where('is_active', true)
                ->where('mode', 'simple')
                ->get();
            $keyboard = [];

            foreach ($tariffs as $tariff) {
                $keyboard[] = [
                    [
                        'type' => 'message',
                        'text' => "Купить {$tariff->name}",
                    ]
                ];
            }

        } else {
            $message = $this->textsService->get('start_message') . "\n" . 'Нажмите кнопку "Открыть" для продолжения';
            $message = str_replace('</p>', "\n", $message);
            $message = strip_tags($message, '<b><i><u><a>');
            $message = str_replace('&nbsp;', '', $message);
        }

        $this->maxService->sendImage($user->max_chat, 'https://petr-petr.ru/storage/content/main.jpg', $message, $keyboard ?? []);
    }

    public function getOrCreateUser($data = null): User
    {
        if(isset($data)) {
            $this->firstName = $data['first_name'];
            $this->lastName = $data['last_name'];
            $this->max_chat = $data['max_chat'];
            $this->user_id = $data['max_user_id'];
        }

        return DB::transaction(function () {
            $user = User::query()
                ->where('max_user_id', $this->user_id)
                ->first();

            if (!$user) {
                $user = User::create([
                    'max_user_id' => $this->user_id,
                    'chat' => md5(time()),
                    'max_chat' => $this->max_chat,
                    'name' => $this->firstName,
                    'username' => $this->lastName,
                    'picture' => null,
                    'type' => 'max',
                    'start_key' => 'end',
                ]);
                $this->statisticService->onRegister($user);
                $this->statisticService->onActivity($user);
            } else {
                if($user->last_activity_at->format('d.m.Y') !== now()->format('d.m.Y')) {
                    $this->statisticService->onActivity($user);
                }

                $user->max_chat = $this->max_chat;
                $user->last_activity_at = now();
                $user->is_alive = true;
                $user->died_at = null;
                $user->type = 'max';
                $user->save();
            }

            return $user;
        });

    }

    public function validateMaxWebAppData($initData): array
    {
        $hashCheck = $this->checkHash($initData);

        if (!$hashCheck['valid']) {
            return ['valid' => false];
        }

        $dataUser = $hashCheck['dataUser'];
        $chat = $hashCheck['chat'];

        $user = User::where('max_user_id', $dataUser['id'])->first();

        if($user && $user->is_banned) {
            return ['valid' => false];
        }

        if ($user) {
            $user->update([
                'last_activity_at' => now(),
                'is_alive' => true,
            ]);
        } else {
            $dataUser['max_user_id'] = $dataUser['id'];
            $dataUser['max_chat'] = $chat;
            $user = $this->getOrCreateUser($dataUser);
        }

        return [
            'valid' => true,
            'user' => $user,
            'link' => route_public($user, 'public.pre-registration'),
            'test_link' => route_public($user, 'public.testing'),
            'following_enabled' => $this->optionsService->get('following_enabled'),
        ];
    }

    protected function checkHash(string $initData): array
    {
        $decoded = urldecode($initData);
        parse_str($decoded, $data);

        if (!isset($data['hash'])) {
            return ['valid' => false];
        }

        $hash = $data['hash'];
        unset($data['hash']);

        ksort($data);

        $pairs = [];
        $dataUser = [];
        $chat = null;

        foreach ($data as $key => $value) {

            if ($key === 'auth_date') {
                $authDate = (int)$value;
                if (time() - $authDate > 86400) {
                    return ['valid' => false];
                }
            }

            if ($key === 'user') {
                $dataUser = json_decode($value, true);
            }

            if ($key === 'chat') {
                $chatDecoded = json_decode($value, true);
                $chat = $chatDecoded['id'] ?? null;
            }

            $pairs[] = $key . '=' . $value;
        }

        $dataCheckString = implode("\n", $pairs);

        $secretKey = hash_hmac(
            'sha256',
            config('max.token'),
            'WebAppData',
            true
        );

        $calculatedHash = hash_hmac(
            'sha256',
            $dataCheckString,
            $secretKey
        );

        if (!hash_equals($hash, $calculatedHash)) {
            return ['valid' => false];
        }

        return [
            'valid' => true,
            'dataUser' => $dataUser,
            'chat' => $chat,
        ];
    }

    public function sendPaymentForm(User $user, Order $order)
    {
        $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('payment_form', [
                'tariff' => $order->tariff->name,
                'price' => $order->tariff->price,
                'order_id' => $order->code
            ]),
            [
                [
                    [
                        'type' => 'link',
                        'text' => 'Перейти к оплате',
                        'url' => route_public($user, 'public.pay', [$order->id])
                    ]
                ],
            ]
        );
    }

    public function sendPaymentDenied(string $chat)
    {
        return $this->maxService->sendMessage(
            $chat,
            'Оплата временно недоступна, сожалеем. Попробуйте позднее',
        );
    }

    public function sendInviteToChannel(User $user, ?Order $order = null)
    {
        if(ctype_digit($user->chat)) {
            $telegramService = app(TelegramService::class);
            $channel = -$this->optionsService->get('channel_second_stair_id');
            $telegramLink = $telegramService->createChannelLink($channel);
            $extra = '';
        } else {
            $token = $user->createOrGetSynchronizationToken();
            $telegramLink = "https://t.me/club257bot?start=synchronization-$token";
            $extra = "\nИли вставьте эту команду в Telegram бота\n\n/synchronization-$token";
        }

        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('invite_to_second_stair', [
                'telegram_link' => $telegramLink,
                'max_link' => $this->optionsService->get('max_invite_link'), 
                'expired' => $user->tariff_expired_at->format('d.m.Y H:i'),
                'order_id' => $order ? $order->code : $this->ordersService->generateUniqueCode()
            ]) . $extra
        );
    }

    public function sendBillToThirdStep(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('third_stair_test_result_success'),
            [
                [
                    [
                        'type' => 'message',
                        'text' => 'Оплатить вход на третью ступень',
                    ]
                ]
            ]
        );
    }

    public function sendInviteToThirdStep(User $user, ?Order $order = null)
    {
        $url = 'https://max.ru/join/sFwWugTWaBpq9Xe3yUzf0ZfoJftBuJpeq6BGZBzQkxA';

        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('invite_to_third_stair', [
                'link' => $url,
                'expired' => $user->tariff_expired_at->format('d.m.Y H:i'),
                'order_id' => $order ? $order->code : $this->ordersService->generateUniqueCode()
            ])
        );
    }

    public function kickUserFromChannel(User $user, string $chatId) {
        $this->maxService->kickUserFromChannel($user, $chatId);
    }

    public function sendKickMessage(User $user)
    {
        $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('kick_message')
        );
    }

    public function sendSubscribeCancelation(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('subscribe_cancelation')
        );
    }

    public function sendPaymentReminder(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('payment_reminder'),
            [
                [
                    [
                        'type' => 'message',
                        'text' => 'Отменить подписку'
                    ]
                ]
            ]
        );
    }

    public function sendCancelReminder(User $user)
    {
        return $this->maxService->sendMessage(
            $user->max_chat,
            $this->textsService->get('cancel_reminder'),
            [
                [
                    [
                        'type' => 'message',
                        'text' => 'Продлить подписку',
                    ]
                ]
            ]
        );
    }

    public function test($user) {
        // $uploadUrlData = $this->maxService->getUploadUrl('file');
        // Log::info($uploadUrlData);
        // $uploadResult = $this->maxService->uploadFileToUrl($uploadUrlData['url'], storage_path('app/public/content/rich.pdf'));
        // Log::info($uploadResult);
        // $token = $uploadResult['response']['token'] ?? null;

        // Log::info($token);
        // if ($token) {
        // $this->maxService->sendMessage($user->max_chat, 'Тест <b>отправки</b> видео');
            $resp = $this->maxService->sendFile($user->max_chat, 'f9LHodD0cOIuGw1ICxBcRw8gFzX1ySHiCsbNIjJiA1t7_SZg-aI7glRLIP9K7KBBniWPhSLiHypyV2KaANoL', 'Тестовый файл', 'video');

            Log::info($resp);
        // }
    }

    public function sendSpamBlock(User $user, Post $post)
    {
        $text = $this->postsService->normalize($post->value);

        if($post->file_id) {
            switch($post->file->type) {
                case FileTypes::DOCUMENT:
                    return $this->maxService->sendFile($user->max_chat, $post->file->max_hash, $text, 'file');
                case FileTypes::VIDEO:
                    return $this->maxService->sendFile($user->max_chat, $post->file->max_hash, $text, 'video');
                case FileTypes::PHOTO:
                    return $this->maxService->sendImage($user->max_chat, $post->file->max_hash, $text);
                default:
                    return $this->maxService->sendMessage($user->max_chat, $text);
            }

        } else {
            return $this->maxService->sendMessage($user->max_chat, $text);
        }
    }
}