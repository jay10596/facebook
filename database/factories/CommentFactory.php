<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

use App\User;
use App\Comment;


$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'user_id' => function() {
            return User::all()->random();
        }
    ];
});
