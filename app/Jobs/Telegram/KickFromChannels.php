<?php
/**
 * Исключение юзера из каналов
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

class KickFromChannels implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(TelegramBaseService $telegramBaseService, MaxBaseService $maxBaseService)
    {
        if($this->user->type == 'telegram') {
            $telegramBaseService->kickFromAllChannels($this->user);
            $telegramBaseService->sendKickMessage($this->user);
        } else {
            $maxBaseService->kickUserFromChannel($this->user, '-70931186387659');
            $maxBaseService->kickUserFromChannel($this->user, '-71321808014027');
            $maxBaseService->sendKickMessage($this->user);
        }
    }
}
