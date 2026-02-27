<?php

namespace App\Jobs\Telegram;

use App\Models\User;
use App\Services\TelegramMailing\TelegramBaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use TelegramBot\Api\BotApi;

class SendThirdStairInvite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TelegramBaseService $telegramBaseService)
    {
        $telegramBaseService->sendInviteToThirdStair($this->user);
    }
}
