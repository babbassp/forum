<?php

namespace App\Models;

use App\Notifications\ThreadWasUpdated;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Thread
 *
 * @package App\Models
 *
 * @property int                                               $id
 * @property int                                               $user_id
 * @property int                                               $replies_count
 * @property int                                               $channel_id
 * @property string                                            $title
 * @property string                                            $body
 * @property \Illuminate\Database\Eloquent\Relations\HasMany   $replies
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo $creator
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo $channel
 * @property \Illuminate\Database\Eloquent\Relations\HasMany   $subscriptions
 */
class Thread extends Model
{
    use RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'channel_id',
        'replies_count',
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
    protected $with = ['channel', 'creator'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
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
     * Get the thread's subscription status.
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()->where(['user_id' => auth()->id()])->exists();
    }


    /**
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \App\Filters\ThreadFilters            $filters
     * @return \Illuminate\Database\Eloquent\Builder
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public static function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Subscribes a user to a thread.
     *
     * @param \App\Models\User|int|null $user
     * @return void
     */
    public function subscribe($user = null)
    {
        $this->subscriptions()
            ->create([
                'user_id' => $this->objOrNull($user)
            ]);
    }

    /**
     * @param array $reply
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addReply($reply)
    {
        $newReply = $this->replies()->create($reply);

        $this->subscriptions()
            ->where('user_id', '!=', $newReply->user_id)
            ->get()
            ->each
            ->notify($newReply);

        return $newReply;
    }

    /**
     * Unsubscribes a user from a thread.
     *
     * @param \App\Models\User|int|null $user
     * @return void
     */
    public function unsubscribe($user = null)
    {
        $this->subscriptions()
            ->where('user_id', $this->objOrNull($user))
            ->delete();
    }

    /**
     * Helper to check the parameter type and converts it to an id.
     *
     * @param $user
     * @return int|string|null
     * @return int
     */
    public function objOrNull($user)
    {
        if (is_object($user)) {
            $user = $user->id;
        }elseif (is_null($user)) {
            $user = auth()->id();
        }

        return $user;
    }

    /**
     * The subscriptions the thread has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }
}
