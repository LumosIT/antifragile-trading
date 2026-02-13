<?php
/**
 * Приглашение на 2 ступень
 */

namespace App\Jobs\Telegram;

use App\Models\User;
use App\Services\TelegramMailing\TelegramBaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendRestartWarning implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chat;

    public function __construct(User $user)
    {
        $this->chat = $user->chat;
    }


    public function handle(TelegramBaseService $telegramBaseService)
    {

        /**
         * //@TODO костыль для петра
         */
        $user = new User([
            'chat' => $this->chat
        ]);

        $telegramBaseService->sendRestartWarning($user);
    }
}
