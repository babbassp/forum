<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @package App\Models
 *
 * @property \Illuminate\Database\Eloquent\Relations\HasMany $threads
 * @property int                                             $id
 * @property string                                          $name
 * @property string                                          $email
 * @property string                                          $password
 *
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Get a user's name.
     *
     * @return string
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get a user's threads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * Get a user's replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Gets the user's activity (created thread, replied to a thread, favorited a reply, etc.).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * Gets the user's subscriptions for threads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * @param \App\Models\Thread $thread
     * @return string
     */
    public function visitsCacheKey($thread)
    {
        return sprintf('users.%s.visits.%s', $this->id, $thread->id);
    }

    /**
     * @param \App\Models\Thread $thread
     * @throws \Exception
     * @return void
     */
    public function read($thread)
    {
        cache()->forever( $this->visitsCacheKey($thread), now() );
    }

    /**
     *
     * @param \App\Models\Thread $thread
     * @return bool
     * @throws \Exception
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function hasUpdatesFor($thread)
    {
        $key = $this->visitsCacheKey($thread);

        return $thread->updated_at > cache($key);
    }
}
