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
}
