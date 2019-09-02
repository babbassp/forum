<?php

namespace App\Inspections;

/**
 * Interface SpamInterface
 *
 * @package App\Inspections
 */
interface SpamInterface
{
    /**
     * Check if text is valid. Throws an exception if invalid, otherwise, return false.
     *
     * @param string $text
     * @return void
     * @throws \Exception
     */
    public function detect($text);
}
