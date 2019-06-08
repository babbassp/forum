<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{

    /**
     * @var
     */
    protected $thread;

    /**
     *
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
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
        $this->get(route('threads.show', $this->thread->id))
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }

    /** @test */
    public function a_user_can_see_a_reply_associated_with_a_thread()
    {
        $reply = factory(Reply::class)->create([
            'thread_id' => $this->thread->id
        ]);

        $this->get(route('threads.show', $this->thread->id))
            ->assertSee($reply->body);
    }
}
