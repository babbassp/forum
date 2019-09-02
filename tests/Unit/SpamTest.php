<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    /** @test */
    public function spam_class_checks_for_invalid_string_combinations()
    {
        $this->withoutExceptionHandling();

        $spam = new Spam;

        $this->assertFalse($spam->detect('A valid reply.'));

        $this->expectException(\Exception::class);

        $this->assertFalse($spam->detect('WordPress is the best!'));
    }

    /** @test */
    public function spam_class_checks_if_string_is_a_repeating_keyword()
    {
        $this->withoutExceptionHandling();

        $spam = new Spam;

        $this->expectException(\Exception::class);

        $spam->detect('It\'s ya boi: zzzzz');
    }
}
