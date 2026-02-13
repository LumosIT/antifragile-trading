<?php
namespace App\Exceptions\Texts;

class DumpFileWrongDataException extends \Exception
{

    public function __construct()
    {
        parent::__construct('Dump file wrong data');
    }

}
