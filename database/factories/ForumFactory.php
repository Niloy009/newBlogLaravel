<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Forum;
use Faker\Generator as Faker;

$factory->define(Forum::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'body' => $faker->sentence,
        'user_id' => \App\User::all()->random()->id,
        'category_id' => \App\Category::all()->random()->id,
        'image' => 'https://picsum.photos/200/300',
    ];
});
