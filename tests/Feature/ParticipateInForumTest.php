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
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->actingAs($user = factory(User::class)->create());

        $channel = factory(Channel::class)->create();

        $thread = factory(Thread::class)->create(['channel_id' => $channel->id]);

        $reply = factory(Reply::class)->make();

        $this->post(
            route('threads.reply.store', $thread->getUrlParams()),
            $reply->toArray()
        );

        $this->assertEquals(1, $thread->fresh()->replies_count);
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
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

    /** @test */
    public function unauthorized_users_cannot_delete_a_reply()
    {
        $reply = factory(Reply::class)->create();

        $this->get(route('threads.show', $reply->thread->getUrlParams()))
            ->assertDontSee('Delete');

        $this->delete(route('reply.destroy', $reply->id))
            ->assertRedirect(route('login'));

        $this->signIn()
            ->delete(route('reply.destroy', $reply->id))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_their_replies()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create(['user_id' => auth()->id()]);
        $reply = factory(Reply::class)->create(['thread_id' => $thread->id, 'user_id' => auth()->id()]);

        $this->delete(route('reply.destroy', $reply->id));

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $thread->fresh()->replies_count);
    }

    /** @test */
    public function authorized_users_can_update_their_reply()
    {
        $this->signIn();

        $reply = factory(Reply::class)->create(['user_id' => auth()->id()]);

        $message = 'New message!?';
        $this->patch(route('reply.update', $reply), ['body' => $message]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $message]);
    }

    /** @test */
    public function unauthorized_users_cannot_update_a_reply()
    {
        $reply = factory(Reply::class)->create();

        $message = 'New message!?';
        $this->patch(route('reply.update', $reply), ['body' => $message]);

        $this->assertNotEquals(Reply::find($reply->id)->value('body'), $message);
    }

    /** @test */
    public function replies_that_contain_spam_may_not_be_created()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $reply = factory(Reply::class)
            ->state('by_auth')
            ->create(['body' => 'WordPress is the best!']);
        $thread = $reply->thread;

        $this->expectException(\Exception::class);

        $this->post(
            route('threads.reply.store', $thread->getUrlParams()),
            $reply->toArray()
        );
    }
}
