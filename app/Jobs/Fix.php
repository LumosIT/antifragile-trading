<?php

namespace App\Jobs;

use App\Models\Offer;
use App\Models\Tariff;
use App\Models\User;
use App\Services\MaxService;
use App\Services\OptionsService;
use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Fix implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $channel;
    protected $chat;

    public function __construct($channel, $chat){
        $this->channel = $channel;
        $this->chat = $chat;
    }

    public function handle() {
        $telegramService = app(TelegramService::class);
        $telegramService->bot->unbanChatMember($this->channel, $this->chat);
    }
}