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
    public function every_thread_belongs_to_a_channel()
    {
        $thread = factory(Thread::class)->create();

        $this->assertInstanceOf(\App\Models\Channel::class, $thread->channel);
    }

    /** @test */
    public function a_user_has_many_threads()
    {
        $user = factory(User::class)->create();

        factory(Thread::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Collection::class, $user->threads);
    }
}
