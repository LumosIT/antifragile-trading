<?php
/**
 * Отправка поста-прогрева
 */

namespace App\Jobs\Telegram;

use App\Models\User;
use App\Models\WarmingPost;
use App\Services\TelegramMailing\TelegramWelcomeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSpamBlock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $post;

    public function __construct(User $user, WarmingPost $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    public function handle(TelegramWelcomeService $telegramWelcomeService)
    {
        $telegramWelcomeService->sendSpamBlock($this->user, $this->post);
    }
}
