<?php

namespace App\Utilits\TableGenerator;

use Illuminate\Pagination\LengthAwarePaginator;

class PerfectPaginatorResponse implements \JsonSerializable
{

    public $items;
    public $pages;
    public $count;
    public $currentPage;

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->items = collect($paginator->items());
        $this->pages =  $paginator->lastPage();
        $this->currentPage = $paginator->currentPage();
        $this->count = $paginator->count();
    }

    public function map(\Closure $closure) : self
    {

        $this->items = $this->items->map($closure);

        return $this;

    }


    public function jsonSerialize() : array
    {
        return [
            'items' => $this->items,
            'count' => $this->count,
            'pages' => $this->pages,
            'current_page' => $this->currentPage,
        ];
    }
}
