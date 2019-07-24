<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Activity;
use App\Models\User;
use App\Models\Thread;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {

    $user = factory(User::class)->create();

    $instance = factory(Thread::class)->create(['user_id' => $user->id]);

    return [
        'user_id'      => $user->id,
        'type'         => 'created_thread',
        'subject_id'   => $instance->id,
        'subject_type' => get_class($instance),
    ];
});
