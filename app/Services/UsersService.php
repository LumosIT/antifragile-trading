<?php

namespace App\Services;

/**
 * Сервис для работы с пользователями
 */

use App\Exceptions\Users\NotEnoughBalanceException;
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


    //user - tg, another - max
    public function synchronizationWithMax(User $user, int $id): bool
    {
        if(filled($user->max_chat)) {
            return false;
        }

        if($user->type == 'max') {
            return false;
         }

        $anotherUser = User::query()
            ->where('max_chat', $id)
            ->first();

        if(!$anotherUser) {
            return false;
        }

        $user->update([
            'max_chat' => $anotherUser->max_chat,
            'max_user_id' => $anotherUser->max_user_id,
            'start_key' => 'profile',
            'meta_is_buy' => true,
            'meta_is_pre_form_filled' => true,
        ]);

        $anotherUser->delete();

        return true;
    }
}
