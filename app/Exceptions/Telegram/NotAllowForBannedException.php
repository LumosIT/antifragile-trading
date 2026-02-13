<?php
namespace App\Exceptions\Telegram;

class NotAllowForBannedException extends \Exception
{
    public function __construct()
    {
        parent::__construct("Not allowed for banned users");
    }

}
