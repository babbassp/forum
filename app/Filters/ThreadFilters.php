<?php

namespace App\Filters;

use App\Models\User;

/**
 * @property \Illuminate\Database\Eloquent\Builder builder
 */
class ThreadFilters extends Filters
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $filters = ['by'];

    /**
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @param string $username
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }
}