<?php

namespace App\Exceptions\Admins;

class DontHavePermissionsException extends \Exception
{

    public $permission;

    public function __construct(string $permission)
    {
        parent::__construct('Dont have permissions');

        $this->permission = $permission;
    }

}
