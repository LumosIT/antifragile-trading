<?php

namespace App\Jobs\Telegram;

use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use TelegramBot\Api\Types\ReplyKeyboardRemove;

class SendClearMenu implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function handle(TelegramService $telegramService)
    {
        $telegramService->bot->sendMessage($this->user->chat, 'Меню очищено', 'HTML', true, false, new ReplyKeyboardRemove());
    }
}
