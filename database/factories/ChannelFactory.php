<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Channel;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Channel::class, function (Faker $faker) {
    $name = $faker->words(5, true);
    return [
        'name' => $name,
        'slug' => Str::slug($name, '-')
    ];
});
