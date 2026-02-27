<?php

namespace App\Jobs\Telegram;

use App\Models\User;
use App\Services\TelegramMailing\TelegramFirstStairService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendFirstStair implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $stage;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, int $stage)
    {
        $this->user = $user;
        $this->stage = $stage;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TelegramFirstStairService $telegramFirstStairService)
    {

        if($this->user->first_stair_stage < $this->stage) {
            $telegramFirstStairService->sendStage($this->user, $this->stage);
        }

    }
}
