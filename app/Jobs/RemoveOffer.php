<?php

namespace App\Jobs;

use App\Models\Offer;
use App\Models\Tariff;
use App\Models\User;
use App\Services\MaxService;
use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveOffer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $offer;

    public function __construct(Offer $offer)
    {
        $this->offer = $offer;
    }

    public function handle() {
        $user = User::find($this->offer->user_id);
        $tariff = Tariff::find($this->offer->tariff_id);
        $text = "Выданный вам офер $tariff->name был отозван.\n Если вы им воспользовались и купили подписку, не беспокойтесь, подписка остаётся активной ✅";

        if($this->offer->type == 'telegram') {
            $telegramService = app(TelegramService::class);
            $telegramService->deleteMessage($user, $this->offer->message_id);
            $telegramService->send($user, $text);
        }

        if($this->offer->type == 'max') {
            $maxService = app(MaxService::class);
            $maxService->deleteMessage($this->offer->message_id);
            $maxService->sendMessage($user->max_chat, $text);
        }
    }
}