<?php

namespace App\Exceptions\Subscriptions;

class CantContinueSubscriptionException extends \Exception
{

    public function __construct()
    {
        parent::__construct("Cant continue subscription");
    }

}
