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
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get a user's threads.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * Get a user's replies.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Gets the user's activity (created thread, replied to a thread, favorited a reply, etc.).
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
