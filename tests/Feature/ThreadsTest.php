<?php

namespace Tests\Feature;

use App\Models\Thread;
use Tests\TestCase;

class ThreadsTest extends TestCase
{

    /** @test */
    public function index_route_for_threads_should_work()
    {
        $response = $this->get(route('threads.index'));

        $response->assertStatus(200);

        $response->assertViewIs('threads.index');
    }

    /** @test */
    public function show_route_for_threads_should_work()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get(route('threads.show', $thread->id));

        $response->assertStatus(200);

        $response->assertViewIs('threads.show');
    }

    /** @test */
    public function a_user_can_see_all_threads()
    {
        $threads = factory(Thread::class, 10)->create();

        $response = $this->get(route('threads.index'));

        foreach ($threads as $thread) {
            $response->assertSee($thread->title);
            $response->assertSee($thread->body);
        }
    }

    /** @test */
    public function a_user_can_see_a_specific_thread()
    {
        $thread = factory(Thread::class)->create();

        $response = $this->get(route('threads.show', $thread->id));

        $response->assertSee($thread->title);
        $response->assertSee($thread->body);
    }
}
