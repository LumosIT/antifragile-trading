<?php

namespace App\Utilits\TableGenerator;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PerfectPaginator
{

    protected $query;

    protected $disableLimits = false;
    protected $allowedSortColumns = ['id'];

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function disableLimits() : self
    {
        $this->disableLimits = true;

        return $this;
    }

    public function setAllowedSortColumns(array $fields) : self
    {
        $this->allowedSortColumns = $fields;

        return $this;
    }

    protected function buildQuery(Request $request) : self
    {



    }

    public function build(Request $request, ?callable $cb = null) : PerfectPaginatorResponse
    {

        $data = $request->validate([
            'page' => ['required', 'integer', 'min:1', 'max:999999'],
            'limit' => ['required', 'integer', 'min:1', 'max:' . ($this->disableLimits ? 10000000 : 100)],
            'sort_field' => ['required', 'string', Rule::in($this->allowedSortColumns)],
            'sort_mode' => ['required', 'string', 'in:asc,desc']
        ]);

        $query = $this->query
            ->orderBy($data['sort_field'], $data['sort_mode'])
            ->orderBy('id');

        if($cb){
            $query = call_user_func_array($cb, [$query]);
        }

        $response = $query->paginate($data['limit'], ['*'], 'page', $data['page']);

        return new PerfectPaginatorResponse($response);

    }

}
