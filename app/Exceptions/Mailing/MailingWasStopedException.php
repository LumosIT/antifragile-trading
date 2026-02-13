<?php

namespace App\Exceptions\Mailing;

class MailingWasStopedException extends \Exception
{

    public function __construct()
    {
        parent::__construct("Mailing was stoped");
    }

}
