<?php
/**
 * Напоминание о платеже
 */

namespace App\Jobs\Telegram;

use App\Models\User;
use App\Services\MaxMailing\MaxBaseService;
use App\Services\TelegramMailing\TelegramBaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCancelReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }



    public function handle(TelegramBaseService $telegramBaseService, MaxBaseService $maxBaseService)
    {
        try {
            $telegramBaseService->sendCancelReminder($this->user);
        } catch (\Throwable $exception) {}

        try {
            $maxBaseService->sendCancelReminder($this->user);
        } catch (\Throwable $exception) {}
    }
}
