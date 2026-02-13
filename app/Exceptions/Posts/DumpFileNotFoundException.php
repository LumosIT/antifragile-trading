<?php
namespace App\Exceptions\Posts;

class DumpFileNotFoundException extends \Exception
{

    public $path;

    public function __construct(string $path)
    {
        parent::__construct('Dump file not found: ' . $path);
        $this->path = $path;
    }

}
