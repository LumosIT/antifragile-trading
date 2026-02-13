<?php

namespace App\Services\TelegramMailing;

use App\Services\OptionsService;
use App\Services\PathService;
use App\Services\TelegramService;

class TelegramFilesService
{

    protected $optionsService;
    protected $pathService;
    protected $telegramService;

    public function __construct(OptionsService $optionsService, PathService  $pathService, TelegramService $telegramService)
    {
        $this->optionsService = $optionsService;
        $this->pathService = $pathService;
        $this->telegramService = $telegramService;
    }


    protected function getGroupId() : int
    {
        return -$this->optionsService->get('files_group_id');
    }

    public function savePhoto($file) : string
    {

        $message = $this->telegramService->bot->sendPhoto(
            $this->getGroupId(),
            $file
        );

        $photos = $message->getPhoto();

        return $photos[count($photos) - 1]->getFileId();

    }

    public function saveVideo($file) : string
    {

        $message = $this->telegramService->bot->sendVideo(
            $this->getGroupId(),
            $file
        );

        return $message->getVideo()->getFileId();

    }

    public function saveVoice($file) : string
    {

        $message = $this->telegramService->bot->sendVoice(
            $this->getGroupId(),
            $file
        );

        return $message->getVoice()->getFileId();

    }

    public function saveDocument($file) : string
    {

        $message = $this->telegramService->bot->sendDocument(
            $this->getGroupId(),
            $file
        );

        $something = $message->getDocument()
            ?: $message->getAudio()
            ?: $message->getVideo()
            ?: $message->getVoice();

        if(!$something){
            throw new \Exception('Cant upload this file');
        }

        return $something->getFileId();

    }

}
