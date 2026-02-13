<?php

namespace App\Services;

class OrdersService
{

    public function generateUniqueCode() : string
    {
        return time() . rand(10, 99);
    }

}
