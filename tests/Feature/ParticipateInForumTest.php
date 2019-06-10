<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    /** @test */
    public function unauthenticated_users_cannot_reply_to_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        // just checking if the exception is thrown, no need to create the user, thread, etc.

        $this->post(route('threads.reply.store', 1), []);
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_foriegn_threads()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $thread = factory(Thread::class)->create();

        $reply = factory(Reply::class)->make(['user_id' => $user->id]);

        $this->assertEquals($user->id, $reply->user_id);

        $this->post(route('threads.reply.store', $thread), $reply->toArray());

        $this->get("threads/{$thread->id}")
            ->assertSee($reply->body);
    }
}
