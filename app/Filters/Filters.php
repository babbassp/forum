<?php

namespace App\Filters;

use Illuminate\Http\Request;

/**
 * @property \Illuminate\Database\Eloquent\Builder builder
 */
abstract class Filters
{
    /**
     * @var \Illuminate\Support\Facades\Request
     */
    private $request;

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * ThreadFilters constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                return $this->$filter($value);
            }
        }

        return $builder;
    }

    /**
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return array
     */
    private function getFilters(): array
    {
        return $this->request->only($this->filters);
    }

    /**
     * Filter the query by a given username.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @param string $username
     * @return \Illuminate\Database\Eloquent\Builder
     */
    abstract function by($username);
}