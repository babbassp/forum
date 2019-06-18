<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Support\Collection;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    /** @test */
    public function a_channel_has_threads()
    {
        $channel = factory(Channel::class)->create();
        $thread = factory(Thread::class)->create(['channel_id' => $channel->id]);

        $this->assertInstanceOf(Collection::class, $channel->threads);

        $this->assertTrue($channel->threads->contains($thread));
    }
}


