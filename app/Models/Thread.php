<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Thread
 *
 * @package App\Models
 *
 * @property int                                             $id
 * @property int                                             $user_id
 * @property string                                          $title
 * @property string                                          $body
 * @property \Illuminate\Database\Eloquent\Relations\HasMany $replies
 */
class Thread extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
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
     * The replies associated with a thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
