<?php
namespace App\Services;

/**
 * Сервис содержит базовое ядро для работы с функциями Telegram
 * Сервис напрямую не связан с функционалом бота, а лишь дает необходимые для работы API
 */

use App\Models\User;
use TelegramBot\Api\BotApi;
use TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia;
use TelegramBot\Api\Types\Message;

class TelegramService
{

    public $bot;

    public function __construct(OptionsService $optionsService)
    {
        $this->bot = new BotApi(
            $optionsService->get('telegram_bot_token')
        );
    }

    public function send(User $user, string $message, $markup = null, ?string $mid = null) : Message
    {
        if($mid) {
            return $this->bot->editMessageText($user->chat, $mid, $message, 'HTML', true, $markup);
        }else{
            return $this->bot->sendMessage($user->chat, $message, 'HTML', true, null, $markup);
        }
    }

    public function sendGallery(User $user, ArrayOfInputMedia $files, ?string $message = null) : array
    {

        if($message) {
            $files[0]->setCaption($message);
        }

        return $this->bot->sendMediaGroup($user->chat, $files);

    }

    public function sendPhoto(User $user, $photo, string $message, $markup = null) : Message
    {
        return $this->bot->sendPhoto($user->chat, $photo, $message, null, $markup, false, 'HTML');
    }

    public function sendFile(User $user, $file, string $message, $markup = null) : Message
    {
        return $this->bot->sendDocument($user->chat, $file, $message, null, $markup, false, 'HTML');
    }

    public function sendVideo(User $user, $video, string $message, $markup = null) : Message
    {
        return $this->bot->sendVideo($user->chat, $video, null, $message, null, $markup, false, true, 'HTML');
    }

    public function sendAudio(User $user, $audio, string $message, $markup = null) : Message
    {
        return $this->bot->sendAudio($user->chat, $audio, null, null, $message, $markup, false, true, 'HTML');
    }

    public function sendVoice(User $user, $voice, string $message, $markup = null) : Message
    {
        return $this->bot->sendVoice($user->chat, $voice, $message, null, null, $markup, false, false, 'HTML');
    }

    public function setWebhook(string $url) : void
    {

        $this->bot->setWebhook(
            $url,
            null,
            null,
            100,
            null,
            false,
            $this->getAccessToken()
        );

    }

    public function getAccessToken() : string
    {
        return sha1(
            $this->bot->getUrl()
        );
    }

    public function checkIsChannelMember(string $channel_id, User $user) : bool
    {

        try {

            $check = $this->bot->getChatMember(
                $channel_id,
                $user->chat
            );

            $check = $check->getStatus() === 'member' || $check->getStatus() === 'administrator' || $check->getStatus() === 'creator';

        }catch (\Throwable $e){

            $check = false;

        }

        return $check;

    }

    public function showAlert(string $callback_id, string $text, bool $quietly = false) : bool
    {
        return $this->bot->answerCallbackQuery($callback_id, $text, !$quietly);
    }

    public function removeReplyMarkup(User $user, string $mid)
    {
        return $this->bot->editMessageReplyMarkup($user->chat, $mid, null);
    }

    public function editReplyMarkup(User $user, string $mid, $buttons)
    {
        return $this->bot->editMessageReplyMarkup($user->chat, $mid, $buttons);
    }

    public function deleteMessage(User $user, string $mid) : bool
    {
        return $this->bot->deleteMessage($user->chat, $mid);
    }

    public function sendSticker(User $user, $sticker) : Message
    {
        return $this->bot->sendSticker($user->chat, $sticker);
    }

    public function getInviteLink(string $argument) : string
    {

        $username = $this->bot->getMe()->getUsername();

        return 'https://t.me/' . $username . '?start=' . $argument;

    }

    public function getFile(string $id) : string
    {
        return $this->bot->downloadFile($id);
    }

    public function getAvatar(User $user) : ?string
    {

        $photos = $this->bot->getUserProfilePhotos($user->chat);

        if($photos->getTotalCount()){

            $photos = $photos->getPhotos();
            $photos = $photos[0];

            usort($photos, function($a,$b){
                return $a->getWidth() <=> $b->getWidth();
            });

            foreach($photos as $photo){

                if($photo->getWidth() >= 200){
                    return $this->bot->downloadFile($photo->getFileId());
                }

            }

        }

        return null;

    }

    public function createChannelLink(int $channel_id) : string
    {

        $request = $this->bot->call('createChatInviteLink', [
            'chat_id' => $channel_id,
            'member_limit' => 1,
            'creates_join_request' => false
        ]);

        return $request['invite_link'];

    }

    public function getUsername() : string
    {
        return $this->bot->getMe()->getUsername();
    }

}
