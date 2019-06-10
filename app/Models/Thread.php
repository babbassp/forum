<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Thread
 *
 * @package App\Models
 *
 * @property int                                               $id
 * @property int                                               $user_id
 * @property string                                            $title
 * @property string                                            $body
 * @property \Illuminate\Database\Eloquent\Relations\HasMany   $replies
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo $creator
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
     *
     * @return mixed
     */
    public function getCreatorName()
    {
        return $this->creator->name;
    }

    public function addReply(array $reply)
    {
        $this->replies()->create($reply);
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
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
