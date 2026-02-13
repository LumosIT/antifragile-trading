<?php

namespace Database\Seeders;

use App\Consts\OptionTypes;
use App\Models\Option;
use App\Services\OptionsService;
use Illuminate\Database\Seeder;

class OptionsSeeder extends Seeder
{

    protected $optionsService;

    public function __construct(OptionsService $optionsService)
    {
        $this->optionsService = $optionsService;
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->optionsService->create('payments_enabled', OptionTypes::BOOLEAN, 'Включена ли платежная система. При выключении этой настройки обработка платежей и возможность совершать оплаты приостановится.', true);
        $this->optionsService->create('following_enabled', OptionTypes::BOOLEAN, 'Открыт ли набор в команду Петра', true);
        $this->optionsService->create('testing_enabled', OptionTypes::BOOLEAN, 'Приглашать людей на третью ступень', true);

        $this->optionsService->create('telegram_bot_token', OptionTypes::STRING, 'Токен телеграм-бота', env('TELEGRAM_BOT_TOKEN'));
        $this->optionsService->create('cloud_payments_public', OptionTypes::STRING, 'Публичный ключ CloudPayments', env('CLOUD_PAYMENTS_PUBLIC'));
        $this->optionsService->create('cloud_payments_private', OptionTypes::STRING, 'Секретный ключ CloudPayments', env('CLOUD_PAYMENTS_PRIVATE'));

        $this->optionsService->create('channel_second_stair_id', OptionTypes::NUMBER, 'ID канала: Вторая ступень', env('TELEGRAM_CHANNEL_SECOND_STAIR'));
        $this->optionsService->create('channel_third_stair_id', OptionTypes::NUMBER, 'ID канала: Третья ступень', env('TELEGRAM_CHANNEL_THIRD_STAIR'));
        $this->optionsService->create('chat_second_stair_id', OptionTypes::NUMBER, 'ID группы для комментариев второй ступени', env('TELEGRAM_CHAT_SECOND_STAIR'));
        $this->optionsService->create('admin_group_id', OptionTypes::NUMBER, 'ID группы: Администрация', env('TELEGRAM_GROUP_ADMIN'));
        $this->optionsService->create('files_group_id', OptionTypes::NUMBER, 'ID группы: Файлы', env('TELEGRAM_GROUP_FILES'));

        $this->optionsService->create('support_link', OptionTypes::STRING, 'Ссылка на саппорт', env('SUPPORT_LINK'));

    }
}
