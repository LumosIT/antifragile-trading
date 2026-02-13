<?php
namespace App\Services\TelegramMailing;

/**
 * Сервис содержит основные части Telegram-бота
 */

use App\Consts\TariffModes;
use App\Models\Link;
use App\Models\Order;
use App\Models\Tariff;
use App\Models\User;
use App\Services\OptionsService;
use App\Services\OrdersService;
use App\Services\PathService;
use App\Services\TariffsService;
use App\Services\TelegramService;
use App\Services\TextsService;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;

class TelegramBaseService
{

    public $menuButtonProfile = '⛄️ Профиль';
    public $menuButtonAbout = '📌 Презентация клуба';
    public $menuButtonBuy = '☁️ Войти в Клуб 257';
    public $menuButtonSignature = '💎 Управление подпиской';

    protected $telegramService;
    protected $textsService;
    protected $optionsService;
    protected $pathService;
    protected $tariffsService;
    protected $ordersService;

    public function __construct(
        TelegramService $telegramService,
        TextsService $textsService,
        OptionsService $optionsService,
        PathService $pathService,
        TariffsService $tariffsService,
        OrdersService $ordersService
    ){
        $this->telegramService = $telegramService;
        $this->textsService = $textsService;
        $this->optionsService = $optionsService;
        $this->pathService = $pathService;
        $this->tariffsService = $tariffsService;
        $this->ordersService = $ordersService;
    }

    public function sendMenu(User $user, string $text) : Message
    {
        if($user->tariff_id){

            $buttons = new ReplyKeyboardMarkup([
                [
                    $this->menuButtonProfile, $this->menuButtonSignature
                ]
            ], false, true);

        }else{

            $buttons = new ReplyKeyboardMarkup([
                [$this->menuButtonBuy],
                [$this->menuButtonProfile, $this->menuButtonAbout]
            ], false, true);

        }

        return $this->telegramService->send(
            $user,
            $text,
            $buttons
        );

    }

    public function sendAliveMessage(User $user) : Message
    {
        return $this->telegramService->send(
            $user,
            $this->textsService->get('alive_message')
        );
    }

    public function sendSubscribe(User $user) : Message
    {

        if($user->tariff_id){

            $buttons = [];

            if($user->activeSubscription){

                $buttons[] =  [
                    [
                        'text' => '✅ Автопродление: включено',
                        'callback_data' => 'subscribe_cancel'
                    ]
                ];

                $buttons[] = [
                    [
                        'text' => '✏️ Продлить вручную / Сменить тариф',
                        'callback_data' => 'buy'
                    ]
                ];

            }else{

                $buttons[] = [
                    [
                        'text' => '❌ Автопродление: выключено',
                        'callback_data' => 'subscribe_renewal'
                    ]
                ];

                $buttons[] = [
                    [
                        'text' => '✏️ Продлить вручную / Сменить тариф',
                        'callback_data' => 'buy'
                    ]
                ];
            }

            return $this->telegramService->send(
                $user,
                $this->textsService->get('subscribe', [
                    'tariff' => $user->tariff->name,
                    'expired' => $user->tariff_expired_at->format('d.m.Y H:i')
                ]),
                new InlineKeyboardMarkup($buttons)
            );

        }else{

            return $this->telegramService->send(
                $user,
                $this->textsService->get('no_subscribe')
            );

        }

    }

