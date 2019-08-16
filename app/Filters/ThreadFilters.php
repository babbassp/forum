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
    protected $filters = ['by', 'popularity', 'unanswered'];

    /**
     * @param string $username
     * @return \Illuminate\Database\Eloquent\Builder
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function popularity()
    {
        return $this->builder->orderBy('replies_count', 'desc');
    }

    /**
     * Filter threads that don't have replies.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}
