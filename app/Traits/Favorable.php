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
            $model->favorites->each->delete();
        });
    }

    /**
     * Get the favorites.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * @return mixed
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function favorite()
    {
        if (!$this->isFavorited()) {
            return $this->favorites()->create(['user_id' => auth()->id()]);
        }
    }

    /**
     * @return mixed
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function unfavorite()
    {
        if ($this->isFavorited()) {
            return $this->favorites()->where('user_id', auth()->id())->get()->each->delete();
        }
    }

    /**
     * Check if the user who is signed in has favorited the reply.
     *
     * @return bool
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->isNotEmpty();
    }

    /**
     * Returns true if favorited, otherwise return false.
     *
     * @return bool
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    /**
     * Get the number of favorites.
     *
     * @return int
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
