<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{

    protected $fillable = [
        'user_id',
        'thread_id',
        'body'
    ];

    /**
     * Favorite a reply.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function favorite()
    {
        if (!$this->favorites()->where('user_id', auth()->id())->exists()) {
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    /**
     * The user associated with the reply.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The thread associated with the reply.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Get the reply's favorites.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}
