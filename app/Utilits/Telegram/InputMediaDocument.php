<?php
namespace App\Utilits\Telegram;

use TelegramBot\Api\Types\InputMedia\InputMedia;

class InputMediaDocument extends InputMedia
{
    public function __construct($media, $caption = null, $parseMode = null)
    {
        $this->type = 'document';
        $this->media = $media;
        $this->caption = $caption;
        $this->parseMode = $parseMode;
    }
}
