<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordsActivity;
    
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
