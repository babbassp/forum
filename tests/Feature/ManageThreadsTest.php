<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class ManageThreadsTest extends TestCase
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

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(factory(User::class)->create(['name' => 'foo']));

        $threadByFoo = factory(Thread::class)->create(['user_id' => auth()->id()]);

        $threadNotByFoo = factory(Thread::class)->create();

        $this->get(route('threads.index') . '?by=foo')
            ->assertSee($threadByFoo->title)
            ->assertDontSee($threadNotByFoo->title);
    }

    /** @test */
    public function unauthorized_users_can_not_delete_threads()
    {
        // guests
        $thread = factory(Thread::class)->create([
            'user_id' => factory(User::class)->create()->id
        ]);

        $response = $this->json(
            'DELETE',
            route('threads.destroy', $thread->getUrlParams())
        );

        $response->assertStatus(401);

        // another user
        $this->signIn();

        $response = $this->json(
            'DELETE',
            route('threads.destroy', $thread->getUrlParams())
        );

        $response->assertStatus(403);

        $this->assertDatabaseHas('threads', ['id' => $thread->id]);
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create(['user_id' => auth()->id()]);

        $reply = factory(Reply::class)->create(['thread_id' => $thread->id]);

        $response = $this->json(
            'DELETE',
            route('threads.destroy', $thread->getUrlParams())
        );

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }
}
