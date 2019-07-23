<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;

//    /**
//     * Authorize the action before the intended policy method is actually called.
//     *
//     * @param $user
//     * @param $ability
//     * @return bool
//     */
//    public function before($user, $ability)
//    {
//        return true;
//    }

    /**
     * Determine whether the user can view any threads.
     *
     * @param  User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the thread.
     *
     * @param  User   $user
     * @param  Thread $thread
     * @return mixed
     */
    public function view(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can create threads.
     *
     * @param  User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the thread.
     *
     * @param  User   $user
     * @param  Thread $thread
     * @return mixed
     */
    public function update(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can delete the thread.
     *
     * @param  User   $user
     * @param  Thread $thread
     * @return mixed
     */
    public function delete(User $user, Thread $thread)
    {
        return $user->id == $thread->user_id;
    }

    /**
     * Determine whether the user can restore the thread.
     *
     * @param  User   $user
     * @param  Thread $thread
     * @return mixed
     */
    public function restore(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the thread.
     *
     * @param  User   $user
     * @param  Thread $thread
     * @return mixed
     */
    public function forceDelete(User $user, Thread $thread)
    {
        //
    }
}
