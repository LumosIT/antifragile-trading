<?php
namespace App\Exceptions\Texts;

class TextNotFoundException extends \Exception
{

    public $id;

    public function __construct(string $id)
    {
        parent::__construct('Text not found: ' . $id);
        $this->id = $id;
    }

}
