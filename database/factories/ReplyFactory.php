<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Reply;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'user_id'   => function () {
            return factory(App\Models\User::class)->create()->id;
        },
        'thread_id' => function () {
            return factory(\App\Models\Thread::class)->create()->id;
        },
        'body'      => $faker->paragraph
    ];
});

$factory->state(Reply::class, 'by_auth', function (Faker $faker) {
    $authId = auth()->id();
    return [
        'user_id'   => $authId,
        'thread_id' => function () use ($authId) {
            return factory(\App\Models\Thread::class)->create(['user_id' => $authId])->id;
        },
        'body'      => $faker->paragraph
    ];
});
