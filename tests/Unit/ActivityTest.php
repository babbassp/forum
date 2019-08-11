<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create(['user_id' => auth()->id()]);

        $this->assertDatabaseHas('activities', [
            'type'         => 'created_thread',
            'user_id'      => auth()->id(),
            'subject_id'   => $thread->id,
            'subject_type' => Thread::class
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = factory(Reply::class)->create(['user_id' => auth()->id()]);

        $this->assertEquals(2, Activity::count());

        $this->assertDatabaseHas('activities', [
            'type'         => 'created_reply',
            'user_id'      => auth()->id(),
            'subject_id'   => $reply->id,
            'subject_type' => Reply::class
        ]);

        $activity = Activity::where('subject_id', $reply->id)->first();

        $this->assertEquals($activity->subject->id, $reply->id);
    }

    /** @test */
    public function it_fetches_the_activity_feed_for_any_user()
    {
        $now = Carbon::now();

        $this->signIn();
        $auth = auth()->user();

        $recentThread = factory(Thread::class)
            ->create(['user_id' => $auth->getAuthIdentifier()]);

        Carbon::setTestNow($now->copy()->subWeek());
        $olderThread = factory(Thread::class)
            ->create(['user_id' => $auth->getAuthIdentifier()]);
        Carbon::setTestNow($now);

        $feed = Activity::feed($auth);

        $this->assertCount(2, $feed);

        $this->assertArrayHasKey($now->format('Y-m-d'), $feed);
        $this->assertArrayHasKey($now->subWeek()->format('Y-m-d'), $feed);

        $this->assertEquals($feed->first()->first()->subject->title, $recentThread->title);
        $this->assertEquals($feed->last()->first()->subject->title, $olderThread->title);
    }
}
