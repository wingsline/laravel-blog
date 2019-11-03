<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Posts\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'text' => $faker->paragraph,
        'author' => $faker->name,
        'publish_date' => $faker->dateTimeBetween('-5 years'),
        'published' => $faker->boolean(90),
        'original_content' => $faker->boolean(10),
    ];
});
