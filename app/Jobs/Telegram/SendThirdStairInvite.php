<?php
/**
 * Приглашение на 3 ступень
 */

namespace App\Jobs\Telegram;

use App\Models\Order;
use App\Models\User;
use App\Services\TelegramMailing\TelegramBaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendThirdStairInvite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $order;

    public function __construct(User $user, ?Order $order = null)
    {
        $this->user = $user;
        $this->order = $order;
    }



    public function handle(TelegramBaseService $telegramBaseService)
    {
        $telegramBaseService->sendInviteToThirdStair($this->user, $this->order);
    }
}
