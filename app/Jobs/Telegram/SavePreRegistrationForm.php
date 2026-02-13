<?php
/**
 * Отправка формы пре-регистрации в админ-группу
 */

namespace App\Jobs\Telegram;

use App\Models\Application;
use App\Models\User;
use App\Services\TelegramMailing\TelegramBaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SavePreRegistrationForm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }


    public function handle(TelegramBaseService $telegramBaseService)
    {

        $text = implode("\n", [
            '⚠️ <b>Новая заявка в форме пре-регистрации</b>',
            '',
            '👤 <b>Пользователь:</b> ' . $this->application->user->name,
            '🔗 <b>Телеграм:</b> ' . ($this->application->user->username ? '@' . $this->application->user->username : 'Нет'),
            '',
            '<b>ФИО:</b> ' . ($this->application->user->fio ?: ''),
            '<b>E-mail:</b> ' . ($this->application->user->email ?: ''),
            '<b>Телефон:</b> ' . ($this->application->user->phone ?: ''),
            '<b>Доход:</b> ' . $this->application->profit,
            '<b>Капитал:</b> ' . $this->application->capital,
            '<b>Настрой:</b> ' . $this->application->duration
        ]);

        $telegramBaseService->sendToAdminGroup($text);

    }
}