    public function sendProfile(User $user) : Message
    {

        $refs_count = $user->followers()->count();
        $refs_active_count = $user->followers()->isBuy()->count();

        if($user->tariff_id) {

            return $this->telegramService->send(
                $user,
                $this->textsService->get('profile_active', [
                    'name' => $user->name,
                    'link' => $this->telegramService->getInviteLink($user->chat),
                    'refs_count' => $refs_count,
                    'balance' => $user->balance,
                    'refs_active_count' => $refs_active_count,
                    'date' => $user->created_at->format('d.m.Y H:i'),
                ]),
                new InlineKeyboardMarkup([
                    [
                        [
                            'text' => '💎 Управление подпиской',
                            'callback_data' => 'subscribe'
                        ]
                    ],
                    [
                        [
                            'text' => '⚠️ Тех. поддержка',
                            'url' => $this->optionsService->get('support_link')
                        ]
                    ]
                ])
            );

        }else{

            $support = $this->optionsService->get('support_link');

            $buttons = [];

            if($user->meta_is_buy || $this->optionsService->get('following_enabled')){
                $buttons[] = [
                    [
                        'text' => '☁️ Войти в клуб 257',
                        'callback_data' => 'buy'
                    ]
                ];
            }

            if($support){
                $buttons[] = [
                    [
                        'text' => '⚠️ Тех. поддержка',
                        'url' => $support
                    ]
                ];
            }

            return $this->telegramService->send(
                $user,
                $this->textsService->get('profile_no_active', [
                    'balance' => $user->balance,
                    'name' => $user->name,
                    'link' => $this->telegramService->getInviteLink($user->chat),
                    'refs_count' => $refs_count,
                    'refs_active_count' => $refs_active_count,
                    'date' => $user->created_at->format('d.m.Y H:i')
                ]),
                new InlineKeyboardMarkup($buttons)
            );

        }

    }


    public function sendPresentation(User $user, int $slide = 0) : Message
    {

        $slides = [
            "AgACAgIAAxkBAAJR0GlmOyHx9xn-HAABRNnNA-Ocd8Jm8QACrg1rGyzDMEvN8nQu401regEAAwIAA3kAAzgE",
            "AgACAgIAAxkBAAJR0mlmOyEmaMdDWr2FdYE1YaF934wiAAKvDWsbLMMwS2t5FnYcarLTAQADAgADeQADOAQ",
            "AgACAgIAAxkBAAJR1GlmOyFcZByxFlCXabFt4F6VXXOMAAKwDWsbLMMwS8xLQ681ymxIAQADAgADeQADOAQ",
            "AgACAgIAAxkBAAJR1mlmOyECfhLU8cbptjpL41q42Qx9AAKxDWsbLMMwS26wETsR_2nPAQADAgADeQADOAQ",
            "AgACAgIAAxkBAAJR2GlmOyKT8iJxCzXj5WY3NODff4VYAAKyDWsbLMMwS7Kg7Eqhksh1AQADAgADeQADOAQ",
            "AgACAgIAAxkBAAJR2mlmOyLWkm5kf5MXBcRai7sqwN7fAAKzDWsbLMMwS9lJ_0NskLosAQADAgADeQADOAQ",
            "AgACAgIAAxkBAAJR3GlmOyIggWUMmcH2x-xs78fEkTZ_AAK0DWsbLMMwS722RWx3LHPkAQADAgADeQADOAQ",
            "AgACAgIAAxkBAAJR3WlmOyJmWIA6MuYHUTMHzFJ8YdYSAAK1DWsbLMMwS85qfMxGky4VAQADAgADeQADOAQ",
            "AgACAgIAAxkBAAJR32lmOyOM-E8bRHLe5D9Mq0idbIfeAAK2DWsbLMMwS2QJ01gjvlIJAQADAgADeQADOAQ",
//            "AgACAgIAAxkBAAJR4WlmOyM1yxUCbli1w8U8BXSMCxdGAAK3DWsbLMMwS7eKfGZFzs1zAQADAgADeQADOAQ"
        ];

        if(!array_key_exists($slide, $slides)){
            throw new \Exception('Bad slide index for presentation');
        }

        $buttons = [];

        if($slide > 0){
            $buttons[] = [
                'text' => '◀️',
                'callback_data' => 'presentation,' . ($slide - 1)
            ];
        }else{
            $buttons[] = [
                'text' => '🚫',
                'callback_data' => 'empty'
            ];
        }

        $buttons[] = [
            'text' => ($slide + 1) . '/' . count($slides),
            'callback_data' => 'empty'
        ];

        if($slide < count($slides) - 1){
            $buttons[] = [
                'text' => '▶️',
                'callback_data' => 'presentation,' . ($slide + 1)
            ];
        }else{
            $buttons[] = [
                'text' => '🚫',
                'callback_data' => 'empty'
            ];
        }

        return $this->telegramService->sendPhoto($user, $slides[$slide], '', new InlineKeyboardMarkup([$buttons]));

    }

