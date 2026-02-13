<?php
namespace App\Exceptions\Posts;

class DumpFileWrongDataException extends \Exception
{

    public function __construct()
    {
        parent::__construct('Dump file wrong data');
    }

}
