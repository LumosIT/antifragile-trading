<?php

namespace App\Jobs\Schedule;

use App\Models\User;
use App\Services\OptionsService;
use App\Services\TelegramMailing\TelegramWelcomeService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SpamRemaining implements ShouldQueue
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

    public function handle(TelegramWelcomeService $telegramWelcomeService, OptionsService $optionsService)
    {

        if($optionsService->get('following_enabled')){
            return;
        }

        $from = now()->startOfHour()->subHours(6);
        $to = now()->startOfHour()->subHours(5);

        $users = User::query()
            ->alive()
            ->where('meta_is_pre_form_filled', false)
            ->where('meta_is_buy', false)
            ->where('start_key', '!=', 'end')
            ->whereNull('reminder_at')
            ->where('last_activity_at', '<', now()->subHours(6))
            ->lazyById(10);

        $i = 0;
        foreach($users as $user){

            try{

                $telegramWelcomeService->sendRemaining($user);

                $user->reminder_at = now();
                $user->save();

            }catch (\Throwable $e){}

            if(!(++$i % $this->getDelayInterval())) {
                time_nanosleep($this->getDelayDuration(), 0);
            }

        }

        var_dump('Spam Remaining Users: ' . $i);

    }

}
