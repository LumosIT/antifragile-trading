<?php

namespace App\Jobs\Schedule;

use App\Consts\PostTypes;
use App\Consts\TariffModes;
use App\Models\Post;
use App\Models\User;
use App\Services\OptionsService;
use App\Services\TelegramMailing\TelegramWelcomeService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ScheduleSpamPosts implements ShouldQueue
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

    public function isFollowingEnabled() : bool
    {
        return app(OptionsService::class)->get('following_enabled');
    }

    public function getUsersBuilder(Post $post) : Builder
    {

        switch($post->type){

            case PostTypes::FIRST_STAIR:
                return User::query()
                    ->where('meta_is_pre_form_filled', false)
                    ->where('meta_is_buy', false)
                    ->where('start_key', 'end');

            case PostTypes::SECOND_STAIR:
                return User::query()
                    ->whereRelation('tariff', 'mode', TariffModes::SIMPLE);

            case PostTypes::THIRD_STAIR:
                return User::query()
                    ->whereRelation('tariff', 'mode', TariffModes::FULL);

            default:
                throw new \Exception('Unknown post type');

        }

    }

    public function getPosts(Carbon $now): \Generator
    {

        $types = [
            PostTypes::SECOND_STAIR,
            PostTypes::THIRD_STAIR
        ];

        if(!$this->isFollowingEnabled()){
            $types[] = PostTypes::FIRST_STAIR;
        }

        foreach($types as $type) {

            $posts = Post::query()
                ->where('type', $type)
                ->orderBy('index', 'desc')
                ->lazy(10);

            $latestIndex = Post::query()
                ->where('type', $type)
                ->min('index');

            foreach ($posts as $post) {

                //Есть ли следующий элемент
                $isLatest = ($post->index === $latestIndex);

                $users = $this->getUsersBuilder($post)
                    ->alive()
                    ->where(function (Builder $query) use ($post, $isLatest, $now) {

                        $deadline = $now->clone()->subMinutes($post->delay);

                        $query->where('spam_stage', $post->index);

                        if ($isLatest) {
                            $query->where('created_at', '<', $deadline);
                        } else {
                            $query->where('last_spam_at', '<', $deadline);
                        }

                    })
                    ->lazyById(20);

                yield [$post, $users];

            }

        }

    }

    public function handle(TelegramWelcomeService $telegramWelcomeService)
    {

        $now = now();

        $posts = $this->getPosts($now);

        foreach($posts as [$post, $users]){

            $i = 0;
            foreach ($users as $user) {

                try{
                    $telegramWelcomeService->sendSpamBlock($user, $post);
                }catch (\Throwable $e){
                    Log::error($e);
                }

                $user->spam_stage = $post->index + 1;
                $user->last_spam_at = $now;
                $user->save();

                if(!(++$i % $this->getDelayInterval())) {
                    time_nanosleep($this->getDelayDuration(), 0);
                }

            }

        }


    }

}
