<?php
/**
 * Рассылка прогревающих постов раз в 2 дня
 */

namespace App\Jobs\Schedule;

use App\Consts\UserStages;
use App\Models\User;
use App\Models\Post;
use App\Services\TelegramMailing\TelegramWelcomeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SpamWarmup implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    /**
     * Сколько секунд делаем перерыв
     */
    protected function getDelayDuration() : int
    {
        return 1;
    }

    /**
     * Как часто делать перерыв (каждые N сообщений)
     */
    protected function getDelayInterval() : int
    {
        return 10;
    }


    public function handle(TelegramWelcomeService $telegramWelcomeService)
    {

        $now = now();

        $posts = Post::query()
            ->orderBy('index', 'desc')
            ->get();

        foreach($posts as $i => $post){

            $isLatest = ($i === count($posts) - 1);

            $users = User::query()
                ->alive()
                ->where('meta_is_pre_form_filled', false)
                ->where('meta_is_buy', false)
                ->where('start_key', 'end')
                ->where(function (Builder $query) use ($now, $i, $post, $isLatest){

                    $deadline = $now->clone()->subMinutes($post->delay);

                    $query->where('spam_stage', $post->index);

                    if($isLatest){
                        $query->where('created_at', '<', $deadline);
                    }else{
                        $query->where('last_spam_at', '<', $deadline);
                    }

                })
                ->lazyById(10);

            $i = 0;
            foreach ($users as $user) {

                try{
                    $telegramWelcomeService->sendSpamBlock($user, $post);
                }catch (\Throwable $e){}

                $user->spam_stage = $post->index + 1;
                $user->last_spam_at = $now;
                $user->save();

                if(!(++$i % $this->getDelayInterval())) {
                    time_nanosleep($this->getDelayDuration(), 0);
                }

            }

            var_dump('Spam Warmup Users: ' . $i);

        }


    }

}
