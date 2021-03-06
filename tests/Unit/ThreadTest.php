<?php

namespace Tests\Unit;

use App\Models\Favorite;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
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

    /** @test */
    public function a_reply_can_have_many_likes()
    {
        $reply = factory(Reply::class)->create();

        factory(Favorite::class)->create([
            'favorited_id'   => $reply->id,
            'favorited_type' => Reply::class
        ]);

        $this->assertInstanceOf(Collection::class, $reply->favorites);
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create();

        $thread->subscribe();

        $subscriptions = $thread->subscriptions()
            ->where('user_id', auth()->id())
            ->get();

        $this->assertCount(1, $subscriptions);
    }

    /** @test */
    public function a_thread_can_be_unscribed_from()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create();

        $thread->subscribe();

        $thread->unsubscribe();

        $subscriptions = $thread->subscriptions()
            ->where('user_id', auth()->id())
            ->get();

        $this->assertCount(0, $subscriptions);
    }

    /** @test */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {
        Notification::fake();

        Notification::assertNothingSent();

        $this->signIn();

        $this->thread->subscribe();

        $this->thread->addReply([
            'body'    => $this->faker->paragraph,
            'user_id' => $this->thread->user_id
        ]);

        Notification::assertSentTo(
            [auth()->user()],
            ThreadWasUpdated::class
        );
    }

    /** @test */
    public function a_thread_can_check_if_the_authenticated_user_has_read_its_replies()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create();

        tap(auth()->user(), function ($user) use ($thread) {
            $this->assertTrue($user->hasUpdatesFor($thread));

            $user->read($thread);

            $this->assertFalse($user->hasUpdatesFor($thread));
        });
    }
}
