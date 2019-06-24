<?php

namespace Tests\Feature;

use App\Models\Reply;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    /** @test */
    public function guests_cannot_favorite_anything()
    {
        $this->post(route('replies.favorites', 1))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = factory(Reply::class)->create();

        $this->post(route('replies.favorites', $reply->id));

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_only_favorite_a_thread_once()
    {
        $this->signIn();

        $reply = factory(Reply::class)->create();

        $this->post(route('replies.favorites', $reply->id));

        $this->post(route('replies.favorites', $reply->id));

        $this->assertCount(1, $reply->favorites);
    }
}
