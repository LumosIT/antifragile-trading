<?php

namespace App\Consts;

class Permissions
{

    const GOVERNMENT = 'government';
    const USERS = 'users';
    const STATISTIC = 'statistic';
    const TARIFFS = 'tariffs';
    const PROMOCODES = 'promocodes';
    const TEXTS = 'texts';
    const PAYMENTS = 'payments';
    const OPTIONS = 'options';
    const MAILING = 'mailing';


    static public function getAll() : array
    {

        $reflection = new \ReflectionClass(self::class);

        return $reflection->getConstants();

    }

    static public function getTitles() : array
    {

        return [
            self::GOVERNMENT => 'Управление сотрудниками',
            self::USERS => 'Пользователи',
            self::STATISTIC => 'Статистика',
            self::TARIFFS => 'Тарифы',
            self::PROMOCODES => 'Промокоды',
            self::TEXTS => 'Текста',
            self::PAYMENTS => 'Оплаты',
            self::OPTIONS => 'Настройки',
            self::MAILING => 'Рассылки'
        ];

    }

    static public function getTitle(string $code) : string
    {
        return self::getTitles()[$code];
    }

}
