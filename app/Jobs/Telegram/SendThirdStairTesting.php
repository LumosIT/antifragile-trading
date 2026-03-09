<?php
/**
 * Приглашение на тестирование
 */

namespace App\Jobs\Telegram;

use App\Models\User;
use App\Services\MaxMailing\MaxUpgradeService;
use App\Services\TelegramMailing\TelegramUpgradeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendThirdStairTesting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function handle(TelegramUpgradeService $telegramUpgradeService, MaxUpgradeService $maxUpgradeService)
    {
        try {
            $telegramUpgradeService->sendInvite($this->user);
        } catch (\Exception $e) {}

        try {
            $maxUpgradeService->sendMaxInvite($this->user);
        } catch (\Exception $e) {}
    }
}
