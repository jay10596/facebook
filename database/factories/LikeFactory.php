<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

use App\Like;
use App\User;


$factory->define(Like::class, function (Faker $faker) {
    return [
        'post_id' => function() {
            return User::all()->random();
        },
        'user_id' => function() {
            return User::all()->random();
        }
    ];
});
