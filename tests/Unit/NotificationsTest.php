<?php

namespace Tests\Unit;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_recieves_a_new_reply_that_is_not_by_the_current_user()
    {
        $thread = factory(Thread::class)->create();
        $thread->subscribe();

        $this->assertCount(0, auth()->user()->notifications); // sanity check

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => $this->faker->paragraph
        ]);

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => factory(User::class)->create()->id,
            'body'    => $this->faker->paragraph
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_all_their_unread_notifications()
    {
        $notification = factory(DatabaseNotification::class)->create();

        $response = $this->getJson(
            route('notifications.index', ['user' => auth()->user()->name])
        )->json();

        $this->assertTrue($notification->id == $response[0]['id']);
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        factory(DatabaseNotification::class)->create();

        tap(auth()->user(), function ($user) {
            $this->assertCount(1, $user->unreadNotifications);

            $this->delete(route('notifications.destroy', [
                'user'         => $user->name,
                'notification' => $user->firstUnreadNotification()->id
            ]));

            $this->assertCount(1, $user->readNotifications);
        });
    }
}
