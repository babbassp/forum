<?php

namespace App\Inspections;

use Illuminate\Support\Str;

class InvalidKeyWords implements SpamInterface
{
    /**
     * Invalid keywords that are considered spam.
     *
     * @var array
     */
    private $keyWords = [
        'wordpress is the best'
    ];

    /**
     * @inheritDoc
     */
    public function detect($text)
    {
        if (Str::contains($text, $this->keyWords)) {
            throw new \Exception('Invalid text found.');
        }
    }
}
