<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
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

        $this->get(route('threads.show', $thread->getUrlParams()))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_user_can_filter_a_thread_according_to_tags()
    {
        $expectedThread = factory(Thread::class)->create();

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
    public function a_user_can_filter_threads_that_are_unanswered()
    {
        $unanswered = factory(Thread::class, 10)->create();

        factory(Thread::class, 3)->state('with_reply')->create();

        $response = $this->getJson(route('threads.index') . '?unanswered=1')->decodeResponseJson();

        $this->assertCount(10, $response);

        $maped = array_map(function ($thread) {
            return $thread['id'];
        }, $response);

        $this->assertEmpty(
            array_diff($maped, $unanswered->pluck('id')->toArray())
        );
    }

    /** @test */
    public function the_user_can_request_all_replies_for_a_given_thread()
    {
        $reply = factory(Reply::class)->create();

        $response = $this->getJson(route('threads.replies', $reply->thread->getUrlParams()))->decodeResponseJson();

        $this->assertCount(1, $response['data']);
    }
}
