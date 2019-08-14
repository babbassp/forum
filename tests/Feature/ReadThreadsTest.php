<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
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

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $mostPopular = factory(Thread::class)->create(['created_at' => Carbon::now()->subMinutes(2)]);
        factory(Reply::class, 3)->create(['thread_id' => $mostPopular->id]);

        $somewhatPopular = factory(Thread::class)->create(['created_at' => Carbon::now()->subMinutes(5)]);
        factory(Reply::class, 2)->create(['thread_id' => $somewhatPopular->id]);

        factory(Thread::class)->create(); // least popular with no replies

        $threads = $this->getJson(route('threads.index') . '?popularity=1')->decodeResponseJson();
        $this->assertEquals([3, 2, 0], array_column($threads, 'replies_count'));
    }

    /** @test */
    public function the_user_can_request_all_replies_for_a_given_thread()
    {
        $reply = factory(Reply::class)->create();

        $response = $this->getJson(route('threads.replies', $reply->thread->getUrlParams()))->json();

        $this->assertTrue(true);
    }
}
