<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Favorite;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'remember_token'    => Str::random(10),
    ];
});

$factory->state(User::class, 'favorited_reply', function ($faker) {
    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'remember_token'    => Str::random(10),
    ];
});

$factory->afterCreatingState(User::class, 'favorited_reply', function ($user, $faker) {
    $reply = factory(Reply::class)->create();
    factory(Favorite::class)->create([
        'user_id'        => $user->id,
        'favorited_id'   => $reply->id,
        'favorited_type' => get_class($reply)
    ]);
    $user->replies()->save($reply);
});