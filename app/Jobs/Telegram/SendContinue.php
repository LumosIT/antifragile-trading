<?php
/**
 * Отправка сообщения об отмене подписки
 */

namespace App\Jobs\Telegram;

use App\Models\User;
use App\Services\TelegramMailing\TelegramWelcomeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendContinue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(TelegramWelcomeService $telegramWelcomeService)
    {
        $next = $telegramWelcomeService->getNextStartKey($this->user->start_key);

        $telegramWelcomeService->sendByStartKey($this->user, $next);
    }
}
