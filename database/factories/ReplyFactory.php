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
