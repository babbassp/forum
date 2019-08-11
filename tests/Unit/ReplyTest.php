<?php

namespace Tests\Unit;

use App\Models\Favorite;
use App\Models\Reply;
use App\Models\User;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    /**
     *
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function a_reply_has_an_owner()
    {
        $reply = factory(Reply::class)->create();

        $this->assertInstanceOf(User::class, $reply->owner);
    }

    /** @test */
    public function deleting_a_reply_deletes_its_favorites_and_activity()
    {
        $this->signIn();

        $reply = factory(Reply::class)->create(['user_id' => auth()->id()]);

        $favorite = factory(Favorite::class)->create([
            'favorited_id'   => $reply,
            'favorited_type' => get_class($reply)
        ]);

        $this->delete(route('reply.destroy', $reply->id));

        $this->assertDatabaseMissing('favorites', ['id' => $favorite->id]);

        $this->assertDatabaseMissing('activities', ['id' => 'created_reply']);
    }
}
