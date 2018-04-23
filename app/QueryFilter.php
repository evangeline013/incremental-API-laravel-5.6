<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected $request, $builder;
    protected $filters = [];

    /**
     * QueryFilter constructor.
     * @param $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach($this->getFilters() as $filterName => $value) {
            if(method_exists($this, $filterName)) {
                if(trim($value)) {
                    $this->$filterName($value);
                } else{
                    $this->$filterName();
                }
            }
        };

        return $this->builder;
    }

    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}