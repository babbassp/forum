<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Thread
 *
 * @package App\Models
 *
 * @property int                                                $id
 * @property int                                                $user_id
 * @property string                                             $title
 * @property string                                             $body
 * @property \Illuminate\Database\Eloquent\Relations\HasMany    $replies
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo  $creator
 * @property  \Illuminate\Database\Eloquent\Relations\BelongsTo $channel
 */
class Thread extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'channel_id',
        'title',
        'body'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'created_at',
        'updated_at'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['channel'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::addGlobalScope('creator', function ($builder) {
            $builder->with('creator');
        });
    }

    /**
     * Returns the name of the person who created the thread.
     *
     * @return string
     */
    public function getCreatorName()
    {
        return $this->creator->getName();
    }

    /**
     * Returns the parameters to access the thread.
     *
     * @return array
     */
    public function getUrlParams()
    {
        return [
            $this->channel->getSlug(),
            $this->id
        ];
    }

    /**
     * The replies associated with a thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * The user who created the thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The category the thread belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Filters\ThreadFilters            $filters
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
