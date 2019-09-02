<?php

namespace App\Inspections;

class KeyHeldDown implements SpamInterface
{
    /**
     * @inheritDoc
     */
    public function detect($text)
    {
        if (preg_match('/(.)\\1{4,}/', $text) != false) {
            throw new \Exception('Invalid text found.');
        }
    }
}