    public function sendSubscribeCancelConfirmation(User $user) : Message
    {

        return $this->telegramService->send(
            $user,
            '⚠️ Вы действительно хотите отключить автопродление?',
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Да',
                        'callback_data' => 'subscribe_cancel,1'
                    ],
                    [
                        'text' => 'Нет',
                        'callback_data' => 'subscribe'
                    ]
                ]
            ])
        );

    }

    public function sendSubscribeRenewConfirmation(User $user) : Message
    {

        return $this->telegramService->send(
            $user,
            '⚠️ Вы действительно хотите включить автопродление?',
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Да',
                        'callback_data' => 'subscribe_renewal,1'
                    ],
                    [
                        'text' => 'Нет',
                        'callback_data' => 'subscribe'
                    ]
                ]
            ])
        );

    }

    public function sendTariffs(User $user, string $mode) : Message
    {

        $tariffs = Tariff::query()
            ->active()
            ->where('mode', $mode)
            ->get()
            ->sortBy(function (Tariff $tariff) {
                $this->tariffsService->getDurationSeconds($tariff);
            });

        $buttons = [];
        foreach($tariffs as $tariff){

            $icon = $tariff->mode === TariffModes::SIMPLE
                ? '⚪️' : '🟣';

            $buttons[] = [
                [
                    'text' => $icon . ' ' . $tariff->name . ' - ' . $tariff->price . ' RUB',
                    'callback_data' => 'order,' . $tariff->id
                ]
            ];
        }

        if($user->is_test_completed) {
            $buttons[] = [
                [
                    'text' => '🔙 Назад',
                    'callback_data' => 'buy'
                ]
            ];
        }

        return $this->telegramService->send(
            $user,
            $this->textsService->get('buy_menu'),
            new InlineKeyboardMarkup($buttons)
        );

    }

    public function sendTariffModes(User $user) : Message
    {

        if(!$user->is_test_completed){
            return $this->sendTariffs($user, TariffModes::SIMPLE);
        }

        $buttons = [];

        if(!$user->tariff_id){
            $buttons[] = [
                [
                    'text' => '⚪️ 2 ступень',
                    'callback_data' => 'buy,' . TariffModes::SIMPLE
                ]
            ];
        }

        $buttons[] = [
            [
                'text' => '🟣 3 ступень',
                'callback_data' => 'buy,' . TariffModes::FULL
            ]
        ];

        if(count($buttons)) {

            return $this->telegramService->send(
                $user,
                $this->textsService->get('buy_menu'),
                new InlineKeyboardMarkup($buttons)
            );

        }else{

            return $this->sendProfile($user);

        }

    }


    public function sendReferralReward(User $user) : Message
    {
        return $this->telegramService->send(
            $user,
            $this->textsService->get('referral_reward')
        );
    }

    public function sendSubscribeCancelation(User $user) : Message
    {
        return $this->telegramService->send(
            $user,
            $this->telegramService->get('subscribe_cancelation')
        );
    }

    public function sendPaymentReminder(User $user) : Message
    {
        return $this->telegramService->send(
            $user,
            $this->textsService->get('payment_reminder'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Отменить подписку',
                        'callback_data' => 'subscribe'
                    ]
                ]
            ])
        );
    }

    public function sendCancelReminder(User $user) : Message
    {
        return $this->telegramService->send(
            $user,
            $this->textsService->get('cancel_reminder'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Продлить подписку',
                        'callback_data' => 'buy'
                    ]
                ]
            ])
        );
    }

    public function sendOffer(User $user, Tariff $tariff) : Message
    {
        return $this->telegramService->send(
            $user,
            $this->textsService->get('offer', [
                'tariff' => $tariff->name,
                'price' => $tariff->price,
            ]),
            new InlineKeyboardMarkup([
                [
                    [
                        'callback_data' => 'order,' . $tariff->id . ',force',
                        'text' => 'Перейти к оплате'
                    ]
                ]
            ])
        );
    }

    public function sendInviteToSecondStair(User $user, ?Order $order = null) : Message
    {

        $channel = -$this->optionsService->get('channel_second_stair_id');
        $chat = -$this->optionsService->get('chat_second_stair_id');

        /**
         * Разбаним
         */
        try {
            $this->telegramService->bot->unbanChatMember($channel, $user->chat);
        }catch (\Throwable $e){}

        try{
            $this->telegramService->bot->unbanChatMember($chat, $user->chat);
        }catch (\Throwable $e){}

        $url = $this->telegramService->createChannelLink($channel);

        return $this->sendMenu(
            $user,
            $this->textsService->get('invite_to_second_stair', [
                'link' => $url,
                'expired' => $user->tariff_expired_at->format('d.m.Y H:i'),
                'order_id' => $order ? $order->code : $this->ordersService->generateUniqueCode()
            ])
        );

    }

    public function sendInviteToThirdStair(User $user, ?Order $order = null) : Message
    {

        $channel = -$this->optionsService->get('channel_third_stair_id');

        /**
         * Разбаним
         */
        try {
            $this->telegramService->bot->unbanChatMember($channel, $user->chat);
        }catch (\Throwable $e){
        }

        $url = $this->telegramService->createChannelLink($channel);

        return $this->sendMenu(
            $user,
            $this->textsService->get('invite_to_third_stair', [
                'link' => $url,
                'expired' => $user->tariff_expired_at->format('d.m.Y H:i'),
                'order_id' => $order ? $order->code : $this->ordersService->generateUniqueCode()
            ])
        );

    }

    public function sendPaymentForm(User $user, Order $order) : Message
    {

        return $this->telegramService->send(
            $user,
            $this->textsService->get('payment_form', [
                'tariff' => $order->tariff->name,
                'price' => $order->tariff->price,
                'order_id' => $order->code
            ]),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Перейти к оплате',
                        'url' => route_public($user, 'public.pay', [$order->id])
                    ]
                ],
                [
                    [
                        'text' => '🔙 Назад',
                        'callback_data' => 'buy,' . $order->tariff->mode
                    ]
                ]
            ])
        );

    }

    public function sendPaymentDenied(User $user) : Message
    {
        return $this->telegramService->send(
            $user,
            'Оплата временно недоступна, сожалеем. Попробуйте позднее',
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => '🔙 Назад',
                        'callback_data' => 'buy'
                    ]
                ]
            ])
        );
    }

    public function sendKickMessage(User $user) : Message
    {
        return $this->sendMenu(
            $user,
            $this->textsService->get('kick_message')
        );
    }

    public function sendRestartWarning(User $user) : Message
    {
        return $this->telegramService->send(
            $user,
            '⚠️ Вам необходимо перезапустить бота: /start',
            new ReplyKeyboardRemove(true)
        );
    }

    public function kickFromChannel(User $user, string $channel) : void
    {

        try {
            $this->telegramService->bot->banChatMember(-$channel, $user->chat);
        }catch (\Throwable $e) {
        }

    }

    public function kickFromSecondStairChannel(User $user) : void
    {
        $this->kickFromChannel(
            $user,
            $this->optionsService->get('channel_second_stair_id')
        );
    }

    public function kickFromSecondStairChat(User $user) : void
    {
        $this->kickFromChannel(
            $user,
            $this->optionsService->get('chat_second_stair_id')
        );
    }

    public function kickFromThirdStairChannel(User $user) : void
    {
        $this->kickFromChannel(
            $user,
            $this->optionsService->get('channel_third_stair_id')
        );
    }

    public function kickFromAllChannels(User $user) : void
    {
        $this->kickFromSecondStairChannel($user);
        $this->kickFromSecondStairChat($user);
        $this->kickFromThirdStairChannel($user);
    }

    public function sendToAdminGroup(string $text) : Message
    {
        return $this->telegramService->bot->sendMessage(
            -$this->optionsService->get('admin_group_id'),
            $text,
            'HTML'
        );
    }





}
