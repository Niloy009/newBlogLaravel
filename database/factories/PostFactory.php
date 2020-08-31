<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'body' => $faker->paragraph,
        'user_id' => \App\User::all()->random()->id,
        'category_id' => \App\Category::all()->random()->id,
//        'image' => $faker->imageUrl($width = 480, $height = 768),
        'image' => 'https://picsum.photos/200/300',
    ];
});
