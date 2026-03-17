<?php

namespace App\Jobs\Telegram;

use App\Models\Offer;
use App\Models\Tariff;
use App\Models\User;
use App\Services\MaxMailing\MaxBaseService;
use App\Services\TelegramMailing\TelegramBaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendOffer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;
    protected Tariff $tariff;

    public function __construct(User $user, Tariff $tariff)
    {
        $this->user = $user;
        $this->tariff = $tariff;
    }

    public function handle(TelegramBaseService $telegramBaseService, MaxBaseService $maxBaseService)
    {
        try {
            $telegramOffer = $telegramBaseService->sendOffer($this->user, $this->tariff);
            $mid = $telegramOffer->getMessageId();
            $this->saveOffer($mid, 'telegram');
        } catch (\Throwable $exception) {}
        
        try {
            $maxOffer = $maxBaseService->sendOffer($this->user, $this->tariff);
            $mid = $maxOffer['response']['message']['body']['mid'];
            $this->saveOffer($mid, 'max');
        } catch (\Throwable $exception) {}
    }

    public function saveOffer(string $messageId, string $type) {
        Offer::create([
            'user_id' => $this->user->id,
            'tariff_id' => $this->tariff->id,
            'message_id' => $messageId,
            'type' => $type,
            'is_deleted' => false
        ]);
    }
}
