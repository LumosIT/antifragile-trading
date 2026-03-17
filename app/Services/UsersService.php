<?php

namespace App\Services;

/**
 * Сервис для работы с пользователями
 */

use App\Exceptions\Users\NotEnoughBalanceException;
use App\Models\Dialog;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UsersService
{

    protected $optionsService;

    public function __construct(OptionsService $optionsService)
    {
        $this->optionsService = $optionsService;
    }

    /**
     * Пополнить баланс
     */
    public function depositBalance(User $user, int $balance) : void
    {
        $user->increment('balance', $balance);
    }

    /**
     * Потратить баланс
     */
    public function spendBalance(User $user, int $balance) : void
    {

        $rows = User::query()
            ->where('id', $user->id)
            ->where('balance', '>=', $balance)
            ->decrement('balance', $balance);

        if(!$rows){
            throw new NotEnoughBalanceException($user, $balance);
        }

    }


    /**
     * Ключ для доступа к публичной части Routes
     */
    public function getPublicAccessHash(User $user) : string
    {
        return hash_hmac(
            'sha1',
            $user->id,
            $this->optionsService->get('telegram_bot_token')
        );
    }

    public function synchronizationWithMax(User $telegramUser, string $token)
    {
        if(filled($telegramUser->max_chat)) {
            return 'Вы уже синхронизированны между телеграм и макс';
        }

        $maxUser = User::where('synchronization_token', $token)->first();

        if(!$maxUser) {
            return 'Пользователь не найден';
        }

        $this->syncUsers($maxUser, $telegramUser);
    }

    public function syncUsers(User $maxUser, User $telegramUser) {

        if(!is_null($telegramUser->tariff_id)) {
            $telegramUser->max_chat = $maxUser->max_chat;
            $telegramUser->max_user_id = $maxUser->max_user_id;
            $telegramUser->name_2 = $maxUser->name;
            $telegramUser->username_2 = $maxUser->username;
            $telegramUser->start_key = 'profile';
            $telegramUser->meta_is_buy = true;
            $telegramUser->meta_is_pre_form_filled = true;

            $removedUser = $maxUser;
            $savedUser = $telegramUser;
        }

        if(!is_null($maxUser->tariff_id)) {
            $maxUser->chat = $telegramUser->chat;
            $maxUser->name_2 = $telegramUser->name;
            $maxUser->username_2 = $telegramUser->username;
            $maxUser->start_key = 'profile';
            $maxUser->meta_is_buy = true;
            $maxUser->meta_is_pre_form_filled = true;

            $removedUser = $telegramUser;
            $savedUser = $maxUser;
        }

        if(isset($removedUser) && isset($savedUser)) {
            Dialog::where('client_id', $removedUser->id)->update([
                'client_id' => $savedUser->id,
            ]);

            $removedUser->delete();
            $savedUser->save();

            $this->sendSuccessSyncMessage($savedUser);
        }
    }

    public function sendSuccessSyncMessage($user) {
        $maxService = app(MaxService::class);
        $textService = app(TextsService::class);
        $orderService = app(OrdersService::class);
        $optionService = app(OptionsService::class);
        $telegramService = app(TelegramService::class);

        $channel = -$this->optionsService->get('channel_second_stair_id');

        $maxService->sendMessage(
            $user->max_chat, 
            $textService->get('invite_to_second_stair', [
                'telegram_link' => $telegramService->createChannelLink($channel),
                'max_link' => $optionService->get('max_invite_link'), 
                'expired' => $user->tariff_expired_at->format('d.m.Y H:i'),
                'order_id' => $orderService->generateUniqueCode()
            ]
        ));

        $telegramService->send(
            $user, 
            $textService->get('invite_to_second_stair', [
                'telegram_link' => $telegramService->createChannelLink($channel),
                'max_link' => $optionService->get('max_invite_link'), 
                'expired' => $user->tariff_expired_at->format('d.m.Y H:i'),
                'order_id' => $orderService->generateUniqueCode()
            ]
        ));
    }
}
