<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Favorite;
use App\Models\Reply;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Favorite::class, function (Faker $faker) {
    return [
        'user_id'        => function () {
            return factory(User::class)->create()->id;
        },
        'favorited_id'   => null,
        'favorited_type' => null,
    ];
});

$factory->state(Favorite::class, 'reply', function ($faker) {
    return [
        'user_id'        => function () {
            return factory(User::class)->create()->id;
        },
        'favorited_id'   => function () {
            return factory(Reply::class)->create()->id;
        },
        'favorited_type' => Reply::class,
    ];
});
