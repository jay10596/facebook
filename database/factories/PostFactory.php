<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

use App\Post;
use App\User;


$factory->define(Post::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'avatar' => 'image.jpg',
        'user_id' => function() {
            return User::all()->random();
        }
    ];
});
