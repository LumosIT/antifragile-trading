<?php

namespace App\Services;

/**
 * Сервис для работы с пользователями
 */

use App\Exceptions\Users\NotEnoughBalanceException;
use App\Models\User;

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


}
