<?php

namespace App\Models;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ThreadSubscription
 *
 * @package App\Models
 * @property \App\Models\User   $user
 * @property \App\Models\Thread $thread
 */
class ThreadSubscription extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Gets the user who subscribed to the thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Gets the subscription's thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Sends a notification to the user, who is subscribed to the thread, that another user left a reply.
     *
     * @param \App\Models\Reply $reply
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function notify($reply)
    {
        $this->user->notify(new ThreadWasUpdated($this->thread, $reply));
    }
}
