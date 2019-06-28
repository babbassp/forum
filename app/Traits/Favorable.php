<?php

namespace App\Traits;

use App\Models\Favorite;

trait Favorable
{
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

    /**
     * Favorite a reply.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function favorite()
    {
        if (!$this->isFavorited()) {
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    /**
     * Check if the user who is signed in has favorited the reply.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return bool
     */
    public function isFavorited()
    {
        return $this->favorites->where('user_id', '=', auth()->id())->isNotEmpty();
    }

    /**
     * Get the reply's number of favorites.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return int
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}