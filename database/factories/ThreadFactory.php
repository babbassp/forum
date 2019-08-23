<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Thread;
use App\Models\User;
use App\Notifications\ThreadWasUpdated;
use Faker\Generator as Faker;
use Illuminate\Notifications\DatabaseNotification;
use Ramsey\Uuid\Uuid;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id'    => function () {
            return auth()->id() ?: factory(App\Models\User::class)->create()->id;
        },
        'channel_id' => function () {
            return factory(App\Models\Channel::class)->create()->id;
        },
        'title'      => $faker->sentence,
        'body'       => $faker->paragraph
    ];
});

$factory->state(Thread::class, 'with_reply', function (Faker $faker) {
    return [
        'user_id'    => function () {
            return auth()->id() ?: factory(App\Models\User::class)->create()->id;
        },
        'channel_id' => function () {
            return factory(App\Models\Channel::class)->create()->id;
        },
        'title'      => $faker->sentence,
        'body'       => $faker->paragraph
    ];
});

$factory->afterCreatingState(Thread::class, 'with_reply', function ($thread, Faker $faker) {
    $thread->replies()->save(
        factory(App\Models\Reply::class)->create(['thread_id' => $thread->id])
    );
});

$factory->define(DatabaseNotification::class, function (Faker $faker) {
    return [
        'id'              => Uuid::uuid4()->toString(),
        'type'            => ThreadWasUpdated::class,
        'notifiable_id'   => function () {
            return auth()->id() ?: factory(User::class)->create();
        },
        'notifiable_type' => User::class,
        'data'            => ['data' => $faker->sentence]
    ];
});
