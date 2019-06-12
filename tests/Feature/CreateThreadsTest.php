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
        $this->withoutExceptionHandling();

        $this->expectException(\Illuminate\Auth\AuthenticationException::class);

        $thread = factory(Thread::class)->raw();

        $this->post(route('threads.store', $thread));
    }

    /** @test */
    public function an_athenticated_user_can_create_a_thread()
    {
        $this->signIn($user = factory(User::class)->create());

        $thread = factory(Thread::class)->make(['user_id' => $user->id]);

        $this->post(route('threads.store', $thread->toArray()));

        $this->assertEquals($user->id, $thread->creator->id);

        $this->assertDatabaseHas('threads', [
            'user_id' => $user->id,
            'title'   => $thread->title,
            'body'    => $thread->body
        ]);

        $this->get(route('threads.index'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
