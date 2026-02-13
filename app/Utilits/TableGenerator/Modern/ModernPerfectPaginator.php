<?php

namespace App\Utilits\TableGenerator\Modern;

use App\Utilits\TableGenerator\PerfectPaginator;
use App\Utilits\TableGenerator\PerfectPaginatorResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ModernPerfectPaginator extends PerfectPaginator
{

    protected $allowedSearchColumns = [];
    protected $allowDateFilter = false;
    protected $searchPreparator = null;

    public function setSearchPreparator(callable $searchPreparator)
    {
        $this->searchPreparator = $searchPreparator;
    }

    public function setAllowedSearchColumns(array $columns) : self
    {
        $this->allowedSearchColumns = $columns;

        return $this;
    }

    public function enabledDateFilter() : self
    {
        $this->allowDateFilter = true;

        return $this;
    }

    public function build(Request $request, ?callable $cb = null) : PerfectPaginatorResponse
    {

        $data = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
        ]);

        $search = Arr::get($data, 'search', null);

        $from = Arr::get($data, 'from') ?: null;
        $to = Arr::get($data, 'to') ?: null;

        return parent::build($request, function ($query) use ($search, $cb, $from, $to) {

            if(mb_strlen($search) > 0){

                $search = addcslashes($search, '_');

                if($this->searchPreparator){
                    $search = call_user_func($this->searchPreparator, $search);
                }

                $query->where(function ($subQuery) use ($search) {

                    foreach($this->allowedSearchColumns as $key => $column){

                        if(is_array($column)){
                            foreach($column as $col){
                                $subQuery->orWhereRelation($key, $col, 'LIKE', "%{$search}%");
                            }
                        }else{
                            $subQuery->orWhere($column, 'LIKE', "%{$search}%");
                        }

                    }

                });

            }

            if($this->allowDateFilter){

                if($from){

                    $from = Carbon::parse($from)->format('Y-m-d');

                    $query->where('created_at', '>=', $from);

                }

                if($to){

                    $to = Carbon::parse($to)->format('Y-m-d');

                    $query->where('created_at', '<=', $to);

                }

            }

            return $cb ? call_user_func_array($cb, [$query]) : $query;

        });

    }


}
