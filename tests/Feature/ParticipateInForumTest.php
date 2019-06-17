<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    /** @test */
    public function unauthenticated_users_cannot_reply_to_thread()
    {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post(route('threads.reply.store', ['channel' => 1, 'thread' => 1]), []);
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_foriegn_threads()
    {
        $this->actingAs($user = factory(User::class)->create());

        $channel = factory(Channel::class)->create();

        $thread = factory(Thread::class)->create(['channel_id' => $channel->id]);

        $reply = factory(Reply::class)->make(['user_id' => $user->id]);

        $this->assertEquals($user->id, $reply->user_id);

        $this->post(
            route('threads.reply.store', $thread->getUrlParams()),
            $reply->toArray()
        );

        $this->get(
            route('threads.show', $thread->getUrlParams())
        )->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_body_is_required()
    {
        $this->actingAs($user = factory(User::class)->create());

        $channel = factory(Channel::class)->create();

        $thread = factory(Thread::class)->create(['channel_id' => $channel->id]);

        $reply = factory(Reply::class)->make([
            'user_id' => $user->id,
            'body'    => null
        ]);

        $this->post(
            route('threads.reply.store', $thread->getUrlParams()),
            $reply->toArray()
        )->assertSessionHasErrors('body');
    }
}
