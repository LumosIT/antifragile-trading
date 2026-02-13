<?php

namespace App\Consts;

class UserStages
{
    const NOT_START = 0;
    const BUY_SECOND_PART = 2;
    const BUY_THIRD_PART = 3;
    const CANCEL_SECOND_PART = 4;
    const CANCEL_THIRD_PART = 5;
    const COMPLETE_PRE_FORM = 6;
    const ADMIN = 100;


    static public function getAll() : array
    {

        $reflection = new \ReflectionClass(self::class);

        return $reflection->getConstants();

    }

    static public function getTitles() : array
    {

        return [
            self::NOT_START => 'Не купили',
            self::BUY_SECOND_PART => 'Купили 2 ступень',
            self::BUY_THIRD_PART => 'Купили 3 ступень',
            self::CANCEL_SECOND_PART => 'Отменили 2 ступень',
            self::CANCEL_THIRD_PART => 'Отменили 3 ступень',
            self::COMPLETE_PRE_FORM => 'Заполнили анкету предзаписи',
            self::ADMIN => 'Администратор'
        ];

    }

    static public function getTitle(string $code) : string
    {
        return self::getTitles()[$code];
    }

}
