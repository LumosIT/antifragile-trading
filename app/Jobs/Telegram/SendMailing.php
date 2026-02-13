<?php
/**
 *  Рассылка
 */

namespace App\Jobs\Telegram;

use App\Consts\FileTypes;
use App\Consts\MailingStatuses;
use App\Exceptions\Mailing\MailingWasStopedException;
use App\Models\File;
use App\Models\Mailing;
use App\Models\User;
use App\Services\TelegramService;
use App\Services\TextsService;
use App\Utilits\Telegram\InputMediaDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia;
use TelegramBot\Api\Types\InputMedia\InputMediaPhoto;
use TelegramBot\Api\Types\InputMedia\InputMediaVideo;

class SendMailing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mailing;
    protected $textsService;
    protected $telegramService;

    public function __construct(Mailing $mailing)
    {
        $this->mailing = $mailing;
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



    protected function getQuery()
    {

        $query = User::query()
            ->alive()
            ->whereIn('stage', $this->mailing->stages)
            ->where(function($query) {

                $query->whereIn('tariff_id', $this->mailing->tariffs);

                if(in_array(0, $this->mailing->tariffs)){
                    $query->orWhereNull('tariff_id');
                }

                return $query;

            })
            ->orderByDesc('id');

        if($this->mailing->last_user_id){
            $query->where('id', '<', $this->mailing->last_user_id);
        }

        return $query;

    }

    protected function getButtons() : ?InlineKeyboardMarkup
    {

        $buttons = [];

        if(in_array('buy2', $this->mailing->buttons)){
            $buttons[] = [
                [
                    'text' => 'Войти в Клуб 257',
                    'callback_data' => 'buy'
                ]
            ];
        }

        if(in_array('test3', $this->mailing->buttons)){
            $buttons[] = [
                [
                    'text' => 'Пройти тестирование',
                    'callback_data' => 'testing'
                ]
            ];
        }

        return count($buttons) ? new InlineKeyboardMarkup($buttons) : null;

    }

    protected function sendMessage(User $user)
    {

        $text = $this->textsService->normalize($this->mailing->text);
        $buttons = $this->getButtons();

        $files_count = $this->mailing->files->count();

        if(!$files_count){
            return $this->telegramService->send($user, $text, $buttons);
        }elseif($files_count === 1){

            $file = $this->mailing->files->first();

            if($file->type === FileTypes::VIDEO) {
                return $this->telegramService->sendVideo($user, $file->hash, $text, $buttons);
            }elseif($file->type === FileTypes::PHOTO){
                return $this->telegramService->sendPhoto($user, $file->hash, $text, $buttons);
            }elseif($file->type === FileTypes::VOICE){
                return $this->telegramService->sendVoice($user, $file->hash, $text, $buttons);
            }else{
                return $this->telegramService->sendFile($user, $file->hash, $text, $buttons);
            }

        }else{

            $medias = new ArrayOfInputMedia();
            foreach($this->mailing->files as $file){

                if($file->type === FileTypes::VIDEO){
                    $media = new InputMediaVideo($file->hash);
                }elseif($file->type === FileTypes::PHOTO){
                    $media = new InputMediaPhoto($file->hash);
                }else{
                    $media = new InputMediaDocument($file->hash);
                }

                $medias->addItem($media);

            }

            if(mb_strlen($text) > 1024 || $buttons){

                $this->telegramService->sendGallery($user, $medias);

                return $this->telegramService->send($user, $text, $buttons);

            }else{
                return $this->telegramService->sendGallery($user, $medias, $text);
            }


        }


    }

    public function handle(TextsService $textsService, TelegramService $telegramService)
    {

        $this->textsService = $textsService;
        $this->telegramService = $telegramService;

        $users = $this->getQuery()->lazyByIdDesc(10);

        $this->mailing->users_count = $this->getQuery()->count();
        $this->mailing->status = MailingStatuses::IN_PROGRESS;
        $this->mailing->save();

        $c = 0;
        $i = $this->mailing->messages_count;
        $e = $this->mailing->errors_count;

        foreach($users as $user) {

            //Каждые 10 юзеров
            if(!(++$c % $this->getDelayInterval())){

                $this->mailing->messages_count = $i;
                $this->mailing->errors_count = $e;
                $this->mailing->last_user_id = $user->id;
                $this->mailing->save();

                $this->mailing->refresh();

                if($this->mailing->status !== MailingStatuses::IN_PROGRESS){
                    throw new MailingWasStopedException;
                }

                time_nanosleep($this->getDelayDuration(), 0);

            }

            try{

                $this->sendMessage($user);

                $i++;

            }catch (\Throwable $exception) {

                $e++;

            }


        }

        $this->mailing->status = MailingStatuses::FINISHED;
        $this->mailing->messages_count = $i;
        $this->mailing->errors_count = $e;
        $this->mailing->users_count = $i + $e;
        $this->mailing->save();

    }

}
