<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 *
 * @package App\Models
 *
 * @property int    $id
 * @property string $type
 * @property int    $subject_id
 * @property string $subject_type
 * @property int    $user_id
 */
class Activity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'type',
        'subject_id',
        'subject_type',
        'user_id'
    ];

    /**
     * Get the owning subject model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Get the activity feed for a user.
     *
     * @author Brandon Abbasspour <babbassp@umflint.edu>
     * @param \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable $user
     * @param  int                                                        $take
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function feed(User $user, $take = 50)
    {
        return static::where('user_id', $user->id)
            ->with('subject')
            ->latest()->limit($take)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
