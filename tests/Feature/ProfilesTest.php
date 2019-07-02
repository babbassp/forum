<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    /** @test */
    public function a_user_has_profile()
    {
        $user = factory(User::class)->create();

        $this->get(route('profile', $user->name))
            ->assertSee($user->name);
    }

    /** @test */
    public function profiles_display_all_threads_created_by_the_associated_user()
    {
        $user = factory(User::class)->create();

        $thread = factory(Thread::class)->create(['user_id' => $user->id]);

        $this->get(route('profile', $user->name))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
