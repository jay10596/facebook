<?php

use Faker\Generator as Faker;

use App\Post;
use App\User;


$factory->define(Post::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'user_id' => factory(User::class)
    ];
});
