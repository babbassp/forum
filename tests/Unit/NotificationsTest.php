<?php

namespace Tests\Unit;

use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_recieves_a_new_reply()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create();
        $thread->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => factory(User::class)->create()->id,
            'body'    => $this->faker->paragraph
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_recieves_a_new_reply_that_is_not_by_the_current_user()
    {
        $this->signIn();

        $thread = factory(Thread::class)->create();
        $thread->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => $this->faker->paragraph
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_all_their_unread_notifications()
    {
        $this->signIn();

        $auth = auth()->user();

        $thread = factory(Thread::class)->create();
        $thread->subscribe();

        $thread->addReply([
            'user_id' => factory(User::class)->create()->id,
            'body'    => $this->faker->paragraph
        ]);

        $this->assertCount(1, $auth->unreadNotifications);

        $response = $this->getJson(
            route('notifications.index', ['user' => $auth->name])
        )->json();

        $this->assertCount(1, $response);

        $this->assertTrue($response[0]['id'] == $auth->unreadNotifications->first()->id);
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        $this->signIn();

        $auth = auth()->user();

        $thread = factory(Thread::class)->create();
        $thread->subscribe();

        $thread->addReply([
            'user_id' => factory(User::class)->create()->id,
            'body'    => $this->faker->paragraph
        ]);

        $this->assertCount(1, $auth->unreadNotifications);

        $this->delete(route('notifications.destroy', [
            'user'         => $auth->name,
            'notification' => $auth->unreadNotifications->first()->id
        ]));

        $this->assertCount(1, $auth->readNotifications);
    }
}
