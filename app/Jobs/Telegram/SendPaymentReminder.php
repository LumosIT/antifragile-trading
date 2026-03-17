<?php
/**
 * Напоминание о платеже
 */

namespace App\Jobs\Telegram;

use App\Models\User;
use App\Services\MaxMailing\MaxBaseService;
use App\Services\TelegramMailing\TelegramBaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPaymentReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $days;


    public function __construct(User $user, $days)
    {
        $this->user = $user;
        $this->days = $days;
    }


    public function handle(TelegramBaseService $telegramBaseService, MaxBaseService $maxBaseService)
    {
        if($this->days == 3) {
            try {
                $telegramBaseService->sendPaymentReminder($this->user);
            } catch (\Throwable $exception) {}

            try {
                $maxBaseService->sendPaymentReminder($this->user);
            } catch (\Throwable $exception) {
            }
        } 

        if($this->days == 1) {
            try {
                $telegramBaseService->sendPaymentReminderOneDay($this->user);
            } catch (\Throwable $exception) {}

            try {
                $maxBaseService->sendPaymentReminderOneDay($this->user);
            } catch (\Throwable $exception) {
            }
        }
    }
}
