<?php

namespace App\Exceptions\Promocodes;

use App\Models\Promocode;

class PromocodeNotAvailableException extends \Exception
{

    public $promocode;

    public function __construct(Promocode $promocode)
    {

        parent::__construct("Promocode not available");

        $this->promocode = $promocode;

    }

}
