<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    /** @test */
    public function guests_may_not_create_a_thread()
    {
        // cannot submit thread through a page
        $this->get(
            route('threads.create')
        )->assertRedirect(route('login'));

        // cannot submit a thread manually
        $this->post(
            route('threads.store'),
            factory(Thread::class)->raw()
        )->assertRedirect(route('login'));
    }

    /** @test */
    public function an_athenticated_user_can_create_a_thread()
    {
        $this->signIn($user = factory(User::class)->create());

        $thread = factory(Thread::class)->make(['user_id' => $user->id]);

        $response = $this->post(
            route('threads.store'),
            $thread->toArray()
        );

        $this->assertEquals($user->id, $thread->creator->id);

        $this->get($response->baseResponse->headers->get('location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_channel()
    {
        factory(Thread::class)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 1000])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread(array $overrides = [])
    {
        $this->signIn($user = factory(User::class)->create());

        $overrides['user_id'] = $user->id;

        $thread = factory(Thread::class)->make($overrides);

        return $this->post(route('threads.store'), $thread->toArray());
    }
}
