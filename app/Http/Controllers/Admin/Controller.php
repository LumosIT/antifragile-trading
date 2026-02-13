<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as Base;
use App\Utilits\Traits\Auth\AdminGuard;

class Controller extends Base
{
    use AdminGuard;
}
