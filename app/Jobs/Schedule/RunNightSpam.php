<?php
/**
 * Рассылка прогревающих постов раз в 2 дня
 */

namespace App\Jobs\Schedule;

use App\Consts\UserStages;
use App\Jobs\Telegram\SendSpamBlock;
use App\Models\User;
use App\Models\WarmingPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunNightSpam implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }


    public function handle()
    {

        $now = now();

        $posts = WarmingPost::query()
            ->orderBy('index', 'desc')
            ->get();

        foreach($posts as $i => $post){

            $isLatest = ($i === count($posts) - 1);

            $users = User::query()
                ->alive()
                ->where('meta_is_pre_form_filled', false)
                ->whereIn('stage', [UserStages::NOT_START, UserStages::NOT_READY])
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


            foreach ($users as $user) {

                SendSpamBlock::dispatch($user, $post)->onQueue('telegram');

                $user->spam_stage = $post->index + 1;
                $user->last_spam_at = $now;
                $user->save();

            }

        }


    }

}
