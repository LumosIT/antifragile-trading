<?php
/**
 * Скачивание аватарки юзера
 */

namespace App\Jobs\Telegram;

use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DownloadUserPicture implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(TelegramService $telegramService)
    {

        $user = $this->user;

        $avatar = $telegramService->getAvatar($user);
        $path = "users/{$user->chat}.jpg";

        if($avatar){

            Storage::disk('public')->put($path, $avatar);

            $user->picture = '/storage/' . $path;
            $user->save();

        }

    }
}
