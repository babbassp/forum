<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'favorited_id',
        'favorited_type'
    ];

    /**
     * Get all of the owning favoritable models.
     */
    public function favorited()
    {
        return $this->morphTo();
    }
}
