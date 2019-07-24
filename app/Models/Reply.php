<?php

namespace App\Models;

use App\Traits\Favorable;
use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Reply
 *
 * @package App\Models
 *
 * @property int                                                                              $user_id
 * @property int                                                                              $thread_id
 * @property string                                                                           $body
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo                                $thread
 * @property \Illuminate\Database\Eloquent\Relations\MorphMany|\Illuminate\Support\Collection $favorites
 * @property \Illuminate\Database\Eloquent\Relations\BelongsTo                                $owner
 */
class Reply extends Model
{
    use Favorable,
        RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'thread_id',
        'body'
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['owner', 'favorites'];

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
}
