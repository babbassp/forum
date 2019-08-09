<?php

namespace App\Traits;

use App\Models\Favorite;

trait Favorable
{
    /**
     * Boot the trait.
     */
    protected static function bootFavorable()
    {
        if (auth()->guest()) {
            return;
        }

        static::deleting(function ($model) {
            $model->favorites()->delete();
        });
    }

    /**
     * Get the favorites.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return mixed
     */
    public function favorite()
    {
        if (!$this->isFavorited()) {
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    /**
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return mixed
     */
    public function unfavorite()
    {
        if ($this->isFavorited()) {
            return $this->favorites()->where('user_id', auth()->id())->delete();
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
        return $this->favorites->where('user_id', auth()->id())->isNotEmpty();
    }

    /**
     * Returns true if favorited, otherwise return false.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return bool
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    /**
     * Get the number of favorites.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @return int
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}