<?php
/**
 * Рассылка теста на 3 ступень
 */

namespace App\Jobs\Schedule;

use App\Consts\UserStages;
use App\Jobs\Telegram\SendThirdStairTesting;
use App\Models\User;
use App\Services\OptionsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ScheduleSuggestTesting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    protected function getMonthDelay() : int
    {
        return 6;
    }


    public function handle(OptionsService $optionsService)
    {

        if(!$optionsService->get('testing_enabled')){
            return;
        }

        $date = now()->subMonths(
            $this->getMonthDelay()
        );

        $users = User::query()
            ->whereNull('test_suggested_at')
            ->whereNotNull('first_payment_at')
            ->where('stage', UserStages::BUY_SECOND_PART)
            ->where('first_payment_at', '<', $date)
            ->lazyById(10);

        foreach($users as $user) {

            $user->test_suggested_at = now();
            $user->save();

            SendThirdStairTesting::dispatch($user)->onQueue('telegram');

        }


    }

}
