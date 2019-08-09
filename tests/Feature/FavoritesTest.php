<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Reply;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    /** @test */
    public function guests_cannot_favorite_anything()
    {
        $this->post(route('replies.favorites.store', 1))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = factory(Reply::class)->create();

        $this->post(route('replies.favorites.store', $reply->id));

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_toggle_the_favorite_button()
    {
        $this->signIn();

        $reply = factory(Reply::class)->create(['user_id' => auth()->id()]);

        // can favorite a reply once
        $this->post(route('replies.favorites.store', $reply->id));
        // or
        $reply->favorite();
        $this->assertCount(1, $reply->favorites);


        // can unfavorite a reply once
        $this->delete(route('replies.favorites.delete', $reply->id));
        // or
        $reply->unfavorite();
        $this->assertCount(0, $reply->refresh()->favorites);
    }
}
