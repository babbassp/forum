<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Channel
 *
 * @package App\Models
 *
 * @property string                                          $slug
 * @property string                                          $name
 * @property \Illuminate\Database\Eloquent\Relations\HasMany $threads
 */
class Channel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * The threads associated with the channel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get a channel's slug.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
