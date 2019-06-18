<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    /** @test */
    public function a_user_can_see_all_threads()
    {
        $channel = factory(Channel::class)->create()->id;

        $threads = factory(Thread::class, 10)->create(['channel_id' => $channel]);

        $response = $this->get(route('threads.index'));

        foreach ($threads as $thread) {
            $response->assertSee($thread->title);
            $response->assertSee($thread->body);
        }
    }

    /** @test */
    public function a_user_can_see_a_specific_thread()
    {
        $channel = factory(Channel::class)->create()->id;

        $thread = factory(Thread::class)->create(['channel_id' => $channel]);

        $this->get(route('threads.show', $thread->getUrlParams()))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_user_can_see_a_reply_associated_with_a_thread()
    {
        $channel = factory(Channel::class)->create()->id;

        $thread = factory(Thread::class)->create(['channel_id' => $channel]);

        $reply = factory(Reply::class)->create([
            'thread_id' => $thread->id
        ]);

        $this->get(route('threads.show', $thread->getUrlParams()))
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_a_thread_according_to_tags()
    {
        $expectedThread = factory(Thread::class)->create([
            'channel_id' => factory(Channel::class)->create()->id
        ]);

        $anotherThread = factory(Thread::class)->create();

        $this->get(route('threads.index', $expectedThread->channel->slug))
            ->assertSee($expectedThread->title)
            ->assertDontSee($anotherThread->title);
    }
}
