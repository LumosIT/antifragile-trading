<?php
namespace App\Exceptions\Options;

class OptionNotFoundException extends \Exception
{

    public $id;

    public function __construct(string $id)
    {
        parent::__construct("Option {$id} not found");
        $this->id = $id;
    }

}
