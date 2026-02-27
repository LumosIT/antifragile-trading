<?php

namespace App\Jobs\Telegram;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use TelegramBot\Api\BotApi;

class SendPost implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $text;
    protected $markup;
    protected $bot;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, string $text, $markup = null)
    {
        $this->user = $user;
        $this->text = $text;
        $this->markup = $markup;
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(BotApi $bot)
    {

        $this->bot = $bot;



    }
}
