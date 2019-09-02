<?php

namespace App\Inspections;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Spam
 *
 * @package App\Models
 */
class Spam extends Model
{
    /**
     * @var array
     */
    protected $inspections = [
        InvalidKeyWords::class,
        KeyHeldDown::class
    ];

    /**
     * @param string $text
     * @return bool
     * @throws \Exception
     */
    public function detect($text)
    {
        tap(Str::lower($text), function ($lowercase) {
            foreach ($this->inspections as $inspection) {
                app($inspection)->detect($lowercase);
            }
        });

        return false;
    }
}
