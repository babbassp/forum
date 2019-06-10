<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    /**
     * @var \App\Models\Thread $thread
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
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply(factory(Reply::class)->make()->toArray());

        $this->assertCount(1, $this->thread->replies);

        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }
}
