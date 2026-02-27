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

class ScheduleSuggestTestingForSubscriptions implements ShouldQueue
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

        $day = now()->subMonths(
            $this->getMonthDelay()
        );

        $startOfDay = $day->clone()->startOfDay();
        $endOfDay = $day->clone()->endOfDay();

        $users = User::query()
            ->where('stage', UserStages::BUY_SECOND_PART)
            ->where('first_payment_at', '>=', $startOfDay)
            ->where('first_payment_at', '<=', $endOfDay)
            ->lazyById(10);

        foreach($users as $user) {
            SendThirdStairTesting::dispatch($user)->onQueue('telegram');
        }


    }

}
