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
    protected $filters = ['by', 'popularity'];

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

    /**
     * Filter the query according to most popular threads.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function popularity()
    {
        return $this->builder->orderBy('replies_count', 'desc');
    }
}