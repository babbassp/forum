<?php

namespace Tests\Feature;

use App\Models\Thread;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    /** @test */
    public function a_user_can_subscribe_to_a_thread()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create();

        $this->post(route('threads.subscribe', $thread->getUrlParams()));

        $this->assertCount(1, $thread->subscriptions);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_a_thread()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create();

        $thread->subscribe();

        $this->delete(route('threads.subscribe', $thread->getUrlParams()));

        $this->assertCount(0, $thread->subscriptions);
    }

    /** @test */
    public function a_thread_knows_if_the_authenticated_user_has_subscribed_to_it()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create();

        $this->assertFalse($thread->isSubscribedTo);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);
    }
}
