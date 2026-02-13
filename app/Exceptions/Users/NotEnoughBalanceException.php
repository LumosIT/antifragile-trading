<?php
namespace App\Exceptions\Users;


use App\Models\User;

class NotEnoughBalanceException extends \Exception
{

    protected $user;
    protected $amount;

    public function __construct(User $user, int $amount)
    {
        parent::__construct('Not enough balance');

        $this->user = $user;
        $this->amount = $amount;
    }

}
