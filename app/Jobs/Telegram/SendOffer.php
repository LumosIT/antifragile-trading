<?php
/**
 * Приглашение на 2 ступень
 */

namespace App\Jobs\Telegram;

use App\Models\Tariff;
use App\Models\User;
use App\Services\TelegramMailing\TelegramBaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOffer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected Tariff $tariff;

    public function __construct(User $user, Tariff $tariff)
    {
        $this->user = $user;
        $this->tariff = $tariff;
    }


    public function handle(TelegramBaseService $telegramBaseService)
    {
        $telegramBaseService->sendOffer($this->user, $this->tariff);
    }
}
